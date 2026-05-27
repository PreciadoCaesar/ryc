<?php
#session_start();
require_once __DIR__ . '/../../../config/config.php';

// Línea 4: Subir 3 niveles para llegar a la raíz y luego entrar a src/Services
require_once __DIR__ . '/../../../src/Services/db_mongo.php';

// 1. Obtener todos los profesores ordenados alfabéticamente
try {
    $profesores = $coleccion_profesores->find([], ['sort' => ['nombre' => 1]]);
} catch (Exception $e) {
    die("Error al conectar con Atlas: " . $e->getMessage());
}

// 2. Traducción de mensajes de respuesta
$mensaje = "";
if (isset($_GET['res'])) {
    if ($_GET['res'] == 'deleted') $mensaje = ["tipo" => "success", "texto" => "¡Docente eliminado correctamente!", "icon" => "bi-trash"];
    if ($_GET['res'] == 'updated') $mensaje = ["tipo" => "info", "texto" => "Perfil actualizado con éxito.", "icon" => "bi-check-all"];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Staff | R&C Consulting</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root { --rc-blue: #002e5b; --rc-red: #e60026; --rc-light-bg: #f4f7f9; }

        body { background-color: var(--rc-light-bg); font-family: 'Inter', 'Segoe UI', sans-serif; }

        /* Tarjeta Estilo Premium */
        .profesor-card { 
            border: none; 
            border-radius: 16px; 
            transition: all 0.3s cubic-bezier(.25,.8,.25,1);
            background: #fff;
            height: 100%;
        }
        .profesor-card:hover { 
            transform: translateY(-10px); 
            box-shadow: 0 20px 40px rgba(0,46,91,0.12) !important; 
        }

        /* Contenedor Cuadrado de R&C */
        .img-container {
            width: 100%;
            aspect-ratio: 1 / 1; 
            overflow: hidden;
            background-color: #f0f0f0;
            border-bottom: 1px solid #eee;
        }
        
        .profesor-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        
        .profesor-card:hover .profesor-img { transform: scale(1.1); }

        .nombre-profesor {
            font-size: 0.95rem;
            font-weight: 800;
            color: var(--rc-blue);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            /* Forzar 2 líneas máximo para alineación */
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            height: 2.8rem;
        }

        .btn-rc-blue { background-color: var(--rc-blue); color: white; border: none; font-weight: 600; }
        .btn-rc-blue:hover { background-color: #00152a; color: white; }
        
        .btn-outline-rc { border: 2px solid #e9ecef; color: #6c757d; font-weight: 700; font-size: 0.75rem; transition: 0.2s; }
        .btn-outline-rc:hover { background: #e9ecef; color: var(--rc-blue); }

        .badge-sections { background: #eef2f7; color: var(--rc-blue); font-weight: 600; border: 1px solid #d0d9e4; }
    </style>
</head>
<body>

<div class="container py-5">
    <?php if ($mensaje): ?>
        <div class="alert alert-<?= $mensaje['tipo'] ?> alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" role="alert">
            <i class="bi <?= $mensaje['icon'] ?> me-2"></i> <?= $mensaje['texto'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="row align-items-center mb-5">
        <div class="col-md-7">
            <h1 class="fw-bold text-dark m-0"><i class="bi bi-people-fill text-primary me-2"></i>Gestión de Staff</h1>
            <p class="text-muted mb-0 small text-uppercase fw-semibold tracking-wider">Base de Datos NoSQL (MongoDB Atlas) • R&C Consulting</p>
        </div>
        <div class="col-md-5 text-md-end mt-3 mt-md-0">
            <a href="dashboard.php" class="btn btn-light border-0 shadow-sm px-4 me-2 rounded-3 fw-bold text-muted">
                <i class="bi bi-arrow-left me-1"></i> Volver
            </a>
            <a href="crear_profesor.php" class="btn btn-primary px-4 shadow rounded-3 fw-bold">
                <i class="bi bi-person-plus-fill me-2"></i>Nuevo Profesor
            </a>
        </div>
    </div>

    <div class="row g-4">
        <?php foreach ($profesores as $p): ?>
            <div class="col-sm-6 col-md-4 col-xl-3">
                <div class="card profesor-card shadow-sm border-0">
                    <div class="img-container">
    <?php 
        $ruta_final = BASE_URL . $p['foto'];
        // ESTO MOSTRARÁ LA RUTA EN PANTALLA PARA DEBUGEAR
        // echo "<small class='text-danger'>URL generada: " . $ruta_final . "</small>";
    ?>
    <img src="<?= $ruta_final ?>" class="profesor-img">
</div>
                    <div class="card-body text-center d-flex flex-column p-4">
                        <h5 class="nombre-profesor mb-3"><?= htmlspecialchars($p['nombre']) ?></h5>
                        
                        <div class="mb-4">
                            <span class="badge badge-sections px-3 py-2 rounded-pill small">
                                <i class="bi bi-list-stars me-1 text-primary"></i> 
                                <?= count($p['secciones'] ?? []) ?> Secciones CV
                            </span>
                        </div>

                        <div class="mt-auto">
                            <a href="editar_profesor.php?id=<?= $p['_id'] ?>" class="btn btn-rc-blue w-100 mb-2 py-2 shadow-sm rounded-3">
                                <i class="bi bi-pencil-square me-2"></i>Editar Perfil
                            </a>
                            <a href="ver_profesor.php?id=<?= $p['_id'] ?>" target="_blank" class="btn btn-outline-rc w-100 mb-3 py-2 rounded-3 text-uppercase">
                                <i class="bi bi-eye-fill me-1"></i> Vista Pública
                            </a>
                            
                            <div class="border-top pt-3">
                                <a href="eliminar_profesor.php?id=<?= $p['_id'] ?>" 
                                   class="text-danger small text-decoration-none fw-bold op-7"
                                   onclick="return confirm('¿Estás seguro de eliminar a <?= addslashes($p['nombre']) ?>? Esta acción borrará permanentemente el registro en Atlas.')">
                                    <i class="bi bi-trash3-fill me-1"></i> Eliminar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>