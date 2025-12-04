<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    use \App\Traits\LogActivity;

    public function index()
    {
        $roles = Role::with('permissions')->get();
        $allPermissions = Permission::all();
        return view('dashboard.roles.index', compact('roles', 'allPermissions'));
    }

    public function create()
    {
        // هنقسم الصلاحيات في مجموعات (مثلاً: فروع - مستخدمين - تقارير)
        $permissions = Permission::all()->groupBy(function($item) {
            return explode('.', $item->name)[0]; // مثال: users.create → users
        });

        $role=null;

        return view('dashboard.roles.edit', compact('permissions', 'role'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'array',
        ]);

        $role = Role::create(['name' => $request->name]);
        $role->syncPermissions($request->permissions);

        $permissionsCount = count($request->permissions ?? []);
        // Log the role creation
        $this->logActivity('role_created', "تم إنشاء دور جديد: {$role->name} (ID: {$role->id}) مع {$permissionsCount} صلاحية");

        return redirect()->route('roles.index')->with('toast', [
            'type' => 'bg-success',
            'message' => 'تم إنشاء الدور بنجاح'
        ]);
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all()->groupBy(function($item) {
            return explode('.', $item->name)[0];
        });

        $rolePermissions = $role->permissions->pluck('name')->toArray();

        return view('dashboard.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
            'permissions' => 'array',
        ]);

        $oldName = $role->name;
        $oldPermissionsCount = $role->permissions->count();
        $role->update(['name' => $request->name]);
        $role->syncPermissions($request->permissions);

        $newPermissionsCount = count($request->permissions ?? []);

        // Log the role update
        $this->logActivity('role_updated', "تم تحديث دور: من {$oldName} إلى {$role->name} (ID: {$role->id}) - الصلاحيات: من {$oldPermissionsCount} إلى {$newPermissionsCount}");

        return redirect()->route('roles.index')->with('toast', [
            'type' => 'bg-success',
            'message' => 'تم تحديث الدور بنجاح'
        ]);
    }

    public function destroy(Role $role)
    {
        $roleName = $role->name;
        $roleId = $role->id;
        $permissionsCount = $role->permissions->count();

        $role->delete();

        // Log the role deletion
        $this->logActivity('role_deleted', "تم حذف دور: {$roleName} (ID: {$roleId}) الذي يحتوي على {$permissionsCount} صلاحية");

        return redirect()->route('roles.index')->with('toast', [
            'type' => 'bg-success',
            'message' => 'تم حذف الدور بنجاح'
        ]);
    }
}