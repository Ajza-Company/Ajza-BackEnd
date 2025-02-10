<?php

namespace App\Http\Requests\v1\Supplier\Team;

use App\Traits\DecodesInputTrait;
use Illuminate\Foundation\Http\FormRequest;

class S_UpdateTeamMemberRequest extends FormRequest
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
            'data.name' => 'required|string',
            'data.full_mobile' => 'required|string',
            'data.is_active' => 'required|boolean',
            'permissions' => 'required|array|min:1',
            'permissions.*' => 'required|string|exists:permissions,name',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->decodeInput('store_id');
    }
}
