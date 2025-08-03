<?php

namespace App\Http\Requests\v1\Admin\PromoCode;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class A_UpdatePromoCodeRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $promoCodeId = $this->route('promo_code'); // assuming the route parameter is 'promo_code'
        
        return [
            'code' => [
                'required',
                'string',
                'max:255',
                Rule::unique('promo_codes', 'code')->ignore($promoCodeId)
            ],
            'description' => 'nullable|string|max:255',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'max_uses' => 'nullable|integer|min:1',
            'used_count' => 'nullable|integer|min:0',
            'min_order_value' => 'nullable|numeric|min:0',
            'max_discount' => [
                'nullable',
                'numeric',
                'min:0',
                function ($attribute, $value, $fail) {
                    $minOrderValue = $this->input('min_order_value');
                    if ($value && $minOrderValue && $value > $minOrderValue) {
                        $fail('أقصى خصم لا يمكن أن يتجاوز قيمة الطلب الأدنى.');
                    }
                    
                    $type = $this->input('type');
                    $discountValue = $this->input('value');
                    if ($type === 'percentage' && $discountValue > 100) {
                        $fail('نسبة الخصم لا يمكن أن تتجاوز 100%.');
                    }
                }
            ],
            'is_active' => 'boolean',
            'starts_at' => [
                'nullable',
                'date',
                'after_or_equal:today'
            ],
            'expires_at' => [
                'nullable',
                'date',
                'after_or_equal:starts_at'
            ],
        ];
    }
}