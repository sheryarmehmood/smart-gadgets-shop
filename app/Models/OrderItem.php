<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'variation_id', 'quantity', 'price'];

    /**
     * Relationship with order.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Relationship with variation.
     */
    public function variation()
    {
        return $this->belongsTo(Variation::class);
    }
}
