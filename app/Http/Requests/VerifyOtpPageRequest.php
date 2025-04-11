<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VerifyOtpPageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|numeric|digits:6',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'email.required' => 'Email is required',
            'email.email' => 'Please enter a valid email address',
            'email.exists' => 'This email is not registered in our system',
            'otp.required' => 'OTP code is required',
            'otp.numeric' => 'OTP must contain only numbers',
            'otp.digits' => 'OTP must be 6 digits',
        ];
    }
}
