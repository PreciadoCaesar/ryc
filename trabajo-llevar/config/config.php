<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/**
 * R&C Consulting - Configuración de Autenticación Google OAuth
 * Desarrollador: Marco Alexandre Zárate
 */

// 1. Gestión de Sesión Segura
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Carga de dependencias de Composer (Ajustado: sube un nivel)
require_once __DIR__ . '/../vendor/autoload.php';

// 3. Carga de Variables de Entorno (Ajustado: sube un nivel)
try {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->load();
} catch (Exception $e) {
    die("Error crítico: El archivo .env no se encuentra o está mal formado.");
}

// 4. Validación de Variables Críticas
$clientId = $_ENV['GOOGLE_CLIENT_ID'] ?? null;
$clientSecret = $_ENV['GOOGLE_CLIENT_SECRET'] ?? null;
$redirectUri = isset($_ENV['GOOGLE_REDIRECT_URL']) ? trim($_ENV['GOOGLE_REDIRECT_URL']) : null;

if (!$clientId || !$clientSecret || !$redirectUri) {
    die("Error: Faltan credenciales de Google en el archivo .env.");
}

// 5. Configuración del Cliente de Google (Sintaxis moderna)
$client = new Google\Client(); 
$client->setClientId($clientId);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);

// Permisos solicitados
$client->addScope("email");
$client->addScope("profile");

$client->setAccessType('offline');
$client->setIncludeGrantedScopes(true);

// config/config.php
define('BASE_URL', 'http://localhost/proyecto-oauth/');
?>