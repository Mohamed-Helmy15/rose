<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Commission;
use App\Models\Customer;

class PosSummary extends Component
{
    public $customer_name = '';
    public $customer_phone = '';
    public $notes = '';
    public $payment_method = 'cash';

    protected $listeners = ['cartUpdated' => '$refresh'];

    // مهم جدًا: نحصل على العربة من الكومبوننت التاني
    public function getCartProperty()
    {
        return app('App\Livewire\PosCart')->cart;
    }

    // الإجمالي قبل الضريبة
    public function getSubtotalProperty()
    {
        return collect($this->cart)->sum(function ($item) {
            return $item['product']->priceWithTax() * $item['quantity'];
        });
    }

    // الضريبة
    public function getTaxProperty()
    {
        return $this->subtotal * (settings('vat_rate', 0) / 100);
    }

    // الإجمالي النهائي
    public function getTotalProperty()
    {
        return $this->subtotal + $this->tax;
    }

    public function checkout()
    {
        $this->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|min:11|max:11',
        ]);

        if (empty($this->cart)) {
            $this->dispatchBrowserEvent('toast', ['type' => 'error', 'message' => 'العربة فارغة']);
            return;
        }

        // البحث عن العميل أو إنشاء جديد
        $customer = Customer::where('phone', $this->customer_phone)->first();
        if (!$customer) {
            $customer = Customer::create([
                'name' => $this->customer_name,
                'phone' => $this->customer_phone,
                'is_active' => true,
            ]);
        }

        $orderItems = [];
        $subtotal = 0;

        foreach ($this->cart as $productId => $item) {
            $product = $item['product'];
            $price = $product->priceWithTax();
            $totalItem = $price * $item['quantity'];
            $subtotal += $totalItem;

            $orderItems[] = [
                'product_id' => $product->id,
                'quantity' => $item['quantity'],
                'price_at_sale' => $price,
                'total' => $totalItem,
            ];

            $product->decrement('stock_quantity', $item['quantity']);
        }

        $tax = $subtotal * (settings('vat_rate', 0) / 100);
        $total = $subtotal + $tax;

        $order = Order::create([
            'order_number' => 'ORD-' . str_pad(Order::max('id') + 1, 6, '0', STR_PAD_LEFT),
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

        foreach ($orderItems as $item) {
            $order->items()->create($item);
        }

        // تحديث إحصائيات العميل
        $customer->updateStats($total);

        // العمولة
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

        // إفراغ العربة
        app('App\Livewire\PosCart')->cart = [];

        $this->reset(['customer_name', 'customer_phone', 'notes']);

        $this->dispatchBrowserEvent('toast', ['type' => 'success', 'message' => 'تم إنشاء الطلب بنجاح!']);
        return redirect()->route('orders.print.thermal', $order);
    }

    public function render()
    {
        return view('livewire.pos-summary');
    }
}