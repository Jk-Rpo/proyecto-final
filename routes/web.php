<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\CupController;
use App\Http\Controllers\ReceptionController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // routes/web.php
    Route::resource('patients', PatientController::class);

    
    Route::get('/receptions', [ReceptionController::class, 'index'])->name('receptions.index');
    Route::get('/receptions/create', [ReceptionController::class, 'create'])->name('receptions.create');
    Route::post('/receptions', [ReceptionController::class, 'store'])->name('receptions.store');
    Route::get('/receptions/{reception}', [ReceptionController::class, 'show'])->name('receptions.show');
    Route::get('/receptions/{reception}/edit', [ReceptionController::class, 'edit'])->name('receptions.edit');
    Route::put('/receptions/{reception}', [ReceptionController::class, 'update'])->name('receptions.update');
    Route::delete('/receptions/{reception}', [ReceptionController::class, 'destroy'])->name('receptions.destroy');


});

require __DIR__.'/auth.php';
