<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inventory extends Model
{
    protected $table = 'inventory';

    protected $fillable = ['product_id', 'warehouse_id'];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    /**
     * احسب الكمية الحالية من الباتشات الصالحة لهذا المنتج في هذا المخزن
     */
    public function getCurrentQuantityAttribute(): int
    {
        return \App\Models\Batch::where('product_id', $this->product_id)
            ->where('warehouse_id', $this->warehouse_id)
            ->where('quantity', '>', 0)
            ->where('expiry_date', '>=', now())
            ->sum('quantity');
    }

    /**
     * هل الكمية منخفضة؟
     */
    public function getIsLowStockAttribute(): bool
    {
        $reorderLevel = $this->product?->reorder_level ?? 10;
        return $this->current_quantity <= $reorderLevel;
    }
}