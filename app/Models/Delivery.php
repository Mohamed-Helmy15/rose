<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Delivery extends Model
{
    protected $fillable = [
        'order_id', 'driver_id', 'scheduled_time', 'delivery_time', 'status', 'proof', 'notes'
    ];

    protected $casts = [
        'scheduled_time' => 'datetime',
        'delivery_time' => 'datetime',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    // تحديث حالة عند تسليم
    public function markDelivered(string $proof = null)
    {
        $this->delivery_time = now();
        $this->status = 'delivered';
        $this->proof = $proof;
        $this->save();

        // تحديث حالة الطلب إلى مكتمل
        $this->order->update(['status' => 'delivered']);
    }
}