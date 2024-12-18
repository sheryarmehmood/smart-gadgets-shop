<?php

namespace Database\Seeders;
use App\Models\Cart;
use Illuminate\Database\Seeder;

class CartSeeder extends Seeder
{
    public function run()
    {
        Cart::factory()->count(30)->create();
    }
}
