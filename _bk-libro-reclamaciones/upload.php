<?php
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

header('Content-Type: application/json');
ob_start();

$dbPath = __DIR__ . '/reclamos.db';

try {
    $pdo = new PDO("sqlite:$dbPath");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(["status" => "error", "mensaje" => "Error de conexión"]);
    exit;
}

$tipoPersona = $_POST['tipo_persona'] ?? '';

if ($tipoPersona === 'natural') {
    $nombreVisible = trim($_POST['nombre_completo_natural'] ?? '');
} else {
    $nombreVisible = trim($_POST['razon_social'] ?? '');
}

$fecha = date('Y-m-d H:i:s');

$estado = 'PENDIENTE';

$sql = "INSERT INTO reclamos (
    tipo_persona,
    doc_tipo_natural, doc_numero_natural, nombre_completo_natural,
    ruc_juridica, razon_social, doc_tipo_contacto, doc_num_contacto, nombre_contacto,
    telefono, email, direccion,
    servicio_contratado, nombre_evento, tipo_reclamacion, monto,
    descripcion, pedido, fecha_creacion, estado
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    $tipoPersona,
    $_POST['doc_tipo_natural'] ?? null,
    $_POST['doc_numero_natural'] ?? null,
    $_POST['nombre_completo_natural'] ?? null,
    $_POST['ruc_juridica'] ?? null,
    $_POST['razon_social'] ?? null,
    $_POST['doc_tipo_contacto'] ?? null,
    $_POST['doc_num_contacto'] ?? null,
    $_POST['nombre_contacto'] ?? null,
    $_POST['telefono'] ?? null,
    $_POST['email'] ?? null,
    $_POST['direccion'] ?? null,
    $_POST['servicio_contratado'] ?? null,
    $_POST['nombre_evento'] ?? null,
    $_POST['tipo_reclamacion'] ?? null,
    $_POST['monto'] ?? null,
    $_POST['descripcion'] ?? null,
    $_POST['pedido'] ?? null,
    $fecha,
    $estado,
]);

$reclamoId = $pdo->lastInsertId();

$codigo = 'RC-' . date('Y') . '-' . str_pad($reclamoId, 4, '0', STR_PAD_LEFT);
$pdo->prepare("UPDATE reclamos SET codigo_seguimiento = ? WHERE id = ?")->execute([$codigo, $reclamoId]);

$documento = $tipoPersona === 'natural' ? ($_POST['doc_numero_natural'] ?? '') : ($_POST['ruc_juridica'] ?? '');

$subidos = 0;
if (isset($_FILES['mis_archivos'])) {
    $directorio = __DIR__ . '/uploads/';
    if (!is_dir($directorio)) mkdir($directorio, 0777, true);

    foreach ($_FILES['mis_archivos']['tmp_name'] as $i => $tmpName) {
        $nombreOriginal = $_FILES['mis_archivos']['name'][$i];
        if ($_FILES['mis_archivos']['type'][$i] !== 'application/pdf') continue;

        $nombreSeguro = preg_replace("/[\/\0<>:\"\\|?*]/", "_", $nombreVisible);
        $nombreOriginalSeguro = preg_replace("/[\/\0<>:\"\\|?*]/", "_", $nombreOriginal);
        $nuevoNombre = "{$reclamoId}_" . ($i + 1) . "_{$nombreSeguro}_{$nombreOriginalSeguro}";
        $rutaFinal = $directorio . $nuevoNombre;

        if (move_uploaded_file($tmpName, $rutaFinal)) {
            $stmtFile = $pdo->prepare("INSERT INTO reclamo_archivos (reclamo_id, nombre_original, ruta) VALUES (?, ?, ?)");
            $stmtFile->execute([$reclamoId, $nombreOriginal, "uploads/" . $nuevoNombre]);
            $subidos++;
        }
    }
}

// Envío de correo de confirmación
try {
    $mail = new PHPMailer(true);
    $mail->CharSet = 'UTF-8';
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'noreply@rc-consulting.org';
    $mail->Password   = 'lqhe pdcs khsp jljm';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    $mail->setFrom('noreply@rc-consulting.org', 'R&C Consulting');
    $mail->addAddress($_POST['email'] ?? '');
    $mail->isHTML(true);
    $mail->Subject = "Confirmación de Reclamo - Código $codigo";
    $mail->Body    = "
        <html><body style='font-family: Arial, sans-serif; padding: 20px;'>
            <div style='max-width: 600px; margin: 0 auto; border: 1px solid #ddd; border-radius: 8px; overflow: hidden;'>
                <div style='background: #C8102E; color: white; padding: 20px; text-align: center;'>
                    <h2 style='margin: 0;'>R&C Consulting</h2>
                    <p style='margin: 5px 0 0;'>Escuela de Gobierno y Gestión Pública</p>
                </div>
                <div style='padding: 20px;'>
                    <p>Hola <strong>$nombreVisible</strong>,</p>
                    <p>Hemos recibido tu reclamación correctamente. A continuación los detalles:</p>
                    <div style='background: #f8f9fa; padding: 15px; border-radius: 5px; margin: 15px 0; text-align: center;'>
                        <p style='margin: 0; font-size: 14px; color: #666;'>Código de seguimiento</p>
                        <p style='font-size: 28px; font-weight: bold; color: #0A1F5C; margin: 5px 0; letter-spacing: 2px;'>$codigo</p>
                    </div>
                    <table style='width: 100%; border-collapse: collapse; margin: 15px 0;'>
                        <tr><td style='padding: 8px; border-bottom: 1px solid #eee; color: #666;'>Fecha de registro</td><td style='padding: 8px; border-bottom: 1px solid #eee; font-weight: 500;'>$fecha</td></tr>
                        <tr><td style='padding: 8px; border-bottom: 1px solid #eee; color: #666;'>Tipo</td><td style='padding: 8px; border-bottom: 1px solid #eee; font-weight: 500;'>{$_POST['tipo_reclamacion']}</td></tr>
                        <tr><td style='padding: 8px; border-bottom: 1px solid #eee; color: #666;'>Servicio</td><td style='padding: 8px; border-bottom: 1px solid #eee; font-weight: 500;'>{$_POST['servicio_contratado']}</td></tr>
                        <tr><td style='padding: 8px; color: #666;'>Evento</td><td style='padding: 8px; font-weight: 500;'>{$_POST['nombre_evento']}</td></tr>
                    </table>
                    <p>Recibirás una respuesta en un plazo máximo de <strong>15 días hábiles</strong>.</p>
                    <p style='text-align: center; margin-top: 20px;'>
                        <a href='https://rc-consulting.org/libro-de-reclamaciones/seguimiento.php?codigo=" . urlencode($codigo) . "' style='background: #0A1F5C; color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px; display: inline-block;'>Dar seguimiento a mi reclamo</a>
                    </p>
                    <p style='font-size: 13px; color: #333; text-align: center; margin-top: 15px;'>
                        Descargue el archivo PDF para ver todos los datos completos del reclamo
                    </p>
                    <p style='text-align: center; margin-top: 10px;'>
                        <a href='https://rc-consulting.org/libro-de-reclamaciones/practica/generar_reclamo.php?codigo=" . urlencode($codigo) . "&documento=" . urlencode($documento) . "' style='background: #dc3545; color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px; display: inline-block; font-weight: bold;' target='_blank'>Descargar PDF</a>
                    </p>
                    <p style='color: #999; font-size: 12px; margin-top: 20px;'>Este es un correo automático, por favor no lo respondas.</p>
                </div>
            </div>
        </body></html>
    ";
    $mail->AltBody = "Hola $nombreVisible, tu reclamo $codigo ha sido registrado el $fecha. Tipo: {$_POST['tipo_reclamacion']} - Servicio: {$_POST['servicio_contratado']}. Ingresa a https://rc-consulting.org/libro-de-reclamaciones/seguimiento.php?codigo=" . urlencode($codigo) . " para dar seguimiento. Descarga el PDF completo en: https://rc-consulting.org/libro-de-reclamaciones/practica/generar_reclamo.php?codigo=" . urlencode($codigo) . "&documento=" . urlencode($documento);

    $mail->send();
} catch (Exception $e) {
    error_log("Error al enviar correo de confirmación: " . $mail->ErrorInfo);
}

// Notificar al administrador
try {
    $mailAdmin = new PHPMailer(true);
    $mailAdmin->CharSet = 'UTF-8';
    $mailAdmin->isSMTP();
    $mailAdmin->Host       = 'smtp.gmail.com';
    $mailAdmin->SMTPAuth   = true;
    $mailAdmin->Username   = 'noreply@rc-consulting.org';
    $mailAdmin->Password   = 'lqhe pdcs khsp jljm';
    $mailAdmin->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mailAdmin->Port       = 587;

    $mailAdmin->setFrom('noreply@rc-consulting.org', 'R&C Consulting');
    $mailAdmin->addAddress('d.academica@rc-consulting.org');
    $mailAdmin->isHTML(true);
    $mailAdmin->Subject = "Reclamo del Consumidor - $codigo";
    $mailAdmin->Body = "
        <html><body style='font-family: Arial, sans-serif; padding: 20px;'>
            <div style='max-width: 600px; margin: 0 auto; border: 1px solid #ddd; border-radius: 8px; overflow: hidden;'>
                <div style='background: #C8102E; color: white; padding: 20px; text-align: center;'>
                    <h2 style='margin: 0;'>R&C Consulting</h2>
                    <p style='margin: 5px 0 0;'>Escuela de Gobierno y Gestión Pública</p>
                </div>
                <div style='padding: 20px;'>
                    <p>Hola,</p>
                    <p>Hay un nuevo reclamo registrado recientemente.</p>
                    <div style='background: #f8f9fa; padding: 15px; border-radius: 5px; margin: 15px 0; text-align: center;'>
                        <p style='margin: 0; font-size: 14px; color: #666;'>Código de seguimiento</p>
                        <p style='font-size: 28px; font-weight: bold; color: #0A1F5C; margin: 5px 0; letter-spacing: 2px;'>$codigo</p>
                    </div>
                    <table style='width: 100%; border-collapse: collapse; margin: 15px 0;'>
                        <tr><td style='padding: 8px; border-bottom: 1px solid #eee; color: #666;'>Cliente</td><td style='padding: 8px; border-bottom: 1px solid #eee; font-weight: 500;'>$nombreVisible</td></tr>
                        <tr><td style='padding: 8px; border-bottom: 1px solid #eee; color: #666;'>Email</td><td style='padding: 8px; border-bottom: 1px solid #eee; font-weight: 500;'>{$_POST['email']}</td></tr>
                        <tr><td style='padding: 8px; border-bottom: 1px solid #eee; color: #666;'>Tipo</td><td style='padding: 8px; border-bottom: 1px solid #eee; font-weight: 500;'>{$_POST['tipo_reclamacion']}</td></tr>
                        <tr><td style='padding: 8px; color: #666;'>Servicio</td><td style='padding: 8px; font-weight: 500;'>{$_POST['servicio_contratado']}</td></tr>
                    </table>
                    <p style='text-align: center; margin-top: 20px;'>
                        <a href='https://rc-consulting.org/libro-de-reclamaciones/rc-gestor-reclamos.php' style='background: #0A1F5C; color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px; display: inline-block;'>Acceder al panel de control</a>
                    </p>
                    <p style='font-size: 13px; color: #333; text-align: center; margin-top: 15px;'>
                        Descargue el archivo PDF para ver todos los datos completos del reclamo
                    </p>
                    <p style='text-align: center; margin-top: 10px;'>
                        <a href='https://rc-consulting.org/libro-de-reclamaciones/practica/generar_reclamo.php?codigo=" . urlencode($codigo) . "&documento=" . urlencode($documento) . "' style='background: #dc3545; color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px; display: inline-block; font-weight: bold;' target='_blank'>Descargar PDF</a>
                    </p>
                    <p style='color: #999; font-size: 12px; margin-top: 20px;'>Este es un correo automático, por favor no lo respondas.</p>
                </div>
            </div>
        </body></html>
    ";
    $mailAdmin->AltBody = "Nuevo reclamo $codigo registrado por $nombreVisible ({$_POST['email']}). Tipo: {$_POST['tipo_reclamacion']} - Servicio: {$_POST['servicio_contratado']}. Panel: https://rc-consulting.org/libro-de-reclamaciones/rc-gestor-reclamos.php | PDF: https://rc-consulting.org/libro-de-reclamaciones/practica/generar_reclamo.php?codigo=" . urlencode($codigo) . "&documento=" . urlencode($documento);

    $mailAdmin->send();
} catch (Exception $e) {
    error_log("Error al notificar a admin: " . $mailAdmin->ErrorInfo);
}

// Enviar a Google Sheets via Apps Script
$sheetUrl = 'https://script.google.com/macros/s/AKfycbw9sFX05uTEBML4OtIb1KdckxrOK3wGnOkaNqOWk2iovZwRL1s-BYLK6wRbZHCOPLZpmw/exec';
$datosSheet = [
    'codigo_seguimiento' => $codigo,
    'nombre' => $nombreVisible,
    'estado' => $estado,
];
$ch = curl_init($sheetUrl);
curl_setopt_array($ch, [
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => json_encode($datosSheet),
    CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 15,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_MAXREDIRS => 5,
    CURLOPT_USERAGENT => 'PHP-Sheets-Sync',
]);
$respuesta = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
if (curl_error($ch)) {
    error_log("[Sheets] Error curl: " . curl_error($ch));
}
error_log("[Sheets] HTTP $httpCode - Respuesta: " . substr($respuesta ?? 'sin respuesta', 0, 1000));
curl_close($ch);

ob_clean();
echo json_encode([
    "status" => "ok",
    "codigo_seguimiento" => $codigo,
    "redirect" => "seguimiento.php?codigo=" . urlencode($codigo) . "&documento=" . urlencode($documento),
    "mensaje" => "Reclamo registrado con éxito. Código: $codigo. Archivos subidos: $subidos",
    "sheets_debug" => trim(substr($respuesta ?? 'sin respuesta', 0, 500))
]);
?>

