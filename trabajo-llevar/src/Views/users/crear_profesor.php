<?php
#session_start();
require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../../src/Services/db_mongo.php';

// Seguridad: Solo admin
if (!in_array($_SESSION['rol'], ['gerente', 'desarrollador'])) {
    header("Location: dashboard.php");
    exit();
}

if (isset($_POST['guardar'])) {
    try {
        $nombre = $_POST['nombre'];
        $foto_final = 'https://via.placeholder.com/150'; // Valor por defecto

        // LÓGICA DE SUBIDA DE IMAGEN
        if (isset($_FILES['foto_archivo']) && $_FILES['foto_archivo']['error'] === UPLOAD_ERR_OK) {
            
            // Validar peso (Ejemplo: 2MB máximo)
            $max_size = 2 * 1024 * 1024; 
            if ($_FILES['foto_archivo']['size'] > $max_size) {
                throw new Exception("El archivo es demasiado pesado. El máximo es 2MB.");
            }

            // Validar tipo de archivo
            $allowed_types = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
            $file_type = $_FILES['foto_archivo']['type'];
            if (!in_array($file_type, $allowed_types)) {
                throw new Exception("Formato no permitido. Solo JPG, PNG o WEBP.");
            }

            // Crear carpeta si no existe
            $directorio = __DIR__ . '/../../../public/img/profesores/';
            if (!is_dir($directorio)) {
                mkdir($directorio, 0777, true);
            }

            // Nombre único para evitar sobrescribir
            $extension = pathinfo($_FILES['foto_archivo']['name'], PATHINFO_EXTENSION);
            $nombre_limpio = preg_replace("/[^a-zA-Z0-9]/", "_", $nombre);
            $filename = time() . "_" . $nombre_limpio . "." . $extension;
            $ruta_destino = $directorio . $filename;

            if (move_uploaded_file($_FILES['foto_archivo']['tmp_name'], $ruta_destino)) {
                $foto_final = 'img/profesores/' . $filename;
            }
        }

        $nuevoProfesor = [
            'nombre' => $nombre,
            'foto' => $foto_final,
            'secciones' => [],
            'cursos_vinculados' => [],
            'fecha_creacion' => new MongoDB\BSON\UTCDateTime()
        ];

        $resultado = $coleccion_profesores->insertOne($nuevoProfesor);
        header("Location: editar_profesor.php?id=" . $resultado->getInsertedId());
        exit();

    } catch (Exception $e) {
        $error = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nuevo Profesor | R&C Consulting</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <i class="bi bi-person-plus-fill fs-3"></i>
                        </div>
                        <h3 class="fw-bold">Registrar Staff</h3>
                        <p class="text-muted">Ingresa los datos del docente</p>
                    </div>

                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger border-0 shadow-sm small">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i><?= $error ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Nombre Completo</label>
                            <input type="text" name="nombre" class="form-control form-control-lg" placeholder="Ej: Dr. Marlon Prieto" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold small">Foto de Perfil</label>
                            <input type="file" name="foto_archivo" class="form-control" accept="image/*">
                            <div class="form-text mt-2">
                                <i class="bi bi-info-circle me-1"></i> 
                                <strong>Peso máximo:</strong> 2MB. <br>
                                Formatos permitidos: JPG, PNG o WEBP.
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" name="guardar" class="btn btn-primary btn-lg rounded-3 shadow-sm">
                                <i class="bi bi-cloud-arrow-up-fill me-2"></i>Guardar y Editar CV
                            </button>
                            <a href="panel_profesores.php" class="btn btn-link text-muted text-decoration-none small">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>