<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name',
        'contact_name',
        'phone',
        'email',
        'address',
        'tax_number',
        'bank_details',
        'payment_terms',
        'delivery_time_days',
        'quality_rating',
        'is_active',
    ];

    protected $casts = [
        'quality_rating' => 'decimal:2',
        'is_active' => 'boolean',
        'delivery_time_days' => 'integer',
    ];

    // علاقات
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)->withPivot('price', 'min_order_quantity');
    }

    public function purchaseOrders(): HasMany
    {
        return $this->hasMany(PurchaseOrder::class);
    }

    public function evaluations(): HasMany
    {
        return $this->hasMany(SupplierEvaluation::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function calculateQualityRating()
    {
        $avg = $this->evaluations()->avg('rating');
        $this->quality_rating = $avg ?? 0;
        $this->save();
        return $this->quality_rating;
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($supplier) {
            $supplier->payment_terms = settings('default_payment_terms', 'Net 30');
            $supplier->delivery_time_days = settings('default_delivery_time', 7);
        });
    }
}