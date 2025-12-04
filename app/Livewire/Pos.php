<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Commission;
use App\Models\Customer;
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

    #[On('updateQuantity')]
    public function updateQuantity($productId, $quantity)
    {
        if (!isset($this->cart[$productId])) return;

        if ($quantity <= 0) {
            unset($this->cart[$productId]);
            return;
        }

        $product = $this->cart[$productId]['product'] ?? null;

        if ($product && $quantity <= $product->stock_quantity) {
            $this->cart[$productId]['quantity'] = $quantity;
        } else {
            $this->dispatch('toast', [
                'type' => 'warning',
                'message' => 'الكمية المطلوبة تتجاوز المتوفر'
            ]);
        }
    }

    #[On('removeFromCart')]
    public function removeFromCart($productId)
    {
        unset($this->cart[$productId]);
    }

    public function addToCart($productId)
    {
        $product = Product::find($productId);

        if (!$product || $product->stock_quantity <= 0) {
            $this->dispatch('toast', [
                'type' => 'error',
                'message' => 'المنتج غير متوفر'
            ]);
            return;
        }

        if (isset($this->cart[$productId])) {
            if ($this->cart[$productId]['quantity'] < $product->stock_quantity) {
                $this->cart[$productId]['quantity']++;
            } else {
                $this->dispatch('toast', [
                    'type' => 'warning',
                    'message' => 'الكمية غير متوفرة'
                ]);
            }
        } else {
            $this->cart[$productId] = [
                'product' => $product,
                'quantity' => 1
            ];
        }
    }

    public function getSubtotalProperty()
    {
        return collect($this->cart)->sum(fn($item) =>
            $item['product']->price * $item['quantity']
        );
    }

    public function getTaxProperty()
    {
        $vat = settings('vat_rate', 0) / 100;
        $inclusive = settings('vat_inclusive', 0);
        $taxOnShipping = settings('tax_on_shipping', 0);

        if ($inclusive) return 0;

        $tax = $this->subtotal * $vat;

        if ($taxOnShipping && $this->shipping_cost > 0) {
            $tax += $this->shipping_cost * $vat;
        }

        return $tax;
    }

    public function getTotalProperty()
    {
        return $this->subtotal + $this->tax + ($this->shipping_cost ?? 0);
    }

    public function checkout()
    {
        $this->validate([
            'customer_name' => 'required|string',
            'customer_phone' => 'required|string',
        ]);

        if (empty($this->cart)) {
            $this->dispatch('toast', [
                'type' => 'error',
                'message' => 'العربة فارغة'
            ]);
            return;
        }

        $customer = Customer::firstOrCreate(
            ['phone' => $this->customer_phone],
            ['name' => $this->customer_name, 'is_active' => true]
        );

        $items = [];
        $subtotal = 0;

        foreach ($this->cart as $item) {
            $product = $item['product'];
            $price = $product->priceWithTax();
            $total = $price * $item['quantity'];
            $subtotal += $total;

            $items[] = [
                'product_id' => $product->id,
                'quantity' => $item['quantity'],
                'price_at_sale' => $price,
                'total' => $total,
            ];

            $product->decrement('stock_quantity', $item['quantity']);
        }

        $tax = $subtotal * (settings('vat_rate', 0) / 100);
        $total = $subtotal + $tax;

        $order = Order::create([
            'order_number' => 'ORD-' . str_pad((Order::max('id') ?? 0) + 1, 6, '0', STR_PAD_LEFT),
            'customer_id' => $customer->id,
            'customer_name' => $this->customer_name,
            'customer_phone' => $this->customer_phone,
            'branch_id' => auth()->user()->primaryBranch()?->id,
            'user_id' => auth()->id(),
            'source' => 'pos',
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => $total,
            'payment_method' => $this->payment_method,
            'notes' => $this->notes,
            'status' => 'preparing',
            'payment_status' => 'paid',
        ]);

        foreach ($items as $item) {
            $order->items()->create($item);
        }

        if (method_exists($customer, 'updateStats')) {
            $customer->updateStats($total);
        }

        $rate = auth()->user()->commission_rate ?? settings('default_commission_rate', 5);
        $commission = $total * ($rate / 100);

        $order->update(['commission_amount' => $commission]);

        Commission::create([
            'user_id' => auth()->id(),
            'order_id' => $order->id,
            'commission_rate' => $rate,
            'commission_amount' => $commission,
            'date' => now(),
        ]);

        $this->cart = [];
        $this->reset(['customer_name', 'customer_phone', 'notes']);

        $this->dispatch('toast', [
            'type' => 'success',
            'message' => 'تم إنشاء الطلب بنجاح'
        ]);

        return redirect()->route('orders.print.thermal', $order);
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

        return view('livewire.pos', [
            'products' => $products,
            'subtotal' => $this->subtotal,
            'tax' => $this->tax,
            'total' => $this->total,
        ]);
    }
}
