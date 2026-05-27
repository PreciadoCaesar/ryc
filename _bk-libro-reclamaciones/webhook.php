<?php
header('Content-Type: application/json');

// ============================================================
// GET - Test rápido para verificar que el webhook está vivo
// ============================================================
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo json_encode([
        "status" => "ok",
        "mensaje" => "Webhook activo",
        "db_path" => __DIR__ . "/reclamos.db",
        "db_existe" => file_exists(__DIR__ . "/reclamos.db")
    ]);
    exit;
}

// ============================================================
// POST - Recibir cambios desde Google Sheets
// ============================================================
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["status" => "error", "mensaje" => "Método no permitido"]);
    exit;
}

$rawInput = file_get_contents('php://input');
$input = json_decode($rawInput, true);

error_log("[Webhook] POST recibido: " . substr($rawInput, 0, 500));

if (!$input || !isset($input['codigo']) || !isset($input['nombre_columna']) || !isset($input['valor'])) {
    http_response_code(400);
    $resp = json_encode(["status" => "error", "mensaje" => "Datos incompletos", "recibido" => $input]);
    error_log("[Webhook] Error datos incompletos: " . $resp);
    echo $resp;
    exit;
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
    http_response_code(400);
    echo json_encode(["status" => "error", "mensaje" => "Columna no válida: $nombreColumna"]);
    exit;
}

if ($nombreColumna === 'estado') {
    $valoresValidos = ['PENDIENTE', 'EN REVISION', 'ATENDIDO', 'ARCHIVADO'];
    if (!in_array(strtoupper($valor), $valoresValidos)) {
        http_response_code(400);
        echo json_encode(["status" => "error", "mensaje" => "Estado no válido: $valor"]);
        exit;
    }
    $valor = strtoupper($valor);
}

try {
    $dbPath = __DIR__ . "/reclamos.db";
    if (!file_exists($dbPath)) {
        http_response_code(500);
        echo json_encode(["status" => "error", "mensaje" => "BD no encontrada en: $dbPath"]);
        exit;
    }

    $pdo = new PDO("sqlite:$dbPath");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "UPDATE reclamos SET $nombreColumna = ? WHERE codigo_seguimiento = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$valor, $codigo]);

    if ($stmt->rowCount() > 0) {
        $resp = json_encode(["status" => "ok", "mensaje" => "Reclamo $codigo actualizado: $nombreColumna = $valor"]);
        error_log("[Webhook] OK: $codigo -> $nombreColumna = $valor");
        echo $resp;
    } else {
        $resp = json_encode(["status" => "ok", "mensaje" => "Código $codigo no encontrado en BD local"]);
        error_log("[Webhook] No encontrado: $codigo");
        echo $resp;
    }
} catch (PDOException $e) {
    http_response_code(500);
    $resp = json_encode(["status" => "error", "mensaje" => "Error BD: " . $e->getMessage()]);
    error_log("[Webhook] Error PDO: " . $e->getMessage());
    echo $resp;
}
