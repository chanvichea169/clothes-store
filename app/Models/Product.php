<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [

        'name',
        'slug',
        'description',
        'status',
        'price',
        'cost',
        'SKU',
        'stock_status',
        'featured',
        'quantity',
        'image',
        'gallery',
        'category_id',
        'brand_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    public function recordStockMovement($quantity, $type, $referenceId, $notes = null)
    {
        return StockMovement::create([
            'product_id' => $this->id,
            'quantity' => $quantity,
            'type' => $type,
            'reference_id' => $referenceId,
            'notes' => $notes
        ]);
    }

    public function getStockHistory()
    {
        return $this->hasMany(StockMovement::class)->latest();
    }
}