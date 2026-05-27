<?php
session_start();
require_once __DIR__ . '/../config/config.php'; // Para cargar el autoload y sesiones si es necesario

// Redirigir si no hay sesión
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

$rol_logueado = $_SESSION['rol'] ?? 'usuario'; 
$es_admin_nivel_alto = in_array($rol_logueado, ['gerente', 'desarrollador']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - R&C Consulting</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .hover-card { 
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1); 
            border-radius: 15px !important;
            border: 1px solid #e0e0e0 !important;
        }
        .hover-card:hover { 
            transform: translateY(-5px); 
            border-color: #0d6efd !important; 
            background-color: #f8fbff !important;
            box-shadow: 0 10px 20px rgba(13, 110, 253, 0.1) !important;
        }
        .icon-box { width: 52px; height: 52px; display: flex; align-items: center; justify-content: center; }
        a.hover-card { color: inherit; text-decoration: none; }
    </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-dark mb-4">
    <div class="container">
        <span class="navbar-brand">R&C Consulting System</span>
        <a href="logout.php" class="btn btn-outline-danger btn-sm">Cerrar Sesión</a>
    </div>
</nav>

<div class="container mt-4">
    <div class="alert alert-white shadow-sm border-0">
        <h5>Bienvenido, <strong><?= $_SESSION['email'] ?></strong></h5>
        <span class="badge bg-primary">Rol: <?= strtoupper($rol_logueado) ?></span>
    </div>

    <?php if ($es_admin_nivel_alto): ?>
        <div class="card border-0 shadow-sm rounded-4 mb-4" style="background: #ffffff;">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4 text-dark d-flex align-items-center">
                    <i class="bi bi-grid-1x2-fill me-2 text-primary"></i> 
                    Módulos de Gestión Administrativa
                </h5>
                
                <div class="row g-3">
                    <div class="col-md-6 col-lg-4">
                        <a href="panel_profesores.php" class="btn btn-light border w-100 p-3 text-start shadow-sm hover-card bg-white h-100 d-block">
                            <div class="d-flex align-items-center">
                                <div class="icon-box bg-primary text-white rounded-3 p-2 me-3 shadow-sm">
                                    <i class="bi bi-people-fill fs-4"></i>
                                </div>
                                <div>
                                    <span class="d-block fw-bold text-dark">Panel Profesores</span>
                                    <small class="text-muted">Gestionar CVs en MongoDB</small>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <a href="gestion_usuarios.php" class="btn btn-light border w-100 p-3 text-start shadow-sm hover-card bg-white h-100 d-block">
                            <div class="d-flex align-items-center">
                                <div class="icon-box bg-dark text-white rounded-3 p-2 me-3 shadow-sm">
                                    <i class="bi bi-shield-lock-fill fs-4"></i>
                                </div>
                                <div>
                                    <span class="d-block fw-bold text-dark">Accesos y Roles</span>
                                    <small class="text-muted">Configurar SQLite3</small>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-warning">
            No tienes permisos de administrador para ver los módulos de gestión.
        </div>
    <?php endif; ?>
</div>

</body>
</html>