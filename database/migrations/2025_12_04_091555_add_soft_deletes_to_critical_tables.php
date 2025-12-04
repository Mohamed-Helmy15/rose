<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $tables = [
            'products', 'batches', 'warehouses', 'branches', 'orders',
            'purchase_orders', 'goods_received_notes', 'suppliers', 'stock_movements'
        ];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->softDeletes();
            });
        }
    }

    public function down(): void
    {
        foreach (['products', 'batches', 'warehouses', 'branches', 'orders', 'purchase_orders', 'goods_received_notes', 'suppliers', 'stock_movements'] as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->dropSoftDeletes();
            });
        }
    }
};