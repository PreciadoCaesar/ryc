<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    private array $allowedDestinos = [
        'imagen-portada',
        'imagen-inhouse-desktop',
        'imagen-inhouse-mobile',
        'imagenes-promocionales',
        'portada-curso',
        'profesores',
    ];

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,gif,webp|max:3072',
            'nombre' => 'nullable|string|max:255',
            'destino' => 'required|string|in:' . implode(',', $this->allowedDestinos),
        ]);

        $file = $request->file('file');

        // Validación extra: verificar que sea realmente una imagen (no un PHP disfrazado)
        $realMime = $file->getMimeType();
        $allowedMimes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (!in_array($realMime, $allowedMimes)) {
            return response()->json(['error' => 'El archivo no es una imagen válida (tipo: ' . $realMime . ')'], 422);
        }

        $destino = $request->destino;
        $ext = $file->getClientOriginalExtension();
        $baseName = $request->nombre ?: pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $baseName = preg_replace('/[^a-zA-Z0-9_-]/', '_', $baseName);
        $baseName = substr($baseName, 0, 80);

        $uploadDir = public_path('upload/' . $destino);
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Crear .htaccess dentro del directorio de upload para bloquear ejecución PHP
        $htaccessPath = $uploadDir . '/.htaccess';
        if (!file_exists($htaccessPath)) {
            file_put_contents($htaccessPath, "<FilesMatch \\.php$>\nRequire all denied\n</FilesMatch>\n");
        }

        $filename = $baseName . '.' . $ext;
        $counter = 1;
        while (file_exists($uploadDir . '/' . $filename)) {
            $filename = $baseName . '_' . $counter . '.' . $ext;
            $counter++;
        }

        $file->move($uploadDir, $filename);
        $url = 'upload/' . $destino . '/' . $filename;

        if ($request->expectsJson()) {
            session()->flash('success', 'Imagen subida correctamente');
        }

        return response()->json([
            'url' => $url,
            'name' => $filename,
        ]);
    }

    public function listar(Request $request)
    {
        $carpeta = $request->query('carpeta');

        if (!in_array($carpeta, $this->allowedDestinos)) {
            return response()->json(['error' => 'Carpeta no permitida'], 400);
        }

        $dir = public_path('upload/' . $carpeta);
        if (!is_dir($dir)) {
            return response()->json([]);
        }

        $files = scandir($dir);
        $images = [];
        $extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        foreach ($files as $file) {
            if ($file === '.' || $file === '..') continue;
            $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            if (in_array($ext, $extensions)) {
                $images[] = [
                    'name' => $file,
                    'url' => 'upload/' . $carpeta . '/' . $file,
                ];
            }
        }

        usort($images, function ($a, $b) {
            $aTime = filemtime(public_path($a['url']));
            $bTime = filemtime(public_path($b['url']));
            return $bTime - $aTime;
        });

        return response()->json($images);
    }
}
