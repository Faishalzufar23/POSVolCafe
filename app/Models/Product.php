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

    public function cost()
    {
        if (!$this->ingredients || $this->ingredients->isEmpty()) {
            return 0;
        }

        return $this->ingredients->sum(function ($ingredient) {
            return ($ingredient->pivot->quantity ?? 0) * ($ingredient->price ?? 0);
        });
    }

    // Hitung jumlah terjual hari ini
    public function soldToday()
    {
        return $this->saleItems()
            ->whereDate('created_at', today())
            ->sum('quantity');
    }

    // HPP per porsi
    public function hppPerPorsi()
    {
        return $this->ingredients->sum(function ($ingredient) {
            return ($ingredient->pivot->quantity ?? 0) * ($ingredient->price ?? 0);
        });
    }

    // HPP total hari ini
    public function hppTotalToday()
    {
        return $this->hppPerPorsi() * $this->soldToday();
    }

    // Laba kotor produk hari ini
    public function profitToday()
    {
        return ($this->price - $this->hppPerPorsi()) * $this->soldToday();
    }

    public function saleItems()
    {
        return $this->hasMany(SaleItem::class, 'product_id');
    }


    public function productIngredients()
    {
        return $this->hasMany(ProductIngredient::class);
    }

    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class)
            ->withPivot('quantity')
            ->withTimestamps();
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
