<?php

namespace Database\Factories;

use App\Models\Area;
use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class StoreFactory extends Factory
{
    protected $model = Store::class;

    public function definition(): array
    {
        return [
            // 'user_id' => User::inRandomOrder()->first()->id ?? 1,
            'area_id' => Area::inRandomOrder()->first()->id ?? 1,
            'parent_id' => Store::inRandomOrder()->first()->id ?? null,
            'image' => fake()->imageUrl,
            'address' => fake()->address(),
            'latitude' => fake()->latitude(),
            'longitude' => fake()->longitude()
        ];
    }
}
