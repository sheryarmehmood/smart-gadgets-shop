<?php

namespace Database\Seeders;
use App\Models\OrderItem;
use Illuminate\Database\Seeder;

class OrderItemSeeder extends Seeder
{
    public function run()
    {
        OrderItem::factory()->count(100)->create();
    }
}
