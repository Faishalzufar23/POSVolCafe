<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    protected $fillable = [
        'name',
        'unit',
        'stock',
        'price',        // ← WAJIB !!! supaya harga tersimpan
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_ingredients')
            ->withPivot('quantity', 'unit')
            ->withTimestamps();
    }

    public function usages()
    {
        return $this->hasMany(IngredientUsage::class);
    }
}
