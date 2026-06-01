<?php
error_reporting(0);
ini_set('display_errors', 0);
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Solo se acepta POST']);
    exit;
}

if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
    http_response_code(400);
    echo json_encode(['error' => 'No se recibió el archivo o hubo un error en la subida']);
    exit;
}

$file = $_FILES['file'];

$allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
if (!in_array($file['type'], $allowed)) {
    http_response_code(400);
    echo json_encode(['error' => 'Tipo de archivo no permitido. Usa jpg, png, gif o webp.']);
    exit;
}

$destino = isset($_POST['destino']) ? trim($_POST['destino']) : 'profesores';
$destinosPermitidos = ['profesores', 'imagenes-promocionales', 'imagen-portada', 'imagen-inhouse-desktop', 'imagen-inhouse-mobile'];
if (!in_array($destino, $destinosPermitidos)) {
    http_response_code(400);
    echo json_encode(['error' => 'Destino no válido']);
    exit;
}

$maxSize = (in_array($destino, ['imagenes-promocionales', 'imagen-portada', 'imagen-inhouse-desktop', 'imagen-inhouse-mobile'])) ? 2.5 * 1024 * 1024 : 2 * 1024 * 1024;
if ($file['size'] > $maxSize) {
    $maxMB = $maxSize / 1024 / 1024;
    http_response_code(400);
    echo json_encode(['error' => "La imagen no debe superar los {$maxMB}MB"]);
    exit;
}

$targetDir = __DIR__ . '/' . $destino . '/';
if (!is_dir($targetDir)) {
    mkdir($targetDir, 0755, true);
}

$ext = pathinfo($file['name'], PATHINFO_EXTENSION);

if ($destino === 'profesores') {
    $nombre = isset($_POST['gradoNombre']) ? trim($_POST['gradoNombre']) : 'profesor';
    $base = preg_replace('/[^a-zA-Z0-9_\-]/', '_', str_replace(' ', '_', $nombre));
} else {
    $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : pathinfo($file['name'], PATHINFO_FILENAME);
    $base = preg_replace('/[^a-zA-Z0-9_\-]/', '_', str_replace(' ', '_', $nombre));
}

$filename = $base . '.' . $ext;
$dest = $targetDir . $filename;
$counter = 1;
while (file_exists($dest)) {
    $filename = $base . '_' . $counter . '.' . $ext;
    $dest = $targetDir . $filename;
    $counter++;
}

if (!move_uploaded_file($file['tmp_name'], $dest)) {
    http_response_code(500);
    echo json_encode(['error' => 'Error al guardar el archivo en el servidor']);
    exit;
}

echo json_encode(['url' => $destino . '/' . $filename]);
