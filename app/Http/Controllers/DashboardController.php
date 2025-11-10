<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Visit;
use App\Models\MedicalRecord;
use App\Models\Patients;
use App\Models\Visits;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        
        // Total Pasien
        $totalPatients = Patients::count();
        
        // Total Kunjungan
        $totalVisits = Visits::count();
        
        // Kunjungan Hari Ini
        $visitsToday = Visits::whereDate('visit_date', Carbon::today())->count();
        
        // Kunjungan Bulan Ini
        $visitsThisMonth = Visits::whereMonth('visit_date', Carbon::now()->month)
            ->whereYear('visit_date', Carbon::now()->year)
            ->count();
        
        // Kunjungan Minggu Ini
        $visitsThisWeek = Visits::whereBetween('visit_date', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek()
        ])->count();

        // Status Kunjungan Hari Ini
        $todayStatus = Visits::whereDate('visit_date', Carbon::today())
            ->selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status')
            ->toArray();

        // Statistik Poli
        $polyclinicStats = Visits::whereDate('visit_date', Carbon::today())
            ->selectRaw('polyclinic, count(*) as count')
            ->groupBy('polyclinic')
            ->orderBy('count', 'desc')
            ->take(5)
            ->get();

        // Kunjungan Terbaru (5 data)
        $latestVisits = Visits::with(['patient', 'medicalRecord'])
            ->orderBy('visit_date', 'desc')
            ->take(5)
            ->get();

        // Antrian Hari Ini (yang masih waiting)
        $todayQueue = Visits::with('patient')
            ->whereDate('visit_date', Carbon::today())
            ->where('status', 'waiting')
            ->orderBy('queue_number')
            ->take(10)
            ->get();

        // Statistik bulanan untuk chart
        $monthlyStats = $this->getMonthlyStats();
        
        // Statistik gender pasien
        $genderStats = Patients::selectRaw('gender, count(*) as count')
            ->groupBy('gender')
            ->get()
            ->pluck('count', 'gender')
            ->toArray();

        $data = [
            'title' => 'Dashboard',
            'breadcrumbs' => [
                ['label' => 'Dashboard', 'url' => route('dashboard')],
            ],
            'totalPatients' => $totalPatients,
            'totalVisits' => $totalVisits,
            'visitsToday' => $visitsToday,
            'visitsThisMonth' => $visitsThisMonth,
            'visitsThisWeek' => $visitsThisWeek,
            'todayStatus' => $todayStatus,
            'polyclinicStats' => $polyclinicStats,
            'latestVisits' => $latestVisits,
            'todayQueue' => $todayQueue,
            'monthlyStats' => $monthlyStats,
            'genderStats' => $genderStats,
        ];

        return view('admin.dashboard', $data);
    }

    private function getMonthlyStats()
    {
        $currentYear = Carbon::now()->year;
        
        $monthlyData = Visits::selectRaw('MONTH(visit_date) as month, COUNT(*) as count')
            ->whereYear('visit_date', $currentYear)
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('count', 'month')
            ->toArray();
        
        // Format data untuk chart
        $months = [];
        $counts = [];
        
        for ($month = 1; $month <= 12; $month++) {
            $months[] = Carbon::create()->month($month)->format('M');
            $counts[] = $monthlyData[$month] ?? 0;
        }
        
        return [
            'months' => $months,
            'counts' => $counts,
        ];
    }
}