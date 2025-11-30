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

    public function saleItems()
    {
        return $this->hasMany(SaleItem::class, 'product_id');
    }

    public function productIngredients()
    {
        return $this->hasMany(ProductIngredient::class);
    }

    // Relasi pivot ke tabel product_ingredients
    public function ingredients()
    {
        return $this->belongsToMany(
            Ingredient::class,
            'product_ingredients',
            'product_id',
            'ingredient_id'
        )->withPivot(['quantity', 'unit'])
         ->withTimestamps();
    }

    // HPP per porsi
    public function hppPerPorsi()
    {
        return $this->ingredients->sum(function ($ingredient) {
            return ($ingredient->pivot->quantity ?? 0) * ($ingredient->price ?? 0);
        });
    }

    // Total HPP
    public function hppTotal()
    {
        return $this->hppPerPorsi() * $this->saleItems()->sum('quantity');
    }

    // Total Penjualan
    public function totalSales()
    {
        return $this->saleItems()->sum('line_total');
    }

    // Laba Kotor
    public function profit()
    {
        return $this->totalSales() - $this->hppTotal();
    }
}
