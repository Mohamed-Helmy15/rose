<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockMovement extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'product_id', 'batch_id', 'warehouse_id', 'type', 'quantity', 'reason', 'order_id', 'purchase_order_id', 'user_id'
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function batch(): BelongsTo
    {
        return $this->belongsTo(Batch::class);
    }

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function purchaseOrder(): BelongsTo
    {
        return $this->belongsTo(PurchaseOrder::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($movement) {
            // dd('StockMovement created:', $movement->toArray());
            $inventory = Inventory::firstOrCreate([
                'product_id' => $movement->product_id,
                'warehouse_id' => $movement->warehouse_id,
            ]);

            // $inventory->updateQuantity($movement->quantity, $movement->type);

            // إذا FEFO, اختر batch تلقائياً للخروج
            if (settings('inventory_method') === 'FEFO' && $movement->type === 'out' && !$movement->batch_id) {
                $batch = Batch::where('product_id', $movement->product_id)
                    ->where('warehouse_id', $movement->warehouse_id)
                    ->where('status', 'available')
                    ->orderBy('expiry_date', 'asc') // أقرب صالحية أولاً
                    ->first();
                if ($batch) {
                    $movement->batch_id = $batch->id;
                    $movement->save();
                    $batch->quantity -= $movement->quantity;
                    $batch->save();
                }
            }
        });
    }
}