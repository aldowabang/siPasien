<?php

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MedicinesController;

Route::get('/', [MedicinesController::class, 'index'])->name('medic');



