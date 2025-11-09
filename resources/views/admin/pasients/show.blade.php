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
            <h2 class="card-title mb-0">Detail Data Pasien</h2>
            <p class="mb-0">Informasi lengkap data pasien</p>
        </div>
        <div>
            <a href="{{ route('patients.edit', $patient->id) }}" class="btn btn-sm btn-warning buttom-radius">
                <i class="fas fa-edit"></i> Edit
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="info-section">
                    <h5 class="info-title">Informasi Pribadi</h5>
                    <div class="info-content">
                        <div class="info-item">
                            <label>Nama Lengkap</label>
                            <p>{{ $patient->name }}</p>
                        </div>
                        <div class="info-item">
                            <label>NIK</label>
                            <p>{{ $patient->nik ?? '-' }}</p>
                        </div>
                        <div class="info-item">
                            <label>Nomor Rekam Medis</label>
                            <p class="text-primary font-weight-bold">{{ $patient->medical_record_number }}</p>
                        </div>
                        <div class="info-item">
                            <label>Tempat, Tanggal Lahir</label>
                            <p>{{ $patient->birth_place }}, {{ $patient->birth_date->format('d/m/Y') }}</p>
                        </div>
                        <div class="info-item">
                            <label>Jenis Kelamin</label>
                            <p>{{ $patient->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="info-section">
                    <h5 class="info-title">Kontak & Darurat</h5>
                    <div class="info-content">
                        <div class="info-item">
                            <label>Nomor Telepon</label>
                            <p>{{ $patient->phone }}</p>
                        </div>
                        <div class="info-item">
                            <label>Alamat Lengkap</label>
                            <p>{{ $patient->address }}</p>
                        </div>
                        <div class="info-item">
                            <label>Nama Kontak Darurat</label>
                            <p>{{ $patient->emergency_contact_name }}</p>
                        </div>
                        <div class="info-item">
                            <label>Telepon Kontak Darurat</label>
                            <p>{{ $patient->emergency_contact_phone }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-6">
                <div class="info-section">
                    <h5 class="info-title">Informasi Asuransi</h5>
                    <div class="info-content">
                        <div class="info-item">
                            <label>Jenis Asuransi</label>
                            <p>{{ $patient->insurance_type ?? '-' }}</p>
                        </div>
                        <div class="info-item">
                            <label>Nomor Asuransi</label>
                            <p>{{ $patient->insurance_number ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="info-section">
                    <h5 class="info-title">Informasi Medis</h5>
                    <div class="info-content">
                        <div class="info-item">
                            <label>Riwayat Alergi</label>
                            <p>{{ $patient->allergy_history ?: 'Tidak ada' }}</p>
                        </div>
                        <div class="info-item">
                            <label>Catatan Tambahan</label>
                            <p>{{ $patient->notes ?: 'Tidak ada' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-12">
                <div class="info-section">
                    <h5 class="info-title">Informasi Sistem</h5>
                    <div class="info-content">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="info-item">
                                    <label>Dibuat Pada</label>
                                    <p>{{ $patient->created_at->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-item">
                                    <label>Diupdate Pada</label>
                                    <p>{{ $patient->updated_at->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-item">
                                    <label>Status</label>
                                    <p>
                                        @if($patient->deleted_at)
                                            <span class="badge badge-danger">Terhapus</span>
                                        @else
                                            <span class="badge badge-success">Aktif</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
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

.info-item {
    margin-bottom: 15px;
}

.info-item label {
    font-weight: 600;
    color: #495057;
    margin-bottom: 5px;
    display: block;
}

.info-item p {
    margin: 0;
    color: #6c757d;
    background: white;
    padding: 8px 12px;
    border-radius: 4px;
    border: 1px solid #e9ecef;
}

.badge {
    font-size: 0.8em;
    padding: 5px 10px;
    border-radius: 4px;
}
</style>
@endsection