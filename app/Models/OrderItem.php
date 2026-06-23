<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id', 'product_id', 'product_name_snapshot', 
        'product_price_snapshot', 'quantity', 'subtotal'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class)->withTrashed(); // Need withTrashed because products can be soft deleted
    }
}
