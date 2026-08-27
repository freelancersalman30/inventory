<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('stock_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->foreignId('product_variant_id')->nullable()->constrained('product_variants')->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            
            $table->enum('movement_type', ['purchase', 'sale', 'return_in', 'return_out', 'damage_wastage', 'adjustment']);
            $table->decimal('quantity', 10, 2); // Positive or negative based on transaction
            $table->decimal('stock_after', 10, 2); // Audit snapshot
            $table->nullableMorphs('reference'); // Links to Sale, Return, or Purchase ID
            $table->string('note')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });

        Schema::create('returns_and_wastages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products');
            $table->foreignId('product_variant_id')->nullable()->constrained('product_variants')->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            
            $table->enum('type', ['customer_return', 'supplier_return', 'damage', 'wastage', 'expired']);
            $table->decimal('quantity', 10, 2);
            $table->decimal('unit_cost', 12, 2);
            $table->decimal('total_amount', 12, 2);
            $table->string('reason')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('returns_and_wastages');
        Schema::dropIfExists('stock_histories');
    }
};
