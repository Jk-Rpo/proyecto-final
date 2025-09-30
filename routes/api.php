<?php

use App\Http\Controllers\Api\PatientApiController;
use App\Http\Controllers\Api\ReceptionsApiController;




// routes/api.php
Route::apiResource('patients', PatientApiController::class);
Route::apiResource('receptions', ReceptionsApiController::class);
Route::get('patients/search/{identity}', [PatientApiController::class, 'searchByDocument']);