<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use App\Models\Inventory;
use App\Models\Batch;
use App\Models\StockMovement;
use App\Models\PickList;
use App\Models\Delivery;
use App\Models\Product;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InventoryController extends Controller
{
    use \App\Traits\LogActivity; // افترض وجود trait للتسجيل

    public function index()
    {
        $warehouses = Warehouse::with(['inventory.product', 'branch'])
            ->when(settings('multi_branch') && !auth()->user()->hasRole('admin'), function ($q) {
                return $q->whereHas('branch.employees', fn($query) => $query->where('user_id', auth()->id()));
            })
            ->latest()
            ->get();

        return view('dashboard.inventory.index', compact('warehouses'));
    }

    public function create()
    {
        $branches = settings('multi_branch') ? Branch::active()->get() : collect();
        return view('dashboard.inventory.create', compact('branches'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'is_refrigerated' => 'sometimes|boolean',
            'branch_id' => settings('multi_branch') ? 'required|exists:branches,id' : 'nullable',
        ]);

        $data = $request->only(['name', 'address']);
        $data['branch_id'] = settings('multi_branch') ? $request->branch_id : null;
        $data['is_refrigerated'] = $request->has('is_refrigerated');
        $data['is_active'] = true;

        $warehouse = Warehouse::create($data);

        $this->logActivity('warehouse_created', "تم إنشاء مخزن جديد: {$warehouse->name}");

        return redirect()->route('inventory.index')
            ->with('toast', ['type' => 'success', 'message' => 'تم إضافة المخزن بنجاح']);
    }

    public function show(Warehouse $warehouse)
    {
        $warehouse->load(['inventory.product', 'batches.product', 'stockMovements.product', 'branch']);

        if (settings('multi_branch') && !auth()->user()->hasRole('admin')) {
            $allowed = $warehouse->branch && auth()->user()->branches()->where('branch_id', $warehouse->branch_id)->exists();
            if (!$allowed) {
                abort(403, 'غير مصرح لك برؤية هذا المخزن');
            }
        }

        return view('dashboard.inventory.show', compact('warehouse'));
    }

    public function edit(Warehouse $warehouse)
    {
        $branches = settings('multi_branch') ? Branch::active()->get() : collect();
        return view('dashboard.inventory.edit', compact('warehouse', 'branches'));
    }

    public function update(Request $request, Warehouse $warehouse)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'is_refrigerated' => 'sometimes|boolean',
            'branch_id' => settings('multi_branch') ? 'required|exists:branches,id' : 'nullable',
        ]);

        $data = $request->only(['name', 'address']);
        $data['branch_id'] = settings('multi_branch') ? $request->branch_id : null;
        $data['is_refrigerated'] = $request->has('is_refrigerated');

        $warehouse->update($data);

        $this->logActivity('warehouse_updated', "تم تحديث المخزن: {$warehouse->name}");

        return redirect()->route('inventory.index')
            ->with('toast', ['type' => 'success', 'message' => 'تم تحديث المخزن بنجاح']);
    }

    public function destroy(Warehouse $warehouse)
    {
        $name = $warehouse->name;
        $warehouse->delete();

        $this->logActivity('warehouse_deleted', "تم حذف المخزن: {$name}");

        return redirect()->route('inventory.index')
            ->with('toast', ['type' => 'success', 'message' => 'تم حذف المخزن بنجاح']);
    }

    // دالات إضافية (مثال)
    public function movements()
    {
        $movements = StockMovement::with(['product', 'warehouse', 'user'])->latest()->get();
        return view('dashboard.inventory.movements', compact('movements'));
    }

    public function batches()
    {
        $batches = Batch::with(['product', 'warehouse'])->latest()->get();
        return view('dashboard.inventory.batches', compact('batches'));
    }

    public function pickLists()
    {
        $pickLists = PickList::with(['order', 'preparedBy'])->latest()->get();
        return view('dashboard.inventory.pick-lists', compact('pickLists'));
    }

    public function deliveries()
    {
        $deliveries = Delivery::with(['order', 'driver'])->latest()->get();
        return view('dashboard.inventory.deliveries', compact('deliveries'));
    }
}