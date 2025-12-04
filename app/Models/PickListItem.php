<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PickListItem extends Model
{
    protected $table = 'pick_list_items';

    protected $fillable = [
        'pick_list_id',
        'product_id',
        'required_quantity',
        'picked_quantity',
    ];

    public function pickList()
    {
        return $this->belongsTo(PickList::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}