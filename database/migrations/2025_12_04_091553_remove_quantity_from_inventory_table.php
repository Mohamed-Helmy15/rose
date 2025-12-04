<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inventory', function (Blueprint $table) {
            $table->dropColumn(['quantity', 'min_stock_level', 'max_stock_level']);
        });
    }

    public function down(): void
    {
        Schema::table('inventory', function (Blueprint $table) {
            $table->integer('quantity')->default(0);
            $table->integer('min_stock_level')->default(10);
            $table->integer('max_stock_level')->default(100);
        });
    }
};