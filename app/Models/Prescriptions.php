<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prescriptions extends Model
{
    use HasFactory;

    protected $fillable = [
        'medical_record_id', // Pastikan ini medical_record_id (bukan medical_records_id)
        'medicine_id',
        'quantity',
        'dosage',
        'notes'
    ];

    // PERBAIKAN: Tentukan foreign key secara eksplisit
    public function medicalRecord()
    {
        return $this->belongsTo(Medical_records::class, 'medical_record_id'); // Tentukan medical_record_id
    }

    public function medicine()
    {
        return $this->belongsTo(Medicines::class, 'medicine_id');
    }
}