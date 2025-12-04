<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    use \App\Traits\LogActivity;

    public function index(Request $request)
{
    $user = auth()->user();

    $query = $user->hasRole('admin')
        ? Notification::with('actor')
        : Notification::where('actor_id', $user->id)->with('actor');

    $notifications = $query->latest()->paginate(5);

    $todayCount = $user->hasRole('admin')
        ? Notification::whereDate('created_at', today())->count()
        : Notification::where('actor_id', $user->id)->whereDate('created_at', today())->count();

    if ($request->ajax()) {
        return view('dashboard.notifications.partials.timeline', compact('notifications', 'user'))->render();
    }

    return view('dashboard.notifications.index', compact('notifications', 'todayCount', 'user'));
}

    public function create()
    {
        $users = User::all();
        return view('dashboard.notifications.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'actor_id' => 'required|integer|exists:users,id',
            'action' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $notification = Notification::create($validated);

        // Log the creation of this notification (optional, for admin actions)
        $this->logActivity('notification_created', "Created notification: {$notification->id} - {$notification->description}");

        return redirect()->route('notifications.index')->with('toast', [
            'type' => 'success',
            'message' => 'تم الإنشاء بنجاح'
        ]);
    }

    public function show(Notification $notification)
    {
        return view('dashboard.notifications.show', compact('notification'));
    }

    public function edit(Notification $notification)
    {
        $users = User::all();
        return view('dashboard.notifications.edit', compact('notification', 'users'));
    }

    public function update(Request $request, Notification $notification)
    {
        $validated = $request->validate([
            'actor_id' => 'required|integer|exists:users,id',
            'action' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $notification->update($validated);

        // Log the update
        $this->logActivity('notification_updated', "Updated notification: {$notification->id} - {$notification->description}");

        return redirect()->route('notifications.index')->with('toast', [
            'type' => 'success',
            'message' => 'تم التحديث بنجاح'
        ]);
    }

    public function destroy(Notification $notification)
    {
        $description = $notification->description;
        $notification->delete();

        // Log the deletion
        $this->logActivity('notification_deleted', "Deleted notification: {$notification->id} - {$description}");

        return redirect()->route('notifications.index')->with('toast', [
            'type' => 'success',
            'message' => 'تم الحذف بنجاح'
        ]);
    }
}