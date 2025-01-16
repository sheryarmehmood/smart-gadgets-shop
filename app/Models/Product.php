<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'price', 'image'];

    /**
     * Relationship with categories.
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_product');
    }

    /**
     * Relationship with reviews.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Relationship with variations.
     */
    public function variations()
    {
        return $this->hasMany(Variation::class);
    }

    /**
     * Calculate the average rating for the product.
     */
    public function averageRating()
    {
        return $this->reviews()->avg('rating');
    }
}
