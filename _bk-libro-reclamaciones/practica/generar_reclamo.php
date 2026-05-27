<?php
require __DIR__ . '/vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

$codigo = isset($_GET['codigo']) ? trim($_GET['codigo']) : '';
$documento = isset($_GET['documento']) ? trim($_GET['documento']) : '';

if (!$codigo) {
    die('Código de reclamo no proporcionado.');
}

$dbPath = __DIR__ . '/../reclamos.db';
$reclamo = null;
$archivos = [];
$error = '';

try {
    $pdo = new PDO("sqlite:$dbPath");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($documento) {
        $stmt = $pdo->prepare("SELECT * FROM reclamos WHERE codigo_seguimiento = ? AND (doc_numero_natural = ? OR ruc_juridica = ?)");
        $stmt->execute([$codigo, $documento, $documento]);
    } else {
        $stmt = $pdo->prepare("SELECT * FROM reclamos WHERE codigo_seguimiento = ?");
        $stmt->execute([$codigo]);
    }
    $reclamo = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($reclamo) {
        $stmtArch = $pdo->prepare("SELECT * FROM reclamo_archivos WHERE reclamo_id = ?");
        $stmtArch->execute([$reclamo['id']]);
        $archivos = $stmtArch->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $error = 'Código o documento incorrecto.';
    }
} catch (PDOException $e) {
    $error = 'Error al conectar con la base de datos.';
}

$logoPath = __DIR__ . '/img/logo-empresa.webp';
$logoSrc = '';
if (file_exists($logoPath)) {
    $logoData = base64_encode(file_get_contents($logoPath));
    $logoSrc = 'data:image/webp;base64,' . $logoData;
}

$badgeColor = match ($reclamo['estado'] ?? 'PENDIENTE') {
    'PENDIENTE' => '#ffc107',
    'EN REVISION' => '#17a2b8',
    'ATENDIDO' => '#28a745',
    'ARCHIVADO' => '#6c757d',
    default => '#6c757d',
};

$estadoIcono = '';

ob_start();
?>
<!DOCTYPE html>
<html>
<head>
<style>
    body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 30px; }
    .header { text-align: center; border-bottom: 3px solid #4A308B; padding-bottom: 15px; position: relative; }
    .header h1 { margin: 0; font-size: 22px; color: #4A308B; }
    .header small { font-size: 11px; color: #666; }

    .codigo-box {
        background: #e3f0ff; color: #1a3a5c; text-align: center; padding: 15px 20px;
        width: 300px; margin: 25px auto; border-radius: 8px; border: 1px solid #b8d4f0;
    }
    .codigo-box .label { font-size: 10px; text-transform: uppercase; letter-spacing: 1px; color: #5a7a9a; display: block; }
    .codigo-box .code { font-size: 22px; font-weight: bold; letter-spacing: 2px; display: block; margin: 4px 0; color: #0a2a4a; }
    .codigo-box .fecha { font-size: 10px; color: #5a7a9a; display: block; }

    .estado-badge {
        display: inline-block; padding: 6px 18px; border-radius: 20px;
        font-size: 13px; font-weight: bold; color: #fff; margin-top: 10px;
    }

    .seccion-titulo {
        background-color: #f4f4f4; color: #4A308B; padding: 10px;
        font-weight: bold; border-left: 5px solid #4A308B;
        margin: 25px 0 15px 0; text-transform: uppercase; font-size: 13px;
    }

    .row { display: flex; gap: 20px; margin-bottom: 15px; }
    .col { flex: 1; }
    .campo { margin-bottom: 12px; }
    .etiqueta { display: block; font-weight: bold; color: #777; font-size: 10px; text-transform: uppercase; }
    .valor { display: block; font-size: 13px; color: #000; border-bottom: 1px solid #eee; padding: 4px 0 3px 0; }
    .caja-texto { background: #fafafa; border: 1px solid #eee; padding: 10px; font-size: 12px; text-align: justify; line-height: 1.5; white-space: pre-wrap; }

    .adjuntos-lista { list-style: none; padding: 0; font-size: 12px; margin: 0; }
    .adjuntos-lista li { padding: 4px 0; border-bottom: 1px solid #f0f0f0; }
    .adjuntos-lista li:before { content: "• "; color: #4A308B; font-weight: bold; }

    .footer-legal {
        margin-top: 40px; font-size: 9px; color: #999; text-align: justify;
        line-height: 1.3; border-top: 1px solid #eee; padding-top: 15px;
    }

    .error-page { text-align: center; padding: 80px 20px; }
    .error-page h1 { color: #dc3545; font-size: 24px; }
    .error-page p { color: #666; font-size: 14px; }
</style>
</head>
<body>

<?php if ($error): ?>
    <div class="error-page">
        <h1>Reclamo no encontrado</h1>
        <p><?= htmlspecialchars($error) ?></p>
    </div>
<?php else: ?>

    <div class="header">
        <?php if ($logoSrc): ?>
            <img src="<?= $logoSrc ?>" style="position:absolute; top:0; left:0; width:130px;">
        <?php endif; ?>
        <h1>LIBRO DE RECLAMACIONES</h1>
        <small>Código de Protección y Defensa del Consumidor - Ley N° 29571</small>
    </div>

    <div class="codigo-box">
        <span class="label">Código de Seguimiento</span>
        <span class="code"><?= htmlspecialchars($reclamo['codigo_seguimiento']) ?></span>
        <span class="fecha">Registrado el <?= date('d/m/Y \a \l\a\s H:i', strtotime($reclamo['fecha_creacion'])) ?></span>
        <span class="estado-badge" style="background:<?= $badgeColor ?>">
            <?= htmlspecialchars($reclamo['estado'] ?? 'PENDIENTE') ?>
        </span>
    </div>

    <div class="seccion-titulo">1. Identificación del Consumidor Reclamante</div>

    <?php if ($reclamo['tipo_persona'] === 'natural'): ?>
        <div class="row">
            <div class="col">
                <div class="campo">
                    <span class="etiqueta">Tipo de Persona</span>
                    <span class="valor">Persona Natural</span>
                </div>
            </div>
            <div class="col">
                <div class="campo">
                    <span class="etiqueta">Tipo de Documento</span>
                    <span class="valor"><?= htmlspecialchars($reclamo['doc_tipo_natural'] ?? '-') ?></span>
                </div>
            </div>
            <div class="col">
                <div class="campo">
                    <span class="etiqueta">Número de Documento</span>
                    <span class="valor"><?= htmlspecialchars($reclamo['doc_numero_natural'] ?? '-') ?></span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="campo">
                    <span class="etiqueta">Nombres y Apellidos</span>
                    <span class="valor"><?= htmlspecialchars($reclamo['nombre_completo_natural'] ?? '-') ?></span>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="row">
            <div class="col">
                <div class="campo">
                    <span class="etiqueta">Tipo de Persona</span>
                    <span class="valor">Persona Jurídica</span>
                </div>
            </div>
            <div class="col">
                <div class="campo">
                    <span class="etiqueta">RUC</span>
                    <span class="valor"><?= htmlspecialchars($reclamo['ruc_juridica'] ?? '-') ?></span>
                </div>
            </div>
            <div class="col">
                <div class="campo">
                    <span class="etiqueta">Razón Social</span>
                    <span class="valor"><?= htmlspecialchars($reclamo['razon_social'] ?? '-') ?></span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="campo">
                    <span class="etiqueta">Doc. del Contacto</span>
                    <span class="valor"><?= htmlspecialchars($reclamo['doc_tipo_contacto'] ?? '-') ?></span>
                </div>
            </div>
            <div class="col">
                <div class="campo">
                    <span class="etiqueta">Núm. Documento Contacto</span>
                    <span class="valor"><?= htmlspecialchars($reclamo['doc_num_contacto'] ?? '-') ?></span>
                </div>
            </div>
            <div class="col">
                <div class="campo">
                    <span class="etiqueta">Nombres del Contacto</span>
                    <span class="valor"><?= htmlspecialchars($reclamo['nombre_contacto'] ?? '-') ?></span>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col">
            <div class="campo">
                <span class="etiqueta">Teléfono</span>
                <span class="valor"><?= htmlspecialchars($reclamo['telefono'] ?? '-') ?></span>
            </div>
        </div>
        <div class="col">
            <div class="campo">
                <span class="etiqueta">Correo Electrónico</span>
                <span class="valor"><?= htmlspecialchars($reclamo['email'] ?? '-') ?></span>
            </div>
        </div>
    </div>
    <div class="campo">
        <span class="etiqueta">Dirección de Domicilio</span>
        <span class="valor"><?= htmlspecialchars($reclamo['direccion'] ?? '-') ?></span>
    </div>

    <div class="seccion-titulo">2. Detalle de la Reclamación y Pedido del Consumidor</div>

    <div class="row">
        <div class="col">
            <div class="campo">
                <span class="etiqueta">Servicio Contratado</span>
                <span class="valor"><?= htmlspecialchars($reclamo['servicio_contratado'] ?? '-') ?></span>
            </div>
        </div>
        <div class="col">
            <div class="campo">
                <span class="etiqueta">Tipo de Reclamación</span>
                <span class="valor"><?= htmlspecialchars($reclamo['tipo_reclamacion'] ?? '-') ?></span>
            </div>
        </div>
        <div class="col">
            <div class="campo">
                <span class="etiqueta">Monto Reclamado (S/.)</span>
                <span class="valor">S/ <?= htmlspecialchars($reclamo['monto'] ?? '0.00') ?></span>
            </div>
        </div>
    </div>
    <div class="campo">
        <span class="etiqueta">Nombre del Evento / Producto</span>
        <span class="valor"><?= htmlspecialchars($reclamo['nombre_evento'] ?? '-') ?></span>
    </div>

    <div class="seccion-titulo">3. Descripción y Pedido del Consumidor</div>

    <div class="campo">
        <span class="etiqueta">Descripción del Incidente</span>
        <div class="caja-texto" style="min-height:60px;"><?= htmlspecialchars($reclamo['descripcion'] ?? '-') ?></div>
    </div>

    <div class="campo">
        <span class="etiqueta">Pedido Concreto</span>
        <div class="caja-texto" style="min-height:40px;"><?= htmlspecialchars($reclamo['pedido'] ?? '-') ?></div>
    </div>

    <div class="seccion-titulo">4. Archivos Adjuntos</div>
    <?php if ($archivos): ?>
        <ul class="adjuntos-lista">
            <?php foreach ($archivos as $a): ?>
                <li><?= htmlspecialchars($a['nombre_original']) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <div class="campo">
            <span class="valor" style="color:#999;">No se adjuntaron archivos.</span>
        </div>
    <?php endif; ?>

    <div class="footer-legal">
        * La respuesta al presente reclamo será atendida mediante correo electrónico a la dirección consignada, en un plazo no mayor a quince (15) días hábiles, conforme a lo establecido en el Código de Protección y Defensa del Consumidor (Ley N° 29571). Este documento es una representación digital del registro realizado en nuestra plataforma web.
    </div>

<?php endif; ?>

</body>
</html>
<?php
$html = ob_get_clean();

$options = new Options();
$options->set('isRemoteEnabled', true);
$options->set('isHtml5ParserEnabled', true);

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

$dompdf->stream("Reclamo_{$codigo}.pdf", ['Attachment' => false]);
