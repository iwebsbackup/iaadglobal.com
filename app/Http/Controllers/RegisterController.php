<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Mail\RegistrationConfirmation;
use App\Models\User;
use App\Support\RegistrationPricing;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class RegisterController extends Controller
{
    public function create()
    {
        return view('register');
    }

    public function store(RegisterRequest $request)
    {
        $data = $request->validated();
        $tier = RegistrationPricing::currentTier();

        // HOD letter goes to private storage (storage/app/private/hod_letters)
        $hodPath = null;
        if ($data['category'] === 'Post Graduate Student' && $request->hasFile('hod_letter')) {
            $hodPath = $request->file('hod_letter')->store('hod_letters', 'local');
        }

        try {
            $user = DB::transaction(fn() => User::create([
                ...collect($data)->except(['hod_letter', 'password_confirmation'])->all(),
                'iadvl_no' => $data['member_type'] === 'Dermatologist' ? ($data['iadvl_no'] ?? null) : null,
                'hod_letter_path' => $hodPath,
                'fee_tier' => $tier,
                'registration_fee' => RegistrationPricing::fee($data['category'], $tier),
            ]));
        } catch (\Throwable $e) {
            if ($hodPath) {
                Storage::disk('local')->delete($hodPath);
            }
            throw $e;
        }

        Auth::login($user);
        $request->session()->regenerate();

        try {
            Mail::to($user->email)->send(new RegistrationConfirmation($user, $data['password']));
        } catch (\Throwable $e) {
            report($e);
        }

        return redirect('/dashboard')->with('status', 'Account created successful.');
    }
}
