<?php
/**
 * PUENTE DE SEGURIDAD - CREAR NUEVO PROFESOR
 * Ubicación: /proyecto-oauth/public/crear_profesor.php
 */

require_once __DIR__ . '/../config/config.php';

// 1. Verificación de Seguridad: Solo 'gerente' o 'desarrollador'
if (!isset($_SESSION['email']) || !in_array($_SESSION['rol'], ['gerente', 'desarrollador'])) {
    header("Location: dashboard.php?error=unauthorized");
    exit();
}

// 2. Cargamos la vista real que está en src
require_once __DIR__ . '/../src/Views/users/crear_profesor.php';