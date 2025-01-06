<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // Use existing categories with IDs 1 to 5
        $categoryIds = [1, 2, 3, 4, 5];

        // Generate 50 products and attach random categories
        Product::factory()->count(50)->create()->each(function ($product) use ($categoryIds) {
            // Attach 1–3 random categories to each product
            $product->categories()->attach(array_rand(array_flip($categoryIds), rand(1, 3)));
        });
    }
}
