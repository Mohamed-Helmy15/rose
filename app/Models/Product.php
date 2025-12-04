<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'sku',
        'description',
        'price',
        'cost_price',
        'reorder_level',
        'color',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'cost_price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    // علاقات
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class)->withTimestamps();
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }

    public function batches(): HasMany
    {
        return $this->hasMany(Batch::class);
    }

    public function inventory(): HasMany
    {
        return $this->hasMany(Inventory::class);
    }

    // الكمية المتاحة (في كل المخازن أو مخزن معين)
    public function getAvailableQuantityAttribute($warehouse_id = null)
    {
        $query = $this->batches()->available();
        if ($warehouse_id) {
            $query->where('warehouse_id', $warehouse_id);
        }
        return $query->sum('quantity');
    }

    // جلب الباتشات المتاحة حسب FEFO
    public function availableBatches($warehouse_id)
    {
        return $this->batches()
            ->where('warehouse_id', $warehouse_id)
            ->available()
            ->orderBy('expiry_date', 'asc')
            ->get();
    }

    public function priceWithTax(): float
    {
        $vat = settings('vat_rate', 0) / 100;
        $inclusive = settings('vat_inclusive', false);

        return $inclusive ? $this->price : $this->price * (1 + $vat);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            $product->sku = $product->generateSku();
        });
    }

    public function generateSku(): string
    {
        $prefix = 'ROSE-';
        $number = Product::withTrashed()->max('id') + 1;
        return $prefix . str_pad($number, 6, '0', STR_PAD_LEFT);
    }
}