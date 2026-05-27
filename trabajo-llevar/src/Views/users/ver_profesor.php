<?php
require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../../src/Services/db_mongo.php';
use MongoDB\BSON\ObjectId as MongoId;

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID no proporcionado.");
}

$id = $_GET['id'];

try {
    $profesor = $coleccion_profesores->findOne(['_id' => new MongoId($id)]);
    if (!$profesor) die("Docente no encontrado.");
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil: <?= htmlspecialchars($profesor['nombre']) ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root { --rc-blue: #002e5b; --rc-red: #e60026; }
        body { background-color: #f0f2f5; font-family: 'Inter', sans-serif; }
        
        .main-card { border: none; border-radius: 20px; overflow: hidden; }
        .bg-rc { background-color: var(--rc-blue); color: white; }
        
        .foto-perfil { 
            width: 100%; 
            border-radius: 15px; 
            border: 5px solid white;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        
        .section-title { 
            color: var(--rc-blue); 
            font-weight: 800; 
            text-transform: uppercase; 
            font-size: 0.9rem;
            letter-spacing: 1px;
            border-bottom: 2px solid #eee;
            padding-bottom: 10px;
        }

        .list-cv { list-style: none; padding-left: 0; }
        .list-cv li { position: relative; padding-left: 25px; margin-bottom: 12px; color: #4a5568; line-height: 1.6; }
        .list-cv li::before { 
            content: "\F2E5"; 
            font-family: "bootstrap-icons"; 
            position: absolute; 
            left: 0; 
            color: var(--rc-blue); 
            font-weight: bold;
        }

        .badge-curso { 
            background: white; 
            border: 1px solid #e2e8f0; 
            padding: 12px 20px; 
            border-radius: 12px; 
            display: flex; 
            align-items: center;
            transition: 0.3s;
        }
        .badge-curso:hover { border-color: var(--rc-blue); box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="panel_profesores.php" class="text-decoration-none">Staff</a></li>
                <li class="breadcrumb-item active fw-bold"><?= htmlspecialchars($profesor['nombre']) ?></li>
            </ol>
        </nav>
        <a href="panel_profesores.php" class="btn btn-white bg-white shadow-sm rounded-pill px-4 fw-bold">
            <i class="bi bi-arrow-left me-2"></i>Volver al Panel
        </a>
    </div>

    <div class="card main-card shadow-lg p-4 p-md-5 bg-white">
        <div class="row g-5">
            <div class="col-lg-8">
                <h1 class="display-5 fw-800 mb-2 text-dark"><?= htmlspecialchars($profesor['nombre']) ?></h1>
                <p class="text-primary fw-bold mb-5">
                    <i class="bi bi-patch-check-fill me-1"></i> Staff Académico R&C Consulting
                </p>

                <?php if (!empty($profesor['secciones'])): ?>
                    <?php foreach ($profesor['secciones'] as $sec): ?>
                        <div class="mb-5">
                            <h5 class="section-title mb-3"><?= htmlspecialchars($sec['titulo']) ?></h5>
                            <ul class="list-cv">
                                <?php foreach ($sec['items'] as $item): ?>
                                    <li><?= htmlspecialchars($item) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="alert alert-light border-0 py-4 text-center">
                        <i class="bi bi-info-circle fs-2 d-block mb-2 text-muted"></i>
                        Información curricular pendiente de actualización.
                    </div>
                <?php endif; ?>
            </div>

            <div class="col-lg-4">
                <div class="sticky-top" style="top: 20px;">
                    <img src="<?= $profesor['foto'] ?>" class="foto-perfil mb-4" alt="Foto Docente">
                    
                    <div class="bg-light p-4 rounded-4 text-center">
                        <h6 class="fw-bold mb-3 small text-uppercase">¿Necesitas asesoría?</h6>
                        <a href="https://wa.me/51950883155" target="_blank" class="btn btn-success w-100 rounded-pill py-2 shadow-sm">
                            <i class="bi bi-whatsapp me-2"></i>Contactar con R&C
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <hr class="my-5 opacity-10">

        <div class="row">
            <div class="col-12">
                <h4 class="fw-800 text-dark mb-4">
                    <i class="bi bi-mortarboard-fill text-primary me-2"></i>
                    Cursos y Diplomados Vinculados
                </h4>
                
                <?php if (!empty($profesor['cursos_vinculados'])): ?>
                    <div class="row g-3">
                        <?php foreach ($profesor['cursos_vinculados'] as $curso): ?>
                            <div class="col-md-6">
                                <div class="badge-curso h-100">
                                    <div class="bg-primary bg-opacity-10 p-2 rounded-3 me-3 text-primary">
                                        <i class="bi bi-journal-text fs-5"></i>
                                    </div>
                                    <span class="fw-semibold text-muted small"><?= htmlspecialchars($curso) ?></span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="p-4 rounded-4 border text-center text-muted">
                        <i class="bi bi-calendar-x me-2"></i>
                        Actualmente el docente no tiene cursos asignados para este ciclo.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>