<div>
    <div class="card">
        <div class="card-header">
            <div class="input-group">
                <span class="input-group-text"><i class="bx bx-search"></i></span>
                <input type="text" wire:model.live.debounce.300ms="search" class="form-control" placeholder="ابحث عن منتج...">
            </div>
        </div>
        <div class="card-body p-0" style="max-height: 60vh; overflow-y: auto;">
            <div class="row g-2 p-3">
                @foreach($products as $product)
                    <div class="col-4 col-md-3 col-lg-2">
                        <div class="text-center border rounded p-2 hover-shadow cursor-pointer" wire:click="addToCart({{ $product->id }})">
                            @if($product->primaryImage)
                                <img src="{{ asset('storage/'.$product->primaryImage->image_path) }}" class="img-fluid rounded mb-2" style="height: 80px; object-fit: cover;">
                            @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center mb-2" style="height: 80px;">
                                    <i class='bx bxs-florist' style="font-size: 2rem; color: {{ $product->color }};"></i>
                                </div>
                            @endif
                            <small class="d-block text-truncate">{{ $product->name }}</small>
                            <strong class="text-primary">{{ number_format($product->priceWithTax(), 2) }} ج.م</strong>
                            @if($product->stock_quantity <= $product->reorder_level)
                                <span class="badge bg-danger d-block mt-1">منخفض</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>