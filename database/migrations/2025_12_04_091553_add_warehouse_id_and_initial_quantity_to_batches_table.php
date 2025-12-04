<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('batches', function (Blueprint $table) {
            // لو warehouse_id مش موجود
            if (!Schema::hasColumn('batches', 'warehouse_id')) {
                $table->foreignId('warehouse_id')->after('product_id')->constrained('warehouses');
            }

            // نضيف الكمية الأولية
            $table->integer('initial_quantity')->after('quantity')->default(0);

            // نضيف status لو مش موجود
            if (!Schema::hasColumn('batches', 'status')) {
                $table->enum('status', ['available', 'expired', 'damaged', 'consumed'])->default('available');
            }

            // نعمل index قوي للـ FEFO
            $table->index(['warehouse_id', 'product_id']);
            $table->index('expiry_date');
        });

        // نحط الكمية الحالية في initial_quantity للباتشات القديمة
        \DB::statement('UPDATE batches SET initial_quantity = quantity WHERE initial_quantity = 0');
    }

    public function down(): void
    {
        Schema::table('batches', function (Blueprint $table) {
            $table->dropIndex(['warehouse_id', 'product_id']);
            $table->dropIndex(['expiry_date']);

            $table->dropColumn('initial_quantity');
            if (Schema::hasColumn('batches', 'status')) {
                $table->dropColumn('status');
            }
            if (Schema::hasColumn('batches', 'warehouse_id')) {
                $table->dropForeign(['warehouse_id']);
                $table->dropColumn('warehouse_id');
            }
        });
    }
};