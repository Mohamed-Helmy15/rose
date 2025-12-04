<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, HasRoles;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role',
        'branch_id',
        'is_active',
    ];

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'actor_id');
    }

    public function managedBranch()
    {
        return $this->hasOne(Branch::class, 'manager_id');
    }

    public function branches()
    {
        return $this->belongsToMany(Branch::class, 'branch_user');
    }

    public function inBranch($branchId)
    {
        if (!settings('multi_branch', false)) return true;
        return $this->branches()->where('branch_id', $branchId)->exists();
    }

    public function primaryBranch()
    {
        return $this->branches()->first();
    }
}
