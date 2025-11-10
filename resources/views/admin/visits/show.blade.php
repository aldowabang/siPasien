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
            @if($visit->medicalRecord)
                <a href="{{ route('medical-records.show', $visit->medicalRecord->id) }}" 
                   class="btn btn-info buttom-radius">
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
                <div class="visit-info-card">
                    <h5 class="text-primary mb-3">Informasi Kunjungan</h5>
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

        <!-- Informasi Pasien -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="patient-info-card">
                    <h5 class="text-primary mb-3">Informasi Pasien</h5>
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

        <!-- Status Rekam Medis -->
        <div class="row mb-4">
            <div class="col-md-12">
                @if($visit->medicalRecord)
                    <div class="alert alert-success">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-check-circle"></i>
                                <strong>Rekam Medis Tersedia</strong>
                                <p class="mb-0">Kunjungan ini sudah memiliki rekam medis</p>
                            </div>
                            <div>
                                <a href="{{ route('medical-records.show', $visit->medicalRecord->id) }}" 
                                   class="btn btn-success buttom-radius">
                                    <i class="fas fa-eye"></i> Lihat Rekam Medis
                                </a>
                                <a href="{{ route('medical-records.edit', $visit->medicalRecord->id) }}" 
                                   class="btn btn-warning buttom-radius">
                                    <i class="fas fa-edit"></i> Edit Rekam Medis
                                </a>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="alert alert-warning">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-exclamation-triangle"></i>
                                <strong>Belum Ada Rekam Medis</strong>
                                <p class="mb-0">Kunjungan ini belum memiliki rekam medis</p>
                            </div>
                            <div>
                                @if($visit->status != 'completed')
                                    <a href="{{ route('visits.medical-record.create', $visit->id) }}" 
                                       class="btn btn-primary buttom-radius">
                                        <i class="fas fa-file-medical"></i> Input Rekam Medis
                                    </a>
                                @else
                                    <span class="text-muted">Status completed - tidak dapat input rekam medis</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Informasi Sistem -->
        <div class="row">
            <div class="col-md-12">
                <div class="system-info-card">
                    <h5 class="text-primary mb-3">Informasi Sistem</h5>
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

        <!-- Tombol Aksi -->
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="d-flex justify-content-between">
                    <div>
                        <a href="{{ route('visits.index') }}" class="btn btn-secondary buttom-radius">
                            <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                        </a>
                    </div>
                    <div>
                        <a href="{{ route('visits.edit', $visit->id) }}" class="btn btn-warning buttom-radius">
                            <i class="fas fa-edit"></i> Edit Kunjungan
                        </a>
                        @if(!$visit->medicalRecord && $visit->status != 'completed')
                            <a href="{{ route('visits.medical-record.create', $visit->id) }}" class="btn btn-success buttom-radius">
                                <i class="fas fa-file-medical"></i> Input Rekam Medis
                            </a>
                        @endif
                        <form action="{{ route('visits.destroy', $visit->id) }}" method="POST" class="d-inline" 
                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus kunjungan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger buttom-radius">
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
.visit-info-card,
.patient-info-card,
.system-info-card {
    background: #f8f9fa;
    border-left: 4px solid #007bff;
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 20px;
}

.patient-info-card {
    border-left-color: #28a745;
}

.system-info-card {
    border-left-color: #6c757d;
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

.complaint-text {
    background: #fff3cd !important;
    border-color: #ffeaa7 !important;
    color: #856404 !important;
}

.badge {
    font-size: 0.8em;
    padding: 6px 10px;
    border-radius: 4px;
}

.buttom-radius {
    border-radius: 6px;
}

.btn {
    margin-left: 5px;
}

.alert {
    border-radius: 8px;
}
</style>
@endsection