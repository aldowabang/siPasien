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

<!-- Statistik Cards -->
<div class="row row-sm mb-3">
    <div class="col-sm-6 col-lg-3">
        <div class="card card-dashboard-two">
            <div class="card-header">
                <h6>Total Pasien</h6>
            </div>
            <div class="card-body">
                <h2>{{ $totalPatients }}</h2>
                <span>Total semua pasien terdaftar</span>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card card-dashboard-two">
            <div class="card-header">
                <h6>Pasien Bulan Ini</h6>
            </div>
            <div class="card-body">
                <h2>{{ $patientsThisMonth }}</h2>
                <span>Pasien baru bulan ini</span>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card card-dashboard-two">
            <div class="card-header">
                <h6>Pasien Minggu Ini</h6>
            </div>
            <div class="card-body">
                <h2>{{ $patientsThisWeek }}</h2>
                <span>Pasien baru minggu ini</span>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card card-dashboard-two">
            <div class="card-header">
                <h6>Pasien Hari Ini</h6>
            </div>
            <div class="card-body">
                <h2>{{ $patientsToday }}</h2>
                <span>Pasien baru hari ini</span>
            </div>
        </div>
    </div>
</div>

<div class="row row-sm">
    <!-- Chart Statistik -->
    <div class="col-lg-8 mb-3">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="card-title mb-0">Statistik Pasien Tahun {{ date('Y') }}</h6>
                    <p class="mb-0">Grafik pertumbuhan pasien per bulan</p>
                </div>
            </div>
            <div class="card-body">
                <canvas id="patientChart" height="250"></canvas>
            </div>
        </div>
    </div>

    <!-- Statistik Gender -->
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">Distribusi Jenis Kelamin</h6>
            </div>
            <div class="card-body">
                <canvas id="genderChart" height="250"></canvas>
                <div class="mt-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <span>Laki-laki</span>
                        <span class="font-weight-bold">{{ $genderStats['L'] ?? 0 }}</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mt-2">
                        <span>Perempuan</span>
                        <span class="font-weight-bold">{{ $genderStats['P'] ?? 0 }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Pasien Terbaru -->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="card-title mb-0">Pasien Terbaru</h6>
                    <p class="mb-0">5 pasien terbaru yang terdaftar</p>
                </div>
                <a href="{{ route('Pasien') }}" class="btn btn-primary btn-sm buttom-radius">Lihat Semua</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped mg-b-0">
                        <thead>
                            <tr>
                                <th>No. Rekam Medis</th>
                                <th>Nama Pasien</th>
                                <th>NIK</th>
                                <th>Jenis Kelamin</th>
                                <th>Tanggal Daftar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($latestPatients as $patient)
                            <tr>
                                <td>{{ $patient->medical_record_number }}</td>
                                <td>{{ $patient->name }}</td>
                                <td>{{ $patient->nik ?? '-' }}</td>
                                <td>{{ $patient->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                <td>{{ $patient->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <a href="{{ route('patients.show', $patient->id) }}" class="btn btn-info btn-sm buttom-radius">Detail</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">Belum ada data pasien</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mt-4">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">Aksi Cepat</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6 col-lg-3">
                        <a href="{{ route('add-pasien') }}" class="btn btn-primary btn-block p-3">
                            <i class="fas fa-user-plus fa-2x mb-2"></i><br>
                            Tambah Pasien
                        </a>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <a href="{{ route('Pasien') }}" class="btn btn-success btn-block p-3">
                            <i class="fas fa-list fa-2x mb-2"></i><br>
                            Data Pasien
                        </a>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <a href="{{ route('patients.trashed') }}" class="btn btn-warning btn-block p-3">
                            <i class="fas fa-trash-restore fa-2x mb-2"></i><br>
                            Data Terhapus
                        </a>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <a href="#" class="btn btn-info btn-block p-3">
                            <i class="fas fa-chart-line fa-2x mb-2"></i><br>
                            Laporan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript untuk Charts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Chart Statistik Pasien
    const patientCtx = document.getElementById('patientChart').getContext('2d');
    const patientChart = new Chart(patientCtx, {
        type: 'line',
        data: {
            labels: @json($monthlyStats['months']),
            datasets: [{
                label: 'Jumlah Pasien',
                data: @json($monthlyStats['counts']),
                borderColor: '#007bff',
                backgroundColor: 'rgba(0, 123, 255, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    // Chart Distribusi Gender
    const genderCtx = document.getElementById('genderChart').getContext('2d');
    const genderChart = new Chart(genderCtx, {
        type: 'doughnut',
        data: {
            labels: ['Laki-laki', 'Perempuan'],
            datasets: [{
                data: [
                    {{ $genderStats['L'] ?? 0 }},
                    {{ $genderStats['P'] ?? 0 }}
                ],
                backgroundColor: [
                    '#007bff',
                    '#e83e8c'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
});
</script>

<style>
.card-dashboard-two {
    border: none;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    transition: transform 0.2s;
}

.card-dashboard-two:hover {
    transform: translateY(-5px);
}

.card-dashboard-two .card-header {
    background: transparent;
    border-bottom: 1px solid #e3e3e3;
    padding: 15px 20px;
}

.card-dashboard-two .card-header h6 {
    margin: 0;
    color: #6c757d;
    font-size: 14px;
    font-weight: 600;
}

.card-dashboard-two .card-body {
    padding: 20px;
}

.card-dashboard-two .card-body h2 {
    font-size: 2rem;
    font-weight: 700;
    margin: 0;
    color: #007bff;
}

.card-dashboard-two .card-body span {
    font-size: 12px;
    color: #6c757d;
}

.btn-block {
    height: 100px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    border-radius: 10px;
    transition: all 0.3s;
}

.btn-block:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}
</style>
@endsection