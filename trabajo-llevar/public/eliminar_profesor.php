<?php
require_once __DIR__ . '/../config/config.php';

$rol_actual = isset($_SESSION['rol']) ? strtolower(trim($_SESSION['rol'])) : '';

if (!isset($_SESSION['email']) || !in_array($rol_actual, ['gerente', 'desarrollador'])) {
    die("Acceso denegado: No tienes permisos para borrar registros.");
}

// Llamamos al archivo de src que acabas de corregir con los 3 niveles
require_once __DIR__ . '/../src/Views/users/eliminar_profesor.php';