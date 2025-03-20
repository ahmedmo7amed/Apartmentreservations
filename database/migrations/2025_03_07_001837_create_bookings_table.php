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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id(); // أفضل من increments('id')
            $table->datetime('time_from');
            $table->datetime('time_to');
            $table->text('additional_information')->nullable();

            // العلاقات
            $table->foreignId('customer_id')
                ->nullable()
                ->constrained('customers')
                ->cascadeOnDelete();
            // حالة الحجز
            $table->string('status')
                ->default('pending')
                ->comment('pending, confirmed, canceled');



            // الحقول المالية
            $table->decimal('price', 10, 2)
                ->comment('السعر الإجمالي للحجز');

            // إدارة التواريخ
            $table->timestamps();
            $table->softDeletes();

            // الفهارس
            $table->index('deleted_at');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
