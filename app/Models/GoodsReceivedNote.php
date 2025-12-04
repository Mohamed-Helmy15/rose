<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class GoodsReceivedNote extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'purchase_order_id',
        'received_date',
        'received_by_user_id',
        'notes',
        'status',
    ];

    protected $casts = [
        'received_date' => 'date',
    ];

    public function purchaseOrder(): BelongsTo
    {
        return $this->belongsTo(PurchaseOrder::class);
    }

    public function receivedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'received_by_user_id');
    }

    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'grn_items')
            ->withPivot('quantity', 'quality_status', 'lot_number', 'expiry_date');
    }

    // دالة جديدة: إنشاء Batches تلقائياً
    public function createBatchesFromItems($warehouse_id)
    {
        foreach ($this->items as $item) {
            if ($item->pivot->quality_status === 'accepted' && $item->pivot->quantity > 0) {
                Batch::create([
                    'product_id' => $item->id,
                    'warehouse_id' => $warehouse_id,
                    'goods_received_note_id' => $this->id,
                    'lot_number' => $item->pivot->lot_number,
                    'quantity' => $item->pivot->quantity,
                    'receive_date' => $this->received_date,
                    'expiry_date' => $item->pivot->expiry_date,
                    'status' => 'available',
                ]);
            }
        }
    }
}