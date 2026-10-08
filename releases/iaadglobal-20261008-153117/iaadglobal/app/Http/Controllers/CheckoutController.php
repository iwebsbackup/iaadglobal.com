<?php

namespace App\Http\Controllers;

use App\Support\RegistrationPricing;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function show(Request $request)
    {
        $user = $request->user();
        $registration = $user->registration;

        // Nothing saved yet -> go choose options first
        if (! $registration) {
            return redirect('/registration-payment')
                ->with('status', 'Please confirm your registration details first.');
        }

        if ($registration->isPaid()) {
            return redirect('/registration-payment');
        }

        // Fee tier changed since the details were saved -> re-confirm at the new price
        if ($registration->fee_tier !== RegistrationPricing::currentTier()) {
            return redirect('/registration-payment')
                ->with('status', 'Registration rates have changed. Please review and confirm your details again.');
        }

        // ---- build the signed request for the gateway ----
        $amount = (int) $registration->total * 100; // gateway expects paise
        $currency = 'INR';
        $token = Str::random(48);
        $registration->update(['payment_token' => $token]);
        $responseUrl = url('/payment/callback').'?t='.$token;

        $hash = hash_hmac(
            'sha256',
            $amount.'|'.$currency.'|'.$responseUrl,
            config('services.payment_gateway.key')
        );

        return view('checkout', [
            'user' => $user,
            'registration' => $registration,
            'gatewayUrl' => config('services.payment_gateway.url'),
            'amount' => $amount,
            'currency' => $currency,
            'responseUrl' => $responseUrl,
            'hash' => $hash,
        ]);
    }
}
