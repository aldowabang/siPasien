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
            <h2 class="card-title mb-0">Rekam Medis</h2>
            <p class="mb-0">Input data rekam medis untuk kunjungan pasien</p>
        </div>
        <div>
            <a href="{{ route('visits.show', $visit->id) }}" class="btn btn-info buttom-radius">
                <i class="fas fa-arrow-left"></i> Kembali ke Detail
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
                            {{ $visit->patient->name }}
                        </div>
                        <div class="col-md-3">
                            <strong>No. Rekam Medis:</strong><br>
                            {{ $visit->patient->medical_record_number }}
                        </div>
                        <div class="col-md-3">
                            <strong>Usia:</strong><br>
                            {{ \Carbon\Carbon::parse($visit->patient->birth_date)->age }} tahun
                        </div>
                        <div class="col-md-3">
                            <strong>Jenis Kelamin:</strong><br>
                            {{ $visit->patient->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-12">
                            <strong>Keluhan Utama:</strong><br>
                            {{ $visit->complaint }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <form action="{{ route('visits.medical-record.store', $visit->id) }}" method="POST">
            @csrf
            
            <!-- Data Vital Signs -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <h5 class="text-primary mb-3">Tanda-Tanda Vital</h5>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="temperature">Suhu (°C)</label>
                                <input type="number" step="0.1" class="form-control" id="temperature" name="temperature" 
                                       placeholder="36.5" value="{{ old('temperature') }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="blood_pressure_systolic">TD Sistolik</label>
                                <input type="number" class="form-control" id="blood_pressure_systolic" name="blood_pressure_systolic" 
                                       placeholder="120" value="{{ old('blood_pressure_systolic') }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="blood_pressure_diastolic">TD Diastolik</label>
                                <input type="number" class="form-control" id="blood_pressure_diastolic" name="blood_pressure_diastolic" 
                                       placeholder="80" value="{{ old('blood_pressure_diastolic') }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="heart_rate">Denyut Nadi (bpm)</label>
                                <input type="number" class="form-control" id="heart_rate" name="heart_rate" 
                                       placeholder="72" value="{{ old('heart_rate') }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="respiratory_rate">Frekuensi Nafas (rpm)</label>
                                <input type="number" class="form-control" id="respiratory_rate" name="respiratory_rate" 
                                       placeholder="16" value="{{ old('respiratory_rate') }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Keluhan Utama dan Gejala -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="main_complaint" class="required">Keluhan Utama</label>
                        <textarea class="form-control @error('main_complaint') is-invalid @enderror" 
                                  id="main_complaint" name="main_complaint" rows="3" required>{{ old('main_complaint', $visit->complaint) }}</textarea>
                        @error('main_complaint')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="symptoms" class="required">Gejala Penyerta</label>
                        <textarea class="form-control @error('symptoms') is-invalid @enderror" 
                                  id="symptoms" name="symptoms" rows="3" required>{{ old('symptoms') }}</textarea>
                        <small class="form-text text-muted">Deskripsikan gejala yang menyertai keluhan utama</small>
                        @error('symptoms')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Pemeriksaan Fisik -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="physical_examination">Pemeriksaan Fisik</label>
                        <textarea class="form-control @error('physical_examination') is-invalid @enderror" 
                                  id="physical_examination" name="physical_examination" rows="3">{{ old('physical_examination') }}</textarea>
                        <small class="form-text text-muted">Hasil pemeriksaan fisik yang dilakukan</small>
                        @error('physical_examination')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Diagnosis dan Pengobatan -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="diagnosis" class="required">Diagnosis</label>
                        <textarea class="form-control @error('diagnosis') is-invalid @enderror" 
                                  id="diagnosis" name="diagnosis" rows="3" required>{{ old('diagnosis') }}</textarea>
                        @error('diagnosis')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="treatment" class="required">Tatalaksana/Pengobatan</label>
                        <textarea class="form-control @error('treatment') is-invalid @enderror" 
                                  id="treatment" name="treatment" rows="3" required>{{ old('treatment') }}</textarea>
                        <small class="form-text text-muted">Terapi, obat, atau tindakan yang diberikan</small>
                        @error('treatment')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Catatan Tambahan -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="notes">Catatan Tambahan</label>
                        <textarea class="form-control @error('notes') is-invalid @enderror" 
                                  id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                        <small class="form-text text-muted">Catatan lain yang diperlukan</small>
                        @error('notes')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Simpan Rekam Medis
                        </button>
                        <a href="{{ route('visits.show', $visit->id) }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Batal
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
.patient-info-card {
    background: #f8f9fa;
    border-left: 4px solid #007bff;
    padding: 15px;
    border-radius: 4px;
}

.required:after {
    content: " *";
    color: #dc3545;
}

.form-group label {
    font-weight: 600;
    color: #495057;
}

.card {
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.btn {
    border-radius: 4px;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-calculate age based on birth date
    const birthDate = '{{ $visit->patient->birth_date }}';
    if (birthDate) {
        const age = calculateAge(new Date(birthDate));
        document.querySelector('[class*="Usia"]').parentElement.innerHTML = 
            '<strong>Usia:</strong><br>' + age + ' tahun';
    }

    function calculateAge(birthDate) {
        const today = new Date();
        let age = today.getFullYear() - birthDate.getFullYear();
        const monthDiff = today.getMonth() - birthDate.getMonth();
        
        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }
        
        return age;
    }

    // Form validation
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const requiredFields = form.querySelectorAll('[required]');
        let isValid = true;

        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                isValid = false;
                field.classList.add('is-invalid');
            } else {
                field.classList.remove('is-invalid');
            }
        });

        if (!isValid) {
            e.preventDefault();
            alert('Harap lengkapi semua field yang wajib diisi!');
        }
    });
});
</script>
@endsection