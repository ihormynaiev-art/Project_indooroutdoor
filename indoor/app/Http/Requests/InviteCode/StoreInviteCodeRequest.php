<?php

namespace App\Http\Requests\InviteCode;

use Illuminate\Foundation\Http\FormRequest;

class StoreInviteCodeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasRole(['admin', 'super admin']);
    }

    public function rules(): array
    {
        return [
            'code' => 'required|string|max:20|unique:invite_codes,code|regex:/^[A-Z0-9]+$/',
            'plan_id' => 'required|exists:plans,id',
            'expires_at' => 'nullable|date_format:m/d/Y|after:today',
        ];
    }

    public function messages(): array
    {
        return [
            'code.required' => 'Please enter a code.',
            'code.unique' => 'This code already exists.',
            'code.max' => 'Code must not exceed 20 characters.',
            'code.regex' => 'Code must contain only uppercase letters and numbers.',
            'plan_id.required' => 'Please select a plan.',
            'plan_id.exists' => 'The selected plan is invalid.',
            'expires_at.date_format' => 'Please enter a valid date in mm/dd/yyyy format.',
            'expires_at.after' => 'The expiration date must be in the future.',
        ];
    }
}
