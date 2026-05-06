<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cursos SIAF SIGA SEACE Perú 2026 | Diplomados Gestión Pública | R&C Consulting</title>
    <meta name="description" content="Cursos y diplomados SIAF, SIGA, SEACE, Presupuesto Público y Contrataciones del Estado en Perú. Capacitación virtual con certificación oficial SERVIR.">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome 6 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Montserrat:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    @viteReactRefresh
    @vite('resources/js/app.jsx')

    <script>
        window.__COURSES__ = @json($courses ?? []);
    </script>
</head>

<body>
    <div id="app"></div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
