<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'R&C Consulting')</title>
    <meta name="description" content="@yield('meta_description', 'Cursos y Diplomados de Gestión Pública en Perú | SIAF, SIGA, SEACE, Presupuesto Público | R&C Consulting')">
    <meta name="keywords" content="@yield('meta_keywords', 'cursos SIAF, SIGA, SEACE, gestión pública, diplomados virtuales, Perú')">
    <link rel="canonical" href="@yield('canonical', url()->current())">
    <meta property="og:title" content="@yield('og_title', 'R&C Consulting')">
    <meta property="og:description" content="@yield('og_description', 'Cursos y Diplomados de Gestión Pública en Perú')">
    <meta property="og:url" content="@yield('canonical', url()->current())">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:image" content="@yield('og_image', asset('img/og-default.jpg'))">
    <meta property="og:locale" content="es_PE">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('og_title', 'R&C Consulting')">
    <meta name="twitter:description" content="@yield('og_description', 'Cursos y Diplomados de Gestión Pública en Perú')">
    <meta name="twitter:image" content="@yield('og_image', asset('img/og-default.jpg'))">
    
    <!-- CSS externo -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- CSS del proyecto -->
    <link rel="stylesheet" href="{{ asset('css/rc-main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/header-footer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/suscripciones/styles.css') }}">
    
    @yield('styles')
    @yield('head_extra')
</head>
<body>

<!-- HEADER -->
@include('partials.header')

<!-- TOAST CARRITO -->
@if(session('added_to_cart'))
<div id="cartToast" class="cart-toast">
    <div class="cart-toast-icon"><i class="fas fa-check-circle"></i></div>
    <div class="cart-toast-body">
        <strong>{{ session('already_in_cart') ? 'Ya está en tu carrito' : 'Agregado al carrito' }}</strong>
        <span>{{ session('added_to_cart') }}</span>
    </div>
    <div class="cart-toast-actions">
        <a href="/ryc/carrito" class="cart-toast-btn primary">Pagar ahora</a>
        <button onclick="dismissToast()" class="cart-toast-btn secondary">Seguir viendo</button>
    </div>
    <button onclick="dismissToast()" class="cart-toast-close">&times;</button>
</div>
<style>
.cart-toast {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 99999;
    display: flex;
    align-items: center;
    gap: 14px;
    background: #fff;
    padding: 16px 20px;
    border-radius: 12px;
    box-shadow: 0 8px 30px rgba(0,0,0,0.15);
    border-left: 5px solid #FF044D;
    max-width: 420px;
    animation: toastIn 0.4s ease;
    opacity: 1;
    transition: opacity 0.8s ease;
}
.cart-toast.fade-out {
    opacity: 0;
    pointer-events: none;
}
@keyframes toastIn {
    from { transform: translateX(100%); opacity: 0; }
    to { transform: translateX(0); opacity: 1; }
}
.cart-toast-icon {
    font-size: 28px;
    color: #25D366;
    flex-shrink: 0;
}
.cart-toast-body {
    flex: 1;
    display: flex;
    flex-direction: column;
}
.cart-toast-body strong {
    font-size: 14px;
    color: #0A1F5C;
}
.cart-toast-body span {
    font-size: 12px;
    color: #666;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 160px;
}
.cart-toast-actions {
    display: flex;
    flex-direction: column;
    gap: 4px;
    flex-shrink: 0;
}
.cart-toast-btn {
    display: inline-block;
    padding: 5px 12px;
    border-radius: 50px;
    font-size: 11px;
    font-weight: 600;
    text-decoration: none;
    text-align: center;
    border: none;
    cursor: pointer;
    transition: 0.3s;
}
.cart-toast-btn.primary {
    background: #FF044D;
    color: #fff;
}
.cart-toast-btn.primary:hover {
    opacity: 0.85;
    color: #fff;
}
.cart-toast-btn.secondary {
    background: #f0f0f0;
    color: #555;
}
.cart-toast-btn.secondary:hover {
    background: #e0e0e0;
    color: #333;
}
.cart-toast-close {
    position: absolute;
    top: 6px;
    right: 10px;
    background: none;
    border: none;
    font-size: 20px;
    color: #aaa;
    cursor: pointer;
    padding: 0;
    line-height: 1;
}
.cart-toast-close:hover {
    color: #555;
}
</style>
<script>
var toast = document.getElementById('cartToast');
if (toast) {
    setTimeout(function() {
        toast.classList.add('fade-out');
        setTimeout(function() { toast.remove(); }, 800);
    }, 7000);
}
function dismissToast() {
    var t = document.getElementById('cartToast');
    if (t) { t.classList.add('fade-out'); setTimeout(function() { t.remove(); }, 800); }
}
</script>
@endif

<!-- CONTENIDO PRINCIPAL -->
<main>
    @yield('content')
</main>

<!-- FOOTER -->
@include('partials.footer')

<!-- Inyectar datos del usuario autenticado para React -->
<script>
@php
    $userData = Auth::check() ? Auth::user()->only(['name', 'email', 'avatar', 'rol']) : null;
@endphp
window.user = @json($userData);
</script>

<!-- Scripts JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/js/bootstrap.bundle.min.js"></script>
@yield('scripts')

</body>
</html>