<?php
require_once __DIR__ . '/../config/config.php';

// Seguridad: Solo admin/gerente
if (!isset($_SESSION['email']) || !in_array($_SESSION['rol'], ['gerente', 'desarrollador'])) {
    header("Location: index.php");
    exit();
}

// Validar que venga un ID
if (!isset($_GET['id'])) {
    header("Location: panel_profesores.php");
    exit();
}

require_once __DIR__ . '/../src/Views/users/editar_profesor.php';