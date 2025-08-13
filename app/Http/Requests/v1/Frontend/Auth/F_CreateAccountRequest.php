<?php

namespace App\Http\Requests\v1\Frontend\Auth;

use App\Enums\EncodingMethodsEnum;
use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class F_CreateAccountRequest extends FormRequest
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
            'name' => 'required',
            'email' => [
                'required',
                'email',
                function ($attribute, $value, $fail) {
                    // Check if a client already exists with the same email
                    $existingClient = User::where('email', $value)
                        ->whereHas('roles', function ($query) {
                            $query->where('name', RoleEnum::CLIENT);
                        })
                        ->first();
                        
                    if ($existingClient) {
                        $fail('This email is already registered to a client.');
                    }
                },
            ],
            'full_mobile' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    // Check if a client already exists with the same mobile number
                    $existingClient = User::where('full_mobile', $value)
                        ->whereHas('roles', function ($query) {
                            $query->where('name', RoleEnum::CLIENT);
                        })
                        ->first();
                        
                    if ($existingClient) {
                        $fail('This mobile number is already registered to a client.');
                    }
                },
            ],
            'account_type' => 'sometimes|string|in:personal,workshop',
            'personal.gender' => 'required_if:account_type,personal|string|in:male,female',
            'workshop.data.name' => 'required_if:account_type,workshop|string',
            'workshop.data.city_id' => 'required_if:account_type,workshop|integer|exists:cities,id',
            'workshop.data.commercial_registration' => 'required_if:account_type,workshop|string',
            'workshop.data.national_identity' => 'required_if:account_type,workshop|string',
            'workshop.data.added_tax' => 'required_if:account_type,workshop|string',
            'workshop.commercial_registration_image' => 'required_if:account_type,workshop|image|mimes:jpeg,png,jpg,gif,svg',
            //'fcm_token' => 'sometimes|string',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->decodeInput('city_id');

        $this->merge([
            'account_type' => $this->account_type ?? 'personal',
        ]);
    }

    /**
     * Decode the encoded input value.
     *
     * @param string $inputKey
     */
    private function decodeInput(string $inputKey): void
    {
        $value = $this->input($inputKey);

        if ($value && decodeString($value)) {
            $this->merge([$inputKey => decodeString($value)]);
        }
    }
}
