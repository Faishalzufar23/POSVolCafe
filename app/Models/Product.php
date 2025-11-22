<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'sku',
        'description',
        'price',

    ];

    protected $casts = [
    'photo' => 'string',
];



    public function productIngredients()
    {
        return $this->hasMany(ProductIngredient::class);
    }

    public function getStockAttribute()
    {
        $recipes = $this->productIngredients()->with('ingredient')->get();

        if ($recipes->isEmpty()) return 0;

        $min = null;

        foreach ($recipes as $r) {
            if (!$r->ingredient || $r->quantity <= 0) continue;

            $available = floor($r->ingredient->stock / $r->quantity);

            if ($min === null || $available < $min) {
                $min = $available;
            }
        }

        return $min ?? 0;
    }
}
