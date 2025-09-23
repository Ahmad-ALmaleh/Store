<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
             $table->string('name'); // اسم المنتج
            $table->decimal('price', 8, 2); // السعر بدقة خانتين عشري   تين
            $table->text('description')->nullable(); // وصف المنتج (اختياري)
            $table->date('exp_date')->nullable(); // تاريخ انتهاء الصلاحية (اختياري)
            $table->string('img_url')->nullable(); // رابط الصورة (اختياري)
            $table->integer('quantity')->default(1); // الكمية، افتراضي = 1
            $table->foreignId('category_id')->constrained()->onDelete('cascade'); // مفتاح أجنبي للجدول categories
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
