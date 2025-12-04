<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {


            // احذف الأعمدة
            $table->dropColumn(['stock_quantity', 'expiry_date', 'branch_id', 'shelf_life_days']);
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->integer('stock_quantity')->default(0);
            $table->date('expiry_date')->nullable();
            $table->foreignId('branch_id')->nullable()->constrained()->onDelete('cascade');
            $table->integer('shelf_life_days')->default(7);
        });
    }
};
