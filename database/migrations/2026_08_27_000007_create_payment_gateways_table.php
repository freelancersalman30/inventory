<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('payment_gateways', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_id')->default(1);
            $table->string('name'); // e.g. bKash Merchant, Nagad Personal, Card POS, Cash
            $table->string('code')->unique(); // e.g. cash, bkash, nagad, rocket, card, bank
            $table->enum('type', ['cash', 'mfs', 'card', 'bank', 'online'])->default('mfs');
            $table->string('account_number')->nullable();
            $table->decimal('charge_percentage', 5, 2)->default(0.00);
            $table->boolean('is_active')->default(true);
            $table->text('instructions')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('payment_gateways');
    }
};
