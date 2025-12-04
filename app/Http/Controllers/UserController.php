<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    use \App\Traits\LogActivity;

    public function index()
    {
        $users = User::with('roles')->get();
        $roles = Role::all();
        return view('dashboard.users.index', compact('users', 'roles'));
    }

    public function create()
    {
        $roles = Role::all();
        $branches = Branch::active()->get();
        return view('dashboard.users.create', compact('roles', 'branches'));
    }

    // في store()
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|exists:roles,name',
            'branch_ids' => 'sometimes|array',
            'branch_ids.*' => 'exists:branches,id',
            'is_active' => 'in:0,1',
        ]);

        $data = $request->only(['name', 'email', 'phone']);
        $data['password'] = Hash::make($request->password);
        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        $user = User::create($data);
        $user->assignRole($request->role);

        if (settings('multi_branch') && $request->filled('branch_ids')) {
            $user->branches()->sync($request->branch_ids);
        }

        $this->logActivity('user_created', "تم إنشاء مستخدم جديد: {$user->name} بدور {$request->role}");

        return redirect()->route('users.index')->with('toast', ['type' => 'success', 'message' => 'تم الإنشاء بنجاح']);
    }

    public function show(User $user)
    {
        return view('dashboard.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        $branches = Branch::active()->get();
        $userRole = $user->roles->pluck('name')->first();
        $userBranches = $user->branches->pluck('id')->toArray();
        // dd(settings('multi_branch'));
        return view('dashboard.users.edit', compact('user', 'roles', 'userRole', 'branches', 'userBranches'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'required|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|string|exists:roles,name',
            'branch_ids' => 'sometimes|array',
            'branch_ids.*' => 'exists:branches,id',
            'is_active' => 'in:0,1',
        ]);

        $data = $request->only(['name', 'email', 'phone']);
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        $user->update($data);
        $user->syncRoles([$request->role]);

        if (settings('multi_branch')) {
            $user->branches()->sync($request->filled('branch_ids') ? $request->branch_ids : []);
        }

        $this->logActivity('user_updated', "تم تحديث مستخدم: {$user->name}");

        return redirect()->route('users.index')->with('toast', ['type' => 'success', 'message' => 'تم التحديث بنجاح']);
    }
    public function destroy(User $user)
    {
        $userName = $user->name;
        $userId = $user->id;
        $userRole = $user->roles->pluck('name')->first();

        $user->delete();

        // Log the user deletion
        $this->logActivity('user_deleted', "تم حذف مستخدم: {$userName} (ID: {$userId}, دور: {$userRole})");

        return redirect()->route('users.index')->with('toast', [
            'type' => 'success',
            'message' => 'تم الحذف بنجاح'
        ]);
    }
}