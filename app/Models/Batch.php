<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Batch extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'product_id',
        'warehouse_id',
        'goods_received_note_id',
        'lot_number',
        'initial_quantity',
        'quantity',
        'receive_date',
        'expiry_date',
        'status', // available, expired, damaged, consumed
        'notes'
    ];

    protected $casts = [
        'receive_date' => 'date',
        'expiry_date' => 'date',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function goodsReceivedNote(): BelongsTo
    {
        return $this->belongsTo(GoodsReceivedNote::class);
    }

    public function stockMovements(): HasMany
    {
        return $this->hasMany(StockMovement::class);
    }

    public function isExpired()
    {
        return $this->expiry_date?->isPast() && $this->status !== 'expired';
    }

    public function scopeAvailable($query)
    {
        return $query->where('quantity', '>', 0)
            ->where('quantity', '>', 0)
            ->where('status', 'available')
            ->where('expiry_date', '>=', now());
    }

    public function scopeNearExpiry($query, $days = 7)
    {
        return $query->whereBetween('expiry_date', [now(), now()->addDays($days)]);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($batch) {
            if (!$batch->expiry_date && $batch->product) {
                $days = settings('shelf_life_days', 7);
                $batch->expiry_date = $batch->receive_date?->addDays($days);
            }
            if (!$batch->initial_quantity) {
                $batch->initial_quantity = $batch->quantity;
            }
        });
    }
}