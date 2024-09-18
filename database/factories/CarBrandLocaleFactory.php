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
        $this->faker->addProvider(new FakeCar($this->faker));

        do {
            $localeId = Locale::inRandomOrder()->first()->id ?? 1;
            $carBrandId = CarBrand::inRandomOrder()->first()->id ?? 1;
            $name = $this->faker->unique()->vehicleBrand;

            $exists = CarBrandLocale::where('locale_id', $localeId)
                ->where('car_brand_id', $carBrandId)
                ->where('name', $name)
                ->exists();
        } while ($exists);

        return [
            'locale_id' => $localeId,
            'car_brand_id' => $carBrandId,
            'name' => $name,
        ];
    }
}
