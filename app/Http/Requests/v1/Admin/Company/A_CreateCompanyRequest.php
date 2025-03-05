<?php

namespace App\Http\Requests\v1\Admin\Company;

use App\Traits\DecodesInputTrait;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class A_CreateCompanyRequest extends FormRequest
{
    use DecodesInputTrait;

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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'store.data.area_id' => 'required|integer|exists:areas,id',
            'store.data.address' => 'required|string|max:255',
            'store.data.address_url' => 'nullable|string|url|max:255',
            'store.data.phone_number' => 'required|string|max:20',
            'store.data.latitude' => 'nullable|numeric',
            'store.data.longitude' => 'nullable|numeric',
            
            'store.hours' => 'required|array',
            'store.hours.*.day' => 'required|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            'store.hours.*.open_time' => 'nullable|date_format:H:i',
            'store.hours.*.close_time' => 'nullable|date_format:H:i|after:store.hours.*.open_time',
            
            'user.name' => 'required|string|max:255',
            'user.email' => 'required|email|max:50|unique:users,email',
            'user.full_mobile' => 'required|string|max:20|unique:users,full_mobile',
            'user.gender' => 'nullable|in:male,female',
            'user.avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'user.password' => 'required|string|min:8',
            'user.preferred_language' => 'nullable|string|max:5',
            
            'company.country_id' => 'required|integer|exists:countries,id',
            'company.email' => 'required|email|max:50|unique:companies,email',
            'company.phone' => 'required|string|max:20|unique:companies,phone',
            'company.logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'company.cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'company.commercial_register' => 'nullable|string|max:50',
            'company.vat_number' => 'nullable|string|max:50',
            'company.commercial_register_file' => 'nullable|file|max:2048',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->decodeInput('store.data.area_id');
        $this->decodeInput('company.country_id');
    }
}