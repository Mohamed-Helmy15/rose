
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->longText('value')->nullable();
            $table->string('type')->default('text'); // text, image, boolean, number, json
            $table->string('group')->default('general');
            $table->text('description')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        // إضافة البيانات الافتراضية
        $this->seedDefaultSettings();
    }

    private function seedDefaultSettings()
    {
        $settings = [
            // 1. النظام الأساسي
            ['key' => 'system_name', 'value' => 'زهور - نظام إدارة متجر الورود', 'type' => 'text', 'group' => 'general', 'description' => 'اسم النظام يظهر في كل الصفحات والفواتير', 'order' => 1],
            ['key' => 'logo', 'value' => null, 'type' => 'image', 'group' => 'general', 'description' => 'الشعار الرسمي للمتجر', 'order' => 2],
            ['key' => 'language', 'value' => 'ar', 'type' => 'select', 'group' => 'general', 'description' => 'اللغة الأساسية', 'order' => 3],
            ['key' => 'timezone', 'value' => 'Africa/Cairo', 'type' => 'text', 'group' => 'general', 'description' => 'المنطقة الزمنية', 'order' => 4],
            ['key' => 'date_format', 'value' => 'd/m/Y', 'type' => 'text', 'group' => 'general', 'description' => 'تنسيق التاريخ', 'order' => 5],
            ['key' => 'currency', 'value' => 'ج.م', 'type' => 'text', 'group' => 'general', 'description' => 'العملة الأساسية', 'order' => 6],

            // 2. الفروع
            ['key' => 'multi_branch', 'value' => '1', 'type' => 'boolean', 'group' => 'branches', 'description' => 'تفعيل الفروع المتعددة', 'order' => 10],
            ['key' => 'invoice_prefix', 'value' => 'INV-', 'type' => 'text', 'group' => 'branches', 'description' => 'بادئة الفواتير لكل فرع', 'order' => 11],

            // 3. المخزون
            ['key' => 'shelf_life_days', 'value' => '7', 'type' => 'number', 'group' => 'inventory', 'description' => 'مدة صلاحية الزهور (أيام)', 'order' => 20],
            ['key' => 'inventory_method', 'value' => 'FEFO', 'type' => 'select', 'group' => 'inventory', 'description' => 'طريقة إدارة المخزون', 'order' => 21],
            ['key' => 'reorder_level_alert', 'value' => '10', 'type' => 'number', 'group' => 'inventory', 'description' => 'حد إعادة الطلب', 'order' => 22],

            // 4. الضرائب
            ['key' => 'vat_rate', 'value' => '0', 'type' => 'number', 'group' => 'tax', 'description' => 'نسبة ضريبة القيمة المضافة (%)', 'order' => 30],
            ['key' => 'vat_inclusive', 'value' => '0', 'type' => 'boolean', 'group' => 'tax', 'description' => 'السعر شامل الضريبة؟', 'order' => 31],
            ['key' => 'tax_on_shipping', 'value' => '0', 'type' => 'boolean', 'group' => 'tax', 'description' => 'احتساب الضريبة على الشحن', 'order' => 32],

            // 5. الأمان
            ['key' => 'login_attempts', 'value' => '5', 'type' => 'number', 'group' => 'security', 'description' => 'عدد محاولات تسجيل الدخول قبل الحظر', 'order' => 40],
            ['key' => 'session_timeout', 'value' => '30', 'type' => 'number', 'group' => 'security', 'description' => 'مدة الجلسة بالدقائق', 'order' => 41],
        ];

        foreach ($settings as $setting) {
            \App\Models\Setting::create($setting);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};