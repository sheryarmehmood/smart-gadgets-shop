<?php

namespace Database\Seeders;

use App\Models\Product;
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
                $product->categories()->sync(
                    collect($categoryIds)
                        ->random(rand(1, 2))
                        ->toArray()
                );
            });      
    }
}
