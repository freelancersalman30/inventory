<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_id')->nullable()->constrained('business_settings')->cascadeOnDelete();
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->foreignId('unit_id')->nullable()->constrained('units')->nullOnDelete();
            $table->string('name');
            $table->string('slug')->index();
            $table->string('sku')->unique();
            $table->string('barcode')->nullable()->index();
            $table->decimal('purchase_price', 12, 2)->default(0.00);
            $table->decimal('selling_price', 12, 2)->default(0.00);
            $table->decimal('vat_rate', 5, 2)->default(0.00);
            $table->decimal('alert_quantity', 10, 2)->default(5.00);
            $table->boolean('has_variants')->default(false);
            $table->boolean('is_active')->default(true);
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->string('variant_name')->nullable(); // e.g. "Size: XL, Color: Red"
            $table->string('sku')->unique();
            $table->string('barcode')->nullable()->index();
            $table->string('size')->nullable();
            $table->string('color')->nullable();
            $table->decimal('purchase_price', 12, 2)->default(0.00);
            $table->decimal('selling_price', 12, 2)->default(0.00);
            $table->decimal('stock_quantity', 12, 3)->default(0.000);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('product_batches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_variant_id')->constrained('product_variants')->cascadeOnDelete();
            $table->string('batch_number')->index();
            $table->date('expiry_date')->nullable()->index();
            $table->decimal('quantity', 12, 3)->default(0.000);
            $table->decimal('purchase_price', 12, 2)->default(0.00);
            $table->decimal('selling_price', 12, 2)->default(0.00);
            $table->timestamps();
        });

        Schema::create('stock_ledgers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_id')->nullable()->constrained('business_settings')->cascadeOnDelete();
            $table->foreignId('product_variant_id')->constrained('product_variants')->cascadeOnDelete();
            $table->foreignId('batch_id')->nullable()->constrained('product_batches')->nullOnDelete();
            $table->enum('type', ['purchase', 'sale', 'sale_return', 'purchase_return', 'damage', 'wastage', 'adjustment'])->index();
            $table->decimal('quantity', 12, 3);
            $table->decimal('unit_cost', 12, 2)->default(0.00);
            $table->string('reference_type')->nullable();
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('stock_ledgers');
        Schema::dropIfExists('product_batches');
        Schema::dropIfExists('product_variants');
        Schema::dropIfExists('products');
    }
};
