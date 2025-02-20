<?php

namespace App\Http\Requests\v1\Frontend\Address;

use Illuminate\Foundation\Http\FormRequest;

class F_CreateAddressRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:100',
            'house_number' => 'nullable|max:10',
            'level' => 'nullable|integer',
            'apartment_number' => 'nullable|max:10',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'is_default' => 'required|boolean'
        ];
    }
}
