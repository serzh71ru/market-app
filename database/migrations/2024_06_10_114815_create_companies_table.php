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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('abbreviated_name');
            $table->text('full_name')->nullable();
            $table->string('address')->nullable();
            $table->integer('INN/KPP')->nullable();
            $table->integer('payment_account')->nullable();
            $table->text('full_bank_name')->nullable();
            $table->integer('correspondent_account')->nullable();
            $table->integer('BIK')->nullable();
            $table->integer('OKVED_code')->nullable();
            $table->integer('OKATO')->nullable();
            $table->integer('OKPO')->nullable();
            $table->integer('OKFS')->nullable();
            $table->integer('OKOPF')->nullable();
            $table->integer('OGRN')->nullable();
            $table->string('general_director')->nullable();
            $table->string('general_accountant')->nullable();
            $table->string('contact_name');
            $table->string('email');
            $table->string('phone');
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
