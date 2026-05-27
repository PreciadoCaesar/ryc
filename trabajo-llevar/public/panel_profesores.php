<?php
/**
 * PUNTO DE ENTRADA PARA EL PANEL DE PROFESORES
 * Ubicación: /proyecto-oauth/public/panel_profesores.php
 */

// 1. Cargamos la configuración y sesión
require_once __DIR__ . '/../config/config.php';

// 2. Verificamos seguridad (Solo roles autorizados)
if (!isset($_SESSION['email']) || !in_array($_SESSION['rol'], ['gerente', 'desarrollador'])) {
    header("Location: index.php?error=unauthorized");
    exit();
}

// 3. LLAMAMOS A LA VISTA REAL (que está protegida en src)
require_once __DIR__ . '/../src/views/users/panel_profesores.php';