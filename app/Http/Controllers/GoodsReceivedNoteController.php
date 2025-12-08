<?php

namespace App\Http\Controllers;

use App\Models\GoodsReceivedNote;
use App\Models\PurchaseOrder;
use App\Models\Batch;
use App\Models\StockMovement;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GoodsReceivedNoteController extends Controller
{
    use \App\Traits\LogActivity;

    public function index()
    {
        $grns = GoodsReceivedNote::with(['purchaseOrder.supplier', 'receivedBy'])
            ->latest()
            ->get();
        

        return view('dashboard.goods_received_notes.index', compact('grns'));
    }

    public function create()
    {
        $purchaseOrders = PurchaseOrder::whereIn('status', ['pending', 'partial'])
            ->with('products')
            ->get();
        $warehouses = Warehouse::active()->get();
        return view('dashboard.goods_received_notes.create', compact('purchaseOrders', 'warehouses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'purchase_order_id' => 'required|exists:purchase_orders,id',
            'received_date' => 'required|date',
            'warehouse_id' => 'required|exists:warehouses,id',
            'notes' => 'nullable|string',
            'items' => 'required|array',
            'items.*.id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:0',
            'items.*.quality_status' => 'required|in:accepted,rejected,partial',
            'items.*.lot_number' => 'nullable|string|max:50',
            'items.*.expiry_date' => 'nullable|date|after_or_equal:received_date',
        ]);

        return DB::transaction(function () use ($request) {
            $po = PurchaseOrder::with('products')->findOrFail($request->purchase_order_id);

            $grn = GoodsReceivedNote::create([
                'purchase_order_id' => $request->purchase_order_id,
                'received_date' => $request->received_date,
                'received_by_user_id' => auth()->id(),
                'status' => 'accepted',
                'notes' => $request->notes,
            ]);

            $totalAcceptedThisGrn = 0;

            foreach ($request->items as $item) {
                $productId = $item['id'];
                $quantity = (int)$item['quantity'];
                $qualityStatus = $item['quality_status'];

                // فقط المقبول يدخل المخزون
                if ($qualityStatus === 'accepted' && $quantity > 0) {
                    $totalAcceptedThisGrn += $quantity;

                    Batch::create([
                        'product_id' => $productId,
                        'warehouse_id' => $request->warehouse_id,
                        'goods_received_note_id' => $grn->id,
                        'lot_number' => $item['lot_number'] ?? null,
                        'quantity' => $quantity,
                        'initial_quantity' => $quantity,
                        'receive_date' => $request->received_date,
                        'expiry_date' => $item['expiry_date'] ?? null,
                        'status' => 'available',
                    ]);

                    StockMovement::create([
                        'product_id' => $productId,
                        'batch_id' => null, // سيتم تحديثه لاحقًا إذا أردت
                        'warehouse_id' => $request->warehouse_id,
                        'type' => 'in',
                        'quantity' => $quantity,
                        'reason' => "استلام بموجب إيصال #{$grn->id}",
                        'purchase_order_id' => $po->id,
                        'user_id' => auth()->id(),
                    ]);
                }

                $grn->items()->attach($productId, [
                    'quantity' => $quantity,
                    'quality_status' => $qualityStatus,
                    'lot_number' => $item['lot_number'] ?? null,
                    'expiry_date' => $item['expiry_date'] ?? null,
                ]);
            }

            // === الحساب الصحيح لحالة أمر الشراء ===
            $totalOrdered = $po->products->sum('pivot.quantity');

            // اجمع كل الكميات المقبولة من كل الـ GRNs لهذا الأمر
            $totalReceivedAccepted = $po->goodsReceivedNotes()
                ->with('items')
                ->get()
                ->sum(function ($grn) {
                    return $grn->items()
                        ->wherePivot('quality_status', 'accepted')
                        ->sum('grn_items.quantity');
                });

            // تحديث حالة أمر الشراء
            if ($totalReceivedAccepted >= $totalOrdered) {
                $po->status = 'received';
            } elseif ($totalReceivedAccepted > 0) {
                $po->status = 'partial';
            } else {
                $po->status = 'pending';
            }

            $po->save();

            $this->logActivity('grn_created', "تم إنشاء إيصال استلام #{$grn->id} لأمر الشراء #{$po->id}");

            return redirect()->route('goods-received-notes.index')
                ->with('toast', ['type' => 'success', 'message' => 'تم إضافة إيصال الاستلام بنجاح وتحديث حالة أمر الشراء']);
        });
    }

    public function show(GoodsReceivedNote $goodsReceivedNote)
    {
        $goodsReceivedNote->load(['purchaseOrder.supplier', 'items', 'receivedBy']);
        return view('dashboard.goods_received_notes.show', compact('goodsReceivedNote'));
    }

    public function edit(GoodsReceivedNote $goodsReceivedNote)
    {
        abort(404);
    }

    public function update(Request $request, GoodsReceivedNote $goodsReceivedNote)
    {
        abort(404);
    }

    public function destroy(GoodsReceivedNote $goodsReceivedNote)
    {
        abort(404);
    }

    // === جديد: جلب المنتجات مع الكمية المتبقية ===
    public function getPurchaseOrderItems($id)
{
    $po = PurchaseOrder::with('products')->findOrFail($id);

    // الكمية المطلوبة في ال PO
    $ordered = [];
    foreach ($po->products as $product) {
        $ordered[$product->id] = $product->pivot->quantity;
    }

    // احضار GRN مع items
    $receivedGrns = GoodsReceivedNote::where('purchase_order_id', $po->id)
        ->with('items')
        ->get();

    // تجميع الكميات المستلمة من pivot
    $receivedTotals = [];
    foreach ($receivedGrns as $grn) {
        foreach ($grn->items as $item) {

            $pid = $item->pivot->product_id;
            $qty = $item->pivot->quantity;

            if (!isset($receivedTotals[$pid])) {
                $receivedTotals[$pid] = 0;
            }

            $receivedTotals[$pid] += $qty;
        }
    }

    // تجهيز البيانات النهائية
    $items = $po->products->map(function ($product) use ($ordered, $receivedTotals) {
        $received = $receivedTotals[$product->id] ?? 0;
        $remaining = $ordered[$product->id] - $received;

        return [
            'id' => $product->id,
            'name' => $product->name,
            'ordered_quantity' => $ordered[$product->id],
            'received_quantity' => $received,
            'remaining_quantity' => max(0, $remaining),
        ];
    });

    return response()->json($items);
}

}