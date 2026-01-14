<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMailSettingsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Adjust authorization logic as needed
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'array', 'min:1'],
            'email.*' => ['required', 'email'],
        ];
    }

    /**
     * Get custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'email.required' => 'At least one email is required.',
            'email.array' => 'The email field must be an array.',
            'email.*.required' => 'Each email is required.',
            'email.*.email' => 'Each email must be a valid email address.',
        ];
    }
}
