<?php

namespace App\Http\Requests\Contractor;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateContractorRequest extends FormRequest
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
            'files' => [
                'nullable',
                'array',
            ],
            'files.*' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,webp',
                'max:10240',
            ],
            'images' => [
                'nullable',
                'json',
            ],
            'order' => [
                'nullable',
                'string',
            ],
        ];
    }
}
