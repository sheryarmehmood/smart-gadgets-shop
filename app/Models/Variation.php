<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variation extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'color', 'size', 'stock'];

    /**
     * Relationship with product.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Relationship with cart.
     */
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    /**
     * Relationship with order items.
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
