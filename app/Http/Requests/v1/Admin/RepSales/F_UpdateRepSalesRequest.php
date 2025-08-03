<?php

namespace App\Http\Requests\v1\Admin\RepSales;

use Illuminate\Validation\Rule;
use App\Traits\DecodesInputTrait;
use Illuminate\Foundation\Http\FormRequest;

class F_UpdateRepSalesRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($this->id),
            ],
            'full_mobile' => [
                'sometimes',
                'string',
                Rule::unique('users', 'full_mobile')->ignore($this->id),
            ],
            'password' => 'sometimes|min:8',
            'avatar' => 'sometimes|nullable|file|max:2408',
            'gender' => 'sometimes|string|in:male,female',
            // 'country_id' => 'sometimes|integer|exists:countries,id',
            'city_id' => 'required|integer|exists:states,id',
        ];
    }

    /**
     * Get the validation error messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'الاسم مطلوب',
            'name.string' => 'الاسم يجب أن يكون نص',
            'email.required' => 'البريد الإلكتروني مطلوب',
            'email.email' => 'البريد الإلكتروني غير صحيح',
            'email.unique' => 'البريد الإلكتروني مستخدم من قبل',
            'full_mobile.string' => 'رقم الهاتف يجب أن يكون نص',
            'full_mobile.unique' => 'رقم الهاتف مستخدم من قبل',
            'password.min' => 'كلمة المرور يجب أن تكون 8 أحرف على الأقل',
            'avatar.file' => 'الصورة الشخصية يجب أن تكون ملف',
            'avatar.max' => 'حجم الصورة الشخصية يجب ألا يتجاوز 2408 كيلوبايت',
            'gender.string' => 'الجنس يجب أن يكون نص',
            'gender.in' => 'الجنس يجب أن يكون ذكر أو أنثى',
            'city_id.required' => 'المدينة مطلوبة',
            'city_id.integer' => 'المدينة يجب أن تكون رقم صحيح',
            'city_id.exists' => 'المدينة المحددة غير موجودة',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->decodeInput('city_id');
        // $this->decodeInput('country_id');
        $this->merge([
            'id' => decodeString($this->route('id')), // Decode the ID and merge it back into the request
        ]);
    }
}
