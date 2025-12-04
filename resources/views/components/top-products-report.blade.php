<!-- resources/views/components/top-products-report.blade.php -->
<div class="card mb-4">
    <div class="card-header">
        <h5>تقرير أفضل المنتجات مبيعًا</h5>
    </div>
    <div class="card-body">
        @if (session('toast.top_products'))
            <div class="bs-toast toast toast-placement-ex m-3 fade show {{ session('toast.top_products.type') }}" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000">
                <div class="toast-header">
                    <i class='bx bx-bell me-2'></i>
                    <div class="me-auto fw-medium">إشعار</div>
                    <small>الآن</small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    {{ session('toast.top_products.message') }}
                </div>
            </div>
        @endif
        <form id="top-products-report-form" class="mb-4 d-flex justify-content-between align-items-center">
            <div class="d-flex gap-3">
                <div>
                    <label for="top_products_start_date" class="form-label">من تاريخ:</label>
                    <input type="date" name="start_date" id="top_products_start_date" value="{{ $startDate ?? now()->startOfMonth()->toDateString() }}" class="form-control">
                </div>
                <div>
                    <label for="top_products_end_date" class="form-label">إلى تاريخ:</label>
                    <input type="date" name="end_date" id="top_products_end_date" value="{{ $endDate ?? now()->toDateString() }}" class="form-control">
                </div>
                <div>
                    <label for="top_products_limit" class="form-label">عدد المنتجات:</label>
                    <input type="number" name="limit" id="top_products_limit" value="{{ $limit ?? 10 }}" min="1" class="form-control">
                </div>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">عرض</button>
                <button type="button" class="btn btn-success" onclick="exportToExcel()">تحميل Excel</button>
            </div>
        </form>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>المنتج</th>
                        <th>SKU</th>
                        <th>الكمية المباعة</th>
                        <th>إجمالي الإيرادات</th>
                    </tr>
                </thead>
                <tbody id="top-products-report-table">
                    @forelse ($data ?? [] as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->sku }}</td>
                            <td>{{ $product->total_quantity }}</td>
                            <td>{{ number_format($product->total_revenue, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">لا توجد سجلات</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    document.getElementById('top-products-report-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const queryString = new URLSearchParams(formData).toString();
        fetch('{{ route('reports.top-products.data') }}?' + queryString, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            const tableBody = document.querySelector('#top-products-report-table');
            tableBody.innerHTML = '';
            if (data.data.length === 0) {
                tableBody.innerHTML = '<tr><td colspan="4" class="text-center">لا توجد سجلات</td></tr>';
            } else {
                data.data.forEach(item => {
                    tableBody.innerHTML += `
                        <tr>
                            <td>${item.name}</td>
                            <td>${item.sku}</td>
                            <td>${item.total_quantity}</td>
                            <td>${parseFloat(item.total_revenue).toFixed(2)}</td>
                        </tr>
                    `;
                });
            }
        })
        .catch(error => console.error('Error:', error));
    });

    function exportToExcel() {
        const form = document.getElementById('top-products-report-form'); // تعديل هنا
        const formData = new FormData(form);
        const queryString = new URLSearchParams(formData).toString();
        window.location.href = '{{ route("reports.top.export") }}?' + queryString;
    }
</script>