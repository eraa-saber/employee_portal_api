<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'FullName' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required|string|min:6',
            'Phone' => [
                'required',
                'string',
                'regex:/^01[0-9]{9}$/'
            ],
            'NationalID' => [
                'required',
                'digits:14',
                'regex:/^[2-3][0-9]{13}$/'
            ],
            'DocURL' => 'url|max:255',
            'EmailNotifications' => 'required|boolean',
            'insuranceNo' => 'required|integer|digits_between:4,20',
            'TermsAndConditions' => 'required|boolean|in:1,true',
        ];
    }

    /**
     * Get custom error messages for validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'FullName.required' => 'Full name is required.',
            'FullName.string' => 'Full name must be a string.',
            'FullName.max' => 'Full name cannot exceed 255 characters.',
            'email.required' => 'Email is required.',
            'email.string' => 'Email must be a string.',
            'email.email' => 'Email must be a valid email address.',
            'email.max' => 'Email cannot exceed 255 characters.',
            'email.unique' => 'This email is already registered.',
            'password.required' => 'Password is required.',
            'password.string' => 'Password must be a string.',
            'password.min' => 'Password must be at least 6 characters.',
            'password.confirmed' => 'Password confirmation does not match.',
            'password_confirmation.required' => 'Password confirmation is required.',
            'Phone.required' => 'Phone number is required.',
            'Phone.string' => 'Phone number must be a string.',
            'Phone.max' => 'Phone number cannot exceed 20 characters.',
            'Phone.regex' => 'Phone number must be a valid Egyptian mobile number (e.g., 01XXXXXXXXX).',
            'NationalID.required' => 'National ID is required.',
            'NationalID.integer' => 'National ID must be an integer.',
            'NationalID.digits_between' => 'National ID must be between 6 and 20 digits.',
            'NationalID.digits' => 'National ID must be exactly 14 digits.',
            'NationalID.regex' => 'National ID must be a valid Egyptian ID.',
            'DocURL.url' => 'Document URL must be a valid URL.',
            'DocURL.max' => 'Document URL cannot exceed 255 characters.',
            'EmailNotifications.required' => 'Email notification preference is required.',
            'EmailNotifications.boolean' => 'Email notification must be true or false.',
            'insuranceNo.required' => 'Insurance number is required.',
            'insuranceNo.integer' => 'Insurance number must be an integer.',
            'insuranceNo.digits_between' => 'Insurance number must be between 4 and 20 digits.',
            'TermsAndConditions.required' => 'You must accept the terms and conditions.',
            'TermsAndConditions.boolean' => 'Terms and conditions must be true or false.',
            'TermsAndConditions.in' => 'You must accept the terms and conditions.',
        ];
    }
}
\Log::info('insuranceNo:', [$request->insuranceNo]);