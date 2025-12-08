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
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InventoryController extends Controller
{
    use \App\Traits\LogActivity; // افترض وجود trait للتسجيل

    public function index()
    {
        $warehouses = Warehouse::with(['branch', 'inventory.product'])
            ->when(settings('multi_branch') && !auth()->user()->hasRole('admin'), function ($q) {
                return $q->whereHas('branch.employees', fn($query) => $query->where('user_id', auth()->id()));
            })
            ->active()
            ->latest()
            ->get();

        // نحسب الإحصائيات بعد الـ load
        $totalLowStock = 0;
        $totalQuantity = 0;

        foreach ($warehouses as $warehouse) {
            foreach ($warehouse->inventory as $item) {
                if ($item->is_low_stock) {
                    $totalLowStock++;
                }
                $totalQuantity += $item->current_quantity;
            }
        }

        return view('dashboard.inventory.index', compact('warehouses', 'totalLowStock', 'totalQuantity'));
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
        // dd($pickLists);
        return view('dashboard.inventory.pick-lists', compact('pickLists'));
    }

    public function prepare(PickList $pickList)
    {
        if ($pickList->status !== 'pending') {
            return back()->with('toast', [
                'type' => 'error',
                'message' => 'لا يمكن بدء تجهيز قائمة تم البدء فيها مسبقًا'
            ]);
        }

        DB::transaction(function () use ($pickList) {
            $pickList->update([
                'status' => 'prepared',
                'prepared_by' => auth()->id(),
            ]);

            $order = $pickList->order;
            if ($order->status === 'new' || $order->status === 'preparing') {
                $order->update(['status' => 'ready']);
            }

            $this->logActivity('picklist_preparing', "بدأ تجهيز قائمة الانتقاء للطلب #{$pickList->order->order_number}");
        });

        return back()->with('toast', [
            'type' => 'success',
            'message' => 'تم بدء تجهيز القائمة بنجاح'
        ]);
    }

    public function complete(PickList $pickList)
    {
        if ($pickList->status !== 'prepared') {
            return back()->with('toast', [
                'type' => 'error',
                'message' => 'لا يمكن إكمال قائمة لم يتم البدء في تجهيزها'
            ]);
        }

        DB::transaction(function () use ($pickList) {
            $pickList->update([
                'status' => 'ready',
            ]);

            $order = $pickList->order;
            if ($order->status === 'ready') {
                $order->update(['status' => 'delivered']);
            }

            foreach ($pickList->items as $item) {
                $item->update([
                    'picked_quantity' => $item->required_quantity,
                ]);
            }

            $this->logActivity('picklist_completed', "تم إكمال تجهيز قائمة الانتقاء للطلب #{$order->order_number}");
        });

        return back()->with('toast', [
            'type' => 'success',
            'message' => 'تم إكمال تجهيز القائمة وهي جاهزة للتسليم'
        ]);
    }

    public function deliveries()
    {
        $deliveries = Delivery::with(['order', 'driver'])->latest()->get();
        return view('dashboard.inventory.deliveries', compact('deliveries'));
    }
}