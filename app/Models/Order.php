<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'order_number',
        'customer_id',
        'customer_name',
        'customer_phone',
        'customer_address',
        'branch_id',
        'user_id',
        'source',
        'subtotal',
        'tax',
        'shipping',
        'discount',
        'total',
        'commission_amount',
        'status',
        'payment_status',
        'payment_method',
        'notes',
        'delivered_at'
    ];

    protected $casts = [
        'delivered_at' => 'datetime',
        'subtotal' => 'decimal:2',
        'tax' => 'decimal:2',
        'shipping' => 'decimal:2',
        'discount' => 'decimal:2',
        'total' => 'decimal:2',
        'commission_amount' => 'decimal:2',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function commission()
    {
        return $this->hasOne(Commission::class);
    }

    public function getStatusArabicAttribute()
    {
        return [
            'new' => 'جديد',
            'preparing' => 'قيد التجهيز',
            'ready' => 'جاهز',
            'out_for_delivery' => 'في التوصيل',
            'delivered' => 'تم التسليم',
            'canceled' => 'ملغي',
            'returned' => 'مرتجع',
        ][$this->status] ?? $this->status;
    }
}