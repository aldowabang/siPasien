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
            <h2 class="card-title mb-0">Edit Kunjungan</h2>
            <p class="mb-0">Silakan edit data kunjungan pasien</p>
        </div>
        <div>
            <a href="{{ route('visits.show', $visit->id) }}" class="btn btn-info buttom-radius">
                <i class="fas fa-arrow-left"></i> Kembali ke Detail
            </a>
        </div>
    </div>
    <div class="card-body">
        <!-- Informasi Kunjungan Saat Ini -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="current-info-card">
                    <h5 class="text-primary mb-3">Informasi Kunjungan Saat Ini</h5>
                    <div class="row">
                        <div class="col-md-3">
                            <strong>Nomor Antrian:</strong><br>
                            <span class="text-primary font-weight-bold">{{ $visit->queue_number }}</span>
                        </div>
                        <div class="col-md-3">
                            <strong>Status:</strong><br>
                            {!! $visit->status_badge !!}
                        </div>
                        <div class="col-md-3">
                            <strong>Poli:</strong><br>
                            {{ $visit->polyclinic }}
                        </div>
                        <div class="col-md-3">
                            <strong>Tanggal Kunjungan:</strong><br>
                            {{ $visit->visit_date->format('d/m/Y H:i') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <form action="{{ route('visits.update', $visit->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="patient_id" class="required">Pasien</label>
                        <select class="form-control @error('patient_id') is-invalid @enderror" id="patient_id" name="patient_id" required>
                            <option value="">Pilih Pasien</option>
                            @foreach($patients as $patient)
                                <option value="{{ $patient->id }}" 
                                    {{ old('patient_id', $visit->patient_id) == $patient->id ? 'selected' : '' }}>
                                    {{ $patient->name }} - {{ $patient->medical_record_number }}
                                </option>
                            @endforeach
                        </select>
                        @error('patient_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="polyclinic" class="required">Poli</label>
                        <select class="form-control @error('polyclinic') is-invalid @enderror" id="polyclinic" name="polyclinic" required>
                            <option value="">Pilih Poli</option>
                            @foreach($polyclinics as $key => $value)
                                <option value="{{ $key }}" 
                                    {{ old('polyclinic', $visit->polyclinic) == $key ? 'selected' : '' }}>
                                    {{ $value }}
                                </option>
                            @endforeach
                        </select>
                        @error('polyclinic')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="visit_date" class="required">Tanggal & Waktu Kunjungan</label>
                        <input type="datetime-local" class="form-control @error('visit_date') is-invalid @enderror" 
                               id="visit_date" name="visit_date" 
                               value="{{ old('visit_date', $visit->visit_date->format('Y-m-d\TH:i')) }}" required>
                        @error('visit_date')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="status" class="required">Status Kunjungan</label>
                        <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                            <option value="waiting" {{ old('status', $visit->status) == 'waiting' ? 'selected' : '' }}>Menunggu</option>
                            <option value="in_progress" {{ old('status', $visit->status) == 'in_progress' ? 'selected' : '' }}>Dalam Proses</option>
                            <option value="completed" {{ old('status', $visit->status) == 'completed' ? 'selected' : '' }}>Selesai</option>
                            <option value="cancelled" {{ old('status', $visit->status) == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="complaint" class="required">Keluhan Utama</label>
                        <textarea class="form-control @error('complaint') is-invalid @enderror" 
                                  id="complaint" name="complaint" rows="3" required>{{ old('complaint', $visit->complaint) }}</textarea>
                        @error('complaint')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="notes">Catatan Tambahan</label>
                        <textarea class="form-control @error('notes') is-invalid @enderror" 
                                  id="notes" name="notes" rows="3">{{ old('notes', $visit->notes) }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Informasi Status Rekam Medis -->
            @if($visit->medicalRecord)
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        <strong>Informasi:</strong> Kunjungan ini sudah memiliki rekam medis. 
                        Mengubah status menjadi "Selesai" akan mempertahankan rekam medis yang sudah ada.
                    </div>
                </div>
            </div>
            @endif

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Kunjungan
                        </button>
                        <a href="{{ route('visits.show', $visit->id) }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Batal
                        </a>
                        
                        <!-- Tombol Hapus -->
                        <button type="button" class="btn btn-danger float-right" data-toggle="modal" data-target="#deleteModal">
                            <i class="fas fa-trash"></i> Hapus Kunjungan
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus kunjungan ini?</p>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>Peringatan:</strong> Tindakan ini tidak dapat dibatalkan. 
                    @if($visit->medicalRecord)
                    Data rekam medis yang terkait juga akan dihapus.
                    @endif
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <form action="{{ route('visits.destroy', $visit->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.current-info-card {
    background: #f8f9fa;
    border-left: 4px solid #007bff;
    padding: 15px;
    border-radius: 4px;
    border: 1px solid #e9ecef;
}

.required:after {
    content: " *";
    color: #dc3545;
}

.form-group label {
    font-weight: 600;
    color: #495057;
    margin-bottom: 5px;
}

.card {
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.btn {
    border-radius: 4px;
    margin-right: 5px;
}

.alert {
    border-radius: 4px;
}

.badge {
    font-size: 0.8em;
    padding: 6px 10px;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form validation
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const requiredFields = form.querySelectorAll('[required]');
        let isValid = true;

        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                isValid = false;
                field.classList.add('is-invalid');
                
                // Add error message if not exists
                if (!field.nextElementSibling || !field.nextElementSibling.classList.contains('invalid-feedback')) {
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'invalid-feedback';
                    errorDiv.textContent = 'Field ini wajib diisi.';
                    field.parentNode.appendChild(errorDiv);
                }
            } else {
                field.classList.remove('is-invalid');
            }
        });

        if (!isValid) {
            e.preventDefault();
            // Scroll to first error
            const firstError = form.querySelector('.is-invalid');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }
    });

    // Real-time patient info display
    const patientSelect = document.getElementById('patient_id');
    const patientInfoDiv = document.createElement('div');
    patientInfoDiv.className = 'patient-info mt-2';
    patientSelect.parentNode.appendChild(patientInfoDiv);

    patientSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        if (selectedOption.value) {
            const patientText = selectedOption.textContent;
            patientInfoDiv.innerHTML = `
                <div class="alert alert-info py-2">
                    <small><strong>Pasien terpilih:</strong> ${patientText}</small>
                </div>
            `;
        } else {
            patientInfoDiv.innerHTML = '';
        }
    });

    // Trigger change on page load if patient already selected
    if (patientSelect.value) {
        patientSelect.dispatchEvent(new Event('change'));
    }

    // Status change warning
    const statusSelect = document.getElementById('status');
    statusSelect.addEventListener('change', function() {
        const currentStatus = '{{ $visit->status }}';
        const newStatus = this.value;
        
        if (currentStatus === 'completed' && newStatus !== 'completed' && {{ $visit->medicalRecord ? 'true' : 'false' }}) {
            if (!confirm('Mengubah status dari "Selesai" akan mempertahankan rekam medis. Lanjutkan?')) {
                this.value = currentStatus;
            }
        }
    });

    // Auto-format datetime input
    const visitDateInput = document.getElementById('visit_date');
    if (visitDateInput) {
        // Ensure the format is correct for datetime-local
        const currentValue = visitDateInput.value;
        if (currentValue && !currentValue.includes('T')) {
            // Convert from database format if needed
            const date = new Date('{{ $visit->visit_date }}');
            visitDateInput.value = date.toISOString().slice(0, 16);
        }
    }
});
</script>
@endsection