<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medical_records;
use Illuminate\Routing\Controller;
use App\Models\Patients;

class Medical_recordsController extends Controller
{
 public function index(Request $request)
    {
        $search = $request->get('search');
        $medicalRecordNumber = $request->get('medical_record_number');

        // Query untuk mendapatkan pasien dengan rekam medis
        $patients = Patients::withCount(['visits as medical_records_count' => function($query) {
                $query->whereHas('medicalRecord'); // PERBAIKAN: medicalRecord (bukan medicalecord)
            }])
            ->with(['visits.medicalRecord' => function($query) { // PERBAIKAN: medicalRecord
                $query->orderBy('created_at', 'desc')->take(1);
            }])
            ->when($search, function($query) use ($search) {
                return $query->where('name', 'like', "%{$search}%")
                           ->orWhere('medical_record_number', 'like', "%{$search}%");
            })
            ->when($medicalRecordNumber, function($query) use ($medicalRecordNumber) {
                return $query->where('medical_record_number', $medicalRecordNumber);
            })
            ->whereHas('visits.medicalRecord') // PERBAIKAN: medicalRecord
            ->orderBy('name')
            ->paginate(10);

        $data = [
            'title' => 'Rekam Medis',
            'breadcrumbs' => [
                ['label' => 'Rekam Medis', 'url' => route('medical-records.index')],
            ],
            'patients' => $patients,
            'search' => $search,
            'medicalRecordNumber' => $medicalRecordNumber
        ];

        return view('admin.medical-records.index', $data);
    }

    public function showByPatient($patientId)
    {
        $patient = Patients::with(['visits.medicalRecord' => function($query) { // PERBAIKAN: medicalRecord
            $query->orderBy('created_at', 'desc');
        }])->findOrFail($patientId);

        $data = [
            'title' => 'Riwayat Rekam Medis - ' . $patient->medical_record_number,
            'breadcrumbs' => [
                ['label' => 'Rekam Medis', 'url' => route('medical-records.index')],
                ['label' => $patient->medical_record_number, 'url' => route('medical-records.by-patient', $patient->id)],
            ],
            'patient' => $patient
        ];

        return view('admin.medical-records.by-patient', $data);
    }

 public function show($id) // Ubah dari MedicalRecord $medicalRecord ke $id
    {
        // Load data dengan manual query untuk menghindari error relasi
        $medicalRecord = Medical_records::with(['visit.patient', 'visit.user'])
            ->findOrFail($id);

        // Load prescriptions secara manual dengan foreign key yang benar
        $prescriptions = \App\Models\Prescriptions::with('medicine')
            ->where('medical_record_id', $medicalRecord->id) // Gunakan medical_record_id
            ->get();
        
        $medicalRecord->setRelation('prescriptions', $prescriptions);

        $data = [
            'title' => 'Detail Rekam Medis',
            'breadcrumbs' => [
                ['label' => 'Rekam Medis', 'url' => route('medical-records.index')],
                ['label' => 'Detail Rekam Medis', 'url' => route('medical-records.show', $medicalRecord->id)],
            ],
            'medicalRecord' => $medicalRecord
        ];

        return view('admin.medical-records.show', $data);
    }

    public function searchByMedicalRecordNumber(Request $request)
    {
        $request->validate([
            'medical_record_number' => 'required|string'
        ]);

        $patient = Patients::where('medical_record_number', $request->medical_record_number)->first();

        if (!$patient) {
            return redirect()->route('medical-records.index')
                           ->with('error', 'Pasien dengan nomor rekam medis tersebut tidak ditemukan.');
        }

        return redirect()->route('medical-records.by-patient', $patient->id);
    }

    public function edit(Medical_records $medicalRecord)
    {
        $medicalRecord->load(['visit.patient']);

        $data = [
            'title' => 'Edit Rekam Medis',
            'breadcrumbs' => [
                ['label' => 'Rekam Medis', 'url' => route('medical-records.index')],
                ['label' => 'Edit Rekam Medis', 'url' => route('medical-records.edit', $medicalRecord->id)],
            ],
            'medicalRecord' => $medicalRecord
        ];

        return view('admin.medical-records.edit', $data);
    }

    public function update(Request $request, Medical_records $medicalRecord)
    {
        $request->validate([
            'main_complaint' => 'required|string',
            'symptoms' => 'required|string',
            'physical_examination' => 'nullable|string',
            'diagnosis' => 'required|string',
            'treatment' => 'required|string',
            'notes' => 'nullable|string',
            'temperature' => 'nullable|numeric',
            'blood_pressure_systolic' => 'nullable|integer',
            'blood_pressure_diastolic' => 'nullable|integer',
            'heart_rate' => 'nullable|integer',
            'respiratory_rate' => 'nullable|integer'
        ]);

        $medicalRecord->update($request->all());

        return redirect()->route('medical-records.show', $medicalRecord->id)
                        ->with('success', 'Rekam medis berhasil diperbarui.');
    }

    public function destroy(Medical_records $medicalRecord)
    {
        $medicalRecord->delete();

        return redirect()->route('medical-records.index')
                        ->with('success', 'Rekam medis berhasil dihapus.');
    }
}
