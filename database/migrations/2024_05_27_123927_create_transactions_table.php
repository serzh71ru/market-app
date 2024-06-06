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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount', 10, 2)->default(0);
            $table->string('description');
            $table->integer('order_id')->nullable();
            $table->integer('unreg_order_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('user_name');
            $table->string('order_type');
            $table->string('payment_id')->default(0);
            $table->enum('status', ['CREATED', 'FAILED', 'CONFIRMED'])->default('CREATED');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
