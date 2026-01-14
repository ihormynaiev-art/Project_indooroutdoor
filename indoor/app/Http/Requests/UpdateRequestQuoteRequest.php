<?php

namespace App\Http\Requests;

use App\Models\ProviderDetail;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequestQuoteRequest extends FormRequest
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
            'provider_id' => [
                'nullable',
                'integer',
                Rule::exists(ProviderDetail::class, 'id'),
            ],
        ];
    }
}
