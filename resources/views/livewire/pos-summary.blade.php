<div>
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">ملخص الطلب</h5>
        </div>
        <div class="card-body">
            @if(empty($cart))
                <p class="text-center text-muted">العربة فارغة</p>
            @else
                <div class="mb-3" style="max-height: 40vh; overflow-y: auto;">
                    @foreach($cart as $productId => $item)
                        <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                            <div class="flex-grow-1">
                                <strong>{{ $item['product']->name }}</strong><br>
                                <small>{{ number_format($item['product']->priceWithTax(), 2) }} × {{ $item['quantity'] }}</small>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <button wire:click="$set('cart.{{ $productId }}.quantity', {{ $item['quantity'] - 1 }})" class="btn btn-sm btn-outline-secondary">-</button>
                                <span class="fw-bold mx-2">{{ $item['quantity'] }}</span>
                                <button wire:click="$set('cart.{{ $productId }}.quantity', {{ $item['quantity'] + 1 }})" class="btn btn-sm btn-outline-secondary">+</button>
                                <button wire:click="removeFromCart({{ $productId }})" class="btn btn-sm btn-danger">×</button>
                            </div>
                            <strong class="ms-3">{{ number_format($item['product']->priceWithTax() * $item['quantity'], 2) }}</strong>
                        </div>
                    @endforeach
                </div>

                <div class="border-top pt-3">
                    <div class="d-flex justify-content-between mb-2">
                        <span>الإجمالي قبل الضريبة</span>
                        <strong>{{ number_format($subtotal, 2) }} ج.م</strong>
                    </div>
                    @if($tax > 0)
                    <div class="d-flex justify-content-between mb-2">
                        <span>الضريبة</span>
                        <strong>{{ number_format($tax, 2) }} ج.م</strong>
                    </div>
                    @endif
                    <div class="d-flex justify-content-between fs-4 fw-bold text-primary">
                        <span>الإجمالي</span>
                        <span>{{ number_format($total, 2) }} ج.م</span>
                    </div>
                </div>

                <hr>

                <form wire:submit.prevent="checkout">
                    <div class="mb-3">
                        <input type="text" wire:model="customer_name" class="form-control" placeholder="اسم العميل" required>
                    </div>
                    <div class="mb-3">
                        <input type="text" wire:model="customer_phone" class="form-control" placeholder="رقم التليفون" required>
                    </div>
                    <div class="mb-3">
                        <select wire:model="payment_method" class="form-select">
                            <option value="cash">كاش</option>
                            <option value="visa">فيزا/ماستركارد</option>
                            <option value="fawry">فوري</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success btn-lg w-100">
                        <i class='bx bx-check'></i> إنهاء وطباعة الفاتورة
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>