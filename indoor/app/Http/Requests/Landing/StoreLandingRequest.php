<?php

namespace App\Http\Requests\Landing;

use App\Models\ProviderDetail;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;

class StoreLandingRequest extends BaseLandingRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            'provider_detail_id' => [
                'required',
                Rule::exists(ProviderDetail::class, 'id'),
            ],
        ]);
    }
}
