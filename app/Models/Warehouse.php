<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Warehouse extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name',
        'address',
        'is_refrigerated',
        'branch_id',
        'is_active'
    ];

    protected $casts = [
        'is_refrigerated' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function inventory(): HasMany
    {
        return $this->hasMany(Inventory::class);
    }

    // في Warehouse.php أضف الدالة دي
    public function batches()
    {
        return $this->hasMany(Batch::class)->where('quantity', '>', 0)->where('expiry_date', '>=', now());
    }

    public function stockMovements(): HasMany
    {
        return $this->hasMany(StockMovement::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getTotalQuantityAttribute(): int
    {
        return Batch::where('warehouse_id', $this->id)
            ->where('quantity', '>', 0)
            ->where('expiry_date', '>=', now())
            ->sum('quantity');
    }

    public function getLowStockCountAttribute(): int
    {
        return $this->inventory->filter(fn($item) => $item->is_low_stock)->count();
    }
}