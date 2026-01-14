<?php

namespace App\Http\Requests\Landing;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

abstract class BaseLandingRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'string',
                'max:100',
            ],
            'slug' => [
                'required',
                'string',
                'max:50',
                'regex:/^[a-z0-9\-_]+$/',
            ],
            'is_published' => [
                'boolean',
            ],
            'custom_description' => [
                'nullable',
                'string',
            ],
            'use_custom_description' => [
                'boolean',
            ],
            'use_custom_portfolio' => [
                'boolean',
            ],
            'hero_image' => [
                'nullable',
                'file',
                'mimes:jpeg,png,jpg,webp',
                'max:10240',
            ],
            'offer_image' => [
                'nullable',
                'file',
                'mimes:jpeg,png,jpg,webp',
                'max:10240',
            ],
            'portfolio_images' => [
                'nullable',
                'array',
            ],
            'portfolio_images.*' => [
                'file',
                'mimes:jpeg,png,jpg,webp',
                'max:10240',
            ],
            'delete_hero_image' => [
                'nullable',
                'integer',
            ],
            'delete_offer_image' => [
                'nullable',
                'integer',
            ],
            'portfolio_images_ids' => [
                'nullable',
                'json',
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
            'title.max' => 'The title may not be greater than 100 characters.',
            'slug.regex' => 'The slug may only contain lowercase letters, numbers, hyphens and underscores.',
            'slug.max' => 'The slug may not be greater than 50 characters.',
        ];
    }
}
