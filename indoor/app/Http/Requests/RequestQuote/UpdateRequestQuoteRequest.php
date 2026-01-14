<?php

namespace App\Http\Requests\RequestQuote;

use App\Enums\RequestQuote\RequestQuoteStatusEnum;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequestQuoteRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'status' => [
                'required',
                Rule::enum(RequestQuoteStatusEnum::class),
            ],
            'internal_note' => [
                'nullable',
                'string',
                'max:4000',
            ]
        ];
    }
}
