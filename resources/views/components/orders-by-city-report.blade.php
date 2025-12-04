<!-- resources/views/components/orders-by-city-report.blade.php -->
<div class="card mb-4">
    <div class="card-header">
        <h5>تقرير الطلبات حسب المدينة</h5>
    </div>
    <div class="card-body">
        @if (session('toast.orders_by_city'))
            <div class="bs-toast toast toast-placement-ex m-3 fade show {{ session('toast.orders_by_city.type') }}" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000">
                <div class="toast-header">
                    <i class='bx bx-bell me-2'></i>
                    <div class="me-auto fw-medium">إشعار</div>
                    <small>الآن</small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    {{ session('toast.orders_by_city.message') }}
                </div>
            </div>
        @endif
        <form id="orders-by-city-report-form" class="mb-4 d-flex justify-content-between align-items-center">
            <div class="d-flex gap-3">
                <div>
                    <label for="orders_city_start_date" class="form-label">من تاريخ:</label>
                    <input type="date" name="start_date" id="orders_city_start_date" value="{{ $startDate ?? now()->startOfMonth()->toDateString() }}" class="form-control">
                </div>
                <div>
                    <label for="orders_city_end_date" class="form-label">إلى تاريخ:</label>
                    <input type="date" name="end_date" id="orders_city_end_date" value="{{ $endDate ?? now()->toDateString() }}" class="form-control">
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
                        <th>المدينة</th>
                        <th>المحافظة</th>
                        <th>عدد الطلبات</th>
                        <th>إجمالي المبيعات</th>
                    </tr>
                </thead>
                <tbody id="orders-by-city-report-table">
                    @forelse ($data ?? [] as $city)
                        <tr>
                            <td>{{ $city->city_name }}</td>
                            <td>{{ $city->governate_name }}</td>
                            <td>{{ $city->order_count }}</td>
                            <td>{{ number_format($city->total_sales, 2) }}</td>
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
    document.getElementById('orders-by-city-report-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const queryString = new URLSearchParams(formData).toString();
        fetch('{{ route('reports.orders-by-city.data') }}?' + queryString, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            const tableBody = document.querySelector('#orders-by-city-report-table');
            tableBody.innerHTML = '';
            if (data.data.length === 0) {
                tableBody.innerHTML = '<tr><td colspan="4" class="text-center">لا توجد سجلات</td></tr>';
            } else {
                data.data.forEach(item => {
                    tableBody.innerHTML += `
                        <tr>
                            <td>${item.city_name}</td>
                            <td>${item.governate_name}</td>
                            <td>${item.order_count}</td>
                            <td>${parseFloat(item.total_sales).toFixed(2)}</td>
                        </tr>
                    `;
                });
            }
        })
        .catch(error => console.error('Error:', error));
    });

    function exportToExcel() {
        const form = document.getElementById('orders-by-city-report-form'); // تعديل هنا
        const formData = new FormData(form);
        const queryString = new URLSearchParams(formData).toString();
        window.location.href = '{{ route("reports.order.export") }}?' + queryString;
    }
</script>