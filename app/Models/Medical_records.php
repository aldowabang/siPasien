<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medical_records extends Model
{
    use HasFactory;

    protected $fillable = [
        'visit_id',
        'main_complaint',
        'symptoms',
        'physical_examination',
        'diagnosis',
        'treatment',
        'notes',
        'temperature',
        'blood_pressure_systolic',
        'blood_pressure_diastolic',
        'heart_rate',
        'respiratory_rate'
    ];

    protected $casts = [
        'temperature' => 'decimal:2',
    ];

    // Relationships
 // PERBAIKAN: Tentukan foreign key secara eksplisit
    public function visit()
    {
        return $this->belongsTo(Visits::class, 'visit_id'); // Tentukan visit_id sebagai foreign key
    }

    
    public function prescriptions()
    {
        return $this->hasMany(Prescriptions::class);
    }

    // Accessors
    public function getBloodPressureAttribute()
    {
        if ($this->blood_pressure_systolic && $this->blood_pressure_diastolic) {
            return $this->blood_pressure_systolic . '/' . $this->blood_pressure_diastolic . ' mmHg';
        }
        return '-';
    }
}