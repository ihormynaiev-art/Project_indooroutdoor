<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveEditionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string'],
            'files.*' => ['file', 'mimes:pdf,jpeg,png,jpg'],
        ];
    }
}
