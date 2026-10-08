<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        return view('profile', ['user' => $request->user()]);
    }

    public function update(Request $request)
    {
        // email and category are deliberately not accepted here
        $data = $request->validate([
            'title' => ['required', Rule::in(['Dr.', 'Prof.', 'Mr.', 'Miss', 'Ms.'])],
            'name' => ['required', 'string', 'max:255'],
            'age' => ['required', 'integer', 'between:18,120'],
            'gender' => ['required', Rule::in(['Male', 'Female', 'Other'])],
            'institution' => ['required', 'string', 'max:255'],
            'member_type' => ['required', Rule::in(['Plastic Surgeon', 'Dermatologist'])],
            'iadvl_no' => ['nullable', 'string', 'max:50'],
            'iaaps_apsi_no' => ['nullable', 'string', 'max:50'],
            'address' => ['required', 'string', 'max:500'],
            'city' => ['required', 'string', 'max:100'],
            'state' => ['required', 'string', 'max:100'],
            'pincode' => ['required', 'regex:/^\d{6}$/'],
            'phone' => ['required', 'regex:/^\+?[0-9\s\-]{10,15}$/'],
        ], [
            'pincode.regex' => 'Pincode must be 6 digits.',
            'phone.regex' => 'Enter a valid phone number (10–15 digits).',
        ]);

        // keep only the membership number that matches the member type
        $data['iadvl_no'] = $data['member_type'] === 'Dermatologist' ? ($data['iadvl_no'] ?? null) : null;
        $data['iaaps_apsi_no'] = $data['member_type'] === 'Plastic Surgeon' ? ($data['iaaps_apsi_no'] ?? null) : null;

        $request->user()->update($data);

        return back()->with('status', 'Profile updated.');
    }

    public function updatePassword(Request $request)
    {
        $request->validateWithBag('password', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::min(6), 'different:current_password'],
        ], [
            'current_password.current_password' => 'The current password is incorrect.',
            'password.different' => 'The new password must be different from the current one.',
        ]);

        $request->user()->update(['password' => $request->input('password')]);

        return back()->with('status', 'Password updated.');
    }
}
