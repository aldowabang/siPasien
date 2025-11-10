<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Visit;
use App\Models\Visits;
use App\Models\Patient;
use App\Models\Patients;
use Illuminate\Http\Request;
use App\Models\MedicalRecord;
use App\Models\Medical_records;
use Illuminate\Routing\Controller;

class VisitsController extends Controller
{
    public function index(Request $request)
    {
        $polyclinic = $request->get('polyclinic');
        $status = $request->get('status');
        $date = $request->get('date');

        $visits = Visits::with(['patient', 'user'])
            ->when($polyclinic, function($query) use ($polyclinic) {
                return $query->where('polyclinic', $polyclinic);
            })
            ->when($status, function($query) use ($status) {
                return $query->where('status', $status);
            })
            ->when($date, function($query) use ($date) {
                return $query->whereDate('visit_date', $date);
            })
            ->orderBy('visit_date', 'desc')
            ->paginate(10);

        $data = [
            'title' => 'Data Kunjungan',
            'breadcrumbs' => [
                ['label' => 'Data Kunjungan', 'url' => route('visits.index')],
            ],
            'visits' => $visits,
            'polyclinics' => $this->getPolyclinics(),
            'statuses' => $this->getStatuses(),
            'filters' => [
                'polyclinic' => $polyclinic,
                'status' => $status,
                'date' => $date
            ]
        ];

        return view('admin.visits.index', $data);
    }

    public function create()
    {
        $patients = Patients::orderBy('name')->get();
        $queueNumber = $this->generateQueueNumber();

        $data = [
            'title' => 'Tambah Kunjungan',
            'breadcrumbs' => [
                ['label' => 'Data Kunjungan', 'url' => route('visits.index')],
                ['label' => 'Tambah Kunjungan', 'url' => route('visits.create')],
            ],
            'patients' => $patients,
            'polyclinics' => $this->getPolyclinics(),
            'queueNumber' => $queueNumber,
            'visitDate' => now()->format('Y-m-d\TH:i')
        ];

        return view('admin.visits.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'polyclinic' => 'required|string|max:255',
            'complaint' => 'required|string',
            'visit_date' => 'required|date',
            'notes' => 'nullable|string'
        ]);

        $visit = Visits::create([
            'patient_id' => $request->patient_id,
            'polyclinic' => $request->polyclinic,
            'queue_number' => $this->generateQueueNumber($request->polyclinic),
            'complaint' => $request->complaint,
            'visit_date' => $request->visit_date,
            'notes' => $request->notes,
            'status' => 'waiting'
        ]);

        return redirect()->route('visits.index')
                        ->with('success', 'Kunjungan berhasil ditambahkan.');
    }

    public function show(Visits $visit)
    {
        $visit->load(['patient', 'user', 'medicalRecord']);

        $data = [
            'title' => 'Detail Kunjungan',
            'breadcrumbs' => [
                ['label' => 'Data Kunjungan', 'url' => route('visits.index')],
                ['label' => 'Detail Kunjungan', 'url' => route('visits.show', $visit->id)],
            ],
            'visit' => $visit
        ];

        return view('admin.visits.show', $data);
    }

    public function edit(Visits $visit) // Perbaiki dari Visits ke Visit
        {
            $patients = Patients::orderBy('name')->get(); // Perbaiki dari Patients ke Patient

            $data = [
                'title' => 'Edit Kunjungan',
                'breadcrumbs' => [
                    ['label' => 'Data Kunjungan', 'url' => route('visits.index')],
                    ['label' => 'Edit Kunjungan', 'url' => route('visits.edit', $visit->id)],
                ],
                'visit' => $visit,
                'patients' => $patients,
                'polyclinics' => $this->getPolyclinics()
            ];

            return view('admin.visits.edit', $data);
        }

    public function update(Request $request, Visits $visit)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'polyclinic' => 'required|string|max:255',
            'complaint' => 'required|string',
            'visit_date' => 'required|date',
            'status' => 'required|in:waiting,in_progress,completed,cancelled',
            'notes' => 'nullable|string'
        ]);

        $visit->update([
            'patient_id' => $request->patient_id,
            'polyclinic' => $request->polyclinic,
            'complaint' => $request->complaint,
            'visit_date' => $request->visit_date,
            'status' => $request->status,
            'notes' => $request->notes
        ]);

        return redirect()->route('visits.show', $visit->id)
                        ->with('success', 'Kunjungan berhasil diperbarui.');
    }

    // Method untuk mendapatkan daftar poli


    public function destroy(Visits $visit)
    {
        $visit->delete();

        return redirect()->route('visits.index')
                        ->with('success', 'Kunjungan berhasil dihapus.');
    }

    public function updateStatus(Request $request, Visits $visit)
    {
        $request->validate([
            'status' => 'required|in:waiting,in_progress,completed,cancelled'
        ]);

        $visit->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Status kunjungan berhasil diupdate.'
        ]);
    }

    // Medical Record Methods
    public function createMedicalRecord(Visits $visit)
    {
        $visit->load('patient');

        $data = [
            'title' => 'Rekam Medis',
            'breadcrumbs' => [
                ['label' => 'Data Kunjungan', 'url' => route('visits.index')],
                ['label' => 'Rekam Medis', 'url' => route('visits.medical-record.create', $visit->id)],
            ],
            'visit' => $visit
        ];

        return view('admin.visits.medical-record', $data);
    }

    public function storeMedicalRecord(Request $request, Visits $visit)
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

        // Update visit status to completed
        $visit->update(['status' => 'completed']);

        // Create medical record
        Medical_records::create(array_merge(
            $request->all(),
            ['visit_id' => $visit->id]
        ));

        return redirect()->route('visits.show', $visit->id)
                        ->with('success', 'Rekam medis berhasil disimpan.');
    }

    // Private Methods
    private function getPolyclinics()
    {
        return [
            'Umum' => 'Poli Umum',
            'Gigi' => 'Poli Gigi',
            'Anak' => 'Poli Anak',
            'Kandungan' => 'Poli Kandungan',
            'Bedah' => 'Poli Bedah',
            'Penyakit Dalam' => 'Poli Penyakit Dalam',
            'THT' => 'Poli THT',
            'Mata' => 'Poli Mata'
        ];
    }

    private function getStatuses()
    {
        return [
            'waiting' => 'Menunggu',
            'in_progress' => 'Dalam Proses',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan'
        ];
    }

    private function generateQueueNumber($polyclinic = null)
    {
        $today = now()->format('Y-m-d');
        $lastQueue = Visits::whereDate('visit_date', $today)
            ->when($polyclinic, function($query) use ($polyclinic) {
                return $query->where('polyclinic', $polyclinic);
            })
            ->max('queue_number');

        return ($lastQueue ?? 0) + 1;
    }
}