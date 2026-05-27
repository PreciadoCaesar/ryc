<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 1. Forzamos la carga de cada componente de la librería phpdotenv
// Esto salta el error de "Class not found" definitivamente
$baseDir = __DIR__ . '/vendor/vlucas/phpdotenv/src/';

$files = [
    'Store/StoreInterface.php',
    'Store/FileStore.php',
    'Parser/ParserInterface.php',
    'Parser/Parser.php',
    'Loader/LoaderInterface.php',
    'Loader/Loader.php',
    'Repository/RepositoryInterface.php',
    'Repository/AdapterRepository.php',
    'Dotenv.php'
];

foreach ($files as $file) {
    if (file_exists($baseDir . $file)) {
        require_once $baseDir . $file;
    } else {
        die("❌ Error fatal: No se encontró el archivo físico en: " . $baseDir . $file);
    }
}

try {
    // 2. Intentamos cargar el .env
    // ASEGÚRATE que tu archivo se llame .env (con el punto)
    if (!file_exists(__DIR__ . '/.env')) {
        die("❌ Error: El archivo .env no existe en " . __DIR__ . ". Revisa si le pusiste el punto inicial.");
    }

    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    // 3. Conexión y creación de base de datos
    $dbPath = __DIR__ . '/' . ($_ENV['DB_PATH'] ?? 'database.sqlite');
    $pdo = new PDO("sqlite:" . $dbPath);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "CREATE TABLE IF NOT EXISTS usuarios (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        email TEXT NOT NULL UNIQUE,
        rol TEXT CHECK(rol IN ('admin', 'usuario', 'gerente', 'desarrollador', 'asesora-admin')) DEFAULT 'usuario',
        google_id TEXT DEFAULT NULL,
        creado_en DATETIME DEFAULT CURRENT_TIMESTAMP
    );";
    $pdo->exec($sql);

    // 4. Insertar accesos
    $insert = $pdo->prepare("INSERT OR IGNORE INTO usuarios (email, rol) VALUES (?, ?)");
    $insert->execute(['marcozarate050305@gmail.com', 'desarrollador']);
    $insert->execute(['capacitacion@rc-consulting.org', 'asesora-admin']);
    $insert->execute(['marketing@rc-consulting.org', 'gerente']);
    $insert->execute(['preciadotec@gmail.com', 'desarrollador']);

    echo "✅ ¡ÉXITO! Base de datos SQLite generada en: " . $dbPath;

} catch (Exception $e) {
    echo "❌ Error de ejecución: " . $e->getMessage();
}