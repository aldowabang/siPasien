<?php
// database/migrations/2024_01_01_000001_create_patients_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('nik')->unique();
            $table->string('medical_record_number')->unique();
            $table->string('name');
            $table->string('birth_place');
            $table->date('birth_date');
            $table->enum('gender', ['L', 'P']);
            $table->text('address');
            $table->string('phone');
            $table->string('emergency_contact_name');
            $table->string('emergency_contact_phone');
            $table->text('allergy_history')->nullable();
            $table->string('insurance_type')->nullable();
            $table->string('insurance_number')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['nik', 'medical_record_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};