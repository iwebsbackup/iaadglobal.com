<?php

namespace App\Http\Controllers;

use App\Mail\PaymentConfirmation;
use App\Models\Registration;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class PaymentCallbackController extends Controller
{
    public function __invoke(Request $request)
    {
        $status = (string) $request->input('status', 'unknown');
        $orderId = (string) $request->input('razorpay_order_id', '');
        $paymentId = (string) $request->input('razorpay_payment_id', '');
        $error = (string) $request->input('error', '');
        $suppliedHash = (string) $request->input('hash', '');
        $token = (string) $request->query('t', '');

        $context = [
            'status' => $status,
            'order_id' => $orderId,
            'payment_id' => $paymentId,
            'error' => $error,
            'ip' => $request->ip(),
        ];

        // 1. Verify the gateway's signature
        $key = (string) config('services.payment_gateway.key');
        $expected = hash_hmac('sha256', $status . '|' . $orderId . '|' . $paymentId, $key);

        if ($key === '' || $suppliedHash === '' || ! hash_equals($expected, $suppliedHash)) {
            Log::warning('Payment callback: invalid hash', $context);
            abort(403, 'Invalid or missing hash.');
        }

        // 2. Find the registration from the one-time token in the URL
        $registration = $token !== ''
            ? Registration::where('payment_token', $token)->first()
            : null;

        if (! $registration) {
            // Valid signature but unknown or expired token (stale tab, double callback)
            $level = $status === 'success' ? 'critical' : 'warning';
            Log::$level('Payment callback: no matching registration', $context);

            return redirect('/registration-payment?payment=unmatched');
        }

        // 3. Success
        if ($status === 'success' && $paymentId !== '') {
            $justPaid = false;

            try {
                DB::transaction(function () use ($registration, $orderId, $paymentId, &$justPaid) {
                    $locked = Registration::lockForUpdate()->find($registration->id);

                    if ($locked->isPaid()) {
                        return; // already recorded, nothing to do
                    }

                    $locked->update([
                        'status' => 'paid',
                        'paid_at' => now(),
                        'payment_reference' => $paymentId,
                        'gateway_order_id' => $orderId,
                        'payment_error' => null,
                        'payment_token' => null, // link can't be reused
                    ]);

                    $justPaid = true;
                });
            } catch (QueryException $e) {
                // payment_reference is unique: this payment id was already used
                if ($e->getCode() !== '23000') {
                    throw $e;
                }

                Log::critical('Payment callback: payment id already used', $context);

                return redirect('/registration-payment?payment=failed');
            }

            // Email only on the first successful callback, never on a repeat
            if ($justPaid) {
                try {
                    Mail::to($registration->user->email)->send(new PaymentConfirmation($registration->fresh()));
                } catch (\Throwable $e) {
                    report($e); // payment stays recorded even if the email fails
                }
            }

            Log::info('Payment callback: registration paid', $context + ['registration_id' => $registration->id]);

            return redirect('/registration-payment?payment=success');
        }

        // 4. Failed or cancelled: keep it pending, cancel the link
        if (! $registration->isPaid()) {
            $registration->update([
                'payment_error' => $error !== '' ? $error : $status,
                'payment_token' => null,
            ]);
        }

        Log::info('Payment callback: not successful', $context + ['registration_id' => $registration->id]);

        return redirect('/registration-payment?payment=' . ($status === 'cancelled' ? 'cancelled' : 'failed'));
    }
}
