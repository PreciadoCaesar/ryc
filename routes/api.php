<?php
// ⚠️ SEGURIDAD: Este archivo NO está cargado por bootstrap/app.php
// Las rutas API están definidas y protegidas en routes/web.php
// Si en el futuro se activa api.php, asegúrate de agregar middleware ['auth', 'admin.access']
// a las rutas sensibles: /leads (GET/PUT/DELETE), /upload-imagen, /listar-imagenes

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LeadController;
use App\Http\Controllers\Api\ImageController;

Route::prefix('api')->group(function () {
    Route::post('/leads', [LeadController::class, 'store']); // Público para formularios

    Route::middleware(['auth', 'admin.access'])->group(function () {
        Route::get('/leads', [LeadController::class, 'index']);
        Route::put('/leads/{id}', [LeadController::class, 'update']);
        Route::delete('/leads/{id}', [LeadController::class, 'destroy']);

        Route::post('/upload-imagen', [ImageController::class, 'upload']);
        Route::get('/listar-imagenes', [ImageController::class, 'listar']);
    });
});
