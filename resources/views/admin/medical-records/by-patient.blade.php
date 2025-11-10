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
                <h2 class="card-title mb-0">Rekam Medis Pasien</h2>
                <p class="mb-0">Riwayat rekam medis untuk {{ $patient->name }}</p>
            </div>
            <div>
                <span class="badge badge-primary badge-lg mr-2">
                    No. RM: {{ $patient->medical_record_number }}
                </span>
                <a href="{{ route('medical-records.index') }}" class="btn btn-secondary buttom-radius">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
        <div class="card-body">
            <!-- Informasi Pasien -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="patient-info-card">
                        <div class="row">
                            <div class="col-md-3">
                                <strong>Nama:</strong><br>
                                {{ $patient->name }}
                            </div>
                            <div class="col-md-2">
                                <strong>Usia:</strong><br>
                                {{ \Carbon\Carbon::parse($patient->birth_date)->age }} tahun
                            </div>
                            <div class="col-md-2">
                                <strong>Jenis Kelamin:</strong><br>
                                {{ $patient->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}
                            </div>
                            <div class="col-md-3">
                                <strong>Alamat:</strong><br>
                                {{ Str::limit($patient->address, 40) }}
                            </div>
                            <div class="col-md-2">
                                <strong>Telepon:</strong><br>
                                {{ $patient->phone }}
                            </div>
                        </div>
                        @if($patient->allergy_history)
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <strong>Riwayat Alergi:</strong><br>
                                <span class="text-warning">{{ $patient->allergy_history }}</span>
                            </div>
                        </div>
                        @endif
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <strong>Total Kunjungan:</strong><br>
                                <span class="badge badge-info">{{ $patient->visits->count() }} kali</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if($patient->visits->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>No</th>
                                <th>Tanggal Kunjungan</th>
                                <th>Poli</th>
                                <th>Keluhan Utama</th>
                                <th>Diagnosis</th>
                                <th>Pengobatan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($patient->visits as $visit)
                                @if($visit->medicalRecord)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $visit->visit_date->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <span class="badge badge-primary">{{ $visit->polyclinic }}</span>
                                    </td>
                                    <td>{{ Str::limit($visit->medicalRecord->main_complaint, 40) }}</td>
                                    <td>{{ Str::limit($visit->medicalRecord->diagnosis, 40) }}</td>
                                    <td>{{ Str::limit($visit->medicalRecord->treatment, 40) }}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('medical-records.show', $visit->medicalRecord->id) }}" 
                                            class="btn btn-info buttom-radius mr-1" title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('medical-records.edit', $visit->medicalRecord->id) }}" 
                                            class="btn btn-warning buttom-radius mr-1" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="{{ route('visits.show', $visit->id) }}" 
                                            class="btn btn-primary buttom-radius" title="Lihat Kunjungan">
                                                <i class="fas fa-stethoscope"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle fa-2x mb-3"></i>
                    <h5>Belum Ada Rekam Medis</h5>
                    <p class="mb-0">Pasien ini belum memiliki riwayat rekam medis.</p>
                </div>
            @endif

            <!-- Tombol Tambahan -->
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="d-flex justify-content-between">
                        <div>
                            <a href="{{ route('medical-records.index') }}" class="btn btn-secondary buttom-radius">
                                <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                            </a>
                        </div>
                        <div>
                            <a href="{{ route('patients.show', $patient->id) }}" class="btn btn-info buttom-radius">
                                <i class="fas fa-user"></i> Profil Pasien
                            </a>
                            <a href="{{ route('visits.create') }}?patient_id={{ $patient->id }}" class="btn btn-success buttom-radius">
                                <i class="fas fa-plus-circle"></i> Tambah Kunjungan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
    .patient-info-card {
        background: #f8f9fa;
        border-left: 4px solid #007bff;
        padding: 15px;
        border-radius: 4px;
        border: 1px solid #e9ecef;
    }

    .badge-lg {
        font-size: 1rem;
        padding: 8px 12px;
    }

    .btn-group-sm .btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.7rem;
    }

    .buttom-radius {
        border-radius: 4px;
    }

    .alert {
        border-radius: 8px;
        padding: 2rem;
    }

    .alert i {
        display: block;
        margin-bottom: 1rem;
    }

    .table th {
        background-color: #343a40;
        color: white;
        font-weight: 600;
    }

    .patient-info-card strong {
        color: #495057;
        font-size: 0.9rem;
    }

    .patient-info-card .row {
        margin-bottom: 10px;
    }

    .patient-info-card .row:last-child {
        margin-bottom: 0;
    }
    </style>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Tambahkan konfirmasi untuk tombol edit dan delete
        const editButtons = document.querySelectorAll('a[title="Edit"]');
        editButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                if (!confirm('Anda akan mengedit rekam medis. Lanjutkan?')) {
                    e.preventDefault();
                }
            });
        });

        // Auto-format tanggal jika diperlukan
        const dateCells = document.querySelectorAll('td:nth-child(2)');
        dateCells.forEach(cell => {
            const originalDate = cell.textContent.trim();
            if (originalDate && !originalDate.includes('/')) {
                // Format ulang tanggal jika diperlukan
                const date = new Date(originalDate);
                if (!isNaN(date.getTime())) {
                    cell.textContent = date.toLocaleDateString('id-ID', {
                        day: '2-digit',
                        month: '2-digit',
                        year: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit'
                    });
                }
            }
        });

        // Highlight baris saat hover
        const tableRows = document.querySelectorAll('tbody tr');
        tableRows.forEach(row => {
            row.addEventListener('mouseenter', function() {
                this.style.backgroundColor = '#f8f9fa';
            });
            row.addEventListener('mouseleave', function() {
                this.style.backgroundColor = '';
            });
        });
    });
    </script>
    @endsection