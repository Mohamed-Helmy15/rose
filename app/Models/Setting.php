<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class Setting extends Model
{
    protected $fillable = ['key', 'value', 'type', 'group', 'description', 'order'];

    protected $casts = [
        'value' => 'string',
    ];

    public static function boot()
    {
        parent::boot();

        static::saved(function () {
            Cache::forget('app_settings');
        });

        static::deleted(function () {
            Cache::forget('app_settings');
        });
    }

    public static function get($key, $default = null)
    {
        $settings = Cache::rememberForever('app_settings', fn() => self::pluck('value', 'key')->toArray());
        return $settings[$key] ?? $default;
    }

    public static function allSettings()
    {
        return Cache::rememberForever('app_settings', fn() => self::orderBy('group')->orderBy('order')->get());
    }

    public function getValueAttribute($value)
    {
        return match ($this->type) {
            'boolean' => (bool) $value,
            'number' => (int) $value,
            default => $value,
        };
    }
}