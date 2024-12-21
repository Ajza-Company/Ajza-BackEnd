<?php

namespace App\Http\Requests\v1\Supplier\Store;

use App\Traits\DecodesInputTrait;
use Illuminate\Foundation\Http\FormRequest;

class S_UpdateStoreRequest extends FormRequest
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
            'area_id' => 'sometimes|integer|exists:areas,id',
            'address_url' => 'sometimes|string|url',
            'phone_number' => 'sometimes|string',
            'is_active' => 'sometimes|boolean',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->decodeInput('area_id');
    }
}
