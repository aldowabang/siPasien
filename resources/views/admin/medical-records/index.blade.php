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
            <h2 class="card-title mb-0">Data Rekam Medis</h2>
            <p class="mb-0">Daftar pasien dengan rekam medis</p>
        </div>
    </div>
    <div class="card-body">
        <!-- Search Form -->
        <div class="row mb-4">
            <div class="col-md-8">
                <form method="GET" action="{{ route('medical-records.index') }}">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" 
                            placeholder="Cari berdasarkan nama pasien atau nomor rekam medis..." 
                            value="{{ $search }}">
                        <div class="input-group-append">
                            <button class="btn btn-outline-primary buttom-radius" type="submit">
                                <i class="fas fa-search"></i> Cari
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-4">
                <form method="POST" action="{{ route('medical-records.search-by-number') }}">
                    @csrf
                    <div class="input-group">
                        <input type="text" name="medical_record_number" class="form-control" 
                            placeholder="Nomor rekam medis..." required>
                        <div class="input-group-append">
                            <button class="btn btn-primary buttom-radius" type="submit">
                                <i class="fas fa-file-medical"></i> Cari RM
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-striped mg-b-0">
                <thead class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>No. RM</th>
                        <th>Nama Pasien</th>
                        <th>Jumlah Kunjungan</th>
                        <th>Kunjungan Terakhir</th>
                        <th>Diagnosis Terakhir</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($patients as $patient)
                    @php
                        $latestVisit = $patient->visits->first();
                        $latestMedicalRecord = $latestVisit ? $latestVisit->medicalRecord : null;
                    @endphp
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <span class="badge badge-primary badge-lg">
                                {{ $patient->medical_record_number }}
                            </span>
                        </td>
                        <td>
                            <strong>{{ $patient->name }}</strong>
                            <br>
                            <small class="text-muted">
                                {{ $patient->gender == 'L' ? 'Laki-laki' : 'Perempuan' }} | 
                                {{ \Carbon\Carbon::parse($patient->birth_date)->age }} tahun
                            </small>
                        </td>
                        <td>
                            <span class="badge badge-info">
                                {{ $patient->medical_records_count }} kunjungan
                            </span>
                        </td>
                        <td>
                            @if($latestVisit)
                                {{ $latestVisit->visit_date->format('d/m/Y') }}
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if($latestMedicalRecord)
                                {{ Str::limit($latestMedicalRecord->diagnosis, 50) }}
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            <div class="btn-group-vertical btn-group-sm">
                                <a href="{{ route('medical-records.by-patient', $patient->id) }}" 
                                class="btn btn-info buttom-radius mb-1" title="Lihat Riwayat">
                                    <i class="fas fa-history"></i> Riwayat
                                </a>
                                @if($latestMedicalRecord)
                                <a href="{{ route('medical-records.show', $latestMedicalRecord->id) }}" 
                                class="btn btn-primary buttom-radius mb-1" title="Detail Terbaru">
                                    <i class="fas fa-eye"></i> Detail Terbaru
                                </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">
                            @if($search || $medicalRecordNumber)
                                Tidak ditemukan pasien dengan rekam medis sesuai kata kunci tersebut.
                            @else
                                Belum ada data rekam medis.
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $patients->links() }}
        </div>
    </div>
</div>

<style>
.badge-lg {
    font-size: 0.9rem;
    padding: 6px 10px;
}

.btn-group-vertical .btn {
    margin-bottom: 2px;
    text-align: left;
}

.table td {
    vertical-align: middle;
}
</style>
@endsection