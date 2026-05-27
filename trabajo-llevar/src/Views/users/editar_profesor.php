<?php
require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../../src/Services/db_mongo.php';

// Importamos la clase con un alias
use MongoDB\BSON\ObjectId as MongoId;

// 1. Validar que exista el ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: panel_profesores.php");
    exit();
}

$id = $_GET['id'];

try {
    $profesor = $coleccion_profesores->findOne(['_id' => new MongoId($id)]);
    if (!$profesor) {
        die("Profesor no encontrado en la base de datos.");
    }
} catch (Exception $e) {
    die("Error con el ID de MongoDB: " . $e->getMessage());
}

// 2. Lógica de Actualización (Incluye Upload)
if (isset($_POST['actualizar'])) {
    $nombre = $_POST['nombre'];
    $foto_final = $_POST['foto_actual']; // Por defecto mantenemos la ruta que ya existe
    $secciones_raw = json_decode($_POST['secciones_json'], true);

    // Procesar nueva foto si se subió una
    if (isset($_FILES['foto_archivo']) && $_FILES['foto_archivo']['error'] === UPLOAD_ERR_OK) {
        
        // Validar Peso (2MB)
        if ($_FILES['foto_archivo']['size'] > 2 * 1024 * 1024) {
            die("Error: El archivo es muy pesado. Máximo 2MB.");
        }

        $directorio = __DIR__ . '/../../../public/img/profesores/';
        if (!is_dir($directorio)) mkdir($directorio, 0777, true);

        $ext = pathinfo($_FILES['foto_archivo']['name'], PATHINFO_EXTENSION);
        $nuevo_nombre = time() . "_" . preg_replace("/[^a-zA-Z0-9]/", "_", $nombre) . "." . $ext;
        
        if (move_uploaded_file($_FILES['foto_archivo']['tmp_name'], $directorio . $nuevo_nombre)) {
            $foto_final = 'img/profesores/' . $nuevo_nombre;
        }
    }

    try {
        $coleccion_profesores->updateOne(
            ['_id' => new MongoId($id)],
            ['$set' => [
                'nombre' => $nombre,
                'foto'   => $foto_final,
                'secciones' => $secciones_raw
            ]]
        );
        header("Location: panel_profesores.php?res=updated");
        exit();
    } catch (Exception $e) {
        die("Error al actualizar: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editor Dinámico - R&C Consulting</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        .seccion-card { border-left: 5px solid #0d6efd; background: #fff; margin-bottom: 20px; transition: all 0.3s; border-radius: 10px; }
        .seccion-card:hover { border-left-color: #0056b3; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        .preview-img { width: 80px; height: 80px; object-fit: cover; border-radius: 10px; border: 2px solid #dee2e6; }
    </style>
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="card shadow-lg p-4 border-0 rounded-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="bi bi-pencil-square text-primary"></i> Perfil: <?= htmlspecialchars($profesor['nombre']) ?></h2>
            <a href="panel_profesores.php" class="btn btn-outline-secondary btn-sm">Cancelar y Volver</a>
        </div>

        <form id="formProfesor" method="POST" enctype="multipart/form-data">
            
            <input type="hidden" name="foto_actual" value="<?= $profesor['foto'] ?>">

            <div class="row mb-4 align-items-center">
                <div class="col-md-5">
                    <label class="form-label fw-bold small">Nombre del Profesor</label>
                    <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($profesor['nombre']) ?>" required>
                </div>
                <div class="col-md-5">
                    <label class="form-label fw-bold small">Cambiar Foto (Máx 2MB)</label>
                    <input type="file" name="foto_archivo" class="form-control" accept="image/*">
                </div>
                <div class="col-md-2 text-center">
                    <label class="form-label fw-bold small d-block">Actual</label>
                    <img src="<?= BASE_URL . $profesor['foto'] ?>" class="preview-img shadow-sm">
                </div>
            </div>

            <hr class="text-muted">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="m-0 text-dark">Estructura del Currículum</h4>
                <button type="button" class="btn btn-primary shadow-sm" onclick="agregarSeccion()">
                    <i class="bi bi-plus-lg"></i> Nueva Sección
                </button>
            </div>

            <div id="contenedorSecciones"></div>
            <input type="hidden" name="secciones_json" id="secciones_json">

            <div class="mt-5 pt-4">
                <button type="submit" name="actualizar" class="btn btn-success btn-lg w-100 shadow" onclick="prepararEnvio()">
                    <i class="bi bi-cloud-arrow-up-fill me-2"></i> Guardar Cambios en MongoDB Atlas
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    let secciones = <?= json_encode($profesor['secciones'] ?? []) ?>;
    
    function renderizar() {
        const contenedor = document.getElementById('contenedorSecciones');
        contenedor.innerHTML = '';
        secciones.forEach((sec, sIdx) => {
            let htmlItems = sec.items.map((item, iIdx) => `
                <div class="d-flex mb-2">
                    <input type="text" class="form-control form-control-sm" value="${item.replace(/"/g, '&quot;')}" onchange="actualizarItem(${sIdx}, ${iIdx}, this.value)">
                    <button type="button" class="btn btn-outline-danger btn-sm ms-2" onclick="eliminarItem(${sIdx}, ${iIdx})"><i class="bi bi-trash"></i></button>
                </div>
            `).join('');

            contenedor.innerHTML += `
                <div class="card seccion-card shadow-sm p-3 border-0">
                    <div class="d-flex justify-content-between mb-2">
                        <input type="text" class="form-control fw-bold border-0 bg-light" value="${sec.titulo.replace(/"/g, '&quot;')}" onchange="actualizarTitulo(${sIdx}, this.value)" placeholder="Ej: Formación Profesional">
                        <button type="button" class="btn btn-danger btn-sm ms-2" onclick="eliminarSeccion(${sIdx})"><i class="bi bi-x-lg"></i></button>
                    </div>
                    <div class="ps-4 mt-2">
                        <div id="items-sec-${sIdx}">${htmlItems}</div>
                        <button type="button" class="btn btn-link btn-sm text-primary p-0 text-decoration-none" onclick="agregarItem(${sIdx})">+ Añadir punto</button>
                    </div>
                </div>
            `;
        });
    }

    function agregarSeccion() { secciones.push({ titulo: "Nueva Sección", items: [""] }); renderizar(); }
    function eliminarSeccion(idx) { secciones.splice(idx, 1); renderizar(); }
    function actualizarTitulo(idx, valor) { secciones[idx].titulo = valor; }
    function agregarItem(sIdx) { secciones[sIdx].items.push(""); renderizar(); }
    function actualizarItem(sIdx, iIdx, valor) { secciones[sIdx].items[iIdx] = valor; }
    function eliminarItem(sIdx, iIdx) { secciones[sIdx].items.splice(iIdx, 1); renderizar(); }
    function prepararEnvio() { document.getElementById('secciones_json').value = JSON.stringify(secciones); }

    renderizar();
</script>
</body>
</html>