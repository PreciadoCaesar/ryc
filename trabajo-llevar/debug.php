<?php
echo "<h1>Diagnóstico de Ruta</h1>";
echo "Ruta absoluta: " . __DIR__ . "<br>";
echo "PHP Version: " . phpversion() . "<br>";
if (file_exists('vendor/autoload.php')) {
    echo "✅ Vendor encontrado.";
} else {
    echo "❌ Vendor NO encontrado en esta carpeta.";
}