<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Batch;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Commission;
use App\Models\Customer;
use App\Models\StockMovement;
use App\Models\PickList;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;

class Pos extends Component
{
    public $search = '';
    public $cart = []; 
    public $customer_name = '';
    public $customer_phone = '';
    public $notes = '';
    public $payment_method = 'cash';
    public $shipping_cost = 0;

    public $warehouse_id; // نحتفظ بالـ id فقط لتجنب فقدان الـ model عبر re-renders

    public function mount()
    {
        $branch = auth()->user()->primaryBranch();

        if ($branch && $branch->warehouse) {
            $this->warehouse_id = $branch->warehouse->id;
        } else {
            $this->dispatch('toast', [
                'type' => 'error',
                'message' => 'لا يوجد مخزن مرتبط بالفرع الحالي'
            ]);
        }
    }

    #[On('updateQuantity')]
    public function updateQuantity($productId, $quantity)
    {
        if (!isset($this->cart[$productId])) {
            return;
        }

        $quantity = (int) $quantity;

        if ($quantity <= 0) {
            unset($this->cart[$productId]);
            return;
        }

        $available = $this->getAvailableQuantity($productId);

        if ($quantity > $available) {
            $this->dispatch('toast', [
                'type' => 'warning',
                'message' => "الكمية المتاحة فقط: {$available}"
            ]);
            return;
        }

        $this->cart[$productId]['quantity'] = $quantity;
    }

    #[On('removeFromCart')]
    public function removeFromCart($productId)
    {
        unset($this->cart[$productId]);
    }

    public function addToCart($productId)
    {
        $product = Product::find($productId);

        if (!$product || !$product->is_active) {
            $this->dispatch('toast', ['type' => 'error', 'message' => 'المنتج غير متوفر']);
            return;
        }

        $available = $this->getAvailableQuantity($productId);

        if ($available <= 0) {
            $this->dispatch('toast', ['type' => 'error', 'message' => 'المنتج نفد من المخزون']);
            return;
        }

        if (isset($this->cart[$productId])) {
            $newQty = $this->cart[$productId]['quantity'] + 1;
            if ($newQty > $available) {
                $this->dispatch('toast', ['type' => 'warning', 'message' => 'الكمية غير متوفرة']);
                return;
            }
            $this->cart[$productId]['quantity'] = $newQty;
        } else {
            $this->cart[$productId] = [
                'product' => $product,
                'quantity' => 1,
                'available' => $available,
            ];
        }
    }

    private function getAvailableQuantity($productId)
    {
        if (!$this->warehouse_id) {
            return 0;
        }

        return Batch::where('product_id', $productId)
            ->where('warehouse_id', $this->warehouse_id)
            ->where('quantity', '>', 0)
            ->where('status', 'available')
            ->where('expiry_date', '>=', now())
            ->sum('quantity');
    }

    /**
     * مجموع الأسعار قبل الضريبة لجميع البنود
     */
    public function getSubtotalProperty()
    {
        return collect($this->cart)->sum(fn($item) =>
            $item['product']->priceBeforeTax() * $item['quantity']
        );
    }

    /**
     * مجموع الضريبة لجميع البنود
     */
    public function getTaxProperty()
    {
        return collect($this->cart)->sum(fn($item) =>
            $item['product']->taxAmount() * $item['quantity']
        );
    }

    /**
     * الإجمالي النهائي (قبل/بعد الضريبة محسوبة بشكل صحيح) + الشحن
     */
    public function getTotalProperty()
    {
        return $this->subtotal + $this->tax + $this->shipping_cost;
    }

    public function checkout()
    {
        $this->validate([
            'customer_name'  => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
        ]);

        if (empty($this->cart)) {
            $this->dispatch('toast', ['type' => 'error', 'message' => 'العربة فارغة']);
            return;
        }

        if (!$this->warehouse_id) {
            $this->dispatch('toast', ['type' => 'error', 'message' => 'لا يوجد مخزن للفرع']);
            return;
        }

        return DB::transaction(function () {

            $customer = Customer::firstOrCreate(
                ['phone' => $this->customer_phone],
                ['name' => $this->customer_name, 'is_active' => true]
            );

            $order = Order::create([
                'order_number'   => 'ORD-' . str_pad((Order::max('id') ?? 0) + 1, 6, '0', STR_PAD_LEFT),
                'customer_id'    => $customer->id,
                'customer_name'  => $this->customer_name,
                'customer_phone' => $this->customer_phone,
                'branch_id'      => auth()->user()->primaryBranch()?->id,
                'user_id'        => auth()->id(),
                'source'         => 'pos',
                'subtotal'       => $this->subtotal,
                'tax'            => $this->tax,
                'shipping'       => $this->shipping_cost,
                'total'          => $this->total,
                'payment_method' => $this->payment_method,
                'notes'          => $this->notes,
                'status'         => 'preparing',
                'payment_status' => 'paid',
            ]);

            foreach ($this->cart as $cartItem) {
                /** @var Product $product */
                $product = $cartItem['product'];
                $needed  = $cartItem['quantity'];

                // جلب الباتشات حسب FEFO وتخصيص الكمية
                $batches = $product->availableBatches($this->warehouse_id);
                $allocated = $this->allocateFromBatches($batches, $needed);

                // price_at_sale نحفظ السعر النهائي (شامل أو غير شامل حسب الإعداد) كقيمة تُطبع/تُعامل
                $unitPrice = $product->finalPrice();
                $lineTotal = $unitPrice * $needed;

                $orderItem = $order->items()->create([
                    'product_id'    => $product->id,
                    'quantity'      => $needed,
                    'price_at_sale' => $unitPrice,
                    'total'         => $lineTotal,
                ]);

                foreach ($allocated as $alloc) {
                    $batch = Batch::find($alloc['batch_id']);
                    $batch->decrement('quantity', $alloc['quantity']);

                    StockMovement::create([
                        'product_id'   => $product->id,
                        'batch_id'     => $batch->id,
                        'warehouse_id' => $this->warehouse_id,
                        'type'         => 'out',
                        'quantity'     => $alloc['quantity'],
                        'reason'       => "بيع POS طلب #{$order->order_number}",
                        'order_id'     => $order->id,
                        'user_id'      => auth()->id(),
                    ]);
                }
            }

            PickList::generateFromOrder($order);

            $rate = auth()->user()->commission_rate ?? settings('default_commission_rate', 5);
            $commission = $this->total * ($rate / 100);

            $order->update(['commission_amount' => $commission]);

            Commission::create([
                'user_id'           => auth()->id(),
                'order_id'          => $order->id,
                'commission_rate'   => $rate,
                'commission_amount' => $commission,
                'date'              => now(),
            ]);

            $customer->increment('total_spent', $this->total);
            $customer->increment('orders_count');
            $customer->update(['last_order_at' => now()]);

            $this->reset(['cart', 'customer_name', 'customer_phone', 'notes', 'shipping_cost']);

            $this->dispatch('toast', [
                'type' => 'success',
                'message' => "تم إنشاء الطلب #{$order->order_number} بنجاح"
            ]);

            return redirect()->route('orders.print.thermal', $order);
        });
    }

    private function allocateFromBatches($batches, $needed)
    {
        $allocated = [];
        foreach ($batches as $batch) {
            if ($needed <= 0) break;

            $take = min($batch->quantity, $needed);
            $allocated[] = ['batch_id' => $batch->id, 'quantity' => $take];
            $needed -= $take;
        }
        return $allocated;
    }

    public function render()
    {
        $products = Product::active()
            ->when($this->search, fn($q) =>
                $q->where('name', 'like', "%{$this->search}%")
                ->orWhere('sku', 'like', "%{$this->search}%")
            )
            ->with('primaryImage')
            ->inRandomOrder()
            ->take(40)
            ->get();

        foreach ($products as $product) {
            $product->available_in_pos = $this->warehouse_id
                ? $this->getAvailableQuantity($product->id)
                : 0;
        }

        return view('livewire.pos', [
            'products' => $products,
            'subtotal' => $this->subtotal,
            'tax'      => $this->tax,
            'total'    => $this->total,
        ]);
    }
}
