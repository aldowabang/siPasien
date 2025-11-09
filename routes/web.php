<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VisitsController;
use App\Http\Controllers\PatientsController;
use App\Http\Controllers\DashboardController;


// Dashboard Route
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/', [DashboardController::class, 'index'])->name('home');

// Patients Routes
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

// Visit Routes
Route::get('/visits', [VisitsController::class, 'index'])->name('visits.index');
Route::get('/visits/create', [VisitsController::class, 'create'])->name('visits.create');
Route::post('/visits', [VisitsController::class, 'store'])->name('visits.store');
Route::get('/visits/{visit}', [VisitsController::class, 'show'])->name('visits.show');
Route::get('/visits/{visit}/edit', [VisitsController::class, 'edit'])->name('visits.edit');
Route::put('/visits/{visit}', [VisitsController::class, 'update'])->name('visits.update');
Route::delete('/visits/{visit}', [VisitsController::class, 'destroy'])->name('visits.destroy');
Route::get('/visits/{visit}/medical-record/create', [VisitsController::class, 'createMedicalRecord'])->name('visits.medical-record.create');
Route::post('/visits/{visit}/medical-record', [VisitsController::class, 'storeMedicalRecord'])->name('visits.medical-record.store');