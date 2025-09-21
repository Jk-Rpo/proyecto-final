<?php

use App\Http\Controllers\Api\ReceptionController;
use App\Http\Controllers\Api\PatientController;
use App\Http\Controllers\Api\CupController;

Route::apiResource('receptions', ReceptionController::class);
Route::get('patients', [PatientController::class,'index']);
Route::get('cups', [CupController::class,'index']);
