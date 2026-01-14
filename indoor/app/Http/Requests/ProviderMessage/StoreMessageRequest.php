<?php

namespace App\Http\Requests\ProviderMessage;

use App\Models\ProviderDetail;
use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMessageRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'contact' => [
                'required',
                'max:255',
            ],
            'message' => [
                'required',
                'max:4000',
            ],
            'provider_id' => [
                'required',
                'int',
                Rule::exists(ProviderDetail::class, 'id'),
            ],
            'user_id' => [
                'sometimes',
                'int',
                Rule::exists(User::class, 'id'),
            ],
            'documents.*' => [
                'file',
                'mimes:jpeg,png,jpg,webp',
                'max:5120',
            ],
        ];
    }
}
