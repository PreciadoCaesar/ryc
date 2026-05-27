<?php
require_once __DIR__ . '/../config/config.php';

// Seguridad estricta: Verificamos si el rol NO está en la lista permitida
if (!isset($_SESSION['email']) || !in_array($_SESSION['rol'], ['gerente', 'desarrollador'])) {
    die("Acceso denegado: No tienes permisos para borrar registros.");
}

// Si pasa la validación, llamamos al proceso real
require_once __DIR__ . '/../src/Views/users/eliminar_profesor.php';