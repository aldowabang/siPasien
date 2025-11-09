<?php
// database/migrations/2024_01_01_000004_create_medicines_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medicines', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('type'); // tablet, sirup, kapsul, dll
            $table->string('unit'); // pcs, botol, strip
            $table->integer('stock')->default(0);
            $table->integer('min_stock')->default(10);
            $table->decimal('price', 10, 2)->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index(['code', 'name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medicines');
    }
};