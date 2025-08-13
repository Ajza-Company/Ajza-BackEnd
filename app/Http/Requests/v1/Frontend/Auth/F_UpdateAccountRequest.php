<?php

namespace App\Http\Requests\v1\Frontend\Auth;

use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class F_UpdateAccountRequest extends FormRequest
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
     */
    public function rules(): array
    {
        $userId = auth('api')->id();
        
        return [
            'name' => 'required',
            'email' => [
                'required',
                'email',
                function ($attribute, $value, $fail) use ($userId) {
                    // Check if another client already exists with the same email
                    $existingClient = User::where('email', $value)
                        ->where('id', '!=', $userId)
                        ->whereHas('roles', function ($query) {
                            $query->where('name', RoleEnum::CLIENT);
                        })
                        ->first();
                        
                    if ($existingClient) {
                        $fail('This email is already registered to another client.');
                    }
                },
            ],
            'full_mobile' => [
                'sometimes',
                'string',
                function ($attribute, $value, $fail) use ($userId) {
                    // Check if another client already exists with the same mobile number
                    $existingClient = User::where('full_mobile', $value)
                        ->where('id', '!=', $userId)
                        ->whereHas('roles', function ($query) {
                            $query->where('name', RoleEnum::CLIENT);
                        })
                        ->first();
                        
                    if ($existingClient) {
                        $fail('This mobile number is already registered to another client.');
                    }
                },
            ],
            'gender' => 'required|string|in:male,female',
        ];
    }
}
