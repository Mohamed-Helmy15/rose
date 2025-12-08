<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseOrder extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'supplier_id',
        'order_date',
        'expected_delivery_date',
        'total_amount',
        'status', // pending, received, partial, cancelled
        'notes',
    ];

    protected $casts = [
        'order_date' => 'date',
        'expected_delivery_date' => 'date',
        'total_amount' => 'decimal:2',
    ];

    // علاقات
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity', 'price', 'subtotal');
    }

    public function goodsReceivedNotes()
    {
        return $this->hasMany(GoodsReceivedNote::class);
    }

    public function calculateTotal()
    {
        $total = $this->products->sum(function ($product) {
            return $product->pivot->subtotal;
        });
        $this->total_amount = $total;
        $this->save();
        return $this->total_amount;
    }

    public function isFullyReceived($received): bool
    {
        $ordered = $this->products->sum('pivot.quantity');
        // dd($received, $ordered);
        return $received >= $ordered;
    }
}