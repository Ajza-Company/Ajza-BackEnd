<?php

namespace App\Http\Requests\v1\Admin\RepSales;

use App\Enums\RoleEnum;
use App\Models\User;
use App\Traits\DecodesInputTrait;
use App\Enums\EncodingMethodsEnum;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class F_CreateRepSalesRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'full_mobile' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    return User::where('full_mobile', $value)->whereDoesntHave('roles', function ($query) { $query->whereIn('name', [RoleEnum::SUPPLIER, RoleEnum::REPRESENTATIVE]); })->exists();
                },
            ],
            'gender' => 'required|string|in:male,female',
            'avatar' => 'nullable|file|max:2408',
            'password' => 'required|min:8',
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
            'email.required' => 'البريد الإلكتروني مطلوب',
            'email.email' => 'البريد الإلكتروني غير صحيح',
            'email.unique' => 'البريد الإلكتروني مستخدم من قبل',
            'full_mobile.required' => 'رقم الهاتف مطلوب',
            'full_mobile.string' => 'رقم الهاتف يجب أن يكون نص',
            'gender.required' => 'الجنس مطلوب',
            'gender.string' => 'الجنس يجب أن يكون نص',
            'gender.in' => 'الجنس يجب أن يكون ذكر أو أنثى',
            'avatar.file' => 'الصورة الشخصية يجب أن تكون ملف',
            'avatar.max' => 'حجم الصورة الشخصية يجب ألا يتجاوز 2408 كيلوبايت',
            'password.required' => 'كلمة المرور مطلوبة',
            'password.min' => 'كلمة المرور يجب أن تكون 8 أحرف على الأقل',
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
    }

}
