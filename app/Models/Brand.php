<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'brand_id';

    protected $fillable = [
        'brand_name',
        'image',
    ];

    /**
     * Get products of this brand
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'brand_id', 'brand_id');
    }
}
