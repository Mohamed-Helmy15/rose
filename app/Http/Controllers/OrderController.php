<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Delivery;
use App\Models\Order;
use App\Models\PickList;
use App\Models\Commission;
use App\Models\StockMovement;
use App\Models\Batch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    use \App\Traits\LogActivity;

    public function index()
    {
        $orders = Order::with(['branch', 'user', 'customer'])
            ->when(settings('multi_branch') && !auth()->user()->hasRole('super-admin'), fn($q) => $q->where('branch_id', auth()->user()->primaryBranch()?->id))
            ->latest()
            ->paginate(20);

        return view('dashboard.orders.index', compact('orders'));
    }

    public function pos()
    {
        $products = \App\Models\Product::active()->with('primaryImage')->get();
        return view('dashboard.pos.index', compact('products'));
    }

    public function storePos(Request $request)
    {
        return $this->createOrder($request->all() + ['source' => 'pos']);
    }

    public function storeWebsite(Request $request)
    {
        return $this->createOrder($request->all() + ['source' => 'website']);
    }

    private function createOrder($data)
    {
        $branch = auth()->user()->primaryBranch();
        $warehouse = $branch?->warehouse;

        if (!$warehouse) {
            return back()->with('toast', ['type' => 'error', 'message' => 'لا يوجد مخزن للفرع']);
        }

        return DB::transaction(function () use ($data, $warehouse, $branch) {
            $lineItems = [];
            $subtotal = 0;

            foreach ($data['items'] as $itemData) {
                $product = \App\Models\Product::findOrFail($itemData['product_id']);
                $needed = (int) $itemData['quantity'];

                $batches = $product->availableBatches($warehouse->id);
                $available = $batches->sum('quantity');

                if ($available < $needed) {
                    return back()->with('toast', ['type' => 'error', 'message' => "الكمية غير متوفرة لـ {$product->name} (متوفر: {$available})"]);
                }

                $price = $product->priceWithTax();
                $lineTotal = $price * $needed;
                $subtotal += $lineTotal;

                $allocatedBatches = $this->allocateBatches($batches, $needed);

                $lineItems[] = [
                    'product_id' => $product->id,
                    'quantity' => $needed,
                    'price' => $price,
                    'total' => $lineTotal,
                    'batches' => $allocatedBatches,
                ];
            }

            $tax = $subtotal * (settings('vat_rate', 0) / 100);
            $total = $subtotal + $tax + ($data['shipping'] ?? 0) - ($data['discount'] ?? 0);

            $customer = $this->getOrCreateCustomer($data);

            $order = Order::create([
                'order_number' => 'ORD-' . str_pad(Order::max('id') + 1, 6, '0', STR_PAD_LEFT),
                'customer_id' => $customer->id,
                'customer_name' => $data['customer_name'],
                'customer_phone' => $data['customer_phone'],
                'customer_address' => $data['customer_address'] ?? null,
                'branch_id' => $branch->id,
                'user_id' => auth()->id(),
                'source' => $data['source'],
                'subtotal' => $subtotal,
                'tax' => $tax,
                'shipping' => $data['shipping'] ?? 0,
                'discount' => $data['discount'] ?? 0,
                'total' => $total,
                'payment_method' => $data['payment_method'] ?? 'cash',
                'notes' => $data['notes'] ?? null,
                'status' => 'new',
                'payment_status' => 'paid',
            ]);

            foreach ($lineItems as $item) {
                $orderItem = $order->items()->create([
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price_at_sale' => $item['price'],
                    'total' => $item['total'],
                ]);

                foreach ($item['batches'] as $alloc) {
                    $batch = Batch::find($alloc['batch_id']);
                    $batch->decrement('quantity', $alloc['quantity']);

                    StockMovement::create([
                        'product_id' => $item['product_id'],
                        'batch_id' => $batch->id,
                        'warehouse_id' => $warehouse->id,
                        'type' => 'out',
                        'quantity' => $alloc['quantity'],
                        'reason' => "بيع طلب #{$order->order_number}",
                        'order_id' => $order->id,
                        'user_id' => auth()->id(),
                    ]);
                }
            }

            PickList::generateFromOrder($order);

            if ($data['source'] === 'website') {
                Delivery::create(['order_id' => $order->id, 'status' => 'pending']);
            }

            $customer->increment('total_spent', $total);
            $customer->increment('orders_count');
            $customer->update(['last_order_at' => now()]);

            $rate = auth()->user()->commission_rate ?? settings('default_commission_rate', 5);
            $commission = $total * ($rate / 100);
            $order->update(['commission_amount' => $commission]);
            Commission::create([
                'user_id' => auth()->id(),
                'order_id' => $order->id,
                'commission_rate' => $rate,
                'commission_amount' => $commission,
                'date' => now()->format('Y-m-d'),
            ]);

            $this->logActivity('order_created', "طلب جديد {$order->order_number} - {$data['source']}");

            return redirect()->route('orders.show', $order)
                ->with('toast', ['type' => 'success', 'message' => 'تم إنشاء الطلب بنجاح']);
        });
    }

    private function allocateBatches($batches, $needed)
    {
        $allocated = [];
        foreach ($batches as $batch) {
            if ($needed <= 0)
                break;
            $take = min($batch->quantity, $needed);
            $allocated[] = ['batch_id' => $batch->id, 'quantity' => $take];
            $needed -= $take;
        }
        return $allocated;
    }

    private function getOrCreateCustomer($data)
    {
        $customer = Customer::where('phone', $data['customer_phone'])->first();
        if (!$customer) {
            $customer = Customer::create([
                'name' => $data['customer_name'],
                'phone' => $data['customer_phone'],
                'email' => $data['customer_email'] ?? null,
                'address' => $data['customer_address'] ?? null,
                'is_active' => true,
            ]);
        }
        return $customer;
    }

    public function show(Order $order)
    {
        $order->load(['items.product', 'branch', 'user', 'customer']);
        return view('dashboard.orders.show', compact('order'));
    }

    public function printA4(Order $order)
    {
        $order->load('items.product');
        return view('invoices.a4', compact('order'));
    }

    public function printThermal(Order $order)
    {
        $order->load('items.product');
        return view('invoices.thermal', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate(['status' => 'required|in:new,preparing,ready,out_for_delivery,delivered,canceled,returned']);
        $order->update(['status' => $request->status]);
        if ($request->status === 'delivered') {
            $order->update(['delivered_at' => now(), 'payment_status' => 'paid']);
        }
        return back()->with('toast', ['type' => 'success', 'message' => 'تم تحديث الحالة']);
    }

    public function commissionsReport(Request $request)
    {
        $month = $request->get('month', now()->format('Y-m'));

        [$year, $monthNum] = explode('-', $month);

        $commissions = Commission::with(['user', 'order'])
            ->whereYear('date', $year)
            ->whereMonth('date', $monthNum)
            ->orderByDesc('commission_amount')
            ->get()
            ->groupBy('user_id');

        $totalCommission = $commissions->sum(fn($group) => $group->sum('commission_amount'));

        return view('dashboard.commissions.report', compact('commissions', 'totalCommission', 'month'));
    }
}