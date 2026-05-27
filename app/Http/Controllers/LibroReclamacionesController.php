<?php

namespace App\Http\Controllers;

use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;
use PDO;

class LibroReclamacionesController extends Controller
{
    protected function getDbPath()
    {
        return storage_path('app/libro-reclamaciones/reclamos.db');
    }

    protected function getDb()
    {
        $pdo = new PDO("sqlite:" . $this->getDbPath());
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }

    public function index()
    {
        return view('libro-reclamaciones.index');
    }

    public function buscar()
    {
        return view('libro-reclamaciones.buscar');
    }

    public function detalle(Request $request)
    {
        $codigo = trim($request->get('codigo', ''));
        $reclamo = null;
        $archivos = [];
        $error = '';

        if ($codigo) {
            try {
                $pdo = $this->getDb();
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
            } catch (\PDOException $e) {
                $error = 'Error al conectar con la base de datos.';
            }
        } else {
            return redirect()->route('rc-gestor-reclamos');
        }

        return view('libro-reclamaciones.detalle', compact('reclamo', 'archivos', 'error', 'codigo'));
    }

    public function gestor()
    {
        $reclamos = [];
        $error = '';
        try {
            $pdo = $this->getDb();
            $sql = "SELECT r.*,
                           CASE WHEN r.tipo_persona = 'natural' THEN r.nombre_completo_natural ELSE r.razon_social END as nombre_visible,
                           CASE WHEN r.tipo_persona = 'natural' THEN r.doc_tipo_natural || ' ' || r.doc_numero_natural ELSE 'RUC ' || r.ruc_juridica END as doc_visible,
                           (SELECT COUNT(*) FROM reclamo_archivos WHERE reclamo_id = r.id) as total_archivos
                    FROM reclamos r
                    ORDER BY r.id DESC";
            $reclamos = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            $error = 'Error al conectar con la base de datos.';
        }

        return view('libro-reclamaciones.gestor', compact('reclamos', 'error'));
    }

    public function seguimiento(Request $request)
    {
        $codigo = trim($request->get('codigo', ''));
        $documento = trim($request->get('documento', ''));
        $reclamo = null;
        $archivos = [];
        $error = '';

        if ($codigo && $documento) {
            if (!preg_match('/^[0-9]{8,11}$/', $documento)) {
                $error = 'El documento debe tener entre 8 y 11 dígitos numéricos.';
            } elseif (!preg_match('/^[RC\d\-]{12}$/', $codigo)) {
                $error = 'El código debe tener 12 caracteres y solo puede contener R, C, números y guiones.';
            }

            if (!$error) {
                try {
                    $pdo = $this->getDb();
                    $stmt = $pdo->prepare("SELECT * FROM reclamos WHERE codigo_seguimiento = ? AND (doc_numero_natural = ? OR ruc_juridica = ?)");
                    $stmt->execute([$codigo, $documento, $documento]);
                    $reclamo = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($reclamo) {
                        $stmtArchivos = $pdo->prepare("SELECT * FROM reclamo_archivos WHERE reclamo_id = ?");
                        $stmtArchivos->execute([$reclamo['id']]);
                        $archivos = $stmtArchivos->fetchAll(PDO::FETCH_ASSOC);
                    } else {
                        $error = 'Código o documento incorrecto.';
                    }
                } catch (\PDOException $e) {
                    $error = 'Error al conectar con la base de datos.';
                }
            }
        } else {
            return redirect()->route('libro-reclamaciones.buscar');
        }

        return view('libro-reclamaciones.seguimiento', compact('reclamo', 'archivos', 'error', 'codigo', 'documento'));
    }

    public function upload(Request $request)
    {
        require_once storage_path('app/libro-reclamaciones/vendor/autoload.php');

        header('Content-Type: application/json');

        try {
            $pdo = $this->getDb();
        } catch (\PDOException $e) {
            return response()->json(["status" => "error", "mensaje" => "Error de conexión"]);
        }

        $tipoPersona = $request->post('tipo_persona', '');
        $nombreVisible = $tipoPersona === 'natural'
            ? trim($request->post('nombre_completo_natural', ''))
            : trim($request->post('razon_social', ''));

        $fecha = date('Y-m-d H:i:s');
        $estado = 'PENDIENTE';

        $stmt = $pdo->prepare("INSERT INTO reclamos (
            tipo_persona, doc_tipo_natural, doc_numero_natural, nombre_completo_natural,
            ruc_juridica, razon_social, doc_tipo_contacto, doc_num_contacto, nombre_contacto,
            telefono, email, direccion, servicio_contratado, nombre_evento, tipo_reclamacion, monto,
            descripcion, pedido, fecha_creacion, estado
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->execute([
            $tipoPersona,
            $request->post('doc_tipo_natural'),
            $request->post('doc_numero_natural'),
            $request->post('nombre_completo_natural'),
            $request->post('ruc_juridica'),
            $request->post('razon_social'),
            $request->post('doc_tipo_contacto'),
            $request->post('doc_num_contacto'),
            $request->post('nombre_contacto'),
            $request->post('telefono'),
            $request->post('email'),
            $request->post('direccion'),
            $request->post('servicio_contratado'),
            $request->post('nombre_evento'),
            $request->post('tipo_reclamacion'),
            $request->post('monto'),
            $request->post('descripcion'),
            $request->post('pedido'),
            $fecha,
            $estado,
        ]);

        $reclamoId = $pdo->lastInsertId();
        $codigo = 'RC-' . date('Y') . '-' . str_pad($reclamoId, 4, '0', STR_PAD_LEFT);
        $pdo->prepare("UPDATE reclamos SET codigo_seguimiento = ? WHERE id = ?")->execute([$codigo, $reclamoId]);

        $documento = $tipoPersona === 'natural'
            ? ($request->post('doc_numero_natural', ''))
            : ($request->post('ruc_juridica', ''));

        $subidos = 0;
        if ($request->hasFile('mis_archivos')) {
            $directorio = storage_path('app/libro-reclamaciones/uploads/');
            if (!is_dir($directorio)) mkdir($directorio, 0777, true);

            foreach ($request->file('mis_archivos') as $i => $file) {
                if ($file->getMimeType() !== 'application/pdf') continue;
                $nombreOriginal = $file->getClientOriginalName();
                $nombreSeguro = preg_replace("/[\/\0<>:\"\\|?*]/", "_", $nombreVisible);
                $nombreOriginalSeguro = preg_replace("/[\/\0<>:\"\\|?*]/", "_", $nombreOriginal);
                $nuevoNombre = "{$reclamoId}_" . ($i + 1) . "_{$nombreSeguro}_{$nombreOriginalSeguro}";
                $rutaFinal = $directorio . $nuevoNombre;

                $file->move($directorio, $nuevoNombre);
                $stmtFile = $pdo->prepare("INSERT INTO reclamo_archivos (reclamo_id, nombre_original, ruta) VALUES (?, ?, ?)");
                $stmtFile->execute([$reclamoId, $nombreOriginal, "uploads/" . $nuevoNombre]);
                $subidos++;
            }
        }

        $this->sendConfirmationEmail($request, $codigo, $nombreVisible, $fecha, $documento);
        $this->notifyAdmin($request, $codigo, $nombreVisible, $documento);
        $this->syncToSheets($codigo, $nombreVisible, $estado);

        return response()->json([
            "status" => "ok",
            "codigo_seguimiento" => $codigo,
            "redirect" => route('libro-reclamaciones.seguimiento', ['codigo' => $codigo, 'documento' => $documento]),
            "mensaje" => "Reclamo registrado con éxito. Código: $codigo. Archivos subidos: $subidos",
        ]);
    }

    public function updateEstado(Request $request)
    {
        if (!$request->isMethod('post')) {
            return response()->json(["status" => "error", "mensaje" => "Método no permitido"], 405);
        }

        $codigo = trim($request->input('codigo', ''));
        $estado = strtoupper(trim($request->input('estado', '')));

        $validos = ['PENDIENTE', 'EN REVISION', 'ATENDIDO', 'ARCHIVADO'];
        if (!in_array($estado, $validos)) {
            return response()->json(["status" => "error", "mensaje" => "Estado no válido"], 400);
        }

        try {
            $pdo = $this->getDb();
            $stmt = $pdo->prepare("UPDATE reclamos SET estado = ? WHERE codigo_seguimiento = ?");
            $stmt->execute([$estado, $codigo]);

            if ($stmt->rowCount() > 0) {
                return response()->json(["status" => "ok", "mensaje" => "Estado actualizado a $estado"]);
            } else {
                return response()->json(["status" => "error", "mensaje" => "Código no encontrado"]);
            }
        } catch (\PDOException $e) {
            return response()->json(["status" => "error", "mensaje" => "Error BD: " . $e->getMessage()], 500);
        }
    }

    public function webhook(Request $request)
    {
        if ($request->isMethod('get')) {
            return response()->json([
                "status" => "ok",
                "mensaje" => "Webhook activo",
                "db_path" => $this->getDbPath(),
                "db_existe" => file_exists($this->getDbPath())
            ]);
        }

        if (!$request->isMethod('post')) {
            return response()->json(["status" => "error", "mensaje" => "Método no permitido"], 405);
        }

        $input = $request->all();
        if (!$input || !isset($input['codigo']) || !isset($input['nombre_columna']) || !isset($input['valor'])) {
            return response()->json(["status" => "error", "mensaje" => "Datos incompletos", "recibido" => $input], 400);
        }

        $codigo = $input['codigo'];
        $nombreColumna = $input['nombre_columna'];
        $valor = $input['valor'];

        $columnas = [
            'estado', 'tipo_persona', 'doc_tipo_natural', 'doc_numero_natural',
            'nombre_completo_natural', 'ruc_juridica', 'razon_social',
            'doc_tipo_contacto', 'doc_num_contacto', 'nombre_contacto',
            'telefono', 'email', 'direccion', 'servicio_contratado',
            'nombre_evento', 'tipo_reclamacion', 'monto', 'descripcion', 'pedido',
        ];

        if (!in_array($nombreColumna, $columnas)) {
            return response()->json(["status" => "error", "mensaje" => "Columna no válida: $nombreColumna"], 400);
        }

        if ($nombreColumna === 'estado') {
            $valoresValidos = ['PENDIENTE', 'EN REVISION', 'ATENDIDO', 'ARCHIVADO'];
            if (!in_array(strtoupper($valor), $valoresValidos)) {
                return response()->json(["status" => "error", "mensaje" => "Estado no válido: $valor"], 400);
            }
            $valor = strtoupper($valor);
        }

        try {
            $pdo = $this->getDb();
            $sql = "UPDATE reclamos SET $nombreColumna = ? WHERE codigo_seguimiento = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$valor, $codigo]);

            if ($stmt->rowCount() > 0) {
                return response()->json(["status" => "ok", "mensaje" => "Reclamo $codigo actualizado: $nombreColumna = $valor"]);
            } else {
                return response()->json(["status" => "ok", "mensaje" => "Código $codigo no encontrado en BD local"]);
            }
        } catch (\PDOException $e) {
            return response()->json(["status" => "error", "mensaje" => "Error BD: " . $e->getMessage()], 500);
        }
    }

    public function descargarArchivo($id)
    {
        $pdo = $this->getDb();
        $stmt = $pdo->prepare("SELECT * FROM reclamo_archivos WHERE id = ?");
        $stmt->execute([$id]);
        $archivo = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$archivo) {
            abort(404);
        }

        $path = storage_path('app/libro-reclamaciones/' . $archivo['ruta']);
        if (!file_exists($path)) {
            abort(404);
        }

        return response()->download($path, $archivo['nombre_original']);
    }

    public function generarPdf(Request $request)
    {
        $codigo = trim($request->get('codigo', ''));
        $documento = trim($request->get('documento', ''));
        $reclamo = null;
        $archivos = [];
        $error = '';

        try {
            $pdo = $this->getDb();
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
                $error = 'Reclamo no encontrado.';
            }
        } catch (\PDOException $e) {
            $error = 'Error al conectar con la base de datos.';
        }

        if ($error) {
            abort(404, $error);
        }

        $badgeColor = match ($reclamo['estado'] ?? 'PENDIENTE') {
            'PENDIENTE' => '#ffc107',
            'EN REVISION' => '#17a2b8',
            'ATENDIDO' => '#28a745',
            'ARCHIVADO' => '#6c757d',
            default => '#6c757d',
        };

        $logoPath = public_path('img/logo-rc-consulting-sin-fondo.webp');
        $logoSrc = '';
        if (file_exists($logoPath)) {
            $logoData = base64_encode(file_get_contents($logoPath));
            $logoSrc = 'data:image/webp;base64,' . $logoData;
        }

        $html = $this->buildPdfHtml($reclamo, $archivos, $codigo, $badgeColor, $logoSrc);

        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('isHtml5ParserEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return response()->stream(
            fn() => print($dompdf->output()),
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="Reclamo_' . $codigo . '.pdf"',
            ]
        );
    }

    private function buildPdfHtml($reclamo, $archivos, $codigo, $badgeColor, $logoSrc)
    {
        $estado = htmlspecialchars($reclamo['estado'] ?? 'PENDIENTE');
        $fecha = date('d/m/Y \a \l\a\s H:i', strtotime($reclamo['fecha_creacion']));

        $identificacion = $this->renderIdentificacion($reclamo);
        $archivosHtml = $archivos
            ? '<ul class="adjuntos-lista">' . implode('', array_map(fn($a) => '<li>' . htmlspecialchars($a['nombre_original']) . '</li>', $archivos)) . '</ul>'
            : '<div class="campo"><span class="valor" style="color:#999;">No se adjuntaron archivos.</span></div>';

        return <<<HTML
<!DOCTYPE html>
<html>
<head>
<style>
    body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 30px; }
    .header { text-align: center; border-bottom: 3px solid #4A308B; padding-bottom: 15px; position: relative; }
    .header h1 { margin: 0; font-size: 22px; color: #4A308B; }
    .header small { font-size: 11px; color: #666; }
    .codigo-box { background: #e3f0ff; color: #1a3a5c; text-align: center; padding: 15px 20px; width: 300px; margin: 25px auto; border-radius: 8px; border: 1px solid #b8d4f0; }
    .codigo-box .label { font-size: 10px; text-transform: uppercase; letter-spacing: 1px; color: #5a7a9a; display: block; }
    .codigo-box .code { font-size: 22px; font-weight: bold; letter-spacing: 2px; display: block; margin: 4px 0; color: #0a2a4a; }
    .codigo-box .fecha { font-size: 10px; color: #5a7a9a; display: block; }
    .estado-badge { display: inline-block; padding: 6px 18px; border-radius: 20px; font-size: 13px; font-weight: bold; color: #fff; margin-top: 10px; }
    .seccion-titulo { background-color: #f4f4f4; color: #4A308B; padding: 10px; font-weight: bold; border-left: 5px solid #4A308B; margin: 25px 0 15px 0; text-transform: uppercase; font-size: 13px; }
    .row { display: flex; gap: 20px; margin-bottom: 15px; }
    .col { flex: 1; }
    .campo { margin-bottom: 12px; }
    .etiqueta { display: block; font-weight: bold; color: #777; font-size: 10px; text-transform: uppercase; }
    .valor { display: block; font-size: 13px; color: #000; border-bottom: 1px solid #eee; padding: 4px 0 3px 0; }
    .caja-texto { background: #fafafa; border: 1px solid #eee; padding: 10px; font-size: 12px; text-align: justify; line-height: 1.5; white-space: pre-wrap; }
    .adjuntos-lista { list-style: none; padding: 0; font-size: 12px; margin: 0; }
    .adjuntos-lista li { padding: 4px 0; border-bottom: 1px solid #f0f0f0; }
    .adjuntos-lista li:before { content: "• "; color: #4A308B; font-weight: bold; }
    .footer-legal { margin-top: 40px; font-size: 9px; color: #999; text-align: justify; line-height: 1.3; border-top: 1px solid #eee; padding-top: 15px; }
</style>
</head>
<body>
    <div class="header">
        <img src="$logoSrc" style="position:absolute; top:0; left:0; width:130px;">
        <h1>LIBRO DE RECLAMACIONES</h1>
        <small>Código de Protección y Defensa del Consumidor - Ley N° 29571</small>
    </div>
    <div class="codigo-box">
        <span class="label">Código de Seguimiento</span>
        <span class="code">{$reclamo['codigo_seguimiento']}</span>
        <span class="fecha">Registrado el {$fecha}</span>
        <span class="estado-badge" style="background:{$badgeColor}">{$estado}</span>
    </div>
    <div class="seccion-titulo">1. Identificación del Consumidor Reclamante</div>
    {$identificacion}
    <div class="row">
        <div class="col"><div class="campo"><span class="etiqueta">Teléfono</span><span class="valor">{$reclamo['telefono']}</span></div></div>
        <div class="col"><div class="campo"><span class="etiqueta">Correo Electrónico</span><span class="valor">{$reclamo['email']}</span></div></div>
    </div>
    <div class="campo"><span class="etiqueta">Dirección de Domicilio</span><span class="valor">{$reclamo['direccion']}</span></div>
    <div class="seccion-titulo">2. Detalle de la Reclamación y Pedido del Consumidor</div>
    <div class="row">
        <div class="col"><div class="campo"><span class="etiqueta">Servicio Contratado</span><span class="valor">{$reclamo['servicio_contratado']}</span></div></div>
        <div class="col"><div class="campo"><span class="etiqueta">Tipo</span><span class="valor">{$reclamo['tipo_reclamacion']}</span></div></div>
        <div class="col"><div class="campo"><span class="etiqueta">Monto</span><span class="valor">S/ {$reclamo['monto']}</span></div></div>
    </div>
    <div class="campo"><span class="etiqueta">Evento / Producto</span><span class="valor">{$reclamo['nombre_evento']}</span></div>
    <div class="seccion-titulo">3. Descripción y Pedido del Consumidor</div>
    <div class="campo"><span class="etiqueta">Descripción</span><div class="caja-texto">{$reclamo['descripcion']}</div></div>
    <div class="campo"><span class="etiqueta">Pedido</span><div class="caja-texto">{$reclamo['pedido']}</div></div>
    <div class="seccion-titulo">4. Archivos Adjuntos</div>
    {$archivosHtml}
    <div class="footer-legal">
        * La respuesta al presente reclamo será atendida mediante correo electrónico a la dirección consignada, en un plazo no mayor a quince (15) días hábiles, conforme a lo establecido en el Código de Protección y Defensa del Consumidor (Ley N° 29571). Este documento es una representación digital del registro realizado en nuestra plataforma web.
    </div>
</body>
</html>
HTML;
    }

    private function renderIdentificacion($r)
    {
        if (($r['tipo_persona'] ?? 'natural') === 'natural') {
            return '
            <div class="row">
                <div class="col"><div class="campo"><span class="etiqueta">Tipo</span><span class="valor">Persona Natural</span></div></div>
                <div class="col"><div class="campo"><span class="etiqueta">Documento</span><span class="valor">' . htmlspecialchars($r['doc_tipo_natural'] ?? '-') . '</span></div></div>
                <div class="col"><div class="campo"><span class="etiqueta">N° Documento</span><span class="valor">' . htmlspecialchars($r['doc_numero_natural'] ?? '-') . '</span></div></div>
            </div>
            <div class="row">
                <div class="col"><div class="campo"><span class="etiqueta">Nombres y Apellidos</span><span class="valor">' . htmlspecialchars($r['nombre_completo_natural'] ?? '-') . '</span></div></div>
            </div>';
        }

        return '
        <div class="row">
            <div class="col"><div class="campo"><span class="etiqueta">Tipo</span><span class="valor">Persona Jurídica</span></div></div>
            <div class="col"><div class="campo"><span class="etiqueta">RUC</span><span class="valor">' . htmlspecialchars($r['ruc_juridica'] ?? '-') . '</span></div></div>
            <div class="col"><div class="campo"><span class="etiqueta">Razón Social</span><span class="valor">' . htmlspecialchars($r['razon_social'] ?? '-') . '</span></div></div>
        </div>
        <div class="row">
            <div class="col"><div class="campo"><span class="etiqueta">Doc. Contacto</span><span class="valor">' . htmlspecialchars($r['doc_tipo_contacto'] ?? '-') . '</span></div></div>
            <div class="col"><div class="campo"><span class="etiqueta">N° Doc. Contacto</span><span class="valor">' . htmlspecialchars($r['doc_num_contacto'] ?? '-') . '</span></div></div>
            <div class="col"><div class="campo"><span class="etiqueta">Nombre Contacto</span><span class="valor">' . htmlspecialchars($r['nombre_contacto'] ?? '-') . '</span></div></div>
        </div>';
    }

    private function sendConfirmationEmail($request, $codigo, $nombreVisible, $fecha, $documento)
    {
        try {
            $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
            $mail->CharSet = 'UTF-8';
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'noreply@rc-consulting.org';
            $mail->Password = 'lqhe pdcs khsp jljm';
            $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('noreply@rc-consulting.org', 'R&C Consulting');
            $mail->addAddress($request->post('email', ''));
            $mail->isHTML(true);
            $mail->Subject = "Confirmación de Reclamo - Código $codigo";

            $linkSeguimiento = route('libro-reclamaciones.seguimiento', ['codigo' => $codigo, 'documento' => $documento]);
            $linkPdf = route('libro-reclamaciones.pdf', ['codigo' => $codigo, 'documento' => $documento]);

            $mail->Body = $this->buildEmailBody($nombreVisible, $codigo, $fecha, $request, $linkSeguimiento, $linkPdf);
            $mail->AltBody = "Hola $nombreVisible, tu reclamo $codigo ha sido registrado el $fecha. Tipo: {$request->post('tipo_reclamacion')} - Servicio: {$request->post('servicio_contratado')}. Ingresa a $linkSeguimiento para dar seguimiento.";

            $mail->send();
        } catch (\Exception $e) {
            \Log::error("Error al enviar correo de confirmación: " . $e->getMessage());
        }
    }

    private function notifyAdmin($request, $codigo, $nombreVisible, $documento)
    {
        try {
            $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
            $mail->CharSet = 'UTF-8';
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'noreply@rc-consulting.org';
            $mail->Password = 'lqhe pdcs khsp jljm';
            $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('noreply@rc-consulting.org', 'R&C Consulting');
            $mail->addAddress('d.academica@rc-consulting.org');
            $mail->isHTML(true);
            $mail->Subject = "Reclamo del Consumidor - $codigo";

            $linkPanel = route('rc-gestor-reclamos');
            $linkPdf = route('libro-reclamaciones.pdf', ['codigo' => $codigo, 'documento' => $documento]);

            $mail->Body = "
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
                            <tr><td style='padding: 8px; border-bottom: 1px solid #eee; color: #666;'>Email</td><td style='padding: 8px; border-bottom: 1px solid #eee; font-weight: 500;'>{$request->post('email')}</td></tr>
                            <tr><td style='padding: 8px; border-bottom: 1px solid #eee; color: #666;'>Tipo</td><td style='padding: 8px; border-bottom: 1px solid #eee; font-weight: 500;'>{$request->post('tipo_reclamacion')}</td></tr>
                            <tr><td style='padding: 8px; color: #666;'>Servicio</td><td style='padding: 8px; font-weight: 500;'>{$request->post('servicio_contratado')}</td></tr>
                        </table>
                        <p style='text-align: center; margin-top: 20px;'>
                            <a href='$linkPanel' style='background: #0A1F5C; color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px; display: inline-block;'>Acceder al panel de control</a>
                        </p>
                        <p style='text-align: center; margin-top: 10px;'>
                            <a href='$linkPdf' style='background: #dc3545; color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px; display: inline-block; font-weight: bold;' target='_blank'>Descargar PDF</a>
                        </p>
                    </div>
                </div>
            </body></html>";

            $mail->send();
        } catch (\Exception $e) {
            \Log::error("Error al notificar a admin: " . $e->getMessage());
        }
    }

    private function syncToSheets($codigo, $nombreVisible, $estado)
    {
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
            \Log::error("[Sheets] Error curl: " . curl_error($ch));
        }
        \Log::info("[Sheets] HTTP $httpCode - Respuesta: " . substr($respuesta ?? 'sin respuesta', 0, 1000));
        curl_close($ch);
    }

    private function buildEmailBody($nombreVisible, $codigo, $fecha, $request, $linkSeguimiento, $linkPdf)
    {
        return "
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
                        <tr><td style='padding: 8px; border-bottom: 1px solid #eee; color: #666;'>Tipo</td><td style='padding: 8px; border-bottom: 1px solid #eee; font-weight: 500;'>{$request->post('tipo_reclamacion')}</td></tr>
                        <tr><td style='padding: 8px; border-bottom: 1px solid #eee; color: #666;'>Servicio</td><td style='padding: 8px; border-bottom: 1px solid #eee; font-weight: 500;'>{$request->post('servicio_contratado')}</td></tr>
                        <tr><td style='padding: 8px; color: #666;'>Evento</td><td style='padding: 8px; font-weight: 500;'>{$request->post('nombre_evento')}</td></tr>
                    </table>
                    <p>Recibirás una respuesta en un plazo máximo de <strong>15 días hábiles</strong>.</p>
                    <p style='text-align: center; margin-top: 20px;'>
                        <a href='$linkSeguimiento' style='background: #0A1F5C; color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px; display: inline-block;'>Dar seguimiento a mi reclamo</a>
                    </p>
                    <p style='text-align: center; margin-top: 10px;'>
                        <a href='$linkPdf' style='background: #dc3545; color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px; display: inline-block; font-weight: bold;' target='_blank'>Descargar PDF</a>
                    </p>
                    <p style='color: #999; font-size: 12px; margin-top: 20px;'>Este es un correo automático, por favor no lo respondas.</p>
                </div>
            </div>
        </body></html>";
    }
}
