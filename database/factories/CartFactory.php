<?php

namespace Database\factories;
use App\Models\Cart;
use Illuminate\Database\Eloquent\Factories\Factory;

class CartFactory extends Factory
{
    protected $model = Cart::class;

    public function definition()
    {
        return [
            'user_id' => \App\Models\User::factory(),
            // 'product_id' => \App\Models\Product::factory(),
            'product_id' => \App\Models\Product::inRandomOrder()->first()->id, // Use an existing product
            'quantity' => $this->faker->numberBetween(1, 3),
        ];
    }
}
