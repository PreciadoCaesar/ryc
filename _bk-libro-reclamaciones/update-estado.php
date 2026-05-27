<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["status" => "error", "mensaje" => "Método no permitido"]);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

if (!$input || !isset($input['codigo']) || !isset($input['estado'])) {
    http_response_code(400);
    echo json_encode(["status" => "error", "mensaje" => "Datos incompletos"]);
    exit;
}

$codigo = trim($input['codigo']);
$estado = strtoupper(trim($input['estado']));

$validos = ['PENDIENTE', 'EN REVISION', 'ATENDIDO', 'ARCHIVADO'];
if (!in_array($estado, $validos)) {
    http_response_code(400);
    echo json_encode(["status" => "error", "mensaje" => "Estado no válido"]);
    exit;
}

try {
    $pdo = new PDO("sqlite:" . __DIR__ . "/reclamos.db");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare("UPDATE reclamos SET estado = ? WHERE codigo_seguimiento = ?");
    $stmt->execute([$estado, $codigo]);

    if ($stmt->rowCount() > 0) {
        echo json_encode(["status" => "ok", "mensaje" => "Estado actualizado a $estado"]);
    } else {
        echo json_encode(["status" => "error", "mensaje" => "Código no encontrado"]);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["status" => "error", "mensaje" => "Error BD: " . $e->getMessage()]);
}
