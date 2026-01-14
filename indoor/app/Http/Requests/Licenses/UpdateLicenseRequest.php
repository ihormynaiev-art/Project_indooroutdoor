<?php

namespace App\Http\Requests\Licenses;

use App\Enums\License\LicenseStatusEnum;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateLicenseRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'licenses' => [
                'array',
            ],
            'licenses.*.id' => [
                'int',
                Rule::exists('provider_detail_sub_category', 'id'),
            ],
            'licenses.*.license_verified_at' => [
                'nullable',
                'date_format:m/d/Y',
            ],
            'licenses.*.license_expired_on' => [
                'nullable',
                'date_format:m/d/Y',
            ],
            'file_id' => [
                'nullable',
                'integer',
                Rule::exists('files', 'id'),
            ],
            'status' => [
                'string',
                Rule::enum(LicenseStatusEnum::class),
            ],
        ];
    }
}
