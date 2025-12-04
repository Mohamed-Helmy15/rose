<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // جدول المخازن (Warehouses) - لدعم متعدد المخازن، مع خيار التبريد للفريش
        Schema::create('warehouses', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // اسم المخزن (مثل 'المخزن الرئيسي')
            $table->text('address')->nullable(); // عنوان
            $table->boolean('is_refrigerated')->default(false); // هل مبرد للزهور الفريش
            $table->foreignId('branch_id')->nullable()->constrained()->onDelete('cascade'); // ربط بالفرع إذا multi_branch
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // جدول مستويات المخزون (Inventory) - مستوى لكل منتج في مخزن
        Schema::create('inventory', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('warehouse_id')->constrained()->onDelete('cascade');
            $table->integer('quantity')->default(0); // الكمية المتاحة
            $table->integer('min_stock_level')->default(10); // حد إعادة الطلب (من settings reorder_level_alert)
            $table->integer('max_stock_level')->nullable(); // حد أقصى اختياري
            $table->timestamps();
        });

        // جدول الدفعات (Batches) - لتتبع lot, expiry للفريش
        Schema::create('batches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('goods_received_note_id')->constrained()->onDelete('cascade'); // ربط بـ GRN من الاستلام
            $table->foreignId('warehouse_id')->constrained()->onDelete('cascade');
            $table->string('lot_number')->nullable(); // رقم الدفعة
            $table->date('receive_date'); // تاريخ الاستلام
            $table->date('expiry_date')->nullable(); // تاريخ الصالحية (بناءً على shelf_life_days)
            $table->integer('quantity'); // الكمية في الدفعة
            $table->enum('status', ['available', 'expired', 'damaged', 'reserved'])->default('available');
            $table->text('notes')->nullable(); // ملاحظات جودة
            $table->timestamps();
        });

        // جدول حركات المخزون (Stock Movements) - تتبع الدخول/الخروج
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('batch_id')->nullable()->constrained('batches')->onDelete('set null'); // ربط بدفعة إذا FEFO
            $table->foreignId('warehouse_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['in', 'out', 'adjustment', 'return', 'damage']); // نوع: دخول (استلام), خروج (بيع/تجهيز), تعديل, إرجاع, تلف
            $table->integer('quantity');
            $table->text('reason')->nullable(); // سبب (مثل 'استلام شحنة', 'بيع طلب #123', 'تلف')
            $table->foreignId('order_id')->nullable()->constrained()->onDelete('set null'); // ربط بطلب مبيعات إذا خروج
            $table->foreignId('purchase_order_id')->nullable()->constrained()->onDelete('set null'); // ربط بشراء إذا دخول
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // من قام بالحركة (مسؤول استلام/تجهيز)
            $table->timestamps();
        });

        // جدول قوائم الانتقاء (Pick Lists) - لتجهيز الباقات
        Schema::create('pick_lists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade'); // ربط بطلب المبيعات
            $table->json('items'); // مكونات: [{'product_id':1, 'quantity':2, 'batch_id':3}, ...] للباقات المركبة
            $table->enum('status', ['pending', 'prepared', 'packed', 'ready'])->default('pending');
            $table->text('notes')->nullable(); // ملاحظات (تغليف خاص، طقس حار)
            $table->foreignId('prepared_by')->nullable()->constrained('users')->onDelete('set null'); // فريق التجهيز
            $table->timestamps();
        });

        // جدول التوصيلات (Deliveries)
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('driver_id')->nullable()->constrained('users')->onDelete('set null'); // المندوب
            $table->dateTime('scheduled_time')->nullable(); // وقت التوصيل المجدول
            $table->dateTime('delivery_time')->nullable(); // وقت التوصيل الفعلي
            $table->enum('status', ['pending', 'in_transit', 'delivered', 'failed', 'returned'])->default('pending');
            $table->string('proof')->nullable(); // إثبات (توقيع, صورة, رمز)
            $table->text('notes')->nullable(); // ملاحظات (وسائل حفظ, مشكلات)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('deliveries');
        Schema::dropIfExists('pick_lists');
        Schema::dropIfExists('stock_movements');
        Schema::dropIfExists('batches');
        Schema::dropIfExists('inventory');
        Schema::dropIfExists('warehouses');
    }
};