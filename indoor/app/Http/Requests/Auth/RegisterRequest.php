<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;

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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:200',
            ],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:200',
                'unique:'.User::class,
            ],
            'business_name' => [
                'nullable',
                'string',
                'max:200',
            ],
            'password' => [
                'required',
                'confirmed',
                Rules\Password::defaults(),
            ],
            'files' => [
                'nullable',
                'array',
            ],
            'files.*' => [
                'file',
                'mimes:pdf,jpeg,png,jpg',
            ],
            'code' => [
                'nullable',
                'string',
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.max' => 'The name may not be greater than 200 characters.',
            'email.max' => 'The email may not be greater than 200 characters.',
            'business_name.max' => 'The business name may not be greater than 200 characters.',
            'files.*.mimes' => 'Must be a file of type: pdf, jpeg, png, jpg.',
        ];
    }
}
