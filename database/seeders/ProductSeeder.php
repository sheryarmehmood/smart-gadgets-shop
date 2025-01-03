<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // Generate 50 products
        Product::factory()->count(50)->create();
    }
}
