<?php

use App\Http\Controllers\PatientsController;
use Illuminate\Support\Facades\Route;

// Routes untuk Patients dengan soft delete
Route::get('/pasien', [PatientsController::class, 'index'])->name('Pasien');
Route::get('/pasien/trashed', [PatientsController::class, 'trashed'])->name('patients.trashed');
Route::get('/add-pasien', [PatientsController::class, 'create'])->name('add-pasien');
Route::post('/add-pasien', [PatientsController::class, 'store'])->name('store-pasien');
Route::get('/patients/{id}/edit', [PatientsController::class, 'edit'])->name('patients.edit');
Route::put('/patients/{id}', [PatientsController::class, 'update'])->name('patients.update');
Route::delete('/patients/{id}', [PatientsController::class, 'destroy'])->name('patients.destroy');
Route::post('/patients/{id}/restore', [PatientsController::class, 'restore'])->name('patients.restore');
Route::delete('/patients/{id}/force-delete', [PatientsController::class, 'forceDelete'])->name('patients.force-delete');