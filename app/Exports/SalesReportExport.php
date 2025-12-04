<?php

namespace App\Exports;

use App\Models\Order;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Carbon\Carbon;

class SalesReportExport implements FromCollection, WithHeadings
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $period = $this->request->input('period', 'daily');
        $startDate = $this->request->input('start_date', Carbon::today()->startOfMonth()->toDateString());
        $endDate = $this->request->input('end_date', Carbon::today()->toDateString());
        $status = $this->request->input('status', 'delivered');

        $query = Order::where('status', $status)
            ->whereBetween('created_at', [$startDate, Carbon::parse($endDate)->endOfDay()]);

        $salesData = match ($period) {
            'daily' => $query->selectRaw('DATE(created_at) as date, SUM(grand_total) as total_sales, COUNT(*) as order_count')
                ->groupBy('date')
                ->orderBy('date', 'asc')
                ->get(),
            'weekly' => $query->selectRaw('YEARWEEK(created_at, 1) as week, SUM(grand_total) as total_sales, COUNT(*) as order_count')
                ->groupBy('week')
                ->orderBy('week', 'asc')
                ->get()
                ->map(function ($item) {
                    return collect($item)->merge(['date' => Carbon::createFromFormat('Ymd', $item->week . '1')->startOfWeek()->format('Y-m-d')])->forget('week');
                }),
            'monthly' => $query->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, SUM(grand_total) as total_sales, COUNT(*) as order_count')
                ->groupBy('month')
                ->orderBy('month', 'asc')
                ->get()
                ->map(function ($item) {
                    return collect($item)->merge(['date' => Carbon::createFromFormat('Y-m', $item->month)->startOfMonth()->format('Y-m-d')])->forget('month');
                }),
            default => collect([]),
        };

        return $salesData;
    }

    public function headings(): array
    {
        return ['التاريخ', 'إجمالي المبيعات', 'عدد الطلبات'];
    }
}