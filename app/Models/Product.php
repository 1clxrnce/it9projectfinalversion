<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $primaryKey = 'product_id';

    protected $fillable = [
        'product_name',
        'description',
        'image',
        'price',
        'category_id',
        'brand_id',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    /**
     * Get the category of this product
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }

    /**
     * Get the brand of this product
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'brand_id');
    }

    /**
     * Get inventory for this product
     */
    public function inventory()
    {
        return $this->hasOne(Inventory::class, 'product_id', 'product_id');
    }

    /**
     * Get stock transactions for this product
     */
    public function stockTransactions()
    {
        return $this->hasMany(StockTransaction::class, 'product_id', 'product_id');
    }
}
