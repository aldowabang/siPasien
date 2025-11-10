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

    // PERBAIKAN: Tentukan foreign key secara eksplisit
    public function visits()
    {
        return $this->hasMany(Visits::class, 'patient_id'); // Tentukan patient_id sebagai foreign key
    }

    public function scopeActive($query)
    {
        return $query->whereNull('deleted_at');
    }

    public function scopeTrashed($query)
    {
        return $query->whereNotNull('deleted_at');
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('nik', 'like', "%{$search}%")
              ->orWhere('medical_record_number', 'like', "%{$search}%");
        });
    }

    public function getFormattedBirthDateAttribute()
    {
        return $this->birth_date->format('d/m/Y');
    }

    public function getGenderTextAttribute()
    {
        return $this->gender == 'L' ? 'Laki-laki' : 'Perempuan';
    }
}