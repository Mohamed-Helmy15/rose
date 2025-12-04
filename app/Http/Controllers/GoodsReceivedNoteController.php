<?php

namespace App\Http\Controllers;

use App\Models\GoodsReceivedNote;
use App\Models\PurchaseOrder;
use App\Models\Product;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\Sum;

class GoodsReceivedNoteController extends Controller
{
    use \App\Traits\LogActivity;

    public function index()
    {
        $grns = GoodsReceivedNote::with(['purchaseOrder.supplier'])
            ->latest()
            ->get();

        return view('dashboard.goods_received_notes.index', compact('grns'));
    }

    public function create()
    {
        $purchaseOrders = PurchaseOrder::where('status', 'pending')->orWhere('status', 'partial')->get();
        return view('dashboard.goods_received_notes.create', compact('purchaseOrders'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'purchase_order_id' => 'required|exists:purchase_orders,id',
            'received_date' => 'required|date',
            'notes' => 'nullable|string',
            'items' => 'required|array',
            'items.*.id' => 'exists:products,id',
            'items.*.quantity' => 'required|integer|min:0',
            'items.*.quality_status' => 'required|in:accepted,rejected,partial',
            'items.*.lot_number' => 'nullable|string',
            'items.*.expiry_date' => 'nullable|date',
        ]);

        $grn = GoodsReceivedNote::create([
            'purchase_order_id' => $request->purchase_order_id,
            'received_date' => $request->received_date,
            'received_by_user_id' => auth()->id(),
            'status' => 'accepted',
            'notes' => $request->notes,
        ]);

        foreach ($request->items as $item) {
            $grn->items()->attach($item['id'], [
                'quantity' => $item['quantity'],
                'quality_status' => $item['quality_status'],
                'lot_number' => $item['lot_number'] ?? null,
                'expiry_date' => $item['expiry_date'] ?? null,
            ]);
        }

        $grn->updateStock();

        $po = $grn->purchaseOrder;
        $totalQuantityReceived =  $grn->items->sum('pivot.quantity');
        if ($po->isFullyReceived($totalQuantityReceived)) {
            $po->status = 'received';
        } else {
            $po->status = 'partial';
        }
        $po->save();

        $this->logActivity('grn_created', "تم إنشاء إيصال استلام جديد: #{$grn->id}");

        return redirect()->route('goods-received-notes.index')
            ->with('toast', ['type' => 'success', 'message' => 'تم إضافة إيصال الاستلام بنجاح']);
    }

    public function show(GoodsReceivedNote $goodsReceivedNote)
    {
        $goodsReceivedNote->load(['purchaseOrder.supplier', 'items', 'receivedBy']);

        return view('dashboard.goods_received_notes.show', compact('goodsReceivedNote'));
    }

    public function edit(GoodsReceivedNote $goodsReceivedNote)
    {
        // Assuming GRN can be edited if not final
        $purchaseOrders = PurchaseOrder::where('status', 'pending')->orWhere('status', 'partial')->get();
        $selectedItems = $goodsReceivedNote->items->map(function ($item) {
            return [
                'id' => $item->id,
                'quantity' => $item->pivot->quantity,
                'quality_status' => $item->pivot->quality_status,
                'lot_number' => $item->pivot->lot_number,
                'expiry_date' => $item->pivot->expiry_date,
            ];
        })->toArray();
        $products = Product::whereIn('id', array_column($selectedItems, 'id'))->get();

        return view('dashboard.goods_received_notes.edit', compact('goodsReceivedNote', 'purchaseOrders', 'selectedItems', 'products'));
    }

    public function update(Request $request, GoodsReceivedNote $goodsReceivedNote)
    {
        $validated = $request->validate([
            'purchase_order_id' => 'required|exists:purchase_orders,id',
            'received_date' => 'required|date',
            'notes' => 'nullable|string',
            'items' => 'required|array',
            'items.*.id' => 'exists:products,id',
            'items.*.quantity' => 'required|integer|min:0',
            'items.*.quality_status' => 'required|in:accepted,rejected,partial',
            'items.*.lot_number' => 'nullable|string',
            'items.*.expiry_date' => 'nullable|date',
        ]);

        $goodsReceivedNote->update([
            'purchase_order_id' => $request->purchase_order_id,
            'received_date' => $request->received_date,
            'notes' => $request->notes,
        ]);

        // Reverse stock update if needed
        foreach ($goodsReceivedNote->items as $item) {
            if ($item->pivot->quality_status === 'accepted') {
                $item->decrement('stock_quantity', $item->pivot->quantity);
            }
        }

        $goodsReceivedNote->items()->detach();
        foreach ($request->items as $item) {
            $goodsReceivedNote->items()->attach($item['id'], [
                'quantity' => $item['quantity'],
                'quality_status' => $item['quality_status'],
                'lot_number' => $item['lot_number'] ?? null,
                'expiry_date' => $item['expiry_date'] ?? null,
            ]);
        }

        $goodsReceivedNote->updateStock();

        $po = $goodsReceivedNote->purchaseOrder;
        $totalQuantityReceived =  $goodsReceivedNote->items->sum('pivot.quantity');
        if ($po->isFullyReceived($totalQuantityReceived)) {
            $po->status = 'received';
        } else {
            $po->status = 'partial';
        }
        $po->save();

        $this->logActivity('grn_updated', "تم تحديث إيصال الاستلام: #{$goodsReceivedNote->id}");

        return redirect()->route('goods-received-notes.index')
            ->with('toast', ['type' => 'success', 'message' => 'تم تحديث إيصال الاستلام بنجاح']);
    }

    public function destroy(GoodsReceivedNote $goodsReceivedNote)
    {
        // Reverse stock update
        foreach ($goodsReceivedNote->items as $item) {
            if ($item->pivot->quality_status === 'accepted') {
                $item->decrement('stock_quantity', $item->pivot->quantity);
            }
        }

        $id = $goodsReceivedNote->id;
        $goodsReceivedNote->items()->detach();
        $goodsReceivedNote->delete();

        $po = $goodsReceivedNote->purchaseOrder;
        $po->status = 'pending'; // or recalculate
        $po->save();

        $this->logActivity('grn_deleted', "تم حذف إيصال الاستلام: #{$id}");

        return redirect()->route('goods-received-notes.index')
            ->with('toast', ['type' => 'success', 'message' => 'تم حذف إيصال الاستلام بنجاح']);
    }
}