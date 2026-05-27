<?php
require_once __DIR__ . '/../../vendor/autoload.php';

// Aseguramos que Dotenv cargue las variables antes de usarlas
if (file_exists(__DIR__ . '/.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
}

// Validamos que la URI exista
if (!isset($_ENV['MONGO_URI']) || empty($_ENV['MONGO_URI'])) {
    die("Error crítico: No se encontró MONGO_URI en el archivo .env");
}

try {
    $uri = $_ENV['MONGO_URI'];
    $cliente = new MongoDB\Client($uri);
    
    // Seleccionamos la base de datos (Atlas usará la que pongas aquí)
    $db = $cliente->selectDatabase('rc_consulting'); 
    
    // Colecciones
    $coleccion_profesores = $db->profesores;
    
} catch (Exception $e) {
    die("Error de conexión a MongoDB Atlas: " . $e->getMessage());
}