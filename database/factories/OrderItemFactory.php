<?php

namespace Database\factories;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemFactory extends Factory
{
    protected $model = OrderItem::class;

    public function definition()
    {
        return [
            'order_id' => \App\Models\Order::factory(),
            // 'product_id' => \App\Models\Product::factory(),
            'product_id' => \App\Models\Product::inRandomOrder()->first()->id, // Use an existing product
            'quantity' => $this->faker->numberBetween(1, 5),
            'price' => $this->faker->randomFloat(2, 10, 200),
        ];
    }
}
