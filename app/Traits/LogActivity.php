<?php


namespace App\Traits;

use App\Models\Notification;

trait LogActivity
{
    protected function logActivity(string $action, string $description): void
    {
        Notification::create([
            'actor_id' => auth()->id(),
            'action' => $action,
            'description' => $description,
        ]);
    }
}