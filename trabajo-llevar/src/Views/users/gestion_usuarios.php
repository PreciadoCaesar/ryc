<?php
require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../../src/Database/db.php';

if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

$mi_rol = $_SESSION['rol'] ?? 'usuario';
$mi_email = $_SESSION['email'];

if (!in_array($mi_rol, ['gerente', 'desarrollador', 'dios'])) {
    die("No tienes permisos para gestionar usuarios.");
}

// LÓGICA PARA ACTUALIZAR ROL
if (isset($_POST['accion']) && $_POST['accion'] == 'actualizar_rol') {
    $id_user = (int)$_POST['id'];
    $nuevo_rol = $_POST['nuevo_rol'];
    
    // Solo permitimos roles válidos
    $roles_permitidos = ['usuario', 'asesora-admin', 'gerente', 'desarrollador', 'dios'];
    if (in_array($nuevo_rol, $roles_permitidos)) {
        $stmt = $pdo->prepare("UPDATE usuarios SET rol = ? WHERE id = ?");
        $stmt->execute([$nuevo_rol, $id_user]);
        header("Location: gestion_usuarios.php?res=updated");
        exit();
    }
}

// LÓGICA PARA AGREGAR
if (isset($_POST['accion']) && $_POST['accion'] == 'agregar') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $rol = $_POST['rol'];
    $stmt = $pdo->prepare("INSERT OR IGNORE INTO usuarios (email, rol) VALUES (?, ?)");
    $stmt->execute([$email, $rol]);
    header("Location: gestion_usuarios.php?res=added");
    exit();
}

// LÓGICA PARA ELIMINAR
if (isset($_GET['eliminar'])) {
    $id = (int)$_GET['eliminar'];
    $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = ? AND email != ?");
    $stmt->execute([$id, $mi_email]);
    header("Location: gestion_usuarios.php?res=deleted");
    exit();
}

$usuarios = $pdo->query("SELECT * FROM usuarios ORDER BY id ASC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Control de Accesos - RC Consulting</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .card-panel { border: 2px solid #ffc107; border-radius: 15px; }
        .table thead { background-color: #212529; color: white; }
        .btn-actualizar { background-color: #198754; color: white; border: none; }
        .btn-actualizar:hover { background-color: #157347; }
    </style>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="fw-bold">Dashboard Administrativo</h1>
            <a href="logout.php" class="btn btn-danger">Cerrar Sesión</a>
        </div>

        <div class="alert alert-info border-0 shadow-sm rounded-3">
            Bienvenido: <strong><?php echo htmlspecialchars($mi_email); ?></strong> | Rol: <span class="badge bg-dark"><?php echo strtoupper($mi_rol); ?></span>
        </div>
        
        <div class="card card-panel shadow-sm mb-5">
            <div class="card-body p-4">
                <h4 class="text-warning fw-bold mb-4">Panel de Control de Accesos</h4>
                
                <div class="mb-4 p-3 bg-light rounded border">
                    <p class="small text-muted mb-2">Autorizar nuevo correo:</p>
                    <form method="POST" class="row g-3">
                        <input type="hidden" name="accion" value="agregar">
                        <div class="col-md-6">
                            <input type="email" name="email" class="form-control" placeholder="correo-gmail@gmail.com" required>
                        </div>
                        <div class="col-md-4">
                            <select name="rol" class="form-select">
                                <option value="usuario">usuario</option>
                                <option value="asesora-admin">asesora-admin</option>
                                <option value="gerente">gerente</option>
                                <option value="desarrollador">desarrollador</option>
                                <option value="dios">dios</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">Agregar</button>
                        </div>
                    </form>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Email</th>
                                <th>Estado Google</th>
                                <th>Asignar Rol</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($usuarios as $u): ?>
                            <tr>
                                <td><?php echo $u['id']; ?></td>
                                <td class="fw-bold"><?php echo htmlspecialchars($u['email']); ?></td>
                                <td>
                                    <?php echo $u['google_id'] ? 
                                        '<span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2"><i class="bi bi-check-square-fill me-1"></i> Vinculado</span>' : 
                                        '<span class="badge bg-light text-muted border px-3 py-2"><i class="bi bi-hourglass-split me-1"></i> Pendiente</span>'; ?>
                                </td>
                                <td>
                                    <form method="POST" class="d-flex gap-2">
                                        <input type="hidden" name="accion" value="actualizar_rol">
                                        <input type="hidden" name="id" value="<?php echo $u['id']; ?>">
                                        <select name="nuevo_rol" class="form-select form-select-sm">
                                            <?php 
                                            $roles = ['usuario', 'asesora-admin', 'gerente', 'desarrollador', 'dios'];
                                            foreach($roles as $r): 
                                            ?>
                                                <option value="<?php echo $r; ?>" <?php echo ($u['rol'] == $r) ? 'selected' : ''; ?>>
                                                    <?php echo $r; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <button type="submit" class="btn btn-actualizar btn-sm px-3">Actualizar</button>
                                    </form>
                                </td>
                                <td>
                                    <?php if($u['email'] != $mi_email): ?>
                                        <a href="?eliminar=<?php echo $u['id']; ?>" class="btn btn-outline-danger btn-sm px-3" onclick="return confirm('¿Eliminar acceso?')">
                                            Eliminar
                                        </a>
                                    <?php else: ?>
                                        <span class="badge bg-secondary px-3 py-2">Tú (Actual)</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>