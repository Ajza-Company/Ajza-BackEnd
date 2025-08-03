<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
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
        $method = $this->getMethod();
        
        if ($method === 'POST') {
            return [
                'key' => 'required|string|max:255|unique:settings,key',
                'value' => 'required|string'
            ];
        }
        
        if ($method === 'PUT' || $method === 'PATCH') {
            return [
                'value' => 'required|string'
            ];
        }
        
        return [];
    }
    
    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'key.required' => 'Setting key is required',
            'key.unique' => 'Setting key already exists',
            'key.max' => 'Setting key must not exceed 255 characters',
            'value.required' => 'Setting value is required',
        ];
    }
}
