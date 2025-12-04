<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\PurchaseOrder;
use App\Models\GoodsReceivedNote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SupplierController extends Controller
{
    use \App\Traits\LogActivity;

    public function index()
    {
        $suppliers = Supplier::withCount('purchaseOrders')
            ->latest()
            ->get();

        return view('dashboard.suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        return view('dashboard.suppliers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'contact_name' => 'nullable|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'tax_number' => 'nullable|string|max:50',
            'bank_details' => 'nullable|string',
            'payment_terms' => 'nullable|string|max:100',
            'delivery_time_days' => 'nullable|integer|min:1',
            'is_active' => 'sometimes|boolean',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        $supplier = Supplier::create($data);

        $this->logActivity('supplier_created', "تم إنشاء مورد جديد: {$supplier->name}");

        return redirect()->route('suppliers.index')
            ->with('toast', ['type' => 'success', 'message' => 'تم إضافة المورد بنجاح']);
    }

    public function show(Supplier $supplier)
    {
        $supplier->load(['purchaseOrders', 'evaluations']);

        return view('dashboard.suppliers.show', compact('supplier'));
    }

    public function edit(Supplier $supplier)
    {
        return view('dashboard.suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'contact_name' => 'nullable|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'tax_number' => 'nullable|string|max:50',
            'bank_details' => 'nullable|string',
            'payment_terms' => 'nullable|string|max:100',
            'delivery_time_days' => 'nullable|integer|min:1',
            'is_active' => 'sometimes|boolean',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        $supplier->update($data);

        $this->logActivity('supplier_updated', "تم تحديث المورد: {$supplier->name}");

        return redirect()->route('suppliers.index')
            ->with('toast', ['type' => 'success', 'message' => 'تم تحديث المورد بنجاح']);
    }

    public function destroy(Supplier $supplier)
    {
        if ($supplier->purchaseOrders()->exists()) {
            return back()->with('toast', ['type' => 'error', 'message' => 'لا يمكن حذف مورد له أوامر شراء']);
        }

        $name = $supplier->name;
        $supplier->delete();

        $this->logActivity('supplier_deleted', "تم حذف المورد: {$name}");

        return redirect()->route('suppliers.index')
            ->with('toast', ['type' => 'success', 'message' => 'تم حذف المورد بنجاح']);
    }
}