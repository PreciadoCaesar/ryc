<?php
// index.php ubicado en /public/

// 1. Ajuste de ruta para llegar a config.php (sube un nivel)
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../src/Database/db.php';
require_once __DIR__ . '/../vendor/autoload.php';

// 2. Si ya está logueado, mandarlo al dashboard (que está en la misma carpeta /public)
if (isset($_SESSION['email'])) {
    header("Location: dashboard.php");
    exit();
}

$authUrl = $client->createAuthUrl();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso Seguro - R&C Consulting</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    
    <link rel="icon" href="img/icono-rc-consulting.ico" sizes="32x32">

    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', sans-serif;
        }
        .login-card {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            text-align: center;
            max-width: 400px;
            width: 90%;
            border-bottom: 5px solid #002e5b; /* Azul R&C */
        }
        .logo-container img {
            max-width: 220px;
            height: auto;
            margin-bottom: 30px;
        }
        .welcome-text { color: #333; margin-bottom: 30px; }
        .btn-google {
            background-color: white;
            color: #555;
            border: 1px solid #dadce0;
            padding: 12px 20px;
            border-radius: 8px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            transition: all 0.3s ease;
            text-decoration: none;
            width: 100%;
        }
        .btn-google:hover {
            background-color: #f8f9fa;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            color: #000;
            transform: translateY(-2px);
        }
        .btn-google img { width: 20px; }
        .footer-text { margin-top: 30px; font-size: 0.8rem; color: #999; }
    </style>
</head>
<body>

    <div class="login-card shadow">
        <div class="logo-container">
            <img src="img/logo-rc-consulting.webp" alt="R&C Consulting Logo">
        </div>

        <div class="welcome-text">
            <h4 class="fw-bold">Acceso Interno</h4>
            <p class="text-muted small">Por favor, identifícate con tu cuenta corporativa para continuar.</p>
        </div>

        <a href="<?= filter_var($authUrl, FILTER_SANITIZE_URL) ?>" class="btn-google">
            <img src="img/icon_google.png" alt="Google Logo">
            Loguearme con Google
        </a>

        <div class="footer-text">
            &copy; <?= date('Y') ?> R&C Consulting | Todos los derechos reservados.
        </div>
    </div>

</body>
</html>