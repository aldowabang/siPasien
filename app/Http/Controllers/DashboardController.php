<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patients;
use App\Models\User; // Jika ada model User
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Total Pasien
        $totalPatients = Patients::count();
        
        // Pasien bulan ini
        $patientsThisMonth = Patients::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();
        
        // Pasien minggu ini
        $patientsThisWeek = Patients::whereBetween('created_at', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek()
        ])->count();
        
        // Pasien hari ini
        $patientsToday = Patients::whereDate('created_at', Carbon::today())->count();
        
        // Statistik gender
        $genderStats = Patients::selectRaw('gender, count(*) as count')
            ->groupBy('gender')
            ->get()
            ->pluck('count', 'gender')
            ->toArray();
        
        // Pasien terbaru (5 data)
        $latestPatients = Patients::orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        // Statistik bulanan untuk chart
        $monthlyStats = $this->getMonthlyStats();
        
        $data = [
            'title' => 'Dashboard',
            'breadcrumbs' => [
                ['label' => 'Dashboard', 'url' => route('dashboard')],
            ],
            'totalPatients' => $totalPatients,
            'patientsThisMonth' => $patientsThisMonth,
            'patientsThisWeek' => $patientsThisWeek,
            'patientsToday' => $patientsToday,
            'genderStats' => $genderStats,
            'latestPatients' => $latestPatients,
            'monthlyStats' => $monthlyStats,
        ];

        return view('admin.dashboard', $data);
    }

    private function getMonthlyStats()
    {
        $currentYear = Carbon::now()->year;
        
        $monthlyData = Patients::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', $currentYear)
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