<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patients extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nik',
        'medical_record_number',
        'name',
        'birth_place',
        'birth_date',
        'gender',
        'address',
        'phone',
        'emergency_contact_name',
        'emergency_contact_phone',
        'allergy_history',
        'insurance_type',
        'insurance_number',
        'notes',
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];
}