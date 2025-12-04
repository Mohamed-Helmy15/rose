<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;

class PosCart extends Component
{
    public $search = '';
    public $cart = []; // [product_id => ['product' => $product, 'quantity' => 1]]

    public function addToCart($productId)
    {
        $product = Product::find($productId);

        if (!$product || $product->stock_quantity <= 0) {
            $this->dispatchBrowserEvent('toast', ['type' => 'error', 'message' => 'المنتج غير متوفر']);
            return;
        }

        if (isset($this->cart[$productId])) {
            if ($this->cart[$productId]['quantity'] < $product->stock_quantity) {
                $this->cart[$productId]['quantity']++;
            } else {
                $this->dispatchBrowserEvent('toast', ['type' => 'warning', 'message' => 'الكمية غير متوفرة']);
            }
        } else {
            $this->cart[$productId] = [
                'product' => $product,
                'quantity' => 1
            ];
        }
    }

    public function removeFromCart($productId)
    {
        unset($this->cart[$productId]);
    }

    public function updateQuantity($productId, $quantity)
    {
        if ($quantity <= 0) {
            unset($this->cart[$productId]);
            return;
        }

        $product = $this->cart[$productId]['product'];
        if ($quantity > $product->stock_quantity) {
            $this->dispatchBrowserEvent('toast', ['type' => 'error', 'message' => 'الكمية غير متوفرة']);
            return;
        }

        $this->cart[$productId]['quantity'] = $quantity;
    }

    public function render()
    {
        $products = Product::active()
            ->when($this->search, fn($q) => $q->where('name', 'like', "%{$this->search}%")->orWhere('sku', 'like', "%{$this->search}%"))
            ->with('primaryImage')
            ->take(30)
            ->get();

        return view('livewire.pos-cart', compact('products'));
    }
}