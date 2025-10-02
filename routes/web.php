<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ReceptionController;

use App\Http\Controllers\Api\PatientApiController;
use App\Http\Controllers\Api\ReceptionsApiController;
use App\Http\Controllers\Api\CupController;

Route::get('/', function () {
    return view('welcome_sistinpat');
});

Route::get('/menu', function () {
    return view('menu');
})->middleware(['auth', 'verified'])->name('menu');


// API Routes
Route::middleware('auth')->group(function () {
    Route::apiResource('api/cups', CupController::class);
    Route::apiResource('api/patients', PatientApiController::class);
    Route::apiResource('api/receptions', ReceptionsApiController::class);
    Route::get('api/patients/search/{identity}', [PatientApiController::class, 'searchByDocument']);
});

// Web Routes
Route::middleware('auth')->group(function () {
    Route::get('/menu', function () {
        return view('menu');
    })->name('menu');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // routes/web.php
    Route::resource('patients', PatientController::class);

    
    Route::get('/receptions', [ReceptionController::class, 'index'])->name('receptions.index');
    Route::get('/receptions/create', [ReceptionController::class, 'create'])->name('receptions.create');
    Route::get('/receptions/create/patient', [ReceptionController::class, 'createPatient'])->name('receptions.create.patient');
    Route::get('/receptions/create/special', [ReceptionController::class, 'createSpecial'])->name('receptions.create.special');
    Route::post('/receptions', [ReceptionController::class, 'store'])->name('receptions.store');
    Route::get('/receptions/{reception}', [ReceptionController::class, 'show'])->name('receptions.show');
    Route::get('/receptions/{reception}/edit', [ReceptionController::class, 'edit'])->name('receptions.edit');
    Route::put('/receptions/{reception}', [ReceptionController::class, 'update'])->name('receptions.update');
    Route::delete('/receptions/{reception}', [ReceptionController::class, 'destroy'])->name('receptions.destroy');


});

require __DIR__.'/auth.php';
