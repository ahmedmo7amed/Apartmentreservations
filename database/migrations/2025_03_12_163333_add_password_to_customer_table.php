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
        Schema::table('customers', function (Blueprint $table) {
           //$table->string('password');
        });


        Schema::table('sessions', function (Blueprint $table) {

            //$table->foreignId('customer_id')->nullable()->index();

        });

    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customer', function (Blueprint $table) {
            Schema::table('customer', function (Blueprint $table) {
                $table->dropColumn('password');
            });

                  });
    }
};
