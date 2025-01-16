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
            ['name' => 'Automatic Water Dispenser', 'image' => 'images/AUTOMATIC WATER DISPENSER.jpg'],
            ['name' => 'Backlit Mini Keyboard', 'image' => 'images/BACK LIT MINI KEYBOARD.jpg'],
            ['name' => 'Wireless Aluminum Speakers', 'image' => 'images/2 Coin Wireless Aluminum Speakers.jpg'],
        ];

        $gadget = $this->faker->randomElement($gadgets);

        return [
            'name' => $gadget['name'],
            'description' => $this->faker->sentence,
            'price' => $this->faker->numberBetween(30, 90), // Random price between $10 and $200
            'image' => $gadget['image'], // Local image path
        ];
    }
}
