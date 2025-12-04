<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('contact_name')->nullable();
            $table->string('phone');
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->string('tax_number')->nullable();
            $table->text('bank_details')->nullable();
            $table->string('payment_terms')->nullable();
            $table->integer('delivery_time_days')->nullable();
            $table->decimal('quality_rating', 3, 2)->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_id')->constrained()->onDelete('cascade');
            $table->date('order_date');
            $table->date('expected_delivery_date');
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->enum('status', ['pending', 'received', 'partial', 'cancelled'])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('goods_received_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_order_id')->constrained()->onDelete('cascade');
            $table->date('received_date');
            $table->foreignId('received_by_user_id')->constrained('users')->onDelete('cascade');
            $table->enum('status', ['accepted', 'partial', 'rejected'])->default('accepted');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('supplier_evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_id')->constrained()->onDelete('cascade');
            $table->date('evaluation_date');
            $table->decimal('rating', 3, 2);
            $table->text('comments')->nullable();
            $table->foreignId('evaluated_by_user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('product_supplier', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('supplier_id')->constrained()->onDelete('cascade');
            $table->decimal('price', 10, 2)->nullable();
            $table->integer('min_order_quantity')->nullable();
            $table->timestamps();
        });

        Schema::create('product_purchase_order', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('purchase_order_id')->constrained()->onDelete('cascade');
            $table->integer('quantity');
            $table->decimal('price', 10, 2);
            $table->decimal('subtotal', 10, 2);
            $table->timestamps();
        });

        Schema::create('grn_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('goods_received_note_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->integer('quantity');
            $table->enum('quality_status', ['accepted', 'rejected', 'partial']);
            $table->string('lot_number')->nullable();
            $table->date('expiry_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
        Schema::dropIfExists('purchase_orders');
        Schema::dropIfExists('goods_received_notes');
        Schema::dropIfExists('supplier_evaluations');
        Schema::dropIfExists('product_supplier');
        Schema::dropIfExists('product_purchase_order');
        Schema::dropIfExists('grn_items');
    }
};
