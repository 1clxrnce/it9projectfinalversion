<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockTransaction extends Model
{
    protected $primaryKey = 'transaction_id';

    protected $fillable = [
        'product_id',
        'user_id',
        'transactionType',
        'quantity',
        'transactionDate',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'transactionDate' => 'datetime',
    ];

    /**
     * Get the product for this transaction
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }

    /**
     * Get the user who created this transaction
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
