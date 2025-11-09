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
            <h2 class="card-title mb-0">Data Kunjungan</h2>
            <p class="mb-0">Daftar kunjungan pasien</p>
        </div>
        <div>
            <a href="{{ route('visits.create') }}" class="btn btn-primary buttom-radius">Tambah Kunjungan</a>
        </div>
    </div>
    <div class="card-body">
        <!-- Filter Form -->
        <form method="GET" action="{{ route('visits.index') }}" class="mb-4">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Poli</label>
                        <select name="polyclinic" class="form-control">
                            <option value="">Semua Poli</option>
                            @foreach($polyclinics as $key => $value)
                                <option value="{{ $key }}" {{ $filters['polyclinic'] == $key ? 'selected' : '' }}>{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="">Semua Status</option>
                            @foreach($statuses as $key => $value)
                                <option value="{{ $key }}" {{ $filters['status'] == $key ? 'selected' : '' }}>{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Tanggal</label>
                        <input type="date" name="date" class="form-control" value="{{ $filters['date'] }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <div>
                            <button type="submit" class="btn btn-primary buttom-radius">Filter</button>
                            <a href="{{ route('visits.index') }}" class="btn btn-secondary buttom-radius">Reset</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered mg-b-0 display" id="example">
                <thead class="thead-light">
                    <tr>
                        <th>NO.</th>
                        <th>No. Antrian</th>
                        <th>Nama Pasien</th>
                        <th>Poli</th>
                        <th>Keluhan</th>
                        <th>Tanggal Kunjungan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($visits as $visit)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $visit->queue_number }}</td>
                            <td>{{ $visit->patient->name }}</td>
                            <td>{{ $visit->polyclinic }}</td>
                            <td>{{ Str::limit($visit->complaint, 50) }}</td>
                            <td>{{ $visit->visit_date->format('d/m/Y H:i') }}</td>
                            <td>{!! $visit->status_badge !!}</td>
                            <td>
                                <div class="d-flex flex-wrap gap-">
                                    <!-- Detail -->
                                    <a href="{{ route('visits.show', $visit->id) }}" class="btn btn-info btn-sm buttom-radius mr-1">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    
                                    <!-- Edit -->
                                    <a href="{{ route('visits.edit', $visit->id) }}" class="btn btn-warning btn-sm buttom-radius mr-1">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    <!-- Rekam Medis -->
                                    @if(!$visit->medical_records && $visit->status != 'completed')
                                        <a href="{{ route('visits.medical-record.create', $visit->id) }}" class="btn btn-success btn-sm buttom-radius mr-1">
                                            <i class="fas fa-file-medical"></i>
                                        </a>
                                    @endif
                                    
                                    <!-- Hapus -->
                                    <form action="{{ route('visits.destroy', $visit->id) }}" method="POST" class="d-inline" 
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus kunjungan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm buttom-radius mr-1">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $visits->links() }}
        </div>
    </div>
</div>
@endsection