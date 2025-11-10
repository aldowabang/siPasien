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
                <h2 class="card-title mb-0">Detail Rekam Medis</h2>
                <p class="mb-0">Informasi lengkap rekam medis pasien</p>
            </div>
            <div>
                <a href="{{ route('medical-records.by-patient', $medicalRecord->visit->patient->id) }}" 
                class="btn btn-secondary buttom-radius">
                    <i class="fas fa-arrow-left"></i> Kembali ke Riwayat
                </a>
                <a href="{{ route('medical-records.edit', $medicalRecord->id) }}" 
                class="btn btn-warning buttom-radius">
                    <i class="fas fa-edit"></i> Edit
                </a>
            </div>
        </div>
        <div class="card-body">
            <!-- Informasi Pasien -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="patient-info-card">
                        <h5 class="text-primary mb-3">Informasi Pasien</h5>
                        <div class="row">
                            <div class="col-md-3">
                                <strong>Nama Pasien:</strong><br>
                                {{ $medicalRecord->visit->patient->name }}
                            </div>
                            <div class="col-md-3">
                                <strong>No. Rekam Medis:</strong><br>
                                <span class="badge badge-primary">{{ $medicalRecord->visit->patient->medical_record_number }}</span>
                            </div>
                            <div class="col-md-3">
                                <strong>Usia:</strong><br>
                                {{ \Carbon\Carbon::parse($medicalRecord->visit->patient->birth_date)->age }} tahun
                            </div>
                            <div class="col-md-3">
                                <strong>Jenis Kelamin:</strong><br>
                                {{ $medicalRecord->visit->patient->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informasi Kunjungan -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="visit-info-card">
                        <h5 class="text-primary mb-3">Informasi Kunjungan</h5>
                        <div class="row">
                            <div class="col-md-3">
                                <strong>Tanggal Kunjungan:</strong><br>
                                {{ $medicalRecord->visit->visit_date->format('d/m/Y H:i') }}
                            </div>
                            <div class="col-md-3">
                                <strong>Poli:</strong><br>
                                {{ $medicalRecord->visit->polyclinic }}
                            </div>
                            <div class="col-md-3">
                                <strong>No. Antrian:</strong><br>
                                {{ $medicalRecord->visit->queue_number }}
                            </div>
                            <div class="col-md-3">
                                <strong>Status:</strong><br>
                                {!! $medicalRecord->visit->status_badge !!}
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <strong>Keluhan Awal:</strong><br>
                                {{ $medicalRecord->visit->complaint }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tanda-Tanda Vital -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="vital-signs-card">
                        <h5 class="text-primary mb-3">Tanda-Tanda Vital</h5>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="vital-item">
                                    <label>Suhu Tubuh</label>
                                    <div class="vital-value">
                                        {{ $medicalRecord->temperature ? $medicalRecord->temperature . ' °C' : '-' }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="vital-item">
                                    <label>Tekanan Darah</label>
                                    <div class="vital-value">
                                        @if($medicalRecord->blood_pressure_systolic && $medicalRecord->blood_pressure_diastolic)
                                            {{ $medicalRecord->blood_pressure_systolic }}/{{ $medicalRecord->blood_pressure_diastolic }} mmHg
                                        @else
                                            -
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="vital-item">
                                    <label>Denyut Nadi</label>
                                    <div class="vital-value">
                                        {{ $medicalRecord->heart_rate ? $medicalRecord->heart_rate . ' bpm' : '-' }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="vital-item">
                                    <label>Frekuensi Nafas</label>
                                    <div class="vital-value">
                                        {{ $medicalRecord->respiratory_rate ? $medicalRecord->respiratory_rate . ' rpm' : '-' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informasi Medis -->
            <div class="row">
                <div class="col-md-6">
                    <div class="medical-info-card">
                        <h5 class="text-primary mb-3">Informasi Medis</h5>
                        <div class="info-section">
                            <div class="info-item">
                                <label>Keluhan Utama</label>
                                <div class="info-content">
                                    {{ $medicalRecord->main_complaint }}
                                </div>
                            </div>
                            <div class="info-item">
                                <label>Gejala Penyerta</label>
                                <div class="info-content">
                                    {{ $medicalRecord->symptoms }}
                                </div>
                            </div>
                            <div class="info-item">
                                <label>Pemeriksaan Fisik</label>
                                <div class="info-content">
                                    {{ $medicalRecord->physical_examination ?: 'Tidak ada' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="medical-info-card">
                        <h5 class="text-primary mb-3">Diagnosis & Pengobatan</h5>
                        <div class="info-section">
                            <div class="info-item">
                                <label>Diagnosis</label>
                                <div class="info-content diagnosis">
                                    {{ $medicalRecord->diagnosis }}
                                </div>
                            </div>
                            <div class="info-item">
                                <label>Tatalaksana/Pengobatan</label>
                                <div class="info-content">
                                    {{ $medicalRecord->treatment }}
                                </div>
                            </div>
                            <div class="info-item">
                                <label>Catatan Tambahan</label>
                                <div class="info-content">
                                    {{ $medicalRecord->notes ?: 'Tidak ada' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informasi Sistem -->
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="system-info-card">
                        <h5 class="text-primary mb-3">Informasi Sistem</h5>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="info-item">
                                    <label>Dibuat Oleh</label>
                                    <div class="info-content">
                                        {{ $medicalRecord->visit->user->name ?? 'System' }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-item">
                                    <label>Dibuat Pada</label>
                                    <div class="info-content">
                                        {{ $medicalRecord->created_at->format('d/m/Y H:i') }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-item">
                                    <label>Diupdate Pada</label>
                                    <div class="info-content">
                                        {{ $medicalRecord->updated_at->format('d/m/Y H:i') }}
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
                            <a href="{{ route('medical-records.by-patient', $medicalRecord->visit->patient->id) }}" 
                            class="btn btn-secondary buttom-radius">
                                <i class="fas fa-arrow-left"></i> Kembali ke Riwayat
                            </a>
                        </div>
                        <div>
                            <a href="{{ route('visits.show', $medicalRecord->visit->id) }}" 
                            class="btn btn-primary buttom-radius">
                                <i class="fas fa-stethoscope"></i> Lihat Kunjungan
                            </a>
                            <a href="{{ route('medical-records.edit', $medicalRecord->id) }}" 
                            class="btn btn-warning buttom-radius">
                                <i class="fas fa-edit"></i> Edit Rekam Medis
                            </a>
                            <form action="{{ route('medical-records.destroy', $medicalRecord->id) }}" 
                                method="POST" class="d-inline"
                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus rekam medis ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger buttom-radius">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
    .patient-info-card,
    .visit-info-card,
    .vital-signs-card,
    .medical-info-card,
    .system-info-card {
        background: #f8f9fa;
        border-left: 4px solid #007bff;
        padding: 20px;
        border-radius: 8px;
        border: 1px solid #e9ecef;
        margin-bottom: 20px;
    }

    .vital-signs-card {
        border-left-color: #28a745;
    }

    .medical-info-card {
        border-left-color: #6f42c1;
    }

    .system-info-card {
        border-left-color: #6c757d;
    }

    .vital-item {
        text-align: center;
        padding: 15px;
        background: white;
        border-radius: 8px;
        border: 1px solid #e9ecef;
    }

    .vital-item label {
        font-weight: 600;
        color: #495057;
        font-size: 0.9rem;
        display: block;
        margin-bottom: 8px;
    }

    .vital-value {
        font-size: 1.2rem;
        font-weight: 700;
        color: #007bff;
    }

    .info-item {
        margin-bottom: 20px;
    }

    .info-item label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 5px;
        display: block;
        font-size: 0.9rem;
    }

    .info-content {
        background: white;
        padding: 12px 15px;
        border-radius: 6px;
        border: 1px solid #e9ecef;
        min-height: 50px;
        display: flex;
        align-items: center;
    }

    .info-content.diagnosis {
        background: #fff3cd;
        border-color: #ffeaa7;
        color: #856404;
    }

    .badge {
        font-size: 0.8rem;
        padding: 6px 10px;
    }

    .buttom-radius {
        border-radius: 6px;
    }

    .btn {
        margin-left: 5px;
    }
    </style>
    @endsection