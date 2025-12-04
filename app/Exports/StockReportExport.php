<?php

namespace App\Exports;

use App\Models\Stock;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StockReportExport implements FromCollection, WithHeadings
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $branchId = $this->request->input('branch_id');
        $warehouseId = $this->request->input('warehouse_id');

        $query = Stock::query()
            ->join('products', 'stock.product_id', '=', 'products.id')
            ->join('warehouses', 'stock.warehouse_id', '=', 'warehouses.id')
            ->join('branches', 'warehouses.branch_id', '=', 'branches.id')
            ->selectRaw('products.name, products.sku, branches.name as branch_name, warehouses.name as warehouse_name, SUM(stock.quantity) as total_quantity')
            ->groupBy('products.id', 'products.name', 'products.sku', 'warehouses.name', 'branches.name');

        if ($branchId) {
            $query->where('branches.id', $branchId);
        }
        if ($warehouseId) {
            $query->where('warehouses.id', $warehouseId);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return ['المنتج', 'SKU', 'الفرع', 'المخزن', 'الكمية'];
    }
}