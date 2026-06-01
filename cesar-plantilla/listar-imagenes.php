<?php
header('Content-Type: application/json');

$carpeta = isset($_GET['carpeta']) ? trim($_GET['carpeta']) : 'imagenes-promocionales';
$carpetasPermitidas = ['imagenes-promocionales', 'imagen-portada', 'imagen-inhouse-desktop', 'imagen-inhouse-mobile'];

if (!in_array($carpeta, $carpetasPermitidas)) {
    echo json_encode([]);
    exit;
}

$dir = './' . $carpeta . '/';
$images = [];

if (!is_dir($dir)) {
    echo json_encode([]);
    exit;
}

$allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
$files = scandir($dir);

foreach ($files as $file) {
    if ($file === '.' || $file === '..') continue;
    $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
    if (!in_array($ext, $allowed)) continue;
    $images[] = [
        'name' => $file,
        'url' => $carpeta . '/' . $file
    ];
}

echo json_encode($images);
