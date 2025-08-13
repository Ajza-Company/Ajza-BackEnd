<?php

namespace App\Http\Requests\v1\Admin\CarType;

use Illuminate\Foundation\Http\FormRequest;

class A_CreateCarTypeRequest extends FormRequest
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
            'name' => 'required|string|max:50|unique:car_type_locales,name',
            'locale_id' => 'required|exists:locales,id'
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Car type name is required.',
            'name.max' => 'Car type name cannot exceed 50 characters.',
            'name.unique' => 'This car type name already exists.',
            'locale_id.required' => 'Locale ID is required.',
            'locale_id.exists' => 'Selected locale does not exist.'
        ];
    }
}

