<?php
declare(strict_types=1);

/**
 * R&C Consulting - Google OAuth Callback
 * Ubicación: /proyecto-oauth/public/callback.php
 */

session_start(); // ¡No olvides iniciar la sesión!

// 1. Ajuste de rutas: Subimos un nivel (../) para salir de 'public'
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../src/Database/db.php';

// Importamos la clase necesaria
use Google\Service\Oauth2 as GoogleServiceOauth2;

if (isset($_GET['code'])) {
    try {
        // Intercambiar código por token de acceso
        $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
        
        if (isset($token['error'])) {
            throw new Exception("Error de Google: " . $token['error_description']);
        }

        $client->setAccessToken($token['access_token']);

        // 2. Obtener datos del usuario (Uso de la clase correcta con Namespace)
        $google_oauth = new GoogleServiceOauth2($client);
        $google_account_info = $google_oauth->userinfo->get();
        
        $email = $google_account_info->email;
        $google_id = $google_account_info->id;

        // 3. Validar existencia del usuario en la base de datos
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user) {
            // Vincular ID de Google si es la primera vez
            if (empty($user['google_id'])) {
                $update = $pdo->prepare("UPDATE usuarios SET google_id = ? WHERE id = ?");
                $update->execute([$google_id, $user['id']]);
            }

            // 4. Establecer variables de sesión
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email']   = $user['email'];
            $_SESSION['rol']     = $user['rol'];
            $_SESSION['nombre']  = $google_account_info->name;

            // 5. Redirección final
            // Como ya estás dentro de 'public', solo llamas al archivo directamente
            header("Location: dashboard.php");
            exit();

        } else {
            // Caso: El correo no está registrado
            header("Location: index.php?error=unauthorized&email=" . urlencode($email));
            exit();
        }

    } catch (Exception $e) {
        error_log("Falla en OAuth: " . $e->getMessage());
        die("Ocurrió un error técnico durante el inicio de sesión.");
    }

} else {
    header("Location: index.php");
    exit();
}