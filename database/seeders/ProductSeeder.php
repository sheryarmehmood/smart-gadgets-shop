<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Variation;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // Use existing category IDs
        $categoryIds = [1, 2, 3, 4, 5];

        // Generate 50 unique products
        Product::factory()
            ->count(50)
            ->create()
            ->each(function ($product) use ($categoryIds) {
                // Attach product to 1-2 random categories
                $product->categories()->sync(
                    collect($categoryIds)
                        ->random(rand(1, 2))
                        ->toArray()
                );

                // Create variations for the product
                $colors = ['Black', 'White'];
                $sizes = ['Small', 'Medium', 'Large'];

                foreach ($colors as $color) {
                    foreach ($sizes as $size) {
                        Variation::factory()->create([
                            'product_id' => $product->id,
                            'color' => $color,
                            'size' => $size,
                        ]);
                    }
                }
            });
    }
}
