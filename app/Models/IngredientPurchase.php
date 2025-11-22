<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IngredientPurchase extends Model
{
    protected $fillable = [
        'ingredient_id',
        'quantity',
        'unit',
        'note',
    ];
    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class);
    }

    protected static function booted()
    {
        static::created(function ($purchase) {
            $purchase->ingredient->increment('stock', $purchase->quantity);
        });

        static::updated(function ($purchase) {
            $oldQuantity = $purchase->getOriginal('quantity');
            $newQuantity = $purchase->quantity;
            $difference = $newQuantity - $oldQuantity;

            $purchase->ingredient->increment('stock', $difference);
        });

        static::deleted(function ($purchase) {
            $purchase->ingredient->decrement('stock', $purchase->quantity);
        });
    }
}
