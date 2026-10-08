<?php

namespace App\Http\Requests;

use App\Support\RegistrationPricing;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category' => ['required', Rule::in(RegistrationPricing::CATEGORIES)],
            'hod_letter' => [
                'required_if:category,Post Graduate Student',
                'nullable',
                'file',
                'mimes:pdf,jpg,jpeg,png',
                'max:5120',
            ],

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
            'email' => ['required', 'email:rfc', 'max:255', 'unique:users,email'],

            'password' => ['required', 'confirmed', Password::min(6)],
        ];
    }

    public function messages(): array
    {
        return [
            'hod_letter.required_if' => 'Letter of HOD is required for Post Graduate Students.',
            'pincode.regex' => 'Pincode must be 6 digits.',
            'phone.regex' => 'Enter a valid phone number (10–15 digits).',
        ];
    }
}
