<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'governate_id', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];

    public function governate()
    {
        return $this->belongsTo(Governate::class);
    }

    public function locations()
    {
        return $this->hasMany(Location::class);
    }
}