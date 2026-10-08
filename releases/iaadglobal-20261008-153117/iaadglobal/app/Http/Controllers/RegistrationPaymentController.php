<?php

namespace App\Http\Controllers;

use App\Support\RegistrationPricing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RegistrationPaymentController extends Controller
{
    public function show(Request $request)
    {
        return view('registration-payment', [
            'user' => $request->user(),
            'registration' => $request->user()->registration,
        ]);
    }

    public function store(Request $request)
    {
        $user = $request->user();

        // Paid registrations are locked
        abort_if($user->registration?->isPaid(), 403);

        $titles = ['Dr.', 'Prof.', 'Mr.', 'Miss', 'Ms.'];
        $genders = ['Male', 'Female', 'Other'];

        $data = $request->validate([
            'accommodation' => ['required', Rule::in(['none', 'single', 'double'])],

            'sharing.title' => ['required_if:accommodation,double', 'nullable', Rule::in($titles)],
            'sharing.name' => ['required_if:accommodation,double', 'nullable', 'string', 'max:255'],
            'sharing.gender' => ['required_if:accommodation,double', 'nullable', Rule::in($genders)],

            'accompanying' => ['nullable', 'array'],
            'accompanying.*.title' => ['required', Rule::in($titles)],
            'accompanying.*.name' => ['required', 'string', 'max:255'],
            'accompanying.*.gender' => ['required', Rule::in($genders)],

            'workshops' => ['nullable', 'array'],
            'workshops.*' => ['string', Rule::in(config('registration.workshops'))],

            'agree' => ['accepted'],
        ]);

        // ---- price recalculated on the server, never trusted from the browser ----
        $tier = RegistrationPricing::currentTier();
        $nonRes = collect(config('registration.packages.non_residential.rows'))->keyBy('category');
        $res = collect(config('registration.packages.residential.rows'))->keyBy('category');

        $base = match ($data['accommodation']) {
            'double' => $res['Double Occupancy With Accompanying Person']['prices'][$tier],
            'single' => $res['Single Occupancy']['prices'][$tier],
            default => $nonRes[$user->category]['prices'][$tier],
        };

        $accompanying = array_values($data['accompanying'] ?? []);
        $workshops = array_values(array_unique($data['workshops'] ?? []));

        $subtotal = $base
            + count($accompanying) * $nonRes['Accompanying Person']['prices'][$tier]
            + count($workshops) * $nonRes['Any Workshop']['flat'];

        $gstAmount = (int) round($subtotal * config('registration.gst') / 100);

        $user->registration()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'accommodation' => $data['accommodation'],
                'sharing' => $data['accommodation'] === 'double' ? $data['sharing'] : null,
                'accompanying' => $accompanying ?: null,
                'workshops' => $workshops ?: null,
                'fee_tier' => $tier,
                'subtotal' => $subtotal,
                'gst_amount' => $gstAmount,
                'total' => $subtotal + $gstAmount,
                'status' => 'pending',
            ]
        );

        return redirect('/checkout');
    }
}
