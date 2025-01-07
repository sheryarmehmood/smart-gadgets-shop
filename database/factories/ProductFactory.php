<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        $gadgets = [
            ['name' => 'Electric Lunchboxes Deal', 'image' => 'images/2 Electric Lunchboxes ki DEAL.jpg'],
            ['name' => 'Automatic Water Dispenser (2)', 'image' => 'images/AUTOMATIC WATER DISPENSER (2).jpg'],
            ['name' => 'Automatic Water Dispenser', 'image' => 'images/AUTOMATIC WATER DISPENSER.jpg'],
            ['name' => 'Backlit Mini Keyboard (2)', 'image' => 'images/BACK LIT MINI KEYBOARD (2).jpg'],
            ['name' => 'Backlit Mini Keyboard', 'image' => 'images/BACK LIT MINI KEYBOARD.jpg'],
            ['name' => 'Wireless Aluminum Speakers (2)', 'image' => 'images/2 Coin Wireless Aluminum Speakers (2).jpg'],
            ['name' => 'Wireless Aluminum Speakers', 'image' => 'images/2 Coin Wireless Aluminum Speakers.jpg'],
        ];

        $gadget = $this->faker->randomElement($gadgets);

        return [
            'name' => $gadget['name'],
            'description' => $this->faker->sentence,
            'price' => $this->faker->randomFloat(2, 10, 200), // Random price between $10 and $200
            'stock' => $this->faker->numberBetween(1, 50), // Stock between 1 and 50
            'image' => $gadget['image'], // Local image path
            'color' => $this->faker->randomElement(['Black', 'White']), // Random color
        ];
    }
}
