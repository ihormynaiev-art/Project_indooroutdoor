<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequestQuoteRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'category_id' => 'required',
            'sub_category_id' => 'required',
            'full_name' => 'required',
            'email' => 'required|email',
            'city' => 'required',
            'state' => 'required',
            'zipcode' => 'required',
            'details' => 'required',
            'documents.*' => ['file', 'mimes:jpeg,png,jpg,pdf,doc,docx|max:5120'],
//            'g-recaptcha-response' => 'required|captcha',
        ];
    }

    public function messages(): array
    {
        return [
            'g-recaptcha-response.required' => 'Captcha is required.',
            'documents.*.file' => 'The uploaded file must be a valid file.',
            'documents.*.mimes' => 'The file must be a file of type: jpeg, png, jpg, pdf, doc, docx.',
            'documents.*.max' => 'The file may not be greater than 5MB.',
        ];
    }
}
