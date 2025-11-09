<?php
// database/migrations/2024_01_01_000002_create_visits_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            // $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->nu; // dokter
            $table->string('polyclinic');
            $table->integer('queue_number');
            $table->enum('status', ['waiting', 'in_progress', 'completed', 'cancelled'])->default('waiting');
            $table->text('complaint');
            $table->datetime('visit_date');
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index(['visit_date', 'status']);
            $table->index('queue_number');
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visits');
    }
};