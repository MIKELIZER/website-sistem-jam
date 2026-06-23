<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'order_number', 'recipient_name', 'recipient_phone', 
        'shipping_address', 'subtotal', 'shipping_cost', 'grand_total', 
        'status', 'notes'
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function trackingLogs()
    {
        return $this->hasMany(OrderTrackingLog::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
