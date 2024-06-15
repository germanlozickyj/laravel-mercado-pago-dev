<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('mercado_pago_plan_id');
            $table->string('application_id');
            $table->string('reason');
            $table->string('back_url');
            $table->integer('external_reference')->nullable();
            $table->string('url');
            $table->string('status');
            $table->json('auto_recurring');
            $table->json('payment_methods_allowed');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
