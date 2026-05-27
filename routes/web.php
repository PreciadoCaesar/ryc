<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\Admin\CourseController as AdminCourseController;
use App\Http\Controllers\Api\LeadController as ApiLeadController;
use App\Http\Controllers\SuscripcionController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ProfessorController as AdminProfessorController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Admin\AdvisorController as AdminAdvisorController;
use App\Models\Course;

// Google OAuth Routes
Route::prefix('auth')->group(function () {
    Route::get('/google', [GoogleController::class, 'redirect'])->name('auth.google');
    Route::get('/google/callback', [GoogleController::class, 'callback'])->name('auth.google.callback');
    Route::get('/logout', [GoogleController::class, 'logout'])->name('auth.logout');
});

// Login route (required by Laravel's auth middleware)
Route::get('/login', function () {
    return redirect()->route('auth.google');
})->name('login');

Route::prefix('api')->group(function () {
    Route::get('/courses', [CourseController::class, 'index']);
    Route::get('/courses/featured', [CourseController::class, 'featured']);
    Route::get('/courses/{slug}', [CourseController::class, 'show']);
    Route::get('/courses/{slug}/page', [CourseController::class, 'page']);

    Route::middleware(['auth'])->prefix('admin')->group(function () {
        Route::get('/courses', [AdminCourseController::class, 'index']);
        Route::post('/courses', [AdminCourseController::class, 'store']);
        Route::put('/courses/{id}', [AdminCourseController::class, 'update']);
        Route::delete('/courses/{id}', [AdminCourseController::class, 'destroy']);
        Route::post('/courses/{id}/page', [AdminCourseController::class, 'savePage']);
    });

    Route::get('/leads', [ApiLeadController::class, 'index']);
    Route::post('/leads', [ApiLeadController::class, 'store']);
    Route::put('/leads/{id}', [ApiLeadController::class, 'update']);
    Route::delete('/leads/{id}', [ApiLeadController::class, 'destroy']);
});

Route::get('/', function () {
    // Carga automática desde base de datos (reemplaza cursos.php)
    $courses = App\Models\Course::where('status', 'activo')->orWhereNull('status')->get();

    $cursosEnVivo = $courses->where('type', 'curso')->where('mode', 'en_vivo')->values();
    $diplomadosEnVivo = $courses->where('type', 'diplomado')->where('mode', 'en_vivo')->values();
    $cursosOnline = $courses->where('type', 'curso')->where('mode', 'grabado')->values();
    $diplomadosOnline = $courses->where('type', 'diplomado')->where('mode', 'grabado')->values();

    return view('home', compact('cursosEnVivo', 'diplomadosEnVivo', 'cursosOnline', 'diplomadosOnline'));
});

// Rutas de Suscripciones/Membresías
Route::prefix('suscripciones')->group(function () {
    Route::get('/', [SuscripcionController::class, 'index'])->name('suscripciones.index');
    Route::post('/', [SuscripcionController::class, 'store'])->name('suscripciones.store');
});

// Rutas de Carrito de Compras
Route::prefix('carrito')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('carrito.index');
    Route::get('/precios', [CartController::class, 'precios'])->name('carrito.precios');
    Route::post('/agregar/{course}', [CartController::class, 'add'])->name('carrito.add');
    Route::post('/comprar/{course}', [CartController::class, 'buy'])->name('carrito.buy');
    Route::delete('/eliminar/{item}', [CartController::class, 'remove'])->name('carrito.remove');
    Route::post('/vaciar', [CartController::class, 'clear'])->name('carrito.clear');
});

// Rutas de Checkout
Route::prefix('checkout')->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/confirmacion', [CheckoutController::class, 'confirmacion'])->name('checkout.confirmacion');

    Route::get('/pagar', [PaymentController::class, 'index'])->name('checkout.payment');
    Route::match(['get', 'post'], '/exito', [PaymentController::class, 'success'])->name('checkout.success');
    Route::match(['get', 'post'], '/cancelado', [PaymentController::class, 'cancel'])->name('checkout.cancel');
});

// Redirección por si Krypton navega a /exito (sin prefijo checkout)
Route::match(['get', 'post'], '/exito', function () {
    return redirect()->route('checkout.success');
})->name('exito.fallback');

Route::post('/izipay/ipn', [PaymentController::class, 'ipn'])->name('izipay.ipn');

// Rutas de catálogos online
Route::get('/cursos-virtuales', [App\Http\Controllers\CursoController::class, 'catalogoCursos'])->name('cursos-virtuales');
Route::get('/diplomas-virtuales', [App\Http\Controllers\CursoController::class, 'catalogoDiplomas'])->name('diplomas-virtuales');

// Rutas del Libro de Reclamaciones
use App\Http\Controllers\LibroReclamacionesController;

Route::prefix('libro-de-reclamaciones')->name('libro-reclamaciones.')->group(function () {
    Route::get('/', [LibroReclamacionesController::class, 'index'])->name('index');
    Route::get('/buscar', [LibroReclamacionesController::class, 'buscar'])->name('buscar');
    Route::get('/detalle', [LibroReclamacionesController::class, 'detalle'])->name('detalle');
    Route::get('/seguimiento', [LibroReclamacionesController::class, 'seguimiento'])->name('seguimiento');
    Route::post('/upload', [LibroReclamacionesController::class, 'upload'])->name('upload');
    Route::post('/update-estado', [LibroReclamacionesController::class, 'updateEstado'])->name('update-estado');
    Route::match(['get', 'post'], '/webhook', [LibroReclamacionesController::class, 'webhook'])->name('webhook');
    Route::get('/descargar/{id}', [LibroReclamacionesController::class, 'descargarArchivo'])->name('descargar');
    Route::get('/pdf', [LibroReclamacionesController::class, 'generarPdf'])->name('pdf');
});

// Ruta del panel gestor (URL pública independiente)
Route::get('/rc-gestor-reclamos', [LibroReclamacionesController::class, 'gestor'])->name('rc-gestor-reclamos');

// Ruta de Inhouse
Route::get('/inhouse', function () {
    return view('inhouse.index');
})->name('inhouse');

// Ruta de Cursos Inhouse
Route::get('/cursos-inhouse', function () {
    return view('cursos-inhouse.index');
})->name('cursos-inhouse');

// Ruta de Certificados
Route::get('/certificados', function () {
    return view('certificados.index');
})->name('certificados');

// Ruta de Nosotros
Route::get('/nosotros', function () {
    return view('nosotros');
});

Route::get('/experiencia', function () {
    return view('experiencia');
});

// Perfil de usuario (protegido con auth)
Route::middleware(['auth'])->get('/perfil', [ProfileController::class, 'index'])->name('perfil');

// Rutas de Cursos
Route::get('/curso/{slug}', [App\Http\Controllers\CursoController::class, 'mostrar'])->name('curso.mostrar');
Route::post('/cursos', [App\Http\Controllers\CursoController::class, 'store'])->name('cursos.store');

// Dashboard Admin (protegido con auth)
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        $user = auth()->user();
        $advisor = $user->advisor;

        if ($advisor) {
            $courseTitles = \App\Models\Course::where('advisor_id', $advisor->id)
                ->orWhere('asesora_id', $advisor->id)
                ->pluck('title');
            $totalCursos = $courseTitles->count();
            $totalLeads = \App\Models\Lead::where(function ($q) use ($courseTitles, $advisor) {
                $q->whereIn('curso', $courseTitles)->orWhere('advisor_id', $advisor->id);
            })->count();
            $ventasCerradas = \App\Models\Lead::where(function ($q) use ($courseTitles, $advisor) {
                $q->whereIn('curso', $courseTitles)->orWhere('advisor_id', $advisor->id);
            })->where('status', 'venta cerrada')->count();
        } else {
            $totalCursos = \App\Models\Course::count();
            $totalLeads = \App\Models\Lead::count();
            $ventasCerradas = \App\Models\Lead::where('status', 'venta cerrada')->count();
        }
        $totalAdvisors = \App\Models\Advisor::count();

        return view('admin.dashboard', compact('totalCursos', 'totalLeads', 'totalAdvisors', 'ventasCerradas'));
    })->name('admin.dashboard');

    Route::get('/leads', [LeadController::class, 'index'])->name('leads.index');
    Route::get('/leads/export/{advisorId}', [LeadController::class, 'exportExcel'])->name('leads.export');
    Route::get('/leads/export-course/{courseName}', [LeadController::class, 'exportExcelByCourse'])->name('leads.export.course');
    Route::post('/leads/{id}/status', [LeadController::class, 'updateStatus'])->name('leads.updateStatus');

    Route::get('/usuarios', [AdminUserController::class, 'index'])->name('admin.users.index');
    Route::post('/usuarios', [AdminUserController::class, 'store'])->name('admin.users.store');
    Route::put('/usuarios/{id}', [AdminUserController::class, 'update'])->name('admin.users.update');
    Route::delete('/usuarios/{id}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');

    Route::get('/cursos', [App\Http\Controllers\CursoController::class, 'index'])->name('cursos.index');
    Route::get('/cursos/create', [App\Http\Controllers\CursoController::class, 'create'])->name('cursos.create');
    Route::get('/cursos/{id}/editar', [App\Http\Controllers\CursoController::class, 'edit'])->name('cursos.editar');
    Route::put('/cursos/{id}', [App\Http\Controllers\CursoController::class, 'update'])->name('cursos.update');
    Route::delete('/cursos/{id}', [App\Http\Controllers\CursoController::class, 'destroy'])->name('cursos.destroy');

    Route::get('/profesores', [AdminProfessorController::class, 'index'])->name('admin.profesores.index');
    Route::post('/profesores', [AdminProfessorController::class, 'store'])->name('admin.profesores.store');
    Route::put('/profesores/{id}', [AdminProfessorController::class, 'update'])->name('admin.profesores.update');
    Route::delete('/profesores/{id}', [AdminProfessorController::class, 'destroy'])->name('admin.profesores.destroy');

    Route::get('/asesoras', [AdminAdvisorController::class, 'index'])->name('admin.advisors.index');
    Route::put('/asesoras/{id}', [AdminAdvisorController::class, 'update'])->name('admin.advisors.update');
});
