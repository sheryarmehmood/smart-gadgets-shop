<?php

namespace Database\Factories;

use App\Models\Variation;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class VariationFactory extends Factory
{
    protected $model = Variation::class;

    public function definition()
    {
        return [
            'product_id' => Product::factory(), // Dynamically create a product if needed
            'color' => $this->faker->randomElement(['Black', 'White']),
            'size' => $this->faker->randomElement(['Small', 'Medium', 'Large']),
            'stock' => $this->faker->numberBetween(1, 50), // Stock between 1 and 50

            // Calculate price as 5-10% of product price
            'price' => function (array $attributes) {
                $productPrice = Product::find($attributes['product_id'])->price ?? 100; // Default price if product not found
                $percentage = $this->faker->numberBetween(5, 10) / 100; // Random percentage between 5% and 10%
                return round($productPrice * (1 + $percentage), 2);
            },
        ];
    }
}
