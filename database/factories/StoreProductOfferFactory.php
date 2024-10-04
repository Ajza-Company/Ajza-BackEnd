<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Store;
use App\Models\StoreProductOffer;
use Illuminate\Database\Eloquent\Factories\Factory;

class StoreProductOfferFactory extends Factory
{
    protected $model = StoreProductOffer::class;

    public function definition(): array
    {
        return [
            'store_id' => Store::inRandomOrder()->first()->id ?? 1,
            'product_id' => Product::inRandomOrder()->first()->id ?? 1,
            'discount' => fake()->numberBetween(0, 100)
        ];
    }
}
