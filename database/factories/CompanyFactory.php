<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Country;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class CompanyFactory extends Factory
{
    protected $model = Company::class;

    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id ?? 1,
            'country_id' => Country::inRandomOrder()->first()->id ?? 1,
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'logo' => randomImage()[rand(0, 10)],
            'cover_image' => randomImage()[rand(0, 10)],
            'commercial_register' => $this->faker->randomNumber(5),
            'vat_number' => $this->faker->randomNumber(2),
            'commercial_register_file' => $this->faker->filePath()
        ];
    }
}
