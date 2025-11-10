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

<!-- Statistik Utama -->
<div class="row row-sm mb-3">
    <div class="col-sm-6 col-lg-3">
        <div class="card card-dashboard-two">
            <div class="card-header bg-primary text-white">
                <h6><i class="fas fa-user-injured"></i> Total Pasien</h6>
            </div>
            <div class="card-body">
                <h2>{{ $totalPatients }}</h2>
                <span>Pasien terdaftar</span>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card card-dashboard-two">
            <div class="card-header bg-success text-white">
                <h6><i class="fas fa-stethoscope"></i> Total Kunjungan</h6>
            </div>
            <div class="card-body">
                <h2>{{ $totalVisits }}</h2>
                <span>Semua kunjungan</span>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card card-dashboard-two">
            <div class="card-header bg-info text-white">
                <h6><i class="fas fa-calendar-day"></i> Kunjungan Hari Ini</h6>
            </div>
            <div class="card-body">
                <h2>{{ $visitsToday }}</h2>
                <span>Kunjungan tanggal {{ \Carbon\Carbon::today()->format('d/m/Y') }}</span>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card card-dashboard-two">
            <div class="card-header bg-warning text-white">
                <h6><i class="fas fa-calendar-week"></i> Kunjungan Minggu Ini</h6>
            </div>
            <div class="card-body">
                <h2>{{ $visitsThisWeek }}</h2>
                <span>Kunjungan 7 hari terakhir</span>
            </div>
        </div>
    </div>
</div>

<div class="row row-sm">
    <!-- Chart Statistik & Antrian -->
    <div class="col-lg-8">
        <div class="row">
            <!-- Chart Kunjungan -->
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Statistik Kunjungan Tahun {{ date('Y') }}</h6>
                            <p class="mb-0">Grafik kunjungan pasien per bulan</p>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="visitChart" height="250"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kunjungan Terbaru -->
        <div class="row mt-3">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Kunjungan Terbaru</h6>
                            <p class="mb-0">5 kunjungan terbaru</p>
                        </div>
                        <a href="{{ route('visits.index') }}" class="btn btn-primary btn-sm">Lihat Semua</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped mg-b-0">
                                <thead>
                                    <tr>
                                        <th>No. Antrian</th>
                                        <th>Nama Pasien</th>
                                        <th>Poli</th>
                                        <th>Status</th>
                                        <th>Waktu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($latestVisits as $visit)
                                    <tr>
                                        <td>
                                            <span class="badge badge-primary">{{ $visit->queue_number }}</span>
                                        </td>
                                        <td>{{ $visit->patient->name }}</td>
                                        <td>{{ $visit->polyclinic }}</td>
                                        <td>{!! $visit->status_badge !!}</td>
                                        <td>{{ $visit->visit_date->format('H:i') }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Belum ada data kunjungan</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar Kanan -->
    <div class="col-lg-4">
        <!-- Statistik Hari Ini -->
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">Statistik Hari Ini</h6>
            </div>
            <div class="card-body">
                <div class="stats-today">
                    <div class="stat-item d-flex justify-content-between align-items-center mb-3">
                        <span>Menunggu</span>
                        <span class="badge badge-warning">{{ $todayStatus['waiting'] ?? 0 }}</span>
                    </div>
                    <div class="stat-item d-flex justify-content-between align-items-center mb-3">
                        <span>Dalam Proses</span>
                        <span class="badge badge-info">{{ $todayStatus['in_progress'] ?? 0 }}</span>
                    </div>
                    <div class="stat-item d-flex justify-content-between align-items-center mb-3">
                        <span>Selesai</span>
                        <span class="badge badge-success">{{ $todayStatus['completed'] ?? 0 }}</span>
                    </div>
                    <div class="stat-item d-flex justify-content-between align-items-center">
                        <span>Dibatalkan</span>
                        <span class="badge badge-danger">{{ $todayStatus['cancelled'] ?? 0 }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Antrian Hari Ini -->
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="card-title mb-0">Antrian Hari Ini</h6>
            </div>
            <div class="card-body">
                @if($todayQueue->count() > 0)
                    <div class="queue-list">
                        @foreach($todayQueue as $queue)
                        <div class="queue-item d-flex justify-content-between align-items-center mb-2 p-2 border rounded">
                            <div>
                                <strong>#{{ $queue->queue_number }}</strong>
                                <small class="d-block text-muted">{{ $queue->patient->name }}</small>
                                <small class="text-info">{{ $queue->polyclinic }}</small>
                            </div>
                            <span class="badge badge-warning">Menunggu</span>
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted text-center">Tidak ada antrian hari ini</p>
                @endif
            </div>
        </div>

        <!-- Poli Terpopuler -->
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="card-title mb-0">Poli Terpopuler Hari Ini</h6>
            </div>
            <div class="card-body">
                @if($polyclinicStats->count() > 0)
                    @foreach($polyclinicStats as $poly)
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span>{{ $poly->polyclinic }}</span>
                        <span class="badge badge-primary">{{ $poly->count }}</span>
                    </div>
                    @endforeach
                @else
                    <p class="text-muted text-center">Belum ada kunjungan hari ini</p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mt-4 mb-5">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">Aksi Cepat</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6 col-lg-3 mb-3">
                        <a href="{{ route('add-pasien') }}" class="btn btn-primary btn-block p-3 action-btn">
                            <i class="fas fa-user-plus fa-2x mb-2"></i><br>
                            Tambah Pasien
                        </a>
                    </div>
                    <div class="col-sm-6 col-lg-3 mb-3">
                        <a href="{{ route('visits.create') }}" class="btn btn-success btn-block p-3 action-btn">
                            <i class="fas fa-plus-circle fa-2x mb-2"></i><br>
                            Tambah Kunjungan
                        </a>
                    </div>
                    <div class="col-sm-6 col-lg-3 mb-3">
                        <a href="{{ route('Pasien') }}" class="btn btn-info btn-block p-3 action-btn">
                            <i class="fas fa-list fa-2x mb-2"></i><br>
                            Data Pasien
                        </a>
                    </div>
                    <div class="col-sm-6 col-lg-3 mb-3">
                        <a href="{{ route('visits.index') }}" class="btn btn-warning btn-block p-3 action-btn">
                            <i class="fas fa-stethoscope fa-2x mb-2"></i><br>
                            Data Kunjungan
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
    // Chart Statistik Kunjungan
    const visitCtx = document.getElementById('visitChart').getContext('2d');
    const visitChart = new Chart(visitCtx, {
        type: 'bar',
        data: {
            labels: @json($monthlyStats['months']),
            datasets: [{
                label: 'Jumlah Kunjungan',
                data: @json($monthlyStats['counts']),
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
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

    // Update real-time data setiap 30 detik
    function updateDashboard() {
        fetch('/api/dashboard-stats')
            .then(response => response.json())
            .then(data => {
                // Update counters
                document.querySelector('[class*="Kunjungan Hari Ini"]').parentElement.querySelector('h2').textContent = data.visitsToday;
                document.querySelector('[class*="Menunggu"]').nextElementSibling.textContent = data.todayStatus.waiting || 0;
                document.querySelector('[class*="Dalam Proses"]').nextElementSibling.textContent = data.todayStatus.in_progress || 0;
                document.querySelector('[class*="Selesai"]').nextElementSibling.textContent = data.todayStatus.completed || 0;
            })
            .catch(error => console.error('Error updating dashboard:', error));
    }

    // Update setiap 30 detik
    setInterval(updateDashboard, 30000);
});
</script>

<style>
.card-dashboard-two {
    border: none;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    transition: transform 0.2s;
    border-left: 4px solid transparent;
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
}

.card-dashboard-two .card-body span {
    font-size: 12px;
    color: #6c757d;
}

.action-btn {
    height: 100px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    border-radius: 10px;
    transition: all 0.3s;
    text-decoration: none;
    color: white;
}

.action-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    color: white;
    text-decoration: none;
}

.queue-item {
    transition: background-color 0.2s;
}

.queue-item:hover {
    background-color: #f8f9fa;
}

.stats-today .stat-item {
    padding: 8px 0;
    border-bottom: 1px solid #f1f1f1;
}

.stats-today .stat-item:last-child {
    border-bottom: none;
}

.badge {
    font-size: 0.75em;
    padding: 5px 8px;
}

/* Warna card header */
.bg-primary { background-color: #007bff !important; }
.bg-success { background-color: #28a745 !important; }
.bg-info { background-color: #17a2b8 !important; }
.bg-warning { background-color: #ffc107 !important; color: #212529 !important; }

/* Status badges */
.badge-warning { background-color: #ffc107; color: #212529; }
.badge-info { background-color: #17a2b8; }
.badge-success { background-color: #28a745; }
.badge-danger { background-color: #dc3545; }
.badge-primary { background-color: #007bff; }
</style>
@endsection