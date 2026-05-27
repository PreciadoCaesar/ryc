<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h3>Diagnóstico de Rutas:</h3>";
echo "Directorio actual: " . __DIR__ . "<br>";

$autoload = __DIR__ . '/vendor/autoload.php';
if (file_exists($autoload)) {
    echo "✅ Autoload encontrado.<br>";
    require_once $autoload;
} else {
    die("❌ Error: No se encuentra el archivo en $autoload");
}

$dotenv_path = __DIR__ . '/vendor/vlucas/phpdotenv/src/Dotenv.php';
if (file_exists($dotenv_path)) {
    echo "✅ Archivo de la clase Dotenv encontrado.<br>";
} else {
    echo "❌ Error: La librería phpdotenv no está en $dotenv_path <br>";
}

// Intentar instanciar manualmente
if (class_exists('Dotenv\Dotenv')) {
    echo "✅ La clase Dotenv\Dotenv está cargada correctamente.";
} else {
    echo "❌ La clase Dotenv\Dotenv SIGUE SIN SER RECONOCIDA.";
}