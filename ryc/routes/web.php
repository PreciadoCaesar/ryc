<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\Admin\CourseController as AdminCourseController;
use App\Http\Controllers\SuscripcionController;
use App\Models\Course;

Route::prefix('api')->group(function () {
    Route::get('/courses', [CourseController::class, 'index']);
    Route::get('/courses/featured', [CourseController::class, 'featured']);
    Route::get('/courses/{slug}', [CourseController::class, 'show']);
    Route::get('/courses/{slug}/page', [CourseController::class, 'page']);

    Route::prefix('admin')->group(function () {
        Route::get('/courses', [AdminCourseController::class, 'index']);
        Route::post('/courses', [AdminCourseController::class, 'store']);
        Route::put('/courses/{id}', [AdminCourseController::class, 'update']);
        Route::delete('/courses/{id}', [AdminCourseController::class, 'destroy']);
        Route::post('/courses/{id}/page', [AdminCourseController::class, 'savePage']);
    });
});

Route::get('/', function () {
    // Initialize empty arrays for courses
    $cursosEnVivo = [];
    $diplomadosEnVivo = [];
    $cursosOnline = [];
    $diplomadosOnline = [];
    
    // Load courses data from the original file
    $cursosFile = base_path('paginaPrincipal - copia/cursos.php');
    if (file_exists($cursosFile)) {
        require $cursosFile;
    }

    // Ensure all variables are arrays (defensive)
    if (!isset($cursosEnVivo) || !is_array($cursosEnVivo)) $cursosEnVivo = [];
    if (!isset($diplomadosEnVivo) || !is_array($diplomadosEnVivo)) $diplomadosEnVivo = [];
    if (!isset($cursosOnline) || !is_array($cursosOnline)) $cursosOnline = [];
    if (!isset($diplomadosOnline) || !is_array($diplomadosOnline)) $diplomadosOnline = [];
    
    $cursosEnVivo = array_values($cursosEnVivo);
    $diplomadosEnVivo = array_values($diplomadosEnVivo);
    $cursosOnline = array_values($cursosOnline);
    $diplomadosOnline = array_values($diplomadosOnline);

    return view('home', compact('cursosEnVivo', 'diplomadosEnVivo', 'cursosOnline', 'diplomadosOnline'));
});

// Rutas de Suscripciones/Membresías
Route::prefix('suscripciones')->group(function () {
    Route::get('/', [SuscripcionController::class, 'index'])->name('suscripciones.index');
    Route::post('/', [SuscripcionController::class, 'store'])->name('suscripciones.store');
});

// Ruta de Nosotros
Route::get('/nosotros', function () {
    return view('nosotros');
});

Route::get('/experiencia', function () {
    return view('experiencia');
});

// Rutas de Cursos
Route::get('/curso/{slug}', [App\Http\Controllers\CursoController::class, 'mostrar'])->name('curso.mostrar');
Route::get('/formulario', [App\Http\Controllers\CursoController::class, 'formulario'])->name('cursos.formulario');
Route::post('/cursos', [App\Http\Controllers\CursoController::class, 'store'])->name('cursos.store');

// Rutas Admin de Cursos (temporales sin auth)
Route::get('/admin/cursos', [App\Http\Controllers\CursoController::class, 'index'])->name('cursos.index');
Route::get('/admin/cursos/{id}/editar', [App\Http\Controllers\CursoController::class, 'edit'])->name('cursos.editar');
Route::put('/admin/cursos/{id}', [App\Http\Controllers\CursoController::class, 'update'])->name('cursos.update');
Route::delete('/admin/cursos/{id}', [App\Http\Controllers\CursoController::class, 'destroy'])->name('cursos.destroy');

// Ruta para la asesora - Excel de leads
Route::get('/asesora/leads', function () {
    return view('asesora.leads');
})->name('asesora.leads');

// TallCMS Blog Routes (cuando se instale)
// Route::group(['prefix' => 'blog', 'middleware' => ['web']], function () {
//     // Estas rutas se activarán después de instalar TallCMS
//     // Route::get('/', [TallCmsController::class, 'index'])->name('tallcms.blog.index');
//     // Route::get('/{slug}', [TallCmsController::class, 'show'])->name('tallcms.blog.show');
// });

Route::get('/{path}', function () {
    // Initialize empty arrays for courses
    $cursosEnVivo = [];
    $diplomadosEnVivo = [];
    $cursosOnline = [];
    $diplomadosOnline = [];
    
    // Load courses data from the original file
    $cursosFile = base_path('paginaPrincipal - copia/cursos.php');
    if (file_exists($cursosFile)) {
        require $cursosFile;
    }

    // Ensure all variables are arrays (defensive)
    if (!isset($cursosEnVivo) || !is_array($cursosEnVivo)) $cursosEnVivo = [];
    if (!isset($diplomadosEnVivo) || !is_array($diplomadosEnVivo)) $diplomadosEnVivo = [];
    if (!isset($cursosOnline) || !is_array($cursosOnline)) $cursosOnline = [];
    if (!isset($diplomadosOnline) || !is_array($diplomadosOnline)) $diplomadosOnline = [];
    
    $cursosEnVivo = array_values($cursosEnVivo);
    $diplomadosEnVivo = array_values($diplomadosEnVivo);
    $cursosOnline = array_values($cursosOnline);
    $diplomadosOnline = array_values($diplomadosOnline);

    return view('home', compact('cursosEnVivo', 'diplomadosEnVivo', 'cursosOnline', 'diplomadosOnline'));
})->where('path', '.*');
