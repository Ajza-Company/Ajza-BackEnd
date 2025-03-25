<?php

namespace App\Http\Requests\v1\Frontend\Order;

use App\Enums\OrderDeliveryMethodEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class F_GetInvoiceRequest extends FormRequest
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
            'delivery_method' => ['required', 'string', Rule::in(OrderDeliveryMethodEnum::asArray())],
            'address_id' => 'required_if:delivery_method,delivery|integer|exists:addresses,id',
            'order_products' => 'required|array',
            'order_products.*.product_id' => 'required|integer|exists:store_products,id',
            'order_products.*.quantity' => 'required|integer|min:1',
            'promo_code'=>'sometimes|string|exists:promo_codes,code'
        ];
    }
}
