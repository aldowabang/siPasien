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
            <h2 class="card-title mb-0">Data Pasien</h2>
            <p class="mb-0">Berikut adalah data Pasien</p>
        </div>
        <div>
            @if(auth()->user()->role === 'admin')
            <a href="{{ route('add-pasien') }}" class="btn btn-primary buttom-radius"><i class="fas fa-plus mr-2"></i> Tambah Data</a>
            <a href="{{ route('patients.trashed') }}" class="btn btn-secondary buttom-radius">
                <i class="fas fa-trash mr-2"></i> Data Terhapus
            </a>
            @else
            <a href="{{ route('registrasi') }}" class="btn btn-primary buttom-radius"><i class="fas fa-plus mr-2"></i> Pendaftaran Pasien</a>
            @endif
        </div>
    </div>
    <div class="card-body">
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
                        <th>NIK</th>
                        <th>Nama</th>
                        <th>Nomer Rekam Medis</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($patients as $patient)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $patient->nik }}</td>
                            <td>{{ $patient->name }}</td>
                            <td>{{ $patient->medical_record_number }}</td>
                            <td>
                                @if(auth()->user()->role === 'admin')
                                <a href="{{ route('patients.show', $patient->id) }}" class="btn btn-info btn-sm buttom-radius">
                                <i class="fas fa-eye mr-2"></i> Lihat</a>
                                <a href="{{ route('patients.edit', $patient->id) }}" class="btn btn-warning btn-sm buttom-radius"><i class="fas fa-edit mr-2"></i>Edit</a>
                                <form action="{{ route('patients.destroy', $patient->id) }}" method="POST" class="d-inline form-hapus-dokument" >
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm buttom-radius"><i class="fas fa-trash mr-2"></i> Hapus</button>
                                </form>
                                @else
                                <a href="{{ route('patients.show', $patient->id) }}" class="btn btn-info btn-sm buttom-radius">
                                <i class="fas fa-eye"></i> Lihat</a>
                                @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="mt-3">
            {{ $patients->links() }}
        </div>
    </div>
</div>
@endsection