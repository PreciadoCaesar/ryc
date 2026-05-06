<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LeadController;

Route::prefix('api')->group(function () {
    Route::get('/leads', [LeadController::class, 'index']);
    Route::post('/leads', [LeadController::class, 'store']);
    Route::put('/leads/{id}', [LeadController::class, 'update']);
    Route::delete('/leads/{id}', [LeadController::class, 'destroy']);
});
