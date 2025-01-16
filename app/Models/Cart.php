<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'variation_id', 'quantity'];

    /**
     * Relationship with variation.
     */
    public function variation()
    {
        return $this->belongsTo(Variation::class);
    }
}
