<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductFavorite;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ProductFavoriteFactory extends Factory
{
    protected $model = ProductFavorite::class;

    public function definition(): array
    {
        return [
            'product_id' => Product::inRandomOrder()->first()->id ?? 1,
            'user_id' => User::inRandomOrder()->first()->id ?? 1
        ];
    }
}
