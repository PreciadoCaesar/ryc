<?php
// Script de depuración - Renderiza el formulario de cursos y guarda el HTML
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Crear una request simulada
$request = Illuminate\Http\Request::create('/admin/cursos/create', 'GET');
$request->setUserResolver(function() {
    // Usuario mock con permisos de admin
    $user = new stdClass();
    $user->id = 1;
    $user->name = 'Admin';
    $user->email = 'admin@test.com';
    $user->rol = 'desarrollador';
    $user->avatar = null;
    return $user;
});

// Obtener asesoras y profesores
$asesoras = App\Models\Advisor::asesoras()->get();
$profesores = App\Models\Professor::all();

try {
    $html = view('admin.cursos.form', [
        'asesoras' => $asesoras,
        'profesores' => $profesores
    ])->render();
    
    file_put_contents(__DIR__ . '/debug-form-output.html', $html);
    echo "OK: Form rendered successfully (" . strlen($html) . " bytes)\n";
    
    // Extract JavaScript
    preg_match('/<script>(.*?)<\/script>/s', $html, $matches);
    if (isset($matches[1])) {
        $js = $matches[1];
        file_put_contents(__DIR__ . '/debug-form-js.js', $js);
        
        // Check for syntax error with Node.js
        $escapedJs = escapeshellarg($js);
        $output = shell_exec('node --check ' . escapeshellarg(__DIR__ . '/debug-form-js.js') . ' 2>&1');
        echo "Node check: " . ($output ?: "OK\n");
        
        // Count lines
        $lines = explode("\n", $html);
        echo "Total lines: " . count($lines) . "\n";
        if (isset($lines[2886])) {
            echo "Line 2887: " . $lines[2886] . "\n";
        }
        // Also check lines 2880-2895
        for ($i = 2880; $i <= 2895; $i++) {
            if (isset($lines[$i])) {
                echo "$i: " . $lines[$i] . "\n";
            }
        }
    } else {
        echo "ERROR: No <script> tag found in output\n";
    }
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}
