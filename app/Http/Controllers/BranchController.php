<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class BranchController extends Controller
{
    use \App\Traits\LogActivity;

    public function index()
    {
        $branches = Branch::with(['manager', 'employees'])->get();
        return view('dashboard.branches.index', compact('branches'));
    }

    public function create()
    {
        $managers = User::role('manager')->get();
        $employees = User::all();
        return view('dashboard.branches.create', compact('managers', 'employees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:branches,code',
            'manager_id' => 'nullable|exists:users,id',
            'employee_ids' => 'array',
            'employee_ids.*' => 'exists:users,id',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'is_active' => 'in:0,1',
        ]);

        $data = $request->only([
            'name', 'code', 'manager_id', 'phone', 'address',
            'latitude', 'longitude'
        ]);
        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        $branch = Branch::create($data);

        if ($request->filled('employee_ids')) {
            $branch->employees()->sync($request->employee_ids);
        }

        $this->logActivity('branch_created', "تم إنشاء فرع جديد: {$branch->name} (ID: {$branch->id}, كود: {$branch->code})");

        return redirect()->route('branches.index')->with('toast', [
            'type' => 'success',
            'message' => 'تم إنشاء الفرع بنجاح'
        ]);
    }

    public function show(Branch $branch)
    {
        $branch->load(['manager', 'employees']);
        return view('dashboard.branches.show', compact('branch'));
    }

    public function edit(Branch $branch)
    {
        $managers = User::role('manager')->get();
        $employees = User::all();
        $branch->load('employees');
        return view('dashboard.branches.edit', compact('branch', 'managers', 'employees'));
    }

    public function update(Request $request, Branch $branch)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:branches,code,' . $branch->id,
            'manager_id' => 'nullable|exists:users,id',
            'employee_ids' => 'array',
            'employee_ids.*' => 'exists:users,id',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'is_active' => 'in:0,1',
        ]);

        $oldName = $branch->name;
        $oldCode = $branch->code;

        $data = $request->only([
            'name', 'code', 'manager_id', 'phone', 'address',
            'latitude', 'longitude'
        ]);
        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        $branch->update($data);

        if ($request->filled('employee_ids')) {
            $branch->employees()->sync($request->employee_ids);
        } else {
            $branch->employees()->detach();
        }

        $this->logActivity('branch_updated', "تم تحديث فرع: من {$oldName} (كود: {$oldCode}) إلى {$branch->name} (كود: {$branch->code}, ID: {$branch->id})");

        return redirect()->route('branches.index')->with('toast', [
            'type' => 'success',
            'message' => 'تم تحديث الفرع بنجاح'
        ]);
    }

    public function destroy(Branch $branch)
    {
        $branchName = $branch->name;
        $branchId = $branch->id;

        $branch->employees()->detach();
        $branch->delete();

        $this->logActivity('branch_deleted', "تم حذف فرع: {$branchName} (ID: {$branchId})");

        return redirect()->route('branches.index')->with('toast', [
            'type' => 'success',
            'message' => 'تم حذف الفرع بنجاح'
        ]);
    }
}