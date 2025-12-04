<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use App\Models\Supplier;
use App\Models\Product;
use Illuminate\Http\Request;

class PurchaseOrderController extends Controller
{
    use \App\Traits\LogActivity;

    public function index()
    {
        $purchaseOrders = PurchaseOrder::with(['supplier'])
            ->latest()
            ->get();

        return view('dashboard.purchase_orders.index', compact('purchaseOrders'));
    }

    public function create()
    {
        $suppliers = Supplier::active()->get();
        $products = Product::active()->get();
        return view('dashboard.purchase_orders.create', compact('suppliers', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'order_date' => 'required|date',
            'expected_delivery_date' => 'required|date|after_or_equal:order_date',
            'notes' => 'nullable|string',
            'products' => 'required|array',
            'products.*.id' => 'exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.price' => 'required|numeric|min:0',
        ]);

        $purchaseOrder = PurchaseOrder::create([
            'supplier_id' => $request->supplier_id,
            'order_date' => $request->order_date,
            'expected_delivery_date' => $request->expected_delivery_date,
            'status' => 'pending',
            'notes' => $request->notes,
        ]);

        foreach ($request->products as $product) {
            $subtotal = $product['quantity'] * $product['price'];
            $purchaseOrder->products()->attach($product['id'], [
                'quantity' => $product['quantity'],
                'price' => $product['price'],
                'subtotal' => $subtotal,
            ]);
        }

        $purchaseOrder->calculateTotal();

        $this->logActivity('purchase_order_created', "تم إنشاء أمر شراء جديد: #{$purchaseOrder->id}");

        return redirect()->route('purchase-orders.index')
            ->with('toast', ['type' => 'success', 'message' => 'تم إضافة أمر الشراء بنجاح']);
    }

    public function show(PurchaseOrder $purchaseOrder)
    {
        $purchaseOrder->load(['supplier', 'products', 'goodsReceivedNotes']);

        return view('dashboard.purchase_orders.show', compact('purchaseOrder'));
    }

    public function edit(PurchaseOrder $purchaseOrder)
    {
        if ($purchaseOrder->status !== 'pending') {
            return back()->with('toast', ['type' => 'error', 'message' => 'لا يمكن تعديل أمر شراء غير معلق']);
        }

        $suppliers = Supplier::active()->get();
        $products = Product::active()->get();
        $selectedProducts = $purchaseOrder->products->map(function ($product) {
            return [
                'id' => $product->id,
                'quantity' => $product->pivot->quantity,
                'price' => $product->pivot->price,
            ];
        })->toArray();

        return view('dashboard.purchase_orders.edit', compact('purchaseOrder', 'suppliers', 'products', 'selectedProducts'));
    }

    public function update(Request $request, PurchaseOrder $purchaseOrder)
    {
        if ($purchaseOrder->status !== 'pending') {
            return back()->with('toast', ['type' => 'error', 'message' => 'لا يمكن تعديل أمر شراء غير معلق']);
        }

        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'order_date' => 'required|date',
            'expected_delivery_date' => 'required|date|after_or_equal:order_date',
            'notes' => 'nullable|string',
            'products' => 'required|array',
            'products.*.id' => 'exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.price' => 'required|numeric|min:0',
        ]);

        $purchaseOrder->update([
            'supplier_id' => $request->supplier_id,
            'order_date' => $request->order_date,
            'expected_delivery_date' => $request->expected_delivery_date,
            'notes' => $request->notes,
        ]);

        $purchaseOrder->products()->detach();
        foreach ($request->products as $product) {
            $subtotal = $product['quantity'] * $product['price'];
            $purchaseOrder->products()->attach($product['id'], [
                'quantity' => $product['quantity'],
                'price' => $product['price'],
                'subtotal' => $subtotal,
            ]);
        }

        $purchaseOrder->calculateTotal();

        $this->logActivity('purchase_order_updated', "تم تحديث أمر الشراء: #{$purchaseOrder->id}");

        return redirect()->route('purchase-orders.index')
            ->with('toast', ['type' => 'success', 'message' => 'تم تحديث أمر الشراء بنجاح']);
    }

    public function destroy(PurchaseOrder $purchaseOrder)
    {
        if ($purchaseOrder->status !== 'pending') {
            return back()->with('toast', ['type' => 'error', 'message' => 'لا يمكن حذف أمر شراء غير معلق']);
        }

        $id = $purchaseOrder->id;
        $purchaseOrder->products()->detach();
        $purchaseOrder->delete();

        $this->logActivity('purchase_order_deleted', "تم حذف أمر الشراء: #{$id}");

        return redirect()->route('purchase-orders.index')
            ->with('toast', ['type' => 'success', 'message' => 'تم حذف أمر الشراء بنجاح']);
    }

    public function getProducts(PurchaseOrder $purchaseOrder)
    {
        return response()->json($purchaseOrder->products);
    }
}