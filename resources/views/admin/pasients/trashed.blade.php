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

<div class="card mb-2">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <h2 class="card-title mb-0">Data Pasien Terhapus</h2>
            <p class="mb-0">Data pasien yang telah dihapus (soft delete)</p>
        </div>
        <div>
            <a href="{{ route('Pasien') }}" class="btn btn-primary buttom-radius">
                <i class="fas fa-arrow-left"></i> Kembali ke Data Pasien
            </a>
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
                        <th>Tanggal Dihapus</th>
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
                            <td>{{ $patient->deleted_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <form action="{{ route('patients.restore', $patient->id) }}" method="POST" class="d-inline form-pemulihan-dokument">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm buttom-radius">Pulihkan</button>
                                </form>
                                <form action="{{ route('patients.force-delete', $patient->id) }}" method="POST" class="d-inline form-hapus-dokument">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm buttom-radius">Hapus Permanen</button>
                                </form>
                            </td>
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