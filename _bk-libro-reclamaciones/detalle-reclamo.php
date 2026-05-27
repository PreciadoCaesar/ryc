<?php ob_start(function($h) {
    return preg_replace(['/\/\*.*?\*\//s', '/\>[^\S ]+/s', '/[^\S ]+\</s', '/(\s)+/s', '/<!--(.|\s)*?-->/'], ['', '>', '<', '\\1', ''], $h);
});
$codigo = isset($_GET['codigo']) ? trim($_GET['codigo']) : '';
$reclamo = null;
$archivos = [];
$error = '';

if ($codigo) {
    try {
        $pdo = new PDO("sqlite:" . __DIR__ . "/reclamos.db");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("SELECT * FROM reclamos WHERE codigo_seguimiento = ?");
        $stmt->execute([$codigo]);
        $reclamo = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($reclamo) {
            $stmtArchivos = $pdo->prepare("SELECT * FROM reclamo_archivos WHERE reclamo_id = ?");
            $stmtArchivos->execute([$reclamo['id']]);
            $archivos = $stmtArchivos->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $error = 'No se encontró ningún reclamo con el código ingresado.';
        }
    } catch (PDOException $e) {
        $error = 'Error al conectar con la base de datos.';
    }
} else {
    header('Location: rc-gestor-reclamos.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle Reclamo <?= htmlspecialchars($codigo) ?> | R&C Consulting</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="header/header.css" rel="stylesheet">
    <link href="styles.css" rel="stylesheet">
    <link rel="icon" href="./img/logo-rc-consulting-icono.ico" sizes="32x32">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./header/header.css">
    <link rel="stylesheet" href="./css/responsive.css">
    <style>
        .detalle-section {
            background-color: #f4f7f6;
            padding: 40px 0 60px;
            font-family: 'Poppins', sans-serif;
            min-height: 60vh;
        }
        .codigo-badge {
            background: #212529;
            color: #fff;
            font-family: 'Montserrat', sans-serif;
            font-size: 24px;
            font-weight: 800;
            letter-spacing: 3px;
            padding: 16px 32px;
            border-radius: 12px;
            display: inline-block;
            text-align: center;
        }
        .codigo-badge small {
            display: block;
            font-size: 12px;
            font-weight: 400;
            letter-spacing: 1px;
            color: rgba(255,255,255,0.7);
            margin-bottom: 4px;
        }
        .result-card {
            background: #fff;
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 32px;
            margin-bottom: 20px;
        }
        .result-card .card-title {
            color: #0d6efd;
            font-weight: bold;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 10px;
            font-family: 'Montserrat', sans-serif;
            margin-bottom: 20px;
        }
        .result-card .label {
            font-weight: 600;
            color: #495057;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .result-card .value {
            font-weight: 500;
            color: #212529;
            font-size: 15px;
            margin-bottom: 14px;
        }
        .error-box {
            max-width: 600px;
            margin: 60px auto;
            text-align: center;
            padding: 40px;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .error-box h2 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 800;
            color: #dc3545;
        }
        .btn-admin {
            border-radius: 10px;
            padding: 14px 32px;
            font-weight: 700;
            font-size: 16px;
        }
        @media print {
            .no-print { display: none !important; }
            .detalle-section { padding: 20px 0; background: #fff; }
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<!-- NUEVO BANNER MORADO CODE-->
    <div class="banner-purpura">
        <div class="inner-wrap">
            <div class="contenido-banner-purpura">
                <div class="banner-item">
                    <div class="banner-icon">
                        <img src="./img/icons/casa.svg" alt="PDP">
                    </div>
                    <div class="banner-text">
                        <b>Cumple con el PDP 2026</b>
                        <span>Alinea tu capacitación In-House</span>
                    </div>
                </div>

                <div class="banner-item">
                    <div class="banner-icon">
                        <img src="./img/icons/merito.svg" alt="Directiva">
                    </div>
                    <div class="banner-text">
                        <b class="highlight-yellow">CURSOS IN HOUSE</b>
                        <span>Nueva Directiva 00214-2025-SERVIR-PE</span>
                    </div>
                </div>

                <div class="banner-action">
                    <a href="https://wa.me/51948163352?text=Hola%20Arnaldo%2C%20vengo%20de%20la%20web.%20Me%20interesa%20solicitar%20una%20Propuesta%20In%20House%20del%20Curso%20SIAF%20WEB%202026%3A%20Pr%C3%A1ctica%20en%20Administrativo%2C%20Presupuesto%2C%20Contable%20y%20Tesorer%C3%ADa%20para%20mi%20instituci%C3%B3n%20alineada%20al%20PDP%202026.%20%C2%BFPodr%C3%ADas%20ayudarme%3F"
                        class="btn-cotizar" style="color: #5044c2;" target="_blank">
                        <i class="fas fa-handshake"></i> ¡Cotizalo aqui!
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Navegación -->
    <nav class="navbar navbar-expand-lg rc-navbar">
        <div class="container">
            <a class="navbar-brand" href="/">
                <img src="img/logo-rc-consulting-sin-fondo.webp" class="rc-logo" alt="R&C Consulting">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav mx-auto w-100 justify-content-evenly">
                    <li class="nav-item">
                        <a class="nav-link" href="https://rc-consulting.org">Inicio</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Nosotros</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/nosotros">Sobre Nosotros</a></li>
                            <li><a class="dropdown-item" href="/experiencia">Experiencia y Alianzas</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Programas</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="https://rc-consulting.org/cursos-virtuales/">Cursos</a></li>
                            <li><a class="dropdown-item" href="https://rc-consulting.org/diplomas-virtuales/">Diplomas</a></li>
                            <li><a class="dropdown-item" href="https://www.rc-consulting.edu.pe/">Aula Virtual</a></li>
                            <li><a class="dropdown-item" href="https://rc-consulting.org/suscripcion/">Membresía Premium</a></li>
                            <li><a class="dropdown-item" href="https://rc-consulting.org/preguntas-frecuentes/">Preguntas Frecuentes</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://rc-consulting.org/cursos-inhouse/">In House</a>
                    </li>
                </ul>

                <div class="rc-buttons">
                    <a href="https://api.whatsapp.com/send?phone=51950883155" target="_blank" class="btn-wsp">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-whatsapp" viewBox="0 0 16 16">
                            <path d="M13.601 2.326A7.85 7.85 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.9 7.9 0 0 0 13.6 2.326zM7.994 14.521a6.6 6.6 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.56 6.56 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592m3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.73.73 0 0 0-.529.247c-.182.198-.691.677-.691 1.654s.71 1.916.81 2.049c.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232" />
                        </svg>
                        950 883 155
                    </a>
                    <a href="https://rc-consulting.edu.pe/" target="_blank" class="btn-aula">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-house-add-fill" viewBox="0 0 16 16">
                            <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 1 1-1 0v-1h-1a.5.5 0 1 1 0-1h1v-1a.5.5 0 0 1 1 0" />
                            <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L8 2.207l6.646 6.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293z" />
                            <path d="m8 3.293 4.712 4.712A4.5 4.5 0 0 0 8.758 15H3.5A1.5 1.5 0 0 1 2 13.5V9.293z" />
                        </svg>
                        Aula Virtual
                    </a>
                    <a href="https://escueladegobierno.edu.pe/tienda/" target="_blank" class="btn-tienda">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-cart-plus-fill" viewBox="0 0 16 16">
                            <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0m7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0M9 5.5V7h1.5a.5.5 0 0 1 0 1H9v1.5a.5.5 0 0 1-1 0V8H6.5a.5.5 0 0 1 0-1H8V5.5a.5.5 0 0 1 1 0" />
                        </svg>
                        Tienda Virtual
                    </a>
                </div>
            </div>
        </div>
    </nav>
<section class="detalle-section">
    <div class="container">

<?php if ($error): ?>
        <div class="error-box">
            <i class="bi bi-exclamation-triangle text-danger" style="font-size:48px;"></i>
            <h2 class="mt-3">Reclamo no encontrado</h2>
            <p class="text-muted"><?= htmlspecialchars($error) ?></p>
            <a href="rc-gestor-reclamos.php" class="btn btn-primary btn-lg mt-3">
                <i class="bi bi-arrow-left"></i> Volver al panel
            </a>
        </div>
<?php else: ?>

        <div class="d-flex justify-content-between align-items-center mb-4 no-print">
            <a href="rc-gestor-reclamos.php" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Volver al panel
            </a>
            <a href="practica/generar_reclamo.php?codigo=<?= urlencode($codigo) ?>&documento=<?= urlencode($reclamo['tipo_persona'] === 'natural' ? ($reclamo['doc_numero_natural'] ?? '') : ($reclamo['ruc_juridica'] ?? '')) ?>" class="btn btn-danger" target="_blank">
                <i class="bi bi-file-pdf"></i> Descargar PDF
            </a>
        </div>

        <div id="pdf-content">
            <div class="text-center mb-4" style="border-bottom:3px solid #212529;padding-bottom:20px;">
                <img src="img/logo-rc-consulting-sin-fondo.webp" alt="R&C Consulting" style="height:50px;margin-bottom:10px;">
                <h1 style="font-family:'Montserrat',sans-serif;font-weight:800;color:#212529;font-size:28px;">LIBRO DE RECLAMACIONES</h1>
                <p style="color:#6c757d;font-size:14px;">Detalle del Reclamo</p>
            </div>

            <!-- Código + Estado -->
            <div class="text-center mb-4">
                <div class="codigo-badge">
                    <small>Código de seguimiento</small>
                    <?= htmlspecialchars($reclamo['codigo_seguimiento']) ?>
                </div>
                <p class="text-muted mt-2 mb-0">
                    <i class="bi bi-calendar3"></i>
                    Registrado el <?= date('d/m/Y \a \l\a\s H:i', strtotime($reclamo['fecha_creacion'])) ?>
                </p>
                <div class="mt-3">
                    <?php
                    $estado = $reclamo['estado'] ?? 'PENDIENTE';
                    $badgeColor = match ($estado) {
                        'PENDIENTE' => 'warning',
                        'EN REVISION' => 'info',
                        'ATENDIDO' => 'success',
                        'ARCHIVADO' => 'secondary',
                        default => 'secondary',
                    };
                    ?>
                    <span class="badge bg-<?= $badgeColor ?> fs-5 px-4 py-2">
                        <i class="bi <?= match ($estado) {
                            'PENDIENTE' => 'bi-clock',
                            'EN REVISION' => 'bi-search',
                            'ATENDIDO' => 'bi-check-circle',
                            'ARCHIVADO' => 'bi-archive',
                            default => 'bi-question-circle',
                        } ?>"></i>
                        <?= htmlspecialchars($estado) ?>
                    </span>
                </div>
            </div>

            <!-- Datos del consumidor -->
            <div class="result-card">
                <h4 class="card-title"><i class="bi bi-person-fill"></i> 1. Identificación del Consumidor Reclamante</h4>
                <div class="row">
<?php if ($reclamo['tipo_persona'] === 'natural'): ?>
                    <div class="col-md-4">
                        <div class="label">Tipo de Persona</div>
                        <div class="value">Persona Natural</div>
                    </div>
                    <div class="col-md-4">
                        <div class="label">Tipo de Documento</div>
                        <div class="value"><?= htmlspecialchars($reclamo['doc_tipo_natural'] ?? '-') ?></div>
                    </div>
                    <div class="col-md-4">
                        <div class="label">Número de Documento</div>
                        <div class="value"><?= htmlspecialchars($reclamo['doc_numero_natural'] ?? '-') ?></div>
                    </div>
                    <div class="col-md-4">
                        <div class="label">Nombres y Apellidos</div>
                        <div class="value"><?= htmlspecialchars($reclamo['nombre_completo_natural'] ?? '-') ?></div>
                    </div>
<?php else: ?>
                    <div class="col-md-4">
                        <div class="label">Tipo de Persona</div>
                        <div class="value">Persona Jurídica</div>
                    </div>
                    <div class="col-md-4">
                        <div class="label">RUC</div>
                        <div class="value"><?= htmlspecialchars($reclamo['ruc_juridica'] ?? '-') ?></div>
                    </div>
                    <div class="col-md-4">
                        <div class="label">Razón Social</div>
                        <div class="value"><?= htmlspecialchars($reclamo['razon_social'] ?? '-') ?></div>
                    </div>
                    <div class="col-md-4">
                        <div class="label">Doc. del Contacto</div>
                        <div class="value"><?= htmlspecialchars($reclamo['doc_tipo_contacto'] ?? '-') ?></div>
                    </div>
                    <div class="col-md-4">
                        <div class="label">Núm. Documento Contacto</div>
                        <div class="value"><?= htmlspecialchars($reclamo['doc_num_contacto'] ?? '-') ?></div>
                    </div>
                    <div class="col-md-4">
                        <div class="label">Nombres del Contacto</div>
                        <div class="value"><?= htmlspecialchars($reclamo['nombre_contacto'] ?? '-') ?></div>
                    </div>
<?php endif; ?>
                    <div class="col-md-4">
                        <div class="label">Teléfono</div>
                        <div class="value"><?= htmlspecialchars($reclamo['telefono'] ?? '-') ?></div>
                    </div>
                    <div class="col-md-4">
                        <div class="label">Correo Electrónico</div>
                        <div class="value"><?= htmlspecialchars($reclamo['email'] ?? '-') ?></div>
                    </div>
                    <div class="col-12">
                        <div class="label">Dirección de Domicilio</div>
                        <div class="value"><?= htmlspecialchars($reclamo['direccion'] ?? '-') ?></div>
                    </div>
                </div>
            </div>

            <!-- Detalle -->
            <div class="result-card">
                <h4 class="card-title"><i class="bi bi-file-earmark-text-fill"></i> 2. Detalle de la Reclamación y Pedido del Consumidor</h4>
                <div class="row">
                    <div class="col-md-4">
                        <div class="label">Servicio Contratado</div>
                        <div class="value"><?= htmlspecialchars($reclamo['servicio_contratado'] ?? '-') ?></div>
                    </div>
                    <div class="col-md-4">
                        <div class="label">Tipo de Reclamación</div>
                        <div class="value">
                            <span class="badge bg-<?= $reclamo['tipo_reclamacion'] === 'Reclamo' ? 'danger' : 'warning' ?>">
                                <?= htmlspecialchars($reclamo['tipo_reclamacion']) ?>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="label">Monto Reclamado (S/.)</div>
                        <div class="value">S/ <?= htmlspecialchars($reclamo['monto'] ?? '0.00') ?></div>
                    </div>
                    <div class="col-12">
                        <div class="label">Nombre del Evento / Producto</div>
                        <div class="value"><?= htmlspecialchars($reclamo['nombre_evento'] ?? '-') ?></div>
                    </div>
                </div>
            </div>

            <!-- Descripción -->
            <div class="result-card">
                <h4 class="card-title"><i class="bi bi-chat-dots-fill"></i> 3. Descripción y Pedido</h4>
                <div class="row">
                    <div class="col-12">
                        <div class="label">Descripción del incidente</div>
                        <div class="value" style="background:#f8f9fa;padding:14px;border-radius:8px;white-space:pre-wrap;"><?= htmlspecialchars($reclamo['descripcion'] ?? '-') ?></div>
                    </div>
                    <div class="col-12 mt-3">
                        <div class="label">Pedido concreto</div>
                        <div class="value" style="background:#f8f9fa;padding:14px;border-radius:8px;white-space:pre-wrap;"><?= htmlspecialchars($reclamo['pedido'] ?? '-') ?></div>
                    </div>
                </div>
            </div>

            <!-- Archivos -->
            <div class="result-card" id="archivos">
                <h4 class="card-title"><i class="bi bi-paperclip"></i> 4. Archivos Adjuntos</h4>
                <?php if ($archivos): ?>
                <ul class="list-group list-group-flush">
                    <?php foreach ($archivos as $a): ?>
                    <li class="list-group-item d-flex align-items-center gap-3">
                        <i class="bi bi-file-pdf text-danger fs-4"></i>
                        <a href="<?= htmlspecialchars($a['ruta']) ?>" target="_blank" class="text-decoration-none fw-medium">
                            <?= htmlspecialchars($a['nombre_original']) ?>
                        </a>
                        <span class="ms-auto text-muted" style="font-size:12px;">
                            <i class="bi bi-download"></i>
                        </span>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <?php else: ?>
                <p class="text-muted mb-0">No se adjuntaron archivos.</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="text-center mt-4 no-print d-flex justify-content-center gap-2">
            <a href="practica/generar_reclamo.php?codigo=<?= urlencode($codigo) ?>&documento=<?= urlencode($reclamo['tipo_persona'] === 'natural' ? ($reclamo['doc_numero_natural'] ?? '') : ($reclamo['ruc_juridica'] ?? '')) ?>" class="btn btn-danger btn-lg" target="_blank">
                <i class="bi bi-file-pdf"></i> Descargar PDF
            </a>
            <a href="rc-gestor-reclamos.php" class="btn btn-outline-secondary btn-lg">
                <i class="bi bi-arrow-left"></i> Volver al panel
            </a>
        </div>

<?php endif; ?>
    </div>
</section>

<footer>
    <div class="inner-wrap">
        <div class="row g-4">
            <div class="col-md-3">
                <img src="./img/added/logofooter.webp" alt="R&C Consulting" style="height:48px;margin-bottom:20px;display:block;">
                <h3>Contáctanos:</h3>
                <p>Av. Petit Thouars 2166.<br>Lince, Lima - Perú</p>
                <p>Lunes a Viernes de 8:30 a 6:00 pm</p>
                <p><a href="mailto:info@rc-consulting.org">info@rc-consulting.org</a></p>
                <p>012661067 anexo: 100, 101, 104</p>
            </div>
            <div class="col-md-3">
                <h3>Enlaces</h3>
                <ul>
                    <li><a href="https://rc-consulting.org/cursos-virtuales/">Cursos</a></li>
                    <li><a href="https://rc-consulting.org/diplomas-virtuales/">Diplomados</a></li>
                    <li><a href="https://rc-consulting.org/cursos-inhouse/">Inhouse</a></li>
                    <li><a href="https://rc-consulting.org/consultoria-asistencia-tecnica/">Consultorías</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <h3>Información</h3>
                <ul class="mb-3">
                    <li><a href="https://rc-consulting.org/politicas-de-proteccion-de-datos/">Políticas de privacidad</a></li>
                    <li><a href="https://escueladegobierno.edu.pe/terminos-y-condiciones/">Términos y condiciones</a></li>
                    <li><a href="#">Contáctanos</a></li>
                </ul>
                <p style="font-size:11px;margin-bottom:5px;">Métodos de pago</p>
                <img src="./img/added/payment.webp" alt="Métodos de pago" style="max-height:28px;">
            </div>
            <div class="col-md-3">
                <h3>Certificados</h3>
                <a href="https://rc-consulting.org/app-certificados/version1/" class="btn-cert-f" target="_blank"><i class="fas fa-search"></i> Consulta tu certificado</a>
                <div style="display:flex;align-items:center;gap:8px;margin-bottom:14px;">
                    <img src="./img/added/lreclamaciones.svg" alt="Libro de reclamaciones" style="height:32px;">
                    <a href="https://rc-consulting.org/libro-de-reclamaciones/" style="font-size:14px;">Libro de reclamaciones</a>
                </div>
                <div class="social-icons">
                    <a href="https://pe.linkedin.com/company/ryc-consulting" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                    <a href="https://www.instagram.com/rycconsulting_/" target="_blank"><i class="fab fa-instagram"></i></a>
                    <a href="https://www.youtube.com/@CursosGestionPublica" target="_blank"><i class="fab fa-youtube"></i></a>
                    <a href="https://www.facebook.com/rcconsultingperu/" target="_blank"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://www.tiktok.com/@ryc_consulting" target="_blank"><i class="fab fa-tiktok"></i></a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>R&C Consulting 2026 — Todos los derechos reservados</p>
        </div>
    </div>
</footer>

</body>
</html>
