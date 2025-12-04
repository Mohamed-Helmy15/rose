<!-- resources/views/components/sales-report.blade.php -->
<div class="card mb-4">
    <div class="card-header">
        <h5>تقرير المبيعات</h5>
    </div>
    <div class="card-body">
        @if (session('toast.sales'))
            <div class="bs-toast toast toast-placement-ex m-3 fade show {{ session('toast.sales.type') }}" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000">
                <div class="toast-header">
                    <i class='bx bx-bell me-2'></i>
                    <div class="me-auto fw-medium">إشعار</div>
                    <small>الآن</small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    {{ session('toast.sales.message') }}
                </div>
            </div>
        @endif
        <form id="sales-report-form" class="mb-4 d-flex justify-content-between align-items-center">
            <div class="d-flex gap-3">
                <div>
                    <label for="sales_period" class="form-label">الفترة:</label>
                    <select name="period" id="sales_period" class="form-select">
                        <option value="daily" {{ $period ?? 'daily' == 'daily' ? 'selected' : '' }}>يومي</option>
                        <option value="weekly" {{ $period ?? 'daily' == 'weekly' ? 'selected' : '' }}>أسبوعي</option>
                        <option value="monthly" {{ $period ?? 'daily' == 'monthly' ? 'selected' : '' }}>شهري</option>
                    </select>
                </div>
                <div>
                    <label for="sales_start_date" class="form-label">من تاريخ:</label>
                    <input type="date" name="start_date" id="sales_start_date" value="{{ $startDate ?? now()->startOfMonth()->toDateString() }}" class="form-control">
                </div>
                <div>
                    <label for="sales_end_date" class="form-label">إلى تاريخ:</label>
                    <input type="date" name="end_date" id="sales_end_date" value="{{ $endDate ?? now()->toDateString() }}" class="form-control">
                </div>
                <div>
                    <label for="sales_status" class="form-label">حالة الطلب:</label>
                    <select name="status" id="sales_status" class="form-select">
                        <option value="delivered" {{ $status ?? 'delivered' == 'delivered' ? 'selected' : '' }}>مكتمل</option>
                        <option value="pending" {{ $status ?? 'delivered' == 'pending' ? 'selected' : '' }}>معلق</option>
                        <option value="processing" {{ $status ?? 'delivered' == 'processing' ? 'selected' : '' }}>قيد المعالجة</option>
                        <option value="shipped" {{ $status ?? 'delivered' == 'shipped' ? 'selected' : '' }}>تم الشحن</option>
                        <option value="cancelled" {{ $status ?? 'delivered' == 'cancelled' ? 'selected' : '' }}>ملغى</option>
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
                        <th>التاريخ</th>
                        <th>إجمالي المبيعات</th>
                        <th>عدد الطلبات</th>
                    </tr>
                </thead>
                <tbody id="sales-report-table">
                    @forelse ($data ?? [] as $item)
                        <tr>
                            <td>{{ $item['date'] }}</td>
                            <td>{{ number_format($item['total_sales'], 2) }}</td>
                            <td>{{ $item['order_count'] }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">لا توجد سجلات</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    document.getElementById('sales-report-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const queryString = new URLSearchParams(formData).toString();
        fetch('{{ route('reports.sales.data') }}?' + queryString, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            const tableBody = document.querySelector('#sales-report-table');
            tableBody.innerHTML = '';
            if (data.data.length === 0) {
                tableBody.innerHTML = '<tr><td colspan="3" class="text-center">لا توجد سجلات</td></tr>';
            } else {
                data.data.forEach(item => {
                    tableBody.innerHTML += `
                        <tr>
                            <td>${item.date}</td>
                            <td>${parseFloat(item.total_sales).toFixed(2)}</td>
                            <td>${item.order_count}</td>
                        </tr>
                    `;
                });
            }
        })
        .catch(error => console.error('Error:', error));
    });

    function exportToExcel() {
        const form = document.getElementById('sales-report-form'); // تعديل هنا
        const formData = new FormData(form);
        const queryString = new URLSearchParams(formData).toString();
        window.location.href = '{{ route("reports.sales.export") }}?' + queryString;
    }
</script>