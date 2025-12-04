<?php

use Illuminate\Support\Facades\File;

if (!function_exists('create_storage_link')) {
    function create_storage_link(): string
    {
        $target = storage_path('app/public');
        $link = public_path('storage');

        try {
            // Already exists
            if (file_exists($link)) {
                return 'Storage link already exists.';
            }

            // Try symlink first
            if (function_exists('symlink')) {
                symlink($target, $link);
                return 'Storage symlink created successfully.';
            }

            // If symlink not available, fallback to copy
            File::copyDirectory($target, $link);
            return 'Symlink not available. Storage directory copied instead.';
        } catch (\Exception $e) {
            return 'Error: ' . $e->getMessage();
        }
    }
}

if (!function_exists('settings')) {
    function settings($key, $default = null)
    {
        return \App\Models\Setting::get($key, $default);
    }
}
