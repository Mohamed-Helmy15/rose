<div class="row g-0">
    <!-- المنتجات -->
    <div class="col-lg-8 pe-lg-3">
        <div class="card h-100">
            <div class="card-header">
                <div class="input-group">
                    <span class="input-group-text"><i class="bx bx-search"></i></span>
                    <input type="text" wire:model.live.debounce.300ms="search" class="form-control"
                        placeholder="ابحث عن منتج (الاسم أو الكود)...">
                </div>
            </div>

            <div class="card-body p-3" style="max-height: 75vh; overflow-y: auto;">
                @if ($products->count() === 0)
                    <div class="text-center py-5 text-muted">
                        <i class="bx bx-package fs-1"></i>
                        <p class="mt-3">لا توجد منتجات متاحة حالياً</p>
                    </div>
                @else
                    <div class="row g-3">
                        @foreach ($products as $product)
                            @php
                                $available = $product->available_in_pos ?? 0;
                                $isLowStock = $available > 0 && $available <= ($product->reorder_level ?? 10);
                                $isOutOfStock = $available <= 0;
                            @endphp

                            <div class="col-4 col-md-3 col-lg-3">
                                <div class="text-center border rounded-3 p-3 hover-shadow cursor-pointer transition-all position-relative
                                    {{ $isOutOfStock ? 'opacity-50' : '' }}"
                                    wire:click="{{ $isOutOfStock ? '' : 'addToCart(' . $product->id . ')' }}"
                                    style="border: 2px solid {{ $isLowStock ? '#f72585' : ($isOutOfStock ? '#6c757d' : '#e9ecef') }};">
                                    
                                    <!-- علامة نفاد المخزون -->
                                    @if ($isOutOfStock)
                                        <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center bg-dark bg-opacity-50 rounded-3">
                                            <span class="text-white fw-bold fs-5">نفد</span>
                                        </div>
                                    @endif

                                    <!-- الصورة -->
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

                                    <!-- الاسم والسعر -->
                                    <small class="d-block text-truncate fw-bold">{{ $product->name }}</small>
                                    <strong class="text-primary d-block">{{ number_format($product->priceWithTax(), 2) }} ج.م</strong>

                                    <!-- حالة المخزون -->
                                    @if ($isOutOfStock)
                                        <span class="badge bg-secondary d-block mt-1">غير متوفر</span>
                                    @elseif ($isLowStock)
                                        <span class="badge bg-danger d-block mt-1">منخفض ({{ $available }})</span>
                                    @else
                                        <small class="text-success d-block">{{ $available }} متوفر</small>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- ملخص الطلب -->
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">ملخص الطلب</h5>
                <span class="badge bg-light text-primary fs-6">{{ count($cart) }} عنصر</span>
            </div>

            <div class="card-body">
                @if (empty($cart))
                    <div class="text-center py-5 text-muted">
                        <i class="bx bx-cart fs-1"></i>
                        <p class="mt-3">العربة فارغة</p>
                        <small>ابدأ بإضافة منتجات</small>
                    </div>
                @else
                    <div style="max-height: 40vh; overflow-y: auto;" class="mb-3">
                        @foreach ($cart as $productId => $item)
                            @php
                                $available = $item['available'] ?? 0;
                                $canIncrease = $item['quantity'] < $available;
                            @endphp
                            <div class="d-flex align-items-center justify-content-between border-bottom pb-2 mb-2"
                                wire:key="cart-item-{{ $productId }}">
                                <div class="flex-grow-1 me-3">
                                    <strong class="d-block text-truncate">{{ $item['product']->name }}</strong>
                                    <small>{{ number_format($item['product']->priceWithTax(), 2) }} × {{ $item['quantity'] }}</small>
                                    @if (!$canIncrease)
                                        <small class="text-danger d-block">الحد الأقصى المتاح</small>
                                    @endif
                                </div>

                                <div class="d-flex align-items-center gap-1">
                                    <button
                                        wire:click="updateQuantity({{ $productId }}, {{ $item['quantity'] - 1 }})"
                                        class="btn btn-sm btn-outline-secondary">-</button>

                                    <span class="fw-bold mx-2 min-w-40 text-center">{{ $item['quantity'] }}</span>

                                    <button
                                        wire:click="updateQuantity({{ $productId }}, {{ $item['quantity'] + 1 }})"
                                        class="btn btn-sm btn-outline-secondary {{ $canIncrease ? '' : 'disabled' }}"
                                        {{ $canIncrease ? '' : 'disabled' }}>+</button>

                                    <button wire:click="removeFromCart({{ $productId }})"
                                        class="btn btn-sm btn-danger ms-2">×</button>
                                </div>

                                <strong class="ms-3">{{ number_format($item['product']->priceWithTax() * $item['quantity'], 2) }}</strong>
                            </div>
                        @endforeach
                    </div>

                    <div class="border-top pt-3 bg-light rounded p-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">الإجمالي</span>
                            <strong>{{ number_format($subtotal, 2) }} ج.م</strong>
                        </div>

                        @if ($tax > 0)
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">الضريبة</span>
                                <strong>{{ number_format($tax, 2) }} ج.م</strong>
                            </div>
                        @endif

                        @if ($shipping_cost > 0)
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">التوصيل</span>
                                <strong>{{ number_format($shipping_cost, 2) }} ج.م</strong>
                            </div>
                        @endif

                        <div class="d-flex justify-content-between fs-4 fw-bold text-primary border-top pt-3 mt-3">
                            <span>الإجمالي النهائي</span>
                            <strong>{{ number_format($total, 2) }} ج.م</strong>
                        </div>
                    </div>

                    <hr class="my-4">

                    <form wire:submit.prevent="checkout">
                        @csrf
                        <div class="mb-3">
                            <input type="text" wire:model="customer_name" class="form-control" 
                                placeholder="اسم العميل" required>
                        </div>
                        <div class="mb-3">
                            <input type="text" wire:model="customer_phone" class="form-control" 
                                placeholder="رقم التليفون" required>
                        </div>
                        <div class="mb-3">
                            <textarea wire:model="notes" class="form-control" rows="2" 
                                placeholder="ملاحظات (اختياري)"></textarea>
                        </div>
                        <div class="mb-3">
                            <select wire:model="payment_method" class="form-select">
                                <option value="cash">كاش</option>
                                <option value="visa">فيزا / ماستركارد</option>
                                <option value="fawry">فوري</option>
                                <option value="wallet">محفظة إلكترونية</option>
                            </select>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="button" wire:click="$set('cart', [])" 
                                class="btn btn-outline-danger me-md-2">
                                <i class="bx bx-trash"></i> تفريغ العربة
                            </button>
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="bx bx-check-circle"></i> إنهاء الطلب وطباعة الفاتورة
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>