<?php

namespace App\Http\Controllers;

use App\Models\Patients;
use Illuminate\Http\Request;

class PatientsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'title' => 'Data Pasien',
            'breadcrumbs' => [
                ['label' => 'Data Pasien', 'url' => route('Pasien')],
            ],
            'patients' => Patients::whereNull('deleted_at')->orderBy('created_at', 'desc')->paginate(10),
        ];

        return view('admin.pasients.index', $data);
    }

    /**
     * Show trashed patients
     */
    public function trashed()
    {
        $data = [
            'title' => 'Data Pasien Terhapus',
            'breadcrumbs' => [
                ['label' => 'Data Pasien', 'url' => route('Pasien')],
                ['label' => 'Data Terhapus', 'url' => route('patients.trashed')],
            ],
            'patients' => Patients::onlyTrashed()->orderBy('deleted_at', 'desc')->paginate(10),
        ];

        return view('admin.pasients.trashed', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $medical_record_number = $this->generateMedicalRecordNumber();

        $data = [
            'title' => 'Add Pasien',
            'breadcrumbs' => [
                ['label' => 'Data Pasien', 'url' => route('Pasien')],
                ['label' => 'Add Pasien', 'url' => route('add-pasien')],
            ],
            'medical_record_number' => $medical_record_number,
        ];

        return view('admin.pasients.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required|unique:patients,nik',
            'medical_record_number' => 'required|unique:patients,medical_record_number',
            'name' => 'required|string|max:255',
            'birth_place' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'gender' => 'required|in:L,P',
            'address' => 'required|string',
            'phone' => 'required|string|max:15',
            'emergency_contact_name' => 'required|string|max:255',
            'emergency_contact_phone' => 'required|string|max:15',
            'allergy_history' => 'nullable|string',
            'insurance_type' => 'nullable|string|max:255',
            'insurance_number' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ],[
            'nik.required' => 'NIK Harus diisi.',
            'nik.unique' => 'NIK sudah terdaftar.',
            'medical_record_number.required' => 'Nomor Rekam Medis Harus diisi.',
            'medical_record_number.unique' => 'Nomor Rekam Medis sudah terdaftar.',
            'name.required' => 'Nama Pasien Harus diisi.',
            'birth_place.required' => 'Tempat Lahir Harus diisi.',
            'birth_date.required' => 'Tanggal Lahir Harus diisi.',
            'gender.required' => 'Jenis Kelamin Harus dipilih.',
            'address.required' => 'Alamat Harus diisi.',
            'phone.required' => 'Nomor Telepon Harus diisi.',
            'emergency_contact_name.required' => 'Nama Kontak Darurat Harus diisi.',
            'emergency_contact_phone.required' => 'Nomor Telepon Kontak Darurat Harus diisi.',
            'allergy_history.string' => 'Riwayat Alergi harus berupa teks.',
            'insurance_type.string' => 'Jenis Asuransi harus berupa teks.',
            'insurance_number.string' => 'Nomor Asuransi harus berupa teks.',
            'notes.string' => 'Catatan harus berupa teks.',
        ]);

        Patients::create([
            'nik' => $request->nik,
            'medical_record_number' => $request->medical_record_number,
            'name' => $request->name,
            'birth_place' => $request->birth_place,
            'birth_date' => $request->birth_date,
            'gender' => $request->gender,
            'address' => $request->address,
            'phone' => $request->phone,
            'emergency_contact_name' => $request->emergency_contact_name,
            'emergency_contact_phone' => $request->emergency_contact_phone,
            'allergy_history' => $request->allergy_history,
            'insurance_type' => $request->insurance_type,
            'insurance_number' => $request->insurance_number,
            'notes' => $request->notes,
        ]);

        return redirect()->route('Pasien')->with('success', 'Data Pasien berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Patients $patients)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $patient = Patients::findOrFail($id);

        $data = [
            'title' => 'Edit Pasien',
            'breadcrumbs' => [
                ['label' => 'Data Pasien', 'url' => route('Pasien')],
                ['label' => 'Edit Pasien', 'url' => route('patients.edit', $id)],
            ],
            'patient' => $patient,
        ];

        return view('admin.pasients.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $patient = Patients::findOrFail($id);

        $request->validate([
            'nik' => 'required|unique:patients,nik,' . $patient->id,
            'medical_record_number' => 'required|unique:patients,medical_record_number,' . $patient->id,
            'name' => 'required|string|max:255',
            'birth_place' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'gender' => 'required|in:L,P',
            'address' => 'required|string',
            'phone' => 'required|string|max:15',
            'emergency_contact_name' => 'required|string|max:255',
            'emergency_contact_phone' => 'required|string|max:15',
            'allergy_history' => 'nullable|string',
            'insurance_type' => 'nullable|string|max:255',
            'insurance_number' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ],[
            'nik.required' => 'NIK Harus diisi.',
            'nik.unique' => 'NIK sudah terdaftar.',
            'medical_record_number.required' => 'Nomor Rekam Medis Harus diisi.',
            'medical_record_number.unique' => 'Nomor Rekam Medis sudah terdaftar.',
            'name.required' => 'Nama Pasien Harus diisi.',
            'birth_place.required' => 'Tempat Lahir Harus diisi.',
            'birth_date.required' => 'Tanggal Lahir Harus diisi.',
            'gender.required' => 'Jenis Kelamin Harus dipilih.',
            'address.required' => 'Alamat Harus diisi.',
            'phone.required' => 'Nomor Telepon Harus diisi.',
            'emergency_contact_name.required' => 'Nama Kontak Darurat Harus diisi.',
            'emergency_contact_phone.required' => 'Nomor Telepon Kontak Darurat Harus diisi.',
        ]);

        $patient->update([
            'nik' => $request->nik,
            'medical_record_number' => $request->medical_record_number,
            'name' => $request->name,
            'birth_place' => $request->birth_place,
            'birth_date' => $request->birth_date,
            'gender' => $request->gender,
            'address' => $request->address,
            'phone' => $request->phone,
            'emergency_contact_name' => $request->emergency_contact_name,
            'emergency_contact_phone' => $request->emergency_contact_phone,
            'allergy_history' => $request->allergy_history,
            'insurance_type' => $request->insurance_type,
            'insurance_number' => $request->insurance_number,
            'notes' => $request->notes,
        ]);

        return redirect()->route('Pasien')->with('success', 'Data Pasien berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage (Soft Delete).
     */
    public function destroy($id)
    {
        $patient = Patients::findOrFail($id);
        $patient->delete();

        return redirect()->route('Pasien')->with('success', 'Data Pasien berhasil dihapus (masuk ke trash).');
    }

    /**
     * Restore soft deleted patient
     */
    public function restore($id)
    {
        $patient = Patients::onlyTrashed()->findOrFail($id);
        $patient->restore();

        return redirect()->route('patients.trashed')->with('success', 'Data Pasien berhasil dipulihkan.');
    }

    /**
     * Force delete patient permanently
     */
    public function forceDelete($id)
    {
        $patient = Patients::onlyTrashed()->findOrFail($id);
        $patient->forceDelete();

        return redirect()->route('patients.trashed')->with('success', 'Data Pasien berhasil dihapus permanen.');
    }

    /**
     * Generate medical record number automatically
     */
    private function generateMedicalRecordNumber()
    {
        $now = now();
        $year = $now->format('y');
        $month = $now->format('m');
        $day = $now->format('d');
        $time = $now->format('His');
        
        return "MR-{$year}{$month}{$day}-{$time}";
    }
}