<div class="row g-0">
    <!-- المنتجات -->
    <div class="col-lg-8 pe-lg-3">
        <div class="card h-100">
            <div class="card-header">
                <div class="input-group">
                    <span class="input-group-text"><i class="bx bx-search"></i></span>
                    <input type="text" wire:model.live.debounce.300ms="search" class="form-control"
                        placeholder="ابحث عن منتج...">
                </div>
            </div>
            <div class="card-body p-3" style="max-height: 75vh; overflow-y: auto;">
                <div class="row g-3">
                    @foreach ($products as $product)
                        <div class="col-4 col-md-3 col-lg-3">
                            <div class="text-center border rounded-3 p-3 hover-shadow cursor-pointer transition-all"
                                wire:click="addToCart({{ $product->id }})"
                                style="border: 2px solid {{ $product->stock_quantity <= $product->reorder_level ? '#f72585' : '#e9ecef' }};">
                                @if ($product->primaryImage)
                                    <img src="{{ asset('storage/' . $product->primaryImage->image_path) }}"
                                        class="img-fluid rounded mb-2" style="height: 90px; object-fit: cover;">
                                @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center mb-2"
                                        style="height: 90px;">
                                        <i class='bx bxs-florist'
                                            style="font-size: 2.5rem; color: {{ $product->color }};"></i>
                                    </div>
                                @endif
                                <small class="d-block text-truncate fw-bold">{{ $product->name }}</small>
                                <strong class="text-primary d-block">{{ number_format($product->priceWithTax(), 2) }}
                                    ج.م</strong>
                                @if ($product->stock_quantity <= $product->reorder_level)
                                    <span class="badge bg-danger d-block mt-1">منخفض
                                        ({{ $product->stock_quantity }})
                                    </span>
                                @else
                                    <small class="text-success">{{ $product->stock_quantity }} متوفر</small>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- ملخص الطلب -->
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">ملخص الطلب ({{ count($cart) }} عنصر)</h5>
            </div>
            <div class="card-body">
                @if (empty($cart))
                    <p class="text-center text-muted mt-5">العربة فارغة</p>
                @else
                    <div style="max-height: 40vh; overflow-y: auto;" class="mb-3">
                        @foreach ($cart as $productId => $item)
                            <div class="d-flex align-items-center justify-content-between border-bottom pb-2 mb-2"
                                wire:key="cart-item-{{ $productId }}">
                                <div class="flex-grow-1 me-3">
                                    <strong class="d-block text-truncate">{{ $item['product']->name }}</strong>
                                    <small>{{ number_format($item['product']->priceWithTax(), 2) }} ×
                                        {{ $item['quantity'] }}</small>
                                </div>

                                <div class="d-flex align-items-center gap-1">
                                    <button
                                        wire:click="updateQuantity({{ $productId }}, {{ $item['quantity'] - 1 }})"
                                        class="btn btn-sm btn-outline-secondary">-</button>

                                    <span class="fw-bold mx-2">{{ $item['quantity'] }}</span>

                                    <button
                                        wire:click="updateQuantity({{ $productId }}, {{ $item['quantity'] + 1 }})"
                                        class="btn btn-sm btn-outline-secondary">+</button>

                                    <button wire:click="removeFromCart({{ $productId }})"
                                        class="btn btn-sm btn-danger ms-2">×</button>
                                </div>

                                <strong
                                    class="ms-3">{{ number_format($item['product']->priceWithTax() * $item['quantity'], 2) }}</strong>
                            </div>
                        @endforeach
                    </div>

                    <div class="border-top pt-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span>الإجمالي</span>
                            <strong>{{ number_format($subtotal, 2) }}</strong>
                        </div>

                        @if ($tax > 0)
                            <div class="d-flex justify-content-between mb-2">
                                <span>الضريبة</span>
                                <strong>{{ number_format($tax, 2) }}</strong>
                            </div>
                        @endif

                        <div class="d-flex justify-content-between fs-4 fw-bold text-primary">
                            <span>النهائي</span>
                            <strong>{{ number_format($total, 2) }} ج.م</strong>
                        </div>
                    </div>

                    <hr>

                    <form wire:submit.prevent="checkout">
                        <input type="text" wire:model="customer_name" class="form-control mb-2"
                            placeholder="اسم العميل" required>
                        <input type="text" wire:model="customer_phone" class="form-control mb-2"
                            placeholder="رقم التليفون" required>
                        <select wire:model="payment_method" class="form-select mb-3">
                            <option value="cash">كاش</option>
                            <option value="visa">فيزا</option>
                            <option value="fawry">فوري</option>
                        </select>

                        <div class="d-flex gap-2 mb-2">
                            <button type="button" wire:click="$set('cart', [])" class="btn btn-outline-danger w-50">
                                تفريغ العربة
                            </button>
                            <button type="submit" class="btn btn-success w-50">
                                <i class='bx bx-check'></i> إنهاء الطلب وطباعة
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>

</div>
