<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VisitsController;
use App\Http\Controllers\PatientsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Medical_recordsController;


// ==================== AUTH ROUTES ====================
Auth::routes();

// ==================== PUBLIC ROUTES ====================
Route::get('/', function () {
    return redirect()->route('dashboard');
});



// ==================== PROTECTED ROUTES ====================
Route::middleware(['auth'])->group(function () {
    
    // Dashboard - Semua role yang login
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // ==================== ADMIN ONLY ROUTES ====================
    Route::middleware(['role:admin'])->group(function () {
        // User Management
        Route::resource('users', UserController::class);
        Route::post('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
    });

    // ==================== PATIENT ROUTES ====================
    Route::middleware(['role:admin,registrasi,dokter,perawat'])->group(function () {
        Route::get('/pasien', [PatientsController::class, 'index'])->name('Pasien');
        Route::get('/pasien/trashed', [PatientsController::class, 'trashed'])->name('patients.trashed');
        Route::get('/add-pasien', [PatientsController::class, 'create'])->name('add-pasien');
        Route::post('/add-pasien', [PatientsController::class, 'store'])->name('store-pasien');
        Route::get('/patients/{id}', [PatientsController::class, 'show'])->name('patients.show');
        Route::get('/patients/{id}/edit', [PatientsController::class, 'edit'])->name('patients.edit');
        Route::put('/patients/{id}', [PatientsController::class, 'update'])->name('patients.update');
        Route::delete('/patients/{id}', [PatientsController::class, 'destroy'])->name('patients.destroy');
        Route::post('/patients/{id}/restore', [PatientsController::class, 'restore'])->name('patients.restore');
        Route::delete('/patients/{id}/force-delete', [PatientsController::class, 'forceDelete'])->name('patients.force-delete');
    });

    // ==================== VISIT ROUTES ====================
    Route::middleware(['role:admin,perawat'])->group(function () {
        Route::get('/visits', [VisitsController::class, 'index'])->name('visits.index');
        Route::get('/visits/create', [VisitsController::class, 'create'])->name('visits.create');
        Route::post('/visits', [VisitsController::class, 'store'])->name('visits.store');
        Route::get('/visits/{visit}', [VisitsController::class, 'show'])->name('visits.show');
        Route::get('/visits/{visit}/edit', [VisitsController::class, 'edit'])->name('visits.edit');
        Route::put('/visits/{visit}', [VisitsController::class, 'update'])->name('visits.update');
        Route::delete('/visits/{visit}', [VisitsController::class, 'destroy'])->name('visits.destroy');
    });

    // ==================== MEDICAL RECORD ROUTES ====================
    Route::middleware(['role:admin,dokter'])->group(function () {
        Route::get('/medical-records', [Medical_recordsController::class, 'index'])->name('medical-records.index');
        Route::get('/medical-records/patient/{patient}', [Medical_recordsController::class, 'showByPatient'])->name('medical-records.by-patient');
        Route::get('/medical-records/{medicalRecord}', [Medical_recordsController::class, 'show'])->name('medical-records.show');
        Route::get('/medical-records/{medicalRecord}/edit', [Medical_recordsController::class, 'edit'])->name('medical-records.edit');
        Route::put('/medical-records/{medicalRecord}', [Medical_recordsController::class, 'update'])->name('medical-records.update');
        Route::delete('/medical-records/{medicalRecord}', [Medical_recordsController::class, 'destroy'])->name('medical-records.destroy');
        Route::post('/medical-records/search-by-number', [Medical_recordsController::class, 'searchByMedicalRecordNumber'])->name('medical-records.search-by-number');
        Route::get('/visits/{visit}/medical-record/create', [VisitsController::class, 'createMedicalRecord'])->name('visits.medical-record.create');
        Route::post('/visits/{visit}/medical-record', [VisitsController::class, 'storeMedicalRecord'])->name('visits.medical-record.store');
    });

    // ==================== LOGOUT ROUTE ====================
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');
});