<?php

namespace App\Http\Requests\v1\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class RequestAccountDeletionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'reason' => 'nullable|string|max:1000'
        ];
    }

    public function messages(): array
    {
        return [
            'reason.max' => 'The reason must not exceed 1000 characters.'
        ];
    }
}
