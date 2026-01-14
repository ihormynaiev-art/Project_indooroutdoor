<?php

namespace App\Http\Requests\ProviderDetail;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProviderDetailRequest extends FormRequest
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
            'business_name' => [
                'required',
                'string',
                'max:200',
            ],
            'phone' => [
                'required',
                'string',
                'max:15',
            ],
            'description' => [
                'nullable',
                'string',
            ],
            'sub_categories' => [
                'required',
                'array',
            ],
            'categories' => [
                'nullable',
                'array',
            ],
            'logo' => [
                'nullable',
                'file',
                'mimes:jpeg,png,jpg,webp',
                'max:10240',
            ],
            'background' => [
                'nullable',
                'file',
                'mimes:jpeg,png,jpg,webp',
                'max:10240',
            ],
            'files' => [
                'nullable',
                'array',
            ],
            'files.*' => [
                'file',
                'mimes:jpeg,png,jpg,webp',
                'max:10240',
            ],
            'x_url' => [
                'nullable',
                'string',
            ],
            'facebook_url' => [
                'nullable',
                'string',
            ],
            'website_url' => [
                'nullable',
                'string',
            ],
            'instagram_url' => [
                'nullable',
                'string',
            ],
            'youtube_url' => [
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
            'business_name.max' => 'The business name may not be greater than 200 characters.',
            'phone.max' => 'The phone number may not be greater than 15 digits.',
        ];
    }
}
