<?php

namespace App\Exports;

use App\Models\OrderItem;
use App\Models\Order;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Carbon\Carbon;

class CogsProfitReportExport implements FromCollection, WithHeadings
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

        return OrderItem::query()
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->where('orders.status', 'delivered')
            ->whereBetween('orders.created_at', [$startDate, Carbon::parse($endDate)->endOfDay()])
            ->selectRaw('products.name, products.sku, SUM(order_items.quantity) as total_quantity, SUM(order_items.subtotal) as total_revenue, SUM(order_items.quantity * products.cost_price) as total_cogs, (SUM(order_items.subtotal) - SUM(order_items.quantity * products.cost_price)) as profit')
            ->groupBy('products.id', 'products.name', 'products.sku')
            ->get()
            ->map(function ($item) {
                return collect($item)->forget(['id']);
            });
    }

    public function headings(): array
    {
        return ['المنتج', 'SKU', 'الكمية المباعة', 'إجمالي الإيرادات', 'إجمالي التكلفة', 'الربح'];
    }
}