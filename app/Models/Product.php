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
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function brand()
    {
        return $this->belongsToMany(Brand::class, 'brand_product');
    }
}