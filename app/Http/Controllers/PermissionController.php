<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    use \App\Traits\LogActivity;

    public function index()
    {
        $permissions = Permission::all()->groupBy(function ($permission) {
            return explode('.', $permission->name)[0];
        });
        $totalPermissions = Permission::count();

        return view('dashboard.permissions.index', compact('permissions', 'totalPermissions'));
    }

    public function create()
    {
        return view('dashboard.permissions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'names' => 'required|array|min:1',
            'names.*' => 'required|string|regex:/^[a-z]+\.[a-z]+$/|unique:permissions,name',
        ], [
            'names.*.regex' => 'يجب أن تكون الصيغة: group.action (مثل: users.create)',
            'names.*.unique' => 'الصلاحية :input موجودة مسبقًا.',
        ]);

        $created = [];
        foreach ($request->names as $name) {
            $permission = Permission::create(['name' => trim($name)]);
            $created[] = $permission->name;
        }

        $this->logActivity('permissions_created', "تم إنشاء صلاحيات: " . implode(', ', $created));

        return redirect()->route('permissions.index')->with('toast', [
            'type' => 'bg-success',
            'message' => 'تم إنشاء ' . count($created) . ' صلاحية بنجاح'
        ]);
    }

    public function edit(Permission $permission)
    {
        return view('dashboard.permissions.edit', compact('permission'));
    }
    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required|string|regex:/^[a-z]+\.[a-z]+$/|unique:permissions,name,' . $permission->id,
        ], [
            'name.regex' => 'يجب أن تكون الصيغة: group.action (مثل: users.create)',
        ]);

        $oldName = $permission->name;
        $permission->update(['name' => $request->name]);

        $this->logActivity('permission_updated', "تم تعديل الصلاحية من '{$oldName}' إلى '{$permission->name}'");

        return redirect()->route('permissions.index')->with('toast', [
            'type' => 'bg-success',
            'message' => 'تم تحديث الصلاحية بنجاح'
        ]);
    }

    public function destroy(Permission $permission)
    {
        $permissionName = $permission->name;
        $permissionId = $permission->id;

        $permission->delete();

        // Log the permission deletion
        $this->logActivity('permission_deleted', "تم حذف صلاحية: {$permissionName} (ID: {$permissionId})");

        return redirect()->route('permissions.index')->with('toast', [
            'type' => 'bg-success',
            'message' => 'تم حذف الصلاحية بنجاح'
        ]);
    }
}