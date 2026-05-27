<?php
require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../../src/Services/db_mongo.php';

// Importamos la clase para manejar IDs de MongoDB
use MongoDB\BSON\ObjectId as MongoId;

// Seguridad: Solo admin
if (!in_array($_SESSION['rol'], ['gerente', 'desarrollador'])) {
    header("Location: dashboard.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        // 1. Opcional: Buscar el profesor para saber qué foto borrar del servidor
        $profesor = $coleccion_profesores->findOne(['_id' => new MongoId($id)]);
        
        if ($profesor) {
            // Borrar la foto física si existe y no es una URL externa
            $ruta_foto = __DIR__ . '/' . $profesor['foto'];
            if (file_exists($ruta_foto) && is_file($ruta_foto)) {
                unlink($ruta_foto); 
            }

            // 2. Eliminar de la base de datos en Atlas
            $resultado = $coleccion_profesores->deleteOne(['_id' => new MongoId($id)]);

            if ($resultado->getDeletedCount() > 0) {
                header("Location: panel_profesores.php?res=deleted");
            } else {
                header("Location: panel_profesores.php?error=notfound");
            }
        }
    } catch (Exception $e) {
        die("Error al eliminar: " . $e->getMessage());
    }
} else {
    header("Location: panel_profesores.php");
}