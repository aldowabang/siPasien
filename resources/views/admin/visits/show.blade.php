@extends('layout.main')
@section('content')
<div class="az-dashboard-one-title">
    <ul class="az-content-breadcrumb">
        @foreach ($breadcrumbs as $breadcrumb)
            <li class="breadcrumb-item {{ $loop->last ? 'active' : '' }}">
                @if (!$loop->last)
                    <a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['label'] }}</a>
                @else
                    {{ $breadcrumb['label'] }}
                @endif
            </li>
        @endforeach
    </ul>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <h2 class="card-title mb-0">Detail Kunjungan</h2>
            <p class="mb-0">Informasi lengkap kunjungan pasien</p>
        </div>
        <div>
            <a href="{{ route('visits.index') }}" class="btn btn-secondary buttom-radius">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <a href="{{ route('visits.edit', $visit->id) }}" class="btn btn-warning buttom-radius">
                <i class="fas fa-edit"></i> Edit
            </a>
            @if(!$visit->medicalRecord && $visit->status != 'completed')
                <a href="{{ route('visits.medical-record.create', $visit->id) }}" class="btn btn-success buttom-radius">
                    <i class="fas fa-file-medical"></i> Rekam Medis
                </a>
            @endif
        </div>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Informasi Kunjungan -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="info-section">
                    <h5 class="info-title">Informasi Kunjungan</h5>
                    <div class="info-content">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="info-item">
                                    <label>Nomor Antrian</label>
                                    <p class="text-primary font-weight-bold">{{ $visit->queue_number }}</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-item">
                                    <label>Status</label>
                                    <p>{!! $visit->status_badge !!}</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-item">
                                    <label>Poli</label>
                                    <p>{{ $visit->polyclinic }}</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-item">
                                    <label>Tanggal Kunjungan</label>
                                    <p>{{ $visit->visit_date->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="info-item">
                                    <label>Keluhan Utama</label>
                                    <p class="complaint-text">{{ $visit->complaint }}</p>
                                </div>
                            </div>
                        </div>
                        @if($visit->notes)
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <div class="info-item">
                                    <label>Catatan Tambahan</label>
                                    <p>{{ $visit->notes }}</p>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Informasi Pasien -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="info-section">
                    <h5 class="info-title">Informasi Pasien</h5>
                    <div class="info-content">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="info-item">
                                    <label>Nama Lengkap</label>
                                    <p>{{ $visit->patient->name }}</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-item">
                                    <label>NIK</label>
                                    <p>{{ $visit->patient->nik ?? '-' }}</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-item">
                                    <label>No. Rekam Medis</label>
                                    <p class="text-primary">{{ $visit->patient->medical_record_number }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="info-item">
                                    <label>Tempat, Tanggal Lahir</label>
                                    <p>{{ $visit->patient->birth_place }}, {{ $visit->patient->birth_date->format('d/m/Y') }}</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-item">
                                    <label>Usia</label>
                                    <p>{{ \Carbon\Carbon::parse($visit->patient->birth_date)->age }} tahun</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-item">
                                    <label>Jenis Kelamin</label>
                                    <p>{{ $visit->patient->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-item">
                                    <label>Nomor Telepon</label>
                                    <p>{{ $visit->patient->phone }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <label>Alamat</label>
                                    <p>{{ $visit->patient->address }}</p>
                                </div>
                            </div>
                        </div>
                        @if($visit->patient->allergy_history)
                        <div class="row">
                            <div class="col-md-12">
                                <div class="info-item">
                                    <label>Riwayat Alergi</label>
                                    <p class="text-warning">{{ $visit->patient->allergy_history }}</p>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Rekam Medis -->
        @if($visit->medicalRecord)
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="info-section">
                    <h5 class="info-title">Rekam Medis</h5>
                    <div class="info-content">
                        <!-- Tanda-Tanda Vital -->
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <h6 class="text-primary">Tanda-Tanda Vital</h6>
                                <div class="row">
                                    @if($visit->medicalRecord->temperature)
                                    <div class="col-md-2">
                                        <div class="info-item">
                                            <label>Suhu</label>
                                            <p>{{ $visit->medicalRecord->temperature }} °C</p>
                                        </div>
                                    </div>
                                    @endif
                                    @if($visit->medicalRecord->blood_pressure_systolic && $visit->medicalRecord->blood_pressure_diastolic)
                                    <div class="col-md-2">
                                        <div class="info-item">
                                            <label>Tekanan Darah</label>
                                            <p>{{ $visit->medicalRecord->blood_pressure_systolic }}/{{ $visit->medicalRecord->blood_pressure_diastolic }} mmHg</p>
                                        </div>
                                    </div>
                                    @endif
                                    @if($visit->medicalRecord->heart_rate)
                                    <div class="col-md-2">
                                        <div class="info-item">
                                            <label>Denyut Nadi</label>
                                            <p>{{ $visit->medicalRecord->heart_rate }} bpm</p>
                                        </div>
                                    </div>
                                    @endif
                                    @if($visit->medicalRecord->respiratory_rate)
                                    <div class="col-md-2">
                                        <div class="info-item">
                                            <label>Frekuensi Nafas</label>
                                            <p>{{ $visit->medicalRecord->respiratory_rate }} rpm</p>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Keluhan dan Gejala -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="info-item">
                                    <label>Keluhan Utama</label>
                                    <p>{{ $visit->medicalRecord->main_complaint }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <label>Gejala Penyerta</label>
                                    <p>{{ $visit->medicalRecord->symptoms }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Pemeriksaan Fisik -->
                        @if($visit->medicalRecord->physical_examination)
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="info-item">
                                    <label>Pemeriksaan Fisik</label>
                                    <p>{{ $visit->medicalRecord->physical_examination }}</p>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Diagnosis dan Pengobatan -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="info-item">
                                    <label>Diagnosis</label>
                                    <p class="diagnosis-text">{{ $visit->medicalRecord->diagnosis }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <label>Tatalaksana/Pengobatan</label>
                                    <p>{{ $visit->medicalRecord->treatment }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Catatan Tambahan -->
                        @if($visit->medicalRecord->notes)
                        <div class="row">
                            <div class="col-md-12">
                                <div class="info-item">
                                    <label>Catatan Tambahan</label>
                                    <p>{{ $visit->medicalRecord->notes }}</p>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>Belum ada rekam medis</strong> untuk kunjungan ini.
                    @if($visit->status != 'completed')
                    <a href="{{ route('visits.medical-record.create', $visit->id) }}" class="alert-link">Input rekam medis sekarang</a>
                    @endif
                </div>
            </div>
        </div>
        @endif

        <!-- Informasi Sistem -->
        <div class="row">
            <div class="col-md-12">
                <div class="info-section">
                    <h5 class="info-title">Informasi Sistem</h5>
                    <div class="info-content">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="info-item">
                                    <label>Dibuat Oleh</label>
                                    <p>{{ $visit->user->name ?? 'System' }}</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-item">
                                    <label>Dibuat Pada</label>
                                    <p>{{ $visit->created_at->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-item">
                                    <label>Diupdate Pada</label>
                                    <p>{{ $visit->updated_at->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tombol Aksi -->
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="d-flex justify-content-between">
                    <div>
                        <a href="{{ route('visits.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                        </a>
                    </div>
                    <div>
                        <a href="{{ route('visits.edit', $visit->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit Kunjungan
                        </a>
                        @if(!$visit->medicalRecord && $visit->status != 'completed')
                            <a href="{{ route('visits.medical-record.create', $visit->id) }}" class="btn btn-success">
                                <i class="fas fa-file-medical"></i> Input Rekam Medis
                            </a>
                        @endif
                        <form action="{{ route('visits.destroy', $visit->id) }}" method="POST" class="d-inline" 
                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus kunjungan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash"></i> Hapus Kunjungan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.info-section {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 20px;
    margin-bottom: 20px;
    border-left: 4px solid #007bff;
}

.info-title {
    color: #007bff;
    font-weight: 600;
    margin-bottom: 15px;
    padding-bottom: 10px;
    border-bottom: 1px solid #dee2e6;
}

.info-content {
    padding: 0 10px;
}

.info-item {
    margin-bottom: 15px;
}

.info-item label {
    font-weight: 600;
    color: #495057;
    margin-bottom: 5px;
    display: block;
    font-size: 0.9rem;
}

.info-item p {
    margin: 0;
    color: #6c757d;
    background: white;
    padding: 8px 12px;
    border-radius: 4px;
    border: 1px solid #e9ecef;
    min-height: 38px;
    display: flex;
    align-items: center;
}

.complaint-text, .diagnosis-text {
    background: #fff3cd !important;
    border-color: #ffeaa7 !important;
    color: #856404 !important;
}

.badge {
    font-size: 0.8em;
    padding: 6px 10px;
    border-radius: 4px;
}

.alert-link {
    font-weight: 600;
    text-decoration: underline;
}

.btn {
    border-radius: 4px;
    margin-left: 5px;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add confirmation for delete action
    const deleteForms = document.querySelectorAll('form[action*="destroy"]');
    deleteForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!confirm('Apakah Anda yakin ingin menghapus kunjungan ini? Tindakan ini tidak dapat dibatalkan.')) {
                e.preventDefault();
            }
        });
    });

    // Auto-calculate patient age
    const birthDate = '{{ $visit->patient->birth_date }}';
    if (birthDate) {
        const age = calculateAge(new Date(birthDate));
        const ageElement = document.querySelector('[class*="Usia"]');
        if (ageElement) {
            ageElement.querySelector('p').textContent = age + ' tahun';
        }
    }

    function calculateAge(birthDate) {
        const today = new Date();
        let age = today.getFullYear() - birthDate.getFullYear();
        const monthDiff = today.getMonth() - birthDate.getMonth();
        
        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }
        
        return age;
    }
});
</script>
@endsection