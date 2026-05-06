<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'R&C Consulting')</title>
    
    <!-- CSS externo -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- CSS del proyecto -->
    <link rel="stylesheet" href="{{ asset('css/rc-main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/suscripciones/styles.css') }}">
    
    @yield('styles')
    
    <!-- Estilos para header y footer -->
    <style>
    .banner-purpura { background:#5044c2; color:#fff; padding:12px 0; font-family:'Montserrat',sans-serif; position:relative; z-index:1100; }
    .contenido-banner-purpura { display:flex; justify-content:space-evenly; align-items:center; gap:20px; max-width:1200px; margin:0 auto; padding:0 20px; }
    .banner-item { display:flex; align-items:center; gap:12px; text-align:left; }
    .banner-icon img { width:32px; height:auto; filter:brightness(0) invert(1); }
    .banner-text b { display:block; font-size:13px; line-height:1.2; }
    .banner-text span { font-size:11px; font-weight:400; opacity:.9; }
    .highlight-yellow { color:#FFD700; }
    .btn-cotizar { background:#FFD700; color:#5044c2!important; padding:8px 20px; border-radius:6px; font-weight:800; text-decoration:none; font-size:13px; display:flex; align-items:center; gap:8px; transition:transform .2s; box-shadow:0 3px 0 #ccac00; }
    .btn-cotizar:hover { transform:translateY(-2px); background:#ffdb1f; }
    @media(max-width:991px){ .banner-purpura{display:none!important;} }
    .rc-navbar { background:#fff!important; box-shadow:0 2px 12px rgba(0,0,0,.08); position:sticky; top:0; z-index:1050; padding:6px 0; }
    .rc-logo { height:42px; width:auto; }
    .rc-navbar .nav-link { font-family:'Montserrat',sans-serif; font-size:13px; font-weight:700; color:#0A1F5C!important; padding:8px 12px; }
    .rc-navbar .nav-link:hover { color:#C8102E!important; }
    .rc-navbar .dropdown-menu { border:none; box-shadow:0 8px 24px rgba(0,0,0,.1); border-radius:10px; }
    .rc-navbar .dropdown-item { font-family:'Poppins',sans-serif; font-size:13px; padding:8px 18px; }
    .rc-navbar .dropdown-item:hover { background:#0A1F5C; color:#fff; }
    .rc-buttons { display:flex; gap:8px; flex-shrink:0; }
    .rc-buttons a { border-radius:50px; padding:8px 18px; font-size:13px; font-weight:700; font-family:'Montserrat',sans-serif; display:flex; align-items:center; gap:5px; text-decoration:none; color:#fff; transition:transform .2s; }
    .rc-buttons a:hover { transform:translateY(-1px); }
    .btn-wsp { background:#25D366; }
    .btn-aula { background:#136EF0; }
    .btn-tienda { background:#FF044D; }
    footer { background:#0A1F5C; color:#fff; padding:60px 0 30px; }
    footer .inner-wrap { max-width:1200px; margin:0 auto; padding:0 20px; }
    footer h3 { font-family:'Montserrat',sans-serif; font-size:16px; font-weight:700; margin-bottom:20px; color:#fff; }
    footer ul { list-style:none; padding:0; }
    footer li { margin-bottom:10px; }
    footer a { color:rgba(255,255,255,.8); text-decoration:none; font-size:14px; transition:color .2s; }
    footer a:hover { color:#FFD700; }
    footer p { font-size:14px; color:rgba(255,255,255,.8); line-height:1.6; }
    footer .footer-bottom { border-top:1px solid rgba(255,255,255,.1); margin-top:40px; padding-top:20px; text-align:center; }
    footer .footer-bottom p { margin:0; }
    footer .social-icons { display:flex; gap:15px; }
    footer .social-icons a { width:40px; height:40px; background:rgba(255,255,255,.1); border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:18px; transition:background .2s; }
    footer .social-icons a:hover { background:#FFD700; color:#0A1F5C; }
    </style>
</head>
<body>

<!-- HEADER -->
@include('partials.header')

<!-- CONTENIDO PRINCIPAL -->
<main>
    @yield('content')
</main>

<!-- FOOTER -->
@include('partials.footer')

<!-- Scripts JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/js/bootstrap.bundle.min.js"></script>
@yield('scripts')

</body>
</html>