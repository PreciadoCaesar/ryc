<?php
/**
 * PUENTE DE SEGURIDAD - GESTIÓN DE USUARIOS (SQLite)
 * Ubicación: /proyecto-oauth/public/gestion_usuarios.php
 */

require_once __DIR__ . '/../config/config.php';

// 1. Verificación de Seguridad: Solo 'gerente' o 'desarrollador'
if (!isset($_SESSION['email']) || !in_array($_SESSION['rol'], ['gerente', 'desarrollador'])) {
    // Si no tiene permiso, lo mandamos al dashboard con un aviso
    header("Location: dashboard.php?error=no_permission");
    exit();
}

// 2. Cargar la vista real que está protegida en src
require_once __DIR__ . '/../src/Views/users/gestion_usuarios.php';