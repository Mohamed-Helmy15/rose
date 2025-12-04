<!-- resources/views/components/cogs-profit-report.blade.php -->
<div class="card mb-4">
    <div class="card-header">
        <h5>تقرير تكلفة البضاعة المباعة والربح</h5>
    </div>
    <div class="card-body">
        @if (session('toast.cogs_profit'))
            <div class="bs-toast toast toast-placement-ex m-3 fade show {{ session('toast.cogs_profit.type') }}" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000">
                <div class="toast-header">
                    <i class='bx bx-bell me-2'></i>
                    <div class="me-auto fw-medium">إشعار</div>
                    <small>الآن</small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    {{ session('toast.cogs_profit.message') }}
                </div>
            </div>
        @endif
        <form id="cogs-profit-report-form" class="mb-4 d-flex justify-content-between align-items-center">
            <div class="d-flex gap-3">
                <div>
                    <label for="cogs_profit_start_date" class="form-label">من تاريخ:</label>
                    <input type="date" name="start_date" id="cogs_profit_start_date" value="{{ $startDate ?? now()->startOfMonth()->toDateString() }}" class="form-control">
                </div>
                <div>
                    <label for="cogs_profit_end_date" class="form-label">إلى تاريخ:</label>
                    <input type="date" name="end_date" id="cogs_profit_end_date" value="{{ $endDate ?? now()->toDateString() }}" class="form-control">
                </div>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">عرض</button>
                <button type="button" class="btn btn-success" onclick="exportToExcel()">تحميل Excel</button>
            </div>
        </form>
        <div class="mb-4">
        </div>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>المنتج</th>
                        <th>SKU</th>
                        <th>الكمية المباعة</th>
                        <th>إجمالي الإيرادات</th>
                        <th>إجمالي التكلفة</th>
                        <th>الربح</th>
                    </tr>
                </thead>
                <tbody id="cogs-profit-report-table">
                    @forelse ($data ?? [] as $item)
                        <tr>
                            <td>{{ $item['name'] }}</td>
                            <td>{{ $item['sku'] }}</td>
                            <td>{{ $item['total_quantity'] }}</td>
                            <td>{{ number_format($item['total_revenue'], 2) }}</td>
                            <td>{{ number_format($item['total_cogs'], 2) }}</td>
                            <td>{{ number_format($item['profit'], 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">لا توجد سجلات</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    document.getElementById('cogs-profit-report-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const queryString = new URLSearchParams(formData).toString();
        fetch('{{ route('reports.cogs-profit.data') }}?' + queryString, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            const tableBody = document.querySelector('#cogs-profit-report-table');
            const summary = document.querySelector('#cogs-profit-report-table').closest('.card-body').querySelector('.mb-4');
            tableBody.innerHTML = '';
            if (data.data.length === 0) {
                tableBody.innerHTML = '<tr><td colspan="6" class="text-center">لا توجد سجلات</td></tr>';
            } else {
                data.data.forEach(item => {
                    tableBody.innerHTML += `
                        <tr>
                            <td>${item.name}</td>
                            <td>${item.sku}</td>
                            <td>${item.total_quantity}</td>
                            <td>${parseFloat(item.total_revenue).toFixed(2)}</td>
                            <td>${parseFloat(item.total_cogs).toFixed(2)}</td>
                            <td>${parseFloat(item.profit).toFixed(2)}</td>
                        </tr>
                    `;
                });
            }
            // summary.innerHTML = `
            //     <p>إجمالي الإيرادات: ${parseFloat(data.totalRevenue).toFixed(2)}</p>
            //     <p>إجمالي التكلفة: ${parseFloat(data.totalCogs).toFixed(2)}</p>
            //     <p>إجمالي الربح: ${parseFloat(data.totalProfit).toFixed(2)}</p>
            // `;
        })
        .catch(error => console.error('Error:', error));
    });

    function exportToExcel() {
        const form = document.getElementById('cogs-profit-report-form'); // تعديل هنا
        const formData = new FormData(form);
        const queryString = new URLSearchParams(formData).toString();
        window.location.href = '{{ route("reports.cogs.export") }}?' + queryString;
    }
</script>