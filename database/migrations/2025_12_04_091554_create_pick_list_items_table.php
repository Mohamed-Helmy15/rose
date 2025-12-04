<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pick_list_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pick_list_id')->constrained('pick_lists')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('products');
            $table->integer('required_quantity');
            $table->integer('picked_quantity')->default(0);
            $table->timestamps();

            $table->unique(['pick_list_id', 'product_id']);
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('pick_list_items');
    }
};