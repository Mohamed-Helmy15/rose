<?php

namespace App\Exports;

use App\Models\Order;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Carbon\Carbon;

class OrdersByCityReportExport implements FromCollection, WithHeadings
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $startDate = $this->request->input('start_date', Carbon::today()->startOfMonth()->toDateString());
        $endDate = $this->request->input('end_date', Carbon::today()->toDateString());

        return Order::query()
            ->join('locations', 'orders.location_id', '=', 'locations.id')
            ->join('cities', 'locations.city_id', '=', 'cities.id')
            ->join('governates', 'cities.governate_id', '=', 'governates.id')
            ->where('orders.status', 'delivered')
            ->whereBetween('orders.created_at', [$startDate, Carbon::parse($endDate)->endOfDay()])
            ->selectRaw('cities.name as city_name, governates.name as governate_name, COUNT(orders.id) as order_count, SUM(orders.grand_total) as total_sales')
            ->groupBy('cities.id', 'cities.name', 'governates.name')
            ->orderByDesc('total_sales')
            ->get();
    }

    public function headings(): array
    {
        return ['المدينة', 'المحافظة', 'عدد الطلبات', 'إجمالي المبيعات'];
    }
}