<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Branch extends Model
{
    protected $fillable = [
        'name', 'code', 'manager_id', 'phone', 'address',
        'latitude', 'longitude', 'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    public function manager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function employees(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'branch_user');
    }

    public function warehouse()
    {
        return $this->hasOne(Warehouse::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}