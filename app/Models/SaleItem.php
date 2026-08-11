<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SaleItem extends Model
{
    /**
     * The attributes that are mass assignable.
     * 
     * @var array<int, string>
     */
    protected $fillable = [
        'sale_id',
        'product_id',
        'unit_price',
        'quantity',
        'subtotal',        
    ];

    public function sale():BelongsTo
    {
        return $this->belongsTo(Sale::class);
    }

    public function product():BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
