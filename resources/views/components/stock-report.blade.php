<!-- resources/views/components/stock-report.blade.php -->
<div class="card mb-4">
    <div class="card-header">
        <h5>تقرير المخزون</h5>
    </div>
    <div class="card-body">
        @if (session('toast.stock'))
            <div class="bs-toast toast toast-placement-ex m-3 fade show {{ session('toast.stock.type') }}" role="alert"
                aria-live="assertive" aria-atomic="true" data-bs-delay="3000">
                <div class="toast-header">
                    <i class='bx bx-bell me-2'></i>
                    <div class="me-auto fw-medium">إشعار</div>
                    <small>الآن</small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    {{ session('toast.stock.message') }}
                </div>
            </div>
        @endif
        <form id="stock-report-form" class="mb-4 d-flex justify-content-between align-items-center">
            <div class="d-flex gap-3">
                <div>
                    <label for="stock_branch_id" class="form-label">الفرع:</label>
                    <select name="branch_id" id="stock_branch_id" class="form-select">
                        <option value="">جميع الفروع</option>
                        @foreach ($branches as $branch)
                            <option value="{{ $branch->id }}" {{ ($branchId ?? '') == $branch->id ? 'selected' : '' }}>
                                {{ $branch->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="stock_warehouse_id" class="form-label">المخزن:</label>
                    <select name="warehouse_id" id="stock_warehouse_id" class="form-select">
                        <option value="">جميع المخازن</option>
                        @foreach ($warehouses as $warehouse)
                            <option value="{{ $warehouse->id }}" {{ ($warehouseId ?? '') == $warehouse->id ? 'selected' : '' }}>{{ $warehouse->name }}</option>
                        @endforeach
                    </select>
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
                        <th>الفرع</th>
                        <th>المخزن</th>
                        <th>الكمية</th>
                    </tr>
                </thead>
                <tbody id="stock-report-table">
                    @forelse ($data ?? [] as $stock)
                        <tr>
                            <td>{{ $stock->name }}</td>
                            <td>{{ $stock->sku }}</td>
                            <td>{{ $stock->branch_name }}</td>
                            <td>{{ $stock->warehouse_name }}</td>
                            <td>{{ $stock->total_quantity }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">لا توجد سجلات</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    document.getElementById('stock-report-form').addEventListener('submit', function (e) {
        e.preventDefault();
        const formData = new FormData(this);
        const queryString = new URLSearchParams(formData).toString();
        fetch('{{ route('reports.stock.data') }}?' + queryString, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
            .then(response => response.json())
            .then(data => {
                const tableBody = document.querySelector('#stock-report-table');
                tableBody.innerHTML = '';
                if (data.data.length === 0) {
                    tableBody.innerHTML = '<tr><td colspan="5" class="text-center">لا توجد سجلات</td></tr>';
                } else {
                    data.data.forEach(item => {
                        tableBody.innerHTML += `
                        <tr>
                            <td>${item.name}</td>
                            <td>${item.sku}</td>
                            <td>${item.branch_name}</td>
                            <td>${item.warehouse_name}</td>
                            <td>${item.total_quantity}</td>
                        </tr>
                    `;
                    });
                }
            })
            .catch(error => console.error('Error:', error));
    });
    function exportToExcel() {
        const form = document.getElementById('stock-report-form'); // تعديل هنا
        const formData = new FormData(form);
        const queryString = new URLSearchParams(formData).toString();
        window.location.href = '{{ route("reports.stock.export") }}?' + queryString;
    }
</script>