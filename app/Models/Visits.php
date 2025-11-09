<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Visits extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'patient_id',
        'user_id',
        'polyclinic',
        'queue_number',
        'status',
        'complaint',
        'visit_date',
        'notes'
    ];

    protected $casts = [
        'visit_date' => 'datetime',
    ];

    // Relationships
    public function patient()
    {
        return $this->belongsTo(Patients::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

     // PERBAIKAN: Tentukan foreign key secara eksplisit
    public function medicalRecord()
    {
        return $this->hasOne(Medical_records::class, 'visit_id'); // Tentukan visit_id sebagai foreign key
    }

    // Scopes
    public function scopeToday($query)
    {
        return $query->whereDate('visit_date', today());
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByPolyclinic($query, $polyclinic)
    {
        return $query->where('polyclinic', $polyclinic);
    }

    // Accessors
    public function getFormattedVisitDateAttribute()
    {
        return $this->visit_date->format('d/m/Y H:i');
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'waiting' => 'badge-warning',
            'in_progress' => 'badge-info',
            'completed' => 'badge-success',
            'cancelled' => 'badge-danger'
        ];

        $statusText = [
            'waiting' => 'Menunggu',
            'in_progress' => 'Dalam Proses',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan'
        ];

        return '<span class="badge ' . $badges[$this->status] . '">' . $statusText[$this->status] . '</span>';
    }
}