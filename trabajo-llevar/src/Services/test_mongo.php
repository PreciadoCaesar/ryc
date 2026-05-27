<?php
require 'vendor/autoload.php';

try {
    // Esto verifica si la clase existe (gracias a Composer) 
    // y si el driver está cargado (gracias al .dll)
    $manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");
    echo "✅ Driver de MongoDB cargado correctamente.";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage();
}