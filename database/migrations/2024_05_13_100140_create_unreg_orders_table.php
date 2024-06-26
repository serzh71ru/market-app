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
        Schema::create('unreg_orders', function (Blueprint $table) {
            $table->id();
            $table->string('user_name');
            $table->string('user_email');
            $table->string('user_phone');
            $table->string('user_address');
            $table->string('user_address_info')->nullable();
            $table->text('comment')->nullable();
            $table->text('products');
            $table->float('sum');
            $table->enum('status', ['Создан', 'Оплачен', 'Подтвержден', 'Выполнен'])->default('Создан');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unreg_orders');
    }
};
