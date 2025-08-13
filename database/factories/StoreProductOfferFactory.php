<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Store;
use App\Models\StoreProduct;
use App\Models\StoreProductOffer;
use Illuminate\Database\Eloquent\Factories\Factory;

class StoreProductOfferFactory extends Factory
{
    protected $model = StoreProductOffer::class;

    public function definition(): array
    {
        $storeProduct = StoreProduct::inRandomOrder()->first();
        
        return [
            'store_product_id' => $storeProduct->id ?? 1,
            'store_id' => $storeProduct->store_id ?? 1,
            'type' => fake()->randomElement(['fixed', 'percentage']),
            'discount' => fake()->numberBetween(0, 100)
        ];
    }
}
