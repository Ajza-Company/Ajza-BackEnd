<?php

namespace App\Http\Requests\v1\Supplier\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            // 'store_id' => 'required|exists:stores,id',
            'is_select_all' => 'required|boolean',
            
            'product_ids' => [
                'nullable',
                'required_if:is_select_all,false',
                'array'
            ],
            'product_ids.*' => [
                'required_if:is_select_all,false',
                'exists:products,id'
            ],
            
            'category_id' => [
                'nullable',
                'required_if:is_select_all,true',
                'exists:categories,id'
            ],
        ];
    }
    }
