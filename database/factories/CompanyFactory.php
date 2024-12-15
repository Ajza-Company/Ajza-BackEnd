<?php

namespace Database\Factories;

use App\Models\Company;
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
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'logo' => $this->faker->imageUrl,
            'cover_image' => $this->faker->imageUrl,
            'commercial_register' => $this->faker->randomNumber(5),
            'vat_number' => $this->faker->randomNumber(2),
            'commercial_register_file' => $this->faker->filePath()
        ];
    }
}
