<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_id')->nullable()->constrained('business_settings')->cascadeOnDelete();
            $table->string('name');
            $table->string('slug')->index();
            $table->foreignId('parent_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_id')->nullable()->constrained('business_settings')->cascadeOnDelete();
            $table->string('name');
            $table->string('short_code', 20);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('units');
        Schema::dropIfExists('categories');
    }
};
