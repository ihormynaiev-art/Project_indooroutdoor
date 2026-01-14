<?php

namespace App\Http\Requests\SmsTemplate;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSmsTemplateRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_enabled' => $this->boolean('is_enabled'),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'message' => [
                'required',
                'max:255',
            ],
            'description' => [
                'required',
                'max:4000',
            ],
            'is_enabled' => [
                'required',
                'boolean',
            ],
        ];
    }
}
