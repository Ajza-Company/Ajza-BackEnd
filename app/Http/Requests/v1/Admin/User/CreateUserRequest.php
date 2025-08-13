<?php

namespace App\Http\Requests\v1\Admin\User;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'email' => [
                'required',
                'email',
                function ($attribute, $value, $fail) {
                    // Check if an active user exists with the same email
                    $existingActiveUser = User::where('email', $value)
                        ->where('is_active', true)
                        ->whereNull('deleted_at')
                        ->first();
                        
                    if ($existingActiveUser) {
                        $fail('This email is already registered to an active user.');
                    }
                },
            ],
            'full_mobile' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    // Check if an active user exists with the same mobile number
                    $existingActiveUser = User::where('full_mobile', $value)
                        ->where('is_active', true)
                        ->whereNull('deleted_at')
                        ->first();
                        
                    if ($existingActiveUser) {
                        $fail('This mobile number is already registered to an active user.');
                    }
                },
            ],    
            'password' => 'required|min:8',
            'gender' => 'required|string|in:male,female',
            'avatar' => 'sometimes|file|max:2408',
            'permissions'=>'array|min:1',
            'permissions.*'=>'required_with:permissions|string'
        ];
    }

}
