<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PickList extends Model
{

    protected $fillable = [
        'order_id', 'status', 'notes', 'prepared_by'
    ];


    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function preparedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'prepared_by');
    }

    public function items(): HasMany
    {
        return $this->hasMany(PickListItem::class);
    }

    public static function generateFromOrder(Order $order)
    {
        $pickList = self::updateOrCreate(
            ['order_id' => $order->id],
            ['status' => 'pending', 'prepared_by' => auth()->id()]
        );

        foreach ($order->items as $item) {
            $pickList->items()->updateOrCreate(
                ['product_id' => $item->product_id],
                ['required_quantity' => $item->quantity]
            );
        }

        return $pickList;
    }
}