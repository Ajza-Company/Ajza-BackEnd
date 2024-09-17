<?php

namespace Database\Factories;

use App\Models\CarBrand;
use App\Models\Locale;
use App\Models\CarBrandLocale;
use Faker\Factory as Faker;
use Faker\Provider\FakeCar;
use Illuminate\Database\Eloquent\Factories\Factory;

class CarBrandLocaleFactory extends Factory
{
    public function definition(): array
    {
        $locale = Locale::inRandomOrder()->first();
        $faker = Faker::create($locale->locale);
        $faker->addProvider(new FakeCar($this->faker));

        return [
            'locale_id' => $locale->id ?? 1,
            'car_brand_id' => CarBrand::inRandomOrder()->first()->id ?? 1,
            'name' => $faker->unique()->vehicleBrand,
        ];
    }
}
