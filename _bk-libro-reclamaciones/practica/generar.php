<?php
// Cargar las dependencias instaladas por Composer
require 'vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// 1. Configurar opciones (importante para cargar estilos correctamente)
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$dompdf = new Dompdf($options);

// 2. Definir el contenido HTML (Diseño Vertical)
$html = '
<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; padding: 30px; }
        .seccion { margin-bottom: 20px; }
        .etiqueta { 
            display: block; 
            font-weight: bold; 
            color: #4A308B; 
            font-size: 10px; 
            text-transform: uppercase; 
        }
        .valor { 
            display: block; 
            font-size: 14px; 
            border-bottom: 1px solid #eee; 
            padding: 5px 0; 
        }
    </style>
</head>
<body>
    <h1 style="text-align: center;">REPORTE DE PRÁCTICA</h1>
    
    <div class="seccion">
        <span class="etiqueta">Usuario de Prueba:</span>
        <span class="valor">Marco Alexandre Zarate</span>
    </div>

    <div class="seccion">
        <span class="etiqueta">Entorno de Desarrollo:</span>
        <span class="valor">XAMPP / PHP 8.x</span>
    </div>

    <div class="seccion">
        <span class="etiqueta">Estado de la Librería:</span>
        <span class="valor">Dompdf Instalado correctamente</span>
    </div>
</body>
</html>
';

// 3. Cargar el HTML en Dompdf
$dompdf->loadHtml($html);

// 4. Establecer el tamaño de papel (A4 vertical)
$dompdf->setPaper('A4', 'portrait');

// 5. Renderizar el HTML como PDF
$dompdf->render();

// 6. Enviarlo al navegador para descarga
$dompdf->stream("mi_primer_pdf.pdf", ["Attachment" => true]);
?>