@extends('layouts.app-main')

@section('title', ($curso->seo_title ?? $curso->title) . ' | R&C Consulting')
@section('meta_description', $curso->seo_description ?? Str::limit(strip_tags($curso->description ?? ''), 160))
@section('meta_keywords', $curso->seo_keywords ?? '')
@section('canonical', route('curso.mostrar', $curso->slug))
@section('og_title', $curso->seo_title ?? $curso->title)
@section('og_description', $curso->seo_description ?? Str::limit(strip_tags($curso->description ?? ''), 160))
@section('og_image', asset($curso->image_promotion ?? 'img/og-default.svg'))

@section('head_extra')
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
<meta name="author" content="R&C Consulting">
<meta name="publisher" content="R&C Consulting">
<meta name="language" content="Spanish">
<meta name="revisit-after" content="7 days">
<meta name="distribution" content="global">
<meta name="rating" content="general">

<meta name="geo.region" content="PE-LIM" />
<meta name="geo.placename" content="Lima, Perú" />
<meta name="geo.position" content="-12.046374;-77.042793" />
<meta name="ICBM" content="-12.046374, -77.042793" />

<meta name="DC.title" content="{{ $curso->seo_title ?? $curso->title }}">
<meta name="DC.creator" content="R&C Consulting">
<meta name="DC.subject" content="{{ $curso->seo_keywords ?? '' }}">
<meta name="DC.description" content="{{ $curso->seo_description ?? Str::limit(strip_tags($curso->description ?? ''), 160) }}">
<meta name="DC.publisher" content="R&C Consulting">
<meta name="DC.contributor" content="{{ $curso->profesores->pluck('name')->implode(', ') }}">
<meta name="DC.date" content="{{ $curso->start_date ? date('Y-m-d', strtotime($curso->start_date)) : '' }}">
<meta name="DC.type" content="Educational Course">
<meta name="DC.format" content="text/html">
<meta name="DC.identifier" content="{{ route('curso.mostrar', $curso->slug) }}">
<meta name="DC.language" content="es">
<meta name="DC.coverage" content="Perú">
<meta name="DC.rights" content="© {{ date('Y') }} R&C Consulting. Todos los derechos reservados.">

<meta property="og:locale" content="es_PE">
<meta property="og:type" content="website">
<meta property="og:site_name" content="R&C Consulting">
<meta property="og:image:secure_url" content="{{ asset($curso->image_promotion ?? 'img/og-default.svg') }}">
<meta property="og:image:type" content="image/jpeg">
<meta property="og:image:alt" content="{{ $curso->title }} - R&C Consulting">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">

<meta name="twitter:site" content="@RCConsultingPE">
<meta name="twitter:creator" content="@RCConsultingPE">
<meta name="twitter:title" content="{{ Str::limit($curso->title, 60) }} | R&C Consulting">

<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
<meta name="format-detection" content="telephone=no">
<meta name="theme-color" content="#03206A">
<meta name="msapplication-TileColor" content="#03206A">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="default">

<link rel="dns-prefetch" href="https://cdnjs.cloudflare.com">
<link rel="dns-prefetch" href="https://fonts.googleapis.com">
<link rel="dns-prefetch" href="https://fonts.gstatic.com">
<link rel="dns-prefetch" href="https://cdn.jsdelivr.net">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>

<link rel="icon" href="{{ asset('img/logo-rc-consulting-icono.ico') }}" sizes="32x32">
<link rel="apple-touch-icon" href="{{ asset('img/logo-rc-consulting-icono.ico') }}">

<script type="application/ld+json">
{
      "@@context": "https://schema.org",
  "@graph": [
    {
      "@type": "Course",
      "@id": "{{ route('curso.mostrar', $curso->slug) }}#course",
      "name": "{{ $curso->title }}",
      "description": "{{ $curso->seo_description ?? Str::limit(strip_tags($curso->description ?? ''), 200) }}",
      "provider": {
        "@type": "Organization",
        "name": "R&C Consulting",
        "sameAs": "{{ url('/') }}",
        "url": "{{ url('/') }}"
      },
      "educationalLevel": "Especialización Profesional",
      "inLanguage": "es",
      "image": "{{ asset($curso->image_promotion ?? 'img/og-default.svg') }}",
      "url": "{{ route('curso.mostrar', $curso->slug) }}",
      "hasCourseInstance": {
        "@type": "CourseInstance",
        "courseMode": "{{ $curso->mode === 'grabado' ? 'Online' : 'Online' }}",
        "courseWorkload": "PT{{ $curso->hours ?? 90 }}H",
        "startDate": "{{ $curso->start_date ? date('Y-m-d', strtotime($curso->start_date)) : '' }}",
        "location": { "@type": "VirtualLocation", "url": "https://rc-consulting.edu.pe/" }
      },
      "offers": {
        "@type": "Offer",
        "category": "Paid",
        "price": "{{ $curso->precio_flash ?? $curso->precio_regular ?? '0' }}",
        "priceCurrency": "PEN",
        "availability": "https://schema.org/InStock",
        "url": "{{ route('curso.mostrar', $curso->slug) }}"
      }
    },
    {
      "@type": "Organization",
      "@id": "{{ url('/') }}#organization",
      "name": "R&C Consulting",
      "url": "{{ url('/') }}",
      "logo": "{{ asset('img/logo-rc-consulting-sin-fondo.webp') }}",
      "description": "23 a\u00f1os liderando el desarrollo de capacidades en gesti\u00f3n p\u00fablica en el Per\u00fa.",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "Av. Petit Thouars 2166",
        "addressLocality": "Lince",
        "addressRegion": "Lima",
        "addressCountry": "PE"
      },
      "contactPoint": {
        "@type": "ContactPoint",
        "telephone": "+51-12661067",
        "contactType": "customer service",
        "areaServed": "PE",
        "availableLanguage": "Spanish"
      },
      "sameAs": [
        "https://www.facebook.com/rcconsultingperu/",
        "https://www.instagram.com/rycconsulting_/",
        "https://pe.linkedin.com/company/ryc-consulting",
        "https://www.youtube.com/@CursosGestionPublica",
        "https://www.tiktok.com/@ryc_consulting"
      ]
    },
    {
      "@type": "BreadcrumbList",
      "itemListElement": [
        { "@type": "ListItem", "position": 1, "name": "Inicio", "item": "{{ url('/') }}" },
        { "@type": "ListItem", "position": 2, "name": "Cursos Virtuales", "item": "{{ route('cursos-virtuales') }}" },
        { "@type": "ListItem", "position": 3, "name": "{{ $curso->title }}", "item": "{{ route('curso.mostrar', $curso->slug) }}" }
      ]
    }
  ]
}
</script>
@endsection

@section('styles')
<link href="{{ asset('css/curso/styles.css') }}" rel="stylesheet">
<style>
    .c-check-area {
        grid-column: 1 / -1;
        display: flex;
        align-items: flex-start;
        gap: 8px;
        margin: 10px 0;
    }
    .c-check-area input { width: auto !important; margin-top: 4px; cursor: pointer; }
    .c-check-area label { font-size: 0.8rem; cursor: pointer; line-height: 1.2; }
</style>
@endsection

@section('content')
@php
    $tipoMap = ['curso' => 'Curso de Especialización Virtual', 'diplomado' => 'Diplomado de Especialización Virtual'];
    $tipoCertificado = ($curso->type === 'diplomado' || str_contains($curso->type ?? '', 'Diplomado')) ? 'Diploma Especializado' : 'Curso Especializado';
    $badgeTipo = $tipoMap[$curso->type] ?? $curso->type ?? 'Curso de Especialización Virtual';
    $ahorro = ($curso->precio_regular && $curso->precio_flash) ? $curso->precio_regular - $curso->precio_flash : 0;
    $modoClases = $curso->mode === 'grabado' ? 'Acceso Inmediato' : 'en vivo';
    $inicioTexto = $curso->start_date ?: ($curso->mode === 'grabado' ? 'Acceso Inmediato' : 'Próximamente');
    $isDiplomado = $curso->type === 'diplomado' || str_contains($curso->type ?? '', 'Diplomado');
    $videoUrl = $curso->page?->content['video_url'] ?? '';
@endphp

<div class="main-container">

    <div class="panel-amarillo" id="solicitar">
        <div class="panel-oferta-tag">🔥 OFERTA FLASH <br>CONSULTA CON TU ASESORA</div>

        <div class="panel-video-thumb" id="videoContainer" style="position:relative;width:auto;padding-top:56.25%;background:#000;border-radius:8px;overflow:hidden;margin:14px;cursor:pointer;">
            <img src="{{ asset($curso->image_promotion ?? 'img/og-default.svg') }}" alt="Video Thumbnail" style="position:absolute;top:0;left:0;width:100%;height:100%;object-fit:cover;opacity:0.8;">
            <div style="position:absolute;top:0;left:0;width:100%;height:100%;display:flex;flex-direction:column;align-items:center;justify-content:center;background:rgba(0,0,0,0.2);">
                <div style="background:rgba(255,255,255,0.2);border:2px solid #fff;border-radius:50%;width:60px;height:60px;display:flex;align-items:center;justify-content:center;margin-bottom:10px;">
                    <div style="width:0;height:0;border-top:12px solid transparent;border-bottom:12px solid transparent;border-left:20px solid #fff;margin-left:5px;"></div>
                </div>
                <span style="color:#fff;font-family:sans-serif;font-weight:bold;font-size:18px;text-transform:uppercase;letter-spacing:2px;text-shadow:2px 2px 4px rgba(0,0,0,0.5);">Vista Previa</span>
            </div>
        </div>

        <div class="panel-price-box">
            <div class="panel-price-label" style="display:flex;justify-content:center;align-items:center;padding-bottom:10px;font-size:15px;">
                Oferta hasta el {{ $curso->precio_flash_fecha ?? 'próximamente' }}
            </div>
            <div class="panel-price-main">
                <span>S/. </span> {{ $curso->precio_flash ?? '0' }}
                <div class="panel-price-regular">Precio regular:<br><span class="precio-tachado">s/. {{ $curso->precio_regular ?? '0' }}</span></div>
            </div>
            <div class="contain-btn-pago" style="width:100%;margin:25px 0 15px 0;background:white;border-radius:12px;">
                <form action="{{ route('carrito.buy', $curso->slug) }}" method="POST" style="display:inline">
                    @csrf
                    <button type="submit" class="btn btn-pago-tarjeta" style="border:none;width:100%">
                        <i class="fas fa-credit-card"></i> <span>Pagar con tarjeta</span>
                    </button>
                </form>
            </div>
            <div class="panel-logos"><img src="{{ asset('img/added/payment.webp') }}" alt="Métodos de pago"></div>
        </div>

        <div class="panel-registro-box">
            <p class="panel-registro-text">Registra tus datos y un asesor especializado te contactará para ayudarte</p>
            <form onsubmit="return handleLead(event)" id="formRegistroPanel">
                <input type="text" name="nombre" placeholder="Ingresa nombre completo" required>
                <input type="email" name="correo" placeholder="Ingresa correo electrónico" required>
                <input type="tel" name="celular" placeholder="Ingresa celular/WhatsApp" required>
                <label class="panel-check"><input type="checkbox" required checked><span>Acepto las políticas de privacidad de datos</span></label>
                <button type="submit" class="btn-panel-submit1" style="display:flex;align-items:center;justify-content:center;gap:8px;">
                    <img src="{{ asset('img/added/flecha.webp') }}" alt="Icono" class="btn-submit-icon">
                    <span>Solicitar información</span>
                </button>
            </form>
        </div>
    </div>

    <div class="content-wrapper">
        <div class="content-info">

            <section class="hero" id="inicio">
                <div class="hero-fondo"></div>
                <div class="hero-contenido">
                    <div class="inner-wrap">
                        <div class="hero-body">
                            <span class="badge-curso">{{ $badgeTipo }}</span>
                            <h1>{{ $curso->title }} @if($curso->subtitle)<span>{{ $curso->subtitle }}</span>@endif</h1>
                            @if($curso->phrase)<p class="hero-sub">{{ $curso->phrase }}</p>@endif
                            <div class="hero-stats">
                                <span class="stat-pill"><span class="stars">★★★★★</span>&nbsp; 4.8 de calificación</span>
                                <span class="stat-pill">👥 +350 alumnos capacitados en este curso</span>
                            </div>
                            @if($curso->description)<p class="hero-desc">{{ $curso->description }}</p>@endif
                        </div>
                    </div>
                </div>
            </section>

            <div class="quick-bar">
                <div class="inner-wrap">
                    <div class="quick-bar-inner">
                        <div class="qitem">
                            <div class="qicon"><img src="{{ asset('img/SVG/Recurso 49.svg') }}" width="24" height="24" alt=""></div>
                            <div><div class="qtitle">Inicio</div><div class="qtitle">{{ $inicioTexto }}</div></div>
                        </div>
                        <div class="qitem">
                            <div class="qicon"><img src="{{ asset('img/SVG/Recurso 50.svg') }}" width="24" height="24" alt=""></div>
                            <div><div class="qtitle">Duración</div><div class="qtitle">{{ $curso->sessions ?? 0 }} sesiones</div></div>
                        </div>
                        <div class="qitem">
                            <div class="qicon"><img src="{{ asset('img/SVG/Recurso 51.svg') }}" width="24" height="24" alt=""></div>
                            <div><div class="qtitle">Clases</div><div class="qtitle">{{ $modoClases }}</div></div>
                        </div>
                        <div class="qitem">
                            <div class="qicon"><img src="{{ asset('img/SVG/Recurso 52.svg') }}" width="24" height="24" alt=""></div>
                            <div><div class="qtitle">{{ $curso->hours ?? 0 }} Horas</div><div class="qtitle">Certificadas</div></div>
                        </div>
                    </div>
                </div>
            </div>

            @if($curso->image_promotion)
            <div class="promo-wrap">
                <div class="inner-wrap">
                    <img src="{{ asset($curso->image_promotion) }}" width="100%" alt="Bono de regalo" style="border-radius:5px;box-shadow:0 4px 10px rgba(0,0,0,0.6);display:block;">
                </div>
            </div>
            @endif

            <section class="sec bg-white">
                <div class="inner-wrap">
                    <div class="temario-wrap" style="max-width:100%;">
                        <div class="accordion" id="indispensableAcc">
                            @if($curso->objetivos->count() > 0)
                            <div class="accordion-item" style="border:none;margin-bottom:20px;">
                                <div class="temario-header collapsed" data-bs-toggle="collapse" data-bs-target="#indispensable" aria-expanded="false" style="cursor:pointer;border-radius:12px;background:#eaeaea;color:black;">
                                    <span style="color:black;">Objetivos de aprendizaje</span>
                                    <div style="display:flex;align-items:center;gap:8px;"><i style="color:black;" class="fas fa-chevron-down temario-arrow"></i></div>
                                </div>
                                <div id="indispensable" class="accordion-collapse collapse" data-bs-parent="#indispensableAcc">
                                    <div class="temario-body" style="background:white;border-radius:0 0 12px 12px;padding:10px 0;">
                                        @foreach($curso->objetivos as $objetivo)
                                        <div class="valor-item" style="padding:18px 22px;border-bottom:1.5px solid #D1D9E6;">
                                            <strong style="color:#03206A;font-size:13px;display:block;margin-bottom:8px;">● {{ $objetivo->titulo }}</strong>
                                            <p style="font-size:12.5px;color:#4A5568;line-height:1.7;margin:0;">{{ $objetivo->descripcion }}</p>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @endif
                            @if($curso->participantes->count() > 0)
                            <div class="accordion-item" style="border:none;">
                                <div class="temario-header collapsed" data-bs-toggle="collapse" data-bs-target="#quienes" aria-expanded="false" style="cursor:pointer;border-radius:12px;background:#eaeaea;color:black;">
                                    <span style="color:black;">¿Quiénes deben participar?</span>
                                    <div style="display:flex;align-items:center;gap:8px;"><i style="color:black;" class="fas fa-chevron-down temario-arrow"></i></div>
                                </div>
                                <div id="quienes" class="accordion-collapse collapse" data-bs-parent="#indispensableAcc">
                                    <div class="temario-body" style="background:white;border-radius:0 0 12px 12px;padding:10px 0;">
                                        @foreach($curso->participantes as $participante)
                                        <div class="valor-item" style="padding:18px 22px;border-bottom:1.5px solid #D1D9E6;">
                                            <strong style="color:#03206A;font-size:13px;display:block;margin-bottom:8px;">● {{ $participante->descripcion }}</strong>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </section>

            @php
                $hierarchical = $curso->temario_hierarchical ?? [];
                $totalSesiones = 0;

                function renderContenidoHTML($items) {
                    if (is_string($items)) return $items;
                    if (!is_array($items)) return '';
                    $html = '';
                    $listOpen = false;
                    if (count($items) > 0) $html .= '<br>';
                    foreach ($items as $item) {
                        if (($item['tipo'] ?? '') === 'sublista') $item['tipo'] = 'lista';
                        $text = $item['texto'] ?? '';
                        switch ($item['tipo'] ?? '') {
                            case 'subtitulo':
                                if ($listOpen) { $html .= '</ul>'; $listOpen = false; }
                                $html .= '<p><strong>' . e($text) . '</strong></p>';
                                break;
                            case 'texto':
                                if ($listOpen) { $html .= '</ul>'; $listOpen = false; }
                                $html .= '<p style="margin-bottom:.5rem"><strong>' . e($text) . '</strong></p>';
                                break;
                            case 'lista':
                                if (!$listOpen) { $html .= '<ul>'; $listOpen = true; }
                                $html .= '<li><strong>' . e($text) . '</strong>';
                                if (!empty($item['elementos'])) {
                                    $html .= '<ul>';
                                    foreach ($item['elementos'] as $elem) {
                                        $html .= '<li>' . e($elem) . '</li>';
                                    }
                                    $html .= '</ul>';
                                }
                                $html .= '</li>';
                                break;
                        }
                    }
                    if ($listOpen) $html .= '</ul>';
                    return $html;
                }

                if (!empty($hierarchical)) {
                    foreach ($hierarchical as $item) {
                        $t = $item['tipo'] ?? '';
                        if ($t === 'curso') {
                            foreach ($item['modulos'] ?? [] as $mod) {
                                $totalSesiones += count($mod['sesiones'] ?? []);
                            }
                            $totalSesiones += count($item['sesiones'] ?? []);
                        } elseif ($t === 'modulo') {
                            $totalSesiones += count($item['sesiones'] ?? []);
                        } elseif ($t === 'sesion') {
                            $totalSesiones++;
                        }
                    }
                }
            @endphp

            <section class="sec bg-white">
                <div class="inner-wrap">
                    <h2 style="text-align:center;" class="section-title left">Temario del {{ $isDiplomado ? 'diplomado' : 'curso' }}</h2>
                    <br>
                    @if($curso->link_brochure)
                    <a class="btn-brochure" href="{{ $curso->link_brochure }}" target="_blank" rel="noopener">
                        <i class="fas fa-download"></i> DESCARGAR BROCHURE (PDF)
                    </a>
                    <br>
                    @endif
                    <div class="temario-wrap">
                        <div class="temario-header collapsed" data-bs-toggle="collapse" data-bs-target="#temarioContent" aria-expanded="false" style="border-radius:12px 12px 0 0;">
                            <span>{{ $curso->specialization_name ?? $curso->title }}</span>
                            <div style="display:flex;align-items:center;gap:8px;">
                                <span class="pill-sesiones">{{ $totalSesiones > 0 ? $totalSesiones : $curso->temario->count() }} Sesiones</span>
                                <i style="color:#fff;" class="fas fa-chevron-down temario-arrow"></i>
                            </div>
                        </div>
                        <div class="collapse" id="temarioContent">
                            <div class="temario-body" style="background:#E9E9E9;border-radius:0 0 12px 12px;padding:15px;">
                                <div class="accordion" id="sesAcc" style="border:none;background:transparent;">

                                    @if(!empty($hierarchical))
                                        @foreach($hierarchical as $i => $item)
                                            @php $tipo = $item['tipo'] ?? ''; @endphp

                                            @if($tipo === 'curso')
                                            <div class="accordion-item" style="border:none;background:transparent;margin-bottom:12px;">
                                                <button class="accordion-button collapsed btn-curso" type="button" data-bs-toggle="collapse" data-bs-target="#c-{{ $i }}" aria-expanded="false" style="background:#1a252f;color:white;border-radius:8px;font-weight:bold;box-shadow:none;font-size:1.05em;display:flex;justify-content:space-between;align-items:center;">
                                                    <span>{{ $item['titulo'] ?? '' }}</span>
                                                    <i class="fas fa-chevron-down" style="color:#fff;"></i>
                                                </button>
                                                <div class="collapse" id="c-{{ $i }}" style="padding-top:10px;">
                                                    <div class="accordion" style="padding-left:10px;">
                                                        @if(!empty($item['lecturasPrevias']))
                                                        <div class="curso-lecturas" style="background:#fff;border-radius:8px;padding:12px;margin-bottom:10px;border-left:4px solid #2c3e50;">
                                                            {!! $item['lecturasPrevias'] !!}
                                                        </div>
                                                        @endif
                                                        @php $modulos = $item['modulos'] ?? []; $sesDirectas = $item['sesiones'] ?? []; @endphp
                                                        @if(!empty($modulos))
                                                            @foreach($modulos as $j => $mod)
                                                            <div class="accordion-item" style="border:none;background:transparent;margin-bottom:10px;">
                                                                <button class="accordion-button collapsed btn-modulo" type="button" data-bs-toggle="collapse" data-bs-target="#m-{{ $i }}-{{ $j }}" aria-expanded="false" style="background:#2c3e50;color:white;border-radius:8px;font-weight:bold;box-shadow:none;">
                                                                    <span>{{ $mod['titulo'] ?? '' }}</span>
                                                                </button>
                                                                <div class="collapse" id="m-{{ $i }}-{{ $j }}" style="padding-top:10px;">
                                                                    <div class="accordion">
                                                                        @foreach($mod['sesiones'] ?? [] as $k => $ses)
                                                                        <div class="accordion-item" style="border:none;background:transparent;margin-bottom:12px;">
                                                                            <h3 class="accordion-header">
                                                                                <button class="accordion-button collapsed accordion-button-sesion" type="button" data-bs-toggle="collapse" data-bs-target="#s-{{ $i }}-{{ $j }}-{{ $k }}" style="border-radius:10px;border:none;box-shadow:none;">
                                                                                    {{ $ses['titulo'] ?? '' }}
                                                                                </button>
                                                                            </h3>
                                                                            <div id="s-{{ $i }}-{{ $j }}-{{ $k }}" class="accordion-collapse collapse" data-bs-parent="#sesAcc">
                                                                                <div class="accordion-body" style="background:white;border-radius:0 0 10px 10px;margin-top:-5px;">
                                                                                    {!! renderContenidoHTML($ses['contenido'] ?? '') !!}
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @endforeach
                                                        @elseif(!empty($sesDirectas))
                                                            @foreach($sesDirectas as $k => $ses)
                                                            <div class="accordion-item" style="border:none;background:transparent;margin-bottom:12px;">
                                                                <h3 class="accordion-header">
                                                                    <button class="accordion-button collapsed accordion-button-sesion" type="button" data-bs-toggle="collapse" data-bs-target="#s-{{ $i }}-{{ $k }}" style="border-radius:10px;border:none;box-shadow:none;">
                                                                        {{ $ses['titulo'] ?? '' }}
                                                                    </button>
                                                                </h3>
                                                                <div id="s-{{ $i }}-{{ $k }}" class="accordion-collapse collapse" data-bs-parent="#sesAcc">
                                                                    <div class="accordion-body" style="background:white;border-radius:0 0 10px 10px;margin-top:-5px;">
                                                                        {!! renderContenidoHTML($ses['contenido'] ?? '') !!}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            @elseif($tipo === 'modulo')
                                            <div class="accordion-item" style="border:none;background:transparent;margin-bottom:10px;">
                                                <button class="accordion-button collapsed btn-modulo" type="button" data-bs-toggle="collapse" data-bs-target="#m-{{ $i }}" aria-expanded="false" style="background:#2c3e50;color:white;border-radius:8px;font-weight:bold;box-shadow:none;">
                                                    <span>{{ $item['titulo'] ?? '' }}</span>
                                                </button>
                                                <div class="collapse" id="m-{{ $i }}" style="padding-top:10px;">
                                                    <div class="accordion">
                                                        @foreach($item['sesiones'] ?? [] as $k => $ses)
                                                        <div class="accordion-item" style="border:none;background:transparent;margin-bottom:12px;">
                                                            <h3 class="accordion-header">
                                                                <button class="accordion-button collapsed accordion-button-sesion" type="button" data-bs-toggle="collapse" data-bs-target="#s-{{ $i }}-{{ $k }}" style="border-radius:10px;border:none;box-shadow:none;">
                                                                    {{ $ses['titulo'] ?? '' }}
                                                                </button>
                                                            </h3>
                                                            <div id="s-{{ $i }}-{{ $k }}" class="accordion-collapse collapse" data-bs-parent="#sesAcc">
                                                                <div class="accordion-body" style="background:white;border-radius:0 0 10px 10px;margin-top:-5px;">
                                                                    {!! renderContenidoHTML($ses['contenido'] ?? '') !!}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>

                                            @elseif($tipo === 'sesion')
                                            <div class="accordion-item" style="border:none;background:transparent;margin-bottom:12px;">
                                                <h3 class="accordion-header">
                                                    <button class="accordion-button collapsed accordion-button-sesion" type="button" data-bs-toggle="collapse" data-bs-target="#s-{{ $i }}" style="border-radius:10px;border:none;box-shadow:none;">
                                                        {{ $item['titulo'] ?? '' }}
                                                    </button>
                                                </h3>
                                                <div id="s-{{ $i }}" class="accordion-collapse collapse" data-bs-parent="#sesAcc">
                                                    <div class="accordion-body" style="background:white;border-radius:0 0 10px 10px;margin-top:-5px;">
                                                        {!! renderContenidoHTML($item['contenido'] ?? '') !!}
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        @endforeach

                                    @elseif($curso->temario->count() > 0)
                                        @foreach($curso->temario as $sesion)
                                        <div class="accordion-item" style="border:none;background:transparent;margin-bottom:12px;">
                                            <h3 class="accordion-header">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#s{{ $sesion->numero }}" style="border-radius:10px;border:none;box-shadow:none;">
                                                    {{ $sesion->titulo }}
                                                </button>
                                            </h3>
                                            <div id="s{{ $sesion->numero }}" class="accordion-collapse collapse" data-bs-parent="#sesAcc">
                                                <div class="accordion-body" style="background:white;border-radius:0 0 10px 10px;margin-top:-5px;">
                                                    @if($sesion->contenido_html)
                                                        {!! $sesion->contenido_html !!}
                                                    @elseif(is_array($sesion->temas) && count($sesion->temas) > 0)
                                                        <ul>@foreach($sesion->temas as $tema)<li>{{ $tema }}</li>@endforeach</ul>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section style="color:#03206A;" class="sec bg-white">
                <div class="inner-wrap">
                    <h2 class="cert-section-title">Certifícate y mejora<br>tus oportunidades</h2>
                    <p class="cert-section-desc">Obtén tu certificación acreditada con {{ $curso->hours ?? 90 }} horas académicas, válida tanto para el sector público como para el privado. Respaldado por la RPE Nº 000214-2025-SERVIR-PE, garantizamos reconocimiento en el mercado laboral.</p>
                    <div class="cert-box">
                        <span class="badge-solicitado">Más solicitado</span>
                        <div class="row g-4 align-items-center">
                            <div class="col-md-6">
                                <h3 class="cert-box-title">{{ $tipoCertificado }}</h3>
                                <p class="cert-box-sub">Otorgado Por: <br>Escuela de Gobierno y Gestión Publica</p>
                                <p class="cert-box-note">Precio de derecho de tramite incluido<br>en la inversion del programa</p>
                                <ul class="cert-list">
                                    <li><i class="fas fa-check-circle"></i> Certificado físico y digital</li>
                                    <li><i class="far fa-clock" style="color:#03206A;"></i> Duración de tramite: 24 horas</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <span><img src="{{ asset('img/curso-certificado.png') }}" alt="Certificado" class="cert-img-real"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            @if($curso->profesores->count() > 0)
            <section class="sec">
                <div class="inner-wrap">
                    <h2 class="section-title">PROFESORES</h2>
                    <div class="prof-scroll">
                        @foreach($curso->profesores as $index => $profesor)
                        @php $primerNombre = explode(' ', trim($profesor->name))[0]; @endphp
                        <div class="col-prof">
                            <div class="prof-card">
                                <div class="prof-card__imgWrap">
                                    <img src="{{ asset($profesor->photo) }}" class="prof-card__img" alt="{{ $profesor->name }}">
                                </div>
                                <div class="prof-card__body">
                                    <div class="prof-card__name">{{ $profesor->name }}</div>
                                    <button class="btn-ver-perfil" data-bs-toggle="modal" data-bs-target="#modalProfesor{{ $index + 1 }}">Ver Perfil</button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </section>
            @endif

            <section class="sec bg-rojo">
                <div class="valor-fondo"></div>
                <div class="inner-wrap">
                    <h2 class="section-title white">NUESTRO VALOR DIFERENCIAL</h2>
                    <div class="row g-3 justify-content-center">
                        <div class="col-md-6"><div class="dif-card"><div class="dif-icon"><img src="{{ asset('img/SVG/1x/Recurso 46.webp') }}" alt=""></div><div><p>23 años liderando el desarrollo de capacidades en gestión pública en el Perú.</p></div></div></div>
                        <div class="col-md-6"><div class="dif-card"><div class="dif-icon" style="margin-top:10px;"><img src="{{ asset('img/SVG/1x/Recurso 47.webp') }}" alt=""></div><div><p>Power Skills y Liderazgo para la Gestión Pública Moderna.</p></div></div></div>
                        <div class="col-md-6"><div class="dif-card"><div class="dif-icon" style="margin-top:10px;"><img src="{{ asset('img/SVG/1x/Recurso 48.webp') }}" alt=""></div><div><p>Expertos del MEF con Grado de Maestría.</p></div></div></div>
                        <div class="col-md-6"><div class="dif-card"><div class="dif-icon"><img src="{{ asset('img/SVG/1x/Recurso 49.webp') }}" alt=""></div><div><p>Acceso ilimitado 24/7 a clases grabadas y materiales durante un año.</p></div></div></div>
                        <div class="col-md-6"><div class="dif-card"><div class="dif-icon"><img src="{{ asset('img/SVG/1x/Recurso 51.webp') }}" alt=""></div><div><p>Doble certificación (física y digital) con código QR verificable al instante.</p></div></div></div>
                        <div class="col-md-6"><div class="dif-card"><div class="dif-icon" style="margin-top:10px;"><img src="{{ asset('img/SVG/1x/Recurso 52.webp') }}" alt=""></div><div><p>Innovación y calidad educativa garantizada.</p></div></div></div>
                    </div>
                </div>
            </section>{{-- INVERSIÓN Y FORMAS DE PAGO --}}
@if($curso->mode !== 'grabado')
<section class="rc-pay py-5" id="pago">
                <div class="inner-wrap">
                    <div class="text-center mb-4"><h2 class="rc-title mb-2">Inversión y formas de pago</h2></div>
                    <div style="display:flex;flex-wrap:wrap;justify-content:center;gap:20px;width:100%;">
                        <div style="flex:1;min-width:300px;max-width:550px;">
                            <div style="background:#eaeaea;border-radius:12px;padding:25px;height:100%;">
                                <div class="rc-block">
                                    <h3 class="rc-h4 mb-2">Pago por Aplicativo</h3>
                                    <p class="rc-p mb-3">Puedes pagar usando medios digitales como Yape, Plin o transferencia bancaria.</p>
                                    <div class="d-flex flex-wrap gap-2 justify-content-center mb-3" style="max-width:400px;margin:0 auto;">
                                        <img src="{{ asset('img/icons/bancos/bcp.png') }}" class="rc-pay-logo" alt="BCP">
                                        <img src="{{ asset('img/icons/bancos/Scotiabank.png') }}" class="rc-pay-logo" alt="Scotiabank">
                                        <img src="{{ asset('img/icons/bancos/interbank.png') }}" class="rc-pay-logo" alt="Interbank">
                                        <img src="{{ asset('img/icons/bancos/bbva.png') }}" class="rc-pay-logo" alt="BBVA">
                                        <img src="{{ asset('img/icons/bancos/yape.png') }}" class="rc-pay-logo" alt="Yape">
                                        <img src="{{ asset('img/icons/bancos/plim.png') }}" class="rc-pay-logo" alt="Plin">
                                    </div>
                                    <br>
                                    <button style="color:white;" class="btn rc-btn-primary w-100" type="button" data-bs-toggle="modal" data-bs-target="#modalCuentas">
                                        <img src="{{ asset('img/added/ojo.webp') }}" alt="Icono Cuentas" class="btn-icon-adjust"> Ver Cuentas disponibles
                                    </button>
                                </div>
                                <hr class="rc-hr">
                                <div class="rc-block">
                                    <h3 class="rc-h4 mb-2">Pago en línea con tarjeta <br>crédito y/o débito</h3>
                                    <p class="rc-p mb-3">Aceptamos NIUBIZ (PagoLink) con transacciones seguras.</p>
                                    <div class="contain-btn-pago" style="width:100%;">
                                        <form action="{{ route('carrito.buy', $curso->slug) }}" method="POST" style="display:inline">
                                            @csrf
                                            <button type="submit" class="btn btn-pago-tarjeta" style="border:none;width:100%">
                                                <i class="fas fa-credit-card"></i> <span>Pagar con tarjeta</span>
                                            </button>
                                        </form>
                                    </div>
                                    <div class="rc-safe mt-3">
                                        Pagos seguros encriptados con seguridad SSL
                                        <div class="mt-2"><img src="{{ asset('img/tarjetas.png') }}" class="img-fluid" alt="Tarjetas aceptadas"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="flex:1;min-width:300px;max-width:550px;">
                            <div style="background:#eaeaea;border-radius:12px;padding:25px;height:100%;">
                                <div class="rc-right-top">
                                    @if($ahorro > 0)
                                    <h3 class="rc-h4 mb-3">Invierta en su futuro y <span style="color:#de004b;">ahorre hasta S/{{ $ahorro }}</span> con nuestras promociones vigentes</h3>
                                    @else
                                    <h3 class="rc-h4 mb-3">Invierta en su futuro con nuestras promociones vigentes</h3>
                                    @endif
                                    <div class="rc-price rc-price--promo mb-3">
                                        <div class="d-flex align-items-center gap-3">
                                            <span class="rc-coin-rosa">S/</span>
                                            <div>
                                                <div class="rc-price__name" style="color:#FF044D;">Oferta Flash:</div>
                                                <div class="rc-price__sub" style="color:#FF044D;font-size:0.8rem;">Hasta el {{ $curso->precio_flash_fecha ?? 'próximamente' }}<br>o primeros 20 cupos</div>
                                            </div>
                                        </div>
                                        <div class="rc-price__amount" style="color:#FF044D;">S/ {{ $curso->precio_flash ?? '0' }}</div>
                                    </div>
                                    @if($curso->precio_pronto)
                                    <div class="rc-price rc-price--normal mb-3">
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="rc-coin">S/</span>
                                            <div><div class="rc-price__name">Pronto Pago:</div><div class="rc-price__sub">{{ $curso->precio_pronto_fecha ?? 'Preventa disponible' }}</div></div>
                                        </div>
                                        <div class="rc-price__amount">S/ {{ $curso->precio_pronto }}</div>
                                    </div>
                                    @endif
                                    <div class="rc-price rc-price--normal mb-3">
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="rc-coin">S/</span>
                                            <div><div class="rc-price__name">Inversión Regular:</div><div class="rc-price__sub">Precio base</div></div>
                                        </div>
                                        <div class="rc-price__amount">S/ {{ $curso->precio_regular ?? '0' }}</div>
                                    </div>
                                    @if($curso->advisor)
                                    <div style="text-align:center;width:100%;margin-top:20px;">
                                        <a href="https://wa.me/{{ $curso->advisor->whatsapp }}?text=Hola%20{{ urlencode($curso->advisor->name) }}%2C%20podr%C3%ADas%20guiarme%20para%20realizar%20el%20pago%20del%20{{ urlencode($curso->title) }}." class="btn-wsp-inversion" target="_blank" rel="noopener">
                                            <i class="fab fa-whatsapp"></i> <span>Contacta con una asesora</span>
                                        </a>
                                    </div>
                                    @endif
                                    <div class="rc-note mt-3">
                                        <ul>
                                            <li>Reserva tu vacante mientras se gestiona la inscripción.</li>
                                            <li>Si eres corporativo, te guiamos con la O/S paso a paso.</li>
                                        </ul>
                                    </div>
                                </div>
                                <hr class="rc-hr">
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            @endif

            {{-- INVERSIÓN — MODO GRABADO (Online / Acceso inmediato) --}}
            @if($curso->mode === 'grabado')
            <section class="sec bg-white" id="pagoa">
                <div class="inner-wrap">
                    <h2 class="section-title">Invierte y proyéctate</h2>
                    <p style="font-size:13.5px;color:var(--texto-medio);text-align:center;margin-bottom:28px;">Curso 100% grabado | Acceso inmediato 24/7</p>
                    <div class="inversion-wrap">
                        <div class="inversion-main" style="background:#03206A;">
                            <div class="inversion-left" style="background-color:#03206A;border-right:1px solid rgba(255,255,255,0.2);">
                                <h3 style="color:#fff;">Tu inscripción incluye:</h3>
                                <ul>
                                    <li style="color:#FFFFFFB3;">Acceso inmediato 24/7 al curso grabado.</li>
                                    <li style="color:#FFFFFFB3;">Certificación válida para convocatorias públicas (lista para tu CV).</li>
                                    <li style="color:#FFFFFFB3;"><strong style="color:#fff;">{{ $curso->sessions ?? 6 }} sesiones grabadas</strong> para aprender y resolver dudas al momento.</li>
                                    <li style="color:#FFFFFFB3;"><strong style="color:#fff;">Plataforma exclusiva</strong> para estudiar fácil, repasar y aplicar.</li>
                                </ul>
                            </div>
                            <div class="inversion-right" style="background-color:#03206A;">
                                <div id="inv-label-flash" class="inv-label" style="color:#FFFFFFB3;">¡Oferta Flash!</div>
                                <div class="inv-price" style="color:#fff;font-size:42px;font-weight:700;">S/. {{ $curso->precio_flash ?? '0' }}</div>
                                <form action="{{ route('carrito.buy', $curso->slug) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn-acceder-card" style="border:none;width:100%;display:flex;align-items:center;justify-content:center;gap:8px;padding:14px;border-radius:12px;background:var(--rojo);color:#fff;font-weight:700;cursor:pointer;">
                                        <i class="fas fa-credit-card"></i> Acceder ahora
                                    </button>
                                </form>
                                <br>
                                <div class="inv-label" style="color:#FFFFFFB3;">Consulte con su asesora</div>
                                <div class="inv-igv" style="color:#fff;">Todos los precios incluyen IGV</div>
                            </div>
                        </div>
                        @if($curso->advisor)
                        <div style="width:100%;max-width:750px;margin:30px auto 0;display:flex;justify-content:center;">
                            <a href="https://wa.me/{{ $curso->advisor->whatsapp }}?text=Hola%20{{ urlencode($curso->advisor->name) }}%2C%20deseo%20reservar%20mi%20vacante%20para%20el%20{{ urlencode($curso->title) }}.%20Podr%C3%ADas%20ayudarme%2C%20por%20favor." class="btn-wsp-inversion" style="justify-content:center;" target="_blank" rel="noopener">
                                <i class="fab fa-whatsapp"></i> <span>Activa tu acceso por WhatsApp</span>
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </section>
            @endif

            {{-- ASESORA WHATSAPP --}}
            @if($curso->mode !== 'grabado')
            @if($curso->advisor)
            <section class="sec-asesora">
                <div class="asesora-fondo"></div>
                <div class="inner-wrap">
                    <h2 class="asesora-title">¿Prefieres hablar por WhatsApp?</h2>
                    <p class="asesora-subtitle">Nuestros asesores están disponibles para brindarte asesoría personalizada.<br>¡Comunícate con nosotros ahora mismo!</p>
                    <div class="asesora-card-wrap">
                        <a href="https://wa.me/{{ $curso->advisor->whatsapp }}?text=Hola%20{{ urlencode($curso->advisor->name) }}%2C%20consulta%20sobre%20el%20{{ urlencode($curso->title) }}.%20Informaci%C3%B3n%20y%20Promoci%C3%B3n%2C%20por%20favor." target="_blank">
                            <img src="{{ asset($curso->advisor->photo_web ?? $curso->advisor->photo) }}" alt="Asesora de WhatsApp" class="asesora-full-img">
                        </a>
                    </div>
                </div>
            </section>
            @endif
            @endif

            <section class="sec" id="testimonio-seccion">
                <div class="testimonios-fondo"></div>
                <div class="inner-wrap">
                    <h2 class="section-title">TESTIMONIOS: 23 AÑOS GENERANDO VALOR</h2>
                    <div class="testi-grid" id="testiGrid">
                        <div class="testi-card" id="testiA"><p></p><div class="testi-foto"></div><h5></h5><small></small></div>
                        <div class="testi-card" id="testiB"><p></p><div class="testi-foto"></div><h5></h5><small></small></div>
                    </div>
                    <div class="testi-dots" id="testiDots"></div>
                </div>
            </section>

            @if($curso->mode !== 'grabado')
            <section class="sec" style="background-color:white;">
                <div class="inner-wrap">
                    <h2 class="section-title">¡Asegura tu vacante hoy!</h2>
                    <p style="font-size:13.5px;color:var(--texto-medio);text-align:center;margin-bottom:28px;">Inscríbete ahora y accede a estos beneficios:</p>
                    <div class="inversion-wrap">
                        <div class="inversion-main">
                            <div class="inversion-left">
                                <h3>Tu inscripción incluye:</h3>
                                <ul>
                                    <li>Certificación válida para convocatorias públicas (lista para tu CV).</li>
                                    <li><strong>Docentes especialistas</strong> con amplia trayectoria en el sector.</li>
                                    <li><strong>{{ $curso->sessions ?? 6 }} sesiones {{ $modoClases }}</strong> para aprender y resolver dudas al momento.</li>
                                    <li><strong>Plataforma exclusiva</strong> para estudiar fácil, repasar y aplicar.</li>
                                </ul>
                            </div>
                            <div class="inversion-right">
                                <div class="inv-title">Compra segura con tarjeta.</div>
                                <div class="inv-regular-price">Precio regular: S/. {{ $curso->precio_regular ?? '0' }}</div>
                                <div class="inv-discount-badge">¡Oferta Flash!</div>
                                <div class="inv-price-main"><span>S/.</span> {{ $curso->precio_flash ?? '0' }}</div>
                                <form action="{{ route('carrito.buy', $curso->slug) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn-acceder-card" style="border:none;width:100%;display:flex;align-items:center;justify-content:center;gap:8px;padding:14px;border-radius:12px;background:var(--rojo);color:#fff;font-weight:700;cursor:pointer;">
                                        <i class="fas fa-credit-card"></i> Pagar con tarjeta
                                    </button>
                                </form>
                                <br>
                                <div class="inv-secure">Pagos seguros encriptados con seguridad SSL</div>
                                <div class="inv-igv">Todos los precios incluyen IGV</div>
                            </div>
                        </div>
                        @if($curso->advisor)
                        <div style="width:100%;max-width:750px;margin:30px auto 0;display:flex;justify-content:center;">
                            <a href="https://wa.me/{{ $curso->advisor->whatsapp }}?text=Hola%20{{ urlencode($curso->advisor->name) }}%2C%20deseo%20reservar%20mi%20vacante%20para%20el%20{{ urlencode($curso->title) }}.%20Podr%C3%ADas%20ayudarme%2C%20por%20favor." class="btn-wsp-inversion btn-wsp-asegura" style="justify-content:center;" target="_blank" rel="noopener">
                                <i class="fab fa-whatsapp"></i> <span>Escríbenos por WhatsApp y asegura tu vacante hoy</span>
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </section>
            @endif

            @if($curso->inhouse_web || $curso->inhouse_mobile)
            <div class="inhouse-section">
                <div class="inhouse-wrap" data-bs-toggle="modal" data-bs-target="#inhouseModal">
                    <div class="inhouse-ph">
                        <picture>
                            @if($curso->inhouse_mobile)
                            <source media="(max-width:768px)" srcset="{{ asset($curso->inhouse_mobile) }}">
                            @endif
                            @if($curso->inhouse_web)
                            <img src="{{ asset($curso->inhouse_web) }}" alt="Programa In House">
                            @endif
                        </picture>
                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>
</div>



<div class="mobile-sticky-red">
    <div class="msb-red-content">
        <span class="msb-red-text">¡Oferta especial -50% de descuento!</span>
    </div>
</div>

<div class="mobile-sticky-bar">
    <div class="msb-price"><span>S/.</span> {{ $curso->precio_flash ?? $curso->precio_regular ?? '0' }}</div>
    <form action="{{ route('carrito.buy', $curso->slug) }}" method="POST" style="display:inline">
        @csrf
        <button type="submit" class="btn-acceder-card-no-margin" style="border:none;display:flex;align-items:center;gap:8px;padding:12px 25px;border-radius:50px;background:var(--rojo);color:#fff;font-weight:700;cursor:pointer;">
            <i class="fas fa-credit-card"></i> Pagar con tarjeta
        </button>
    </form>
</div>

<div class="modal fade" id="modalRegistro" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:420px;">
        <div class="modal-content">
            <div class="modal-header" style="background:var(--azul);border-radius:14px 14px 0 0;">
                <h3 style="color:#fff;font-family:'Poppins',sans-serif;font-size:15px;font-weight:800;margin:0;">✉️ Registra tus datos</h3>
                <button type="button" class="btn-close" style="filter:invert(1);" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" style="padding:20px 24px;">
                <p style="font-size:12px;color:var(--texto-medio);margin-bottom:16px;">Un asesor especializado te contactará para ayudarte con tu inscripción.</p>
                <form onsubmit="return handleLead(event)" id="formRegistroModal">
                    <input class="form-control" name="nombre" placeholder="Ingresa nombre completo" required style="margin-bottom:10px;border-radius:8px;border:1.5px solid var(--gris-medio);padding:10px 14px;font-size:13px;width:100%;">
                    <input class="form-control" type="email" name="correo" placeholder="Ingresa correo electrónico" required style="margin-bottom:10px;border-radius:8px;border:1.5px solid var(--gris-medio);padding:10px 14px;font-size:13px;width:100%;">
                    <input class="form-control" type="tel" name="celular" placeholder="Ingresa celular/WhatsApp" required style="margin-bottom:12px;border-radius:8px;border:1.5px solid var(--gris-medio);padding:10px 14px;font-size:13px;width:100%;">
                    <label style="display:flex;align-items:flex-start;gap:8px;cursor:pointer;font-size:11px;color:var(--texto-medio);margin-bottom:16px;">
                        <input type="checkbox" required checked style="margin-top:2px;flex-shrink:0;">
                        <span>Acepto las políticas de privacidad de datos</span>
                    </label>
                    <button type="submit" style="width:100%;background:var(--rojo);color:#fff;font-family:'Poppins',sans-serif;font-size:13px;font-weight:700;padding:12px;border-radius:9px;border:none;cursor:pointer;transition:background .2s;">🚀 Solicitar información</button>
                </form>
            </div>
        </div>
    </div>
</div>

@foreach($curso->profesores as $index => $profesor)
<div class="modal fade" id="modalProfesor{{ $index + 1 }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">{{ $profesor->name }}</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if(is_array($profesor->formacion) && count($profesor->formacion) > 0)
                <h4>Formación Profesional</h4>
                <ul>@foreach($profesor->formacion as $form)<li>{{ $form }}</li>@endforeach</ul>
                @endif
                @if(is_array($profesor->experiencia) && count($profesor->experiencia) > 0)
                <h4>Experiencia Profesional</h4>
                <ul>@foreach($profesor->experiencia as $exp)<li>{{ $exp }}</li>@endforeach</ul>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
@endforeach

<div class="modal fade" id="modalCuentas" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content payment-modal-content">
            <div class="modal-header border-0">
                <h2 class="payment-title w-100 text-center">MÉTODOS DE PAGO</h2>
                <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="payment-list">
                    <div class="pay-item">
                        <div class="pay-logo"><img src="{{ asset('img/icons/bancos/Logo-CONCAP-12.png') }}" alt="Banco de la Nación"></div>
                        <div class="pay-info"><span class="pay-bank">Banco de la Nación</span><span class="pay-detail">Cuenta: 04-015-718973</span><span class="pay-detail">Titular: R&C Consulting</span></div>
                    </div>
                    <div class="pay-item">
                        <div class="pay-logo"><img src="{{ asset('img/icons/bancos/bbva.png') }}" alt="BBVA"></div>
                        <div class="pay-info"><span class="pay-bank">Banco BBVA</span><span class="pay-detail">Cuenta: 0011 – 0153 – 0200601672</span><span class="pay-detail">Titular: R&C Consulting</span></div>
                    </div>
                    <div class="pay-item">
                        <div class="pay-logo"><img src="{{ asset('img/icons/bancos/bcp.png') }}" alt="BCP"></div>
                        <div class="pay-info"><span class="pay-bank">Banco de Crédito del Perú</span><span class="pay-detail">Cuenta: 193-2215-6471-0-72</span><span class="pay-detail">Titular: MISAEL RIVERA CARHUAPUMA</span></div>
                    </div>
                    <div class="pay-item">
                        <div class="pay-logo"><img src="{{ asset('img/icons/bancos/interbank.png') }}" alt="Interbank"></div>
                        <div class="pay-info"><span class="pay-bank">Banco Interbank</span><span class="pay-detail">Cuenta: 011-3037-901825</span><span class="pay-detail">Titular: MISAEL RIVERA CARHUAPUMA</span></div>
                    </div>
                    <div class="pay-item">
                        <div class="pay-logo"><img src="{{ asset('img/icons/bancos/Scotiabank.png') }}" alt="Scotiabank"></div>
                        <div class="pay-info"><span class="pay-bank">Banco Scotiabank</span><span class="pay-detail">Cuenta: 027-7653721</span><span class="pay-detail">Titular: MISAEL RIVERA CARHUAPUMA</span></div>
                    </div>
                </div>
                <div class="pay-qr-section row g-2">
                    <div class="col-6"><div class="qr-container"><div class="qr-label"><img src="{{ asset('img/icons/bancos/yape.png') }}" alt="Yape"></div><img src="{{ asset('img/icons/bancos/yape-qr.png') }}" class="qr-img" alt="Yape QR"></div></div>
                    <div class="col-6"><div class="qr-container"><div class="qr-label"><img src="{{ asset('img/icons/bancos/plim.png') }}" alt="Plin"></div><img src="{{ asset('img/icons/bancos/plin-qr.png') }}" class="qr-img" alt="Plin QR"></div></div>
                </div>
                <div class="pay-footer mt-3"><p>Titular: MISAEL RIVERA CARHUAPUMA</p></div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalGracias" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" style="max-width:560px;">
        <div class="modal-content" style="border:none;border-radius:20px;overflow:hidden;background:transparent;">
            <button type="button" class="btn-close btn-close-white position-absolute" data-bs-dismiss="modal" aria-label="Close" style="top:15px;right:15px;z-index:10;filter:brightness(0)invert(1);"></button>
            <div class="card-gracias">
                <div class="cg-top">
                    <div class="cg-check-badge">
                        <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                    </div>
                    <h1>¡Gracias por tu interés<br>en <span>crecer con nosotros!</span></h1>
                    <p class="cg-sub">Recibimos tus datos correctamente. Uno de nuestros asesores especializadas se pondrá en contacto contigo muy pronto.</p>
                    <svg class="cg-wave" viewBox="0 0 560 32" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none"><path d="M0,0 C140,32 420,0 560,24 L560,32 L0,32 Z" fill="white"/></svg>
                </div>
                <div class="cg-body">
                    <div class="cg-steps-grid">
                        <div class="cg-step-item"><div class="cg-step-num">1</div><p>Revisamos tu solicitud</p></div>
                        <div class="cg-step-item"><div class="cg-step-num">2</div><p>Te contactamos pronto</p></div>
                    </div>
                    <div class="cg-time-badge">
                        <div class="cg-time-icon">⏱️</div>
                        <div>
                            <h4>Tiempo de respuesta: menos de 5 minutos</h4>
                            <p>Una asesora ya fue notificada y estará contactándote en breve por el medio que registraste.</p>
                        </div>
                    </div>
                    <div class="cg-divider"></div>
                    <div class="cg-urgent">
                        <div class="cg-urgent-label">
                            <svg viewBox="0 0 24 24" fill="#25D366" width="18" height="18"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M11.999 1C6.477 1 2 5.477 2 11.999a9.94 9.94 0 0 0 1.508 5.255L2 22l4.9-1.474A9.95 9.95 0 0 0 12 22c5.522 0 10-4.477 10-10.001C22 5.477 17.522 1 12 1zm0 18.195a8.19 8.19 0 0 1-4.185-1.148l-.3-.178-3.106.934.888-3.024-.196-.313A8.192 8.192 0 0 1 3.805 12C3.805 6.471 7.471 2.805 12 2.805c4.528 0 8.194 3.666 8.194 8.194 0 4.529-3.666 8.196-8.195 8.196z"/></svg>
                            <span>¿Caso urgente?</span>
                        </div>
                        <p>Si necesitas atención inmediata y no puedes esperar, escríbenos directamente por WhatsApp y uno de los asesores te responderá al instante.</p>
                        @if($curso->advisor)
                        <a class="cg-wsp-btn" href="https://wa.me/{{ $curso->advisor->whatsapp }}?text=Hola%20{{ urlencode($curso->advisor->name) }}%2C%20acabo%20de%20registrar%20mis%20datos%20en%20el%20{{ urlencode($curso->title) }}.%20Quedo%20a%20la%20espera%20de%20tu%20contacto." target="_blank">
                            <svg viewBox="0 0 24 24" fill="white" width="20" height="20"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M11.999 1C6.477 1 2 5.477 2 11.999a9.94 9.94 0 0 0 1.508 5.255L2 22l4.9-1.474A9.95 9.95 0 0 0 12 22c5.522 0 10-4.477 10-10.001C22 5.477 17.522 1 12 1zm0 18.195a8.19 8.19 0 0 1-4.185-1.148l-.3-.178-3.106.934.888-3.024-.196-.313A8.192 8.192 0 0 1 3.805 12C3.805 6.471 7.471 2.805 12 2.805c4.528 0 8.194 3.666 8.194 8.194 0 4.529-3.666 8.196-8.195 8.196z"/></svg>
                            Escribir por WhatsApp ahora
                        </a>
                        @endif
                    </div>
                    <a class="cg-main-cta" href="{{ route('cursos-virtuales') }}" target="_blank">Ver ofertas para mí</a>
                    <p class="cg-cta-sub">Descubre todos nuestros programas y elige el que mejor se adapta a ti</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="inhouseModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content border-0" style="border-radius:15px;overflow:hidden;">
            <div class="modal-body p-0">
                <div class="c-main-layout">
                    <div class="c-design-column">
                        <div class="c-top-banner" style="margin-top:40px;">
                            <img src="{{ asset($curso->inhouse_web ?? 'img/inhouse-01.jpg') }}" alt="Personas con laptop" class="c-hero-img">
                            <div class="c-badge-tag">{{ $badgeTipo }}</div>
                        </div>
                        <div class="c-navy-bar">
                            <i class="fas fa-users" style="color:#FFB800;font-size:24px;margin-right:10px;"></i>
                            <span>Evita observaciones. Estandariza tu equipo.</span>
                        </div>
                        <div class="c-fucsia-content">
                            <h2 class="c-fucsia-text">Modalidad In-House: Un solo curso, un solo estándar: todo tu equipo alineado y operativo.</h2>
                            <div class="c-fucsia-footer">
                                <a href="mailto:asesor@rc-consulting.org" class="c-btn-white"><span class="icon-mail"></span> asesor@rc-consulting.org</a>
                                <a href="https://wa.me/51948163352?text=Hola%20Arnaldo,%20vengo%20de%20la%20web.%20Me%20interesa%20solicitar%20una%20Propuesta%20In%20House%20del%20{{ urlencode($curso->title) }}%20para%20mi%20instituci%C3%B3n%20alineada%20al%20PDP%202026." class="c-btn-whatsapp" target="_blank" rel="noopener"><span class="icon-wa"></span> WhatsApp directo</a>
                            </div>
                        </div>
                    </div>
                    <div class="c-form-column">
                        <span class="c-pill">Programa In House</span>
                        <h1 class="c-title">{{ $curso->title }}</h1>
                        <p class="c-description">{{ $curso->description }}</p>
                        <div class="c-form-container">
                            <h3>Solicita una proforma aquí</h3>
                            <form id="inhouseForm" class="c-form-grid" onsubmit="return handleInhouseLead(event)">
                                <input type="text" placeholder="Ingresa nombre completo" name="nombres" required>
                                <input type="email" placeholder="Ingresa correo electrónico" name="correo" required>
                                <input type="tel" placeholder="Ingresa celular/WhatsApp" name="telefono" pattern="[0-9]{9}" maxlength="9" oninput="this.value = this.value.replace(/[^0-9]/g, '');" title="Debe ingresar exactamente 9 números" required>
                                <input type="text" placeholder="Nombre de tu empresa" name="institucion" required>
                                <select name="cantidadAlumnos" required>
                                    <option value="">Cantidad de alumnos</option>
                                    <option value="5-10">5-10 alumnos</option>
                                    <option value="11-20">11-20 alumnos</option>
                                    <option value="21-30">21-30 alumnos</option>
                                    <option value="31-50">31-50 alumnos</option>
                                    <option value="50+">50+ alumnos</option>
                                </select>
                                <select name="nivelCurso" required>
                                    <option value="">Nivel de curso</option>
                                    <option value="Básico">Básico</option>
                                    <option value="Intermedio">Intermedio</option>
                                    <option value="Avanzado">Avanzado</option>
                                    <option value="Personalizado">Personalizado</option>
                                </select>
                                <div class="c-check-area">
                                    <input type="checkbox" id="terms" name="terminos" required>
                                    <label for="terms">Acepto términos, condiciones y las políticas de privacidad</label>
                                </div>
                                <button type="submit" class="c-btn-submit">Enviar proforma</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if($curso->advisor)
<a class="wa-float" href="https://wa.me/{{ $curso->advisor->whatsapp }}?text=Hola%20{{ urlencode($curso->advisor->name) }}%2C%20consulta%20sobre%20el%20{{ urlencode($curso->title) }}.%20Informaci%C3%B3n%20y%20Promoci%C3%B3n%2C%20por%20favor." target="_blank" rel="noopener">
    <span class="btn-text">PROMO ACTIVA</span>
    <i class="fab fa-whatsapp" style="font-size:16px;"></i>
</a>
@endif

@endsection

@section('scripts')
<script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function abrirPagoNiubiz() {
    var url = "{{ $curso->link_niubiz ?? '' }}";
    if (!url) { alert('Link de pago no disponible aún'); return; }
    var w = 500, h = 650;
    var left = (screen.width - w) / 2;
    var top = (screen.height - h) / 2;
    window.open(url, 'PagoNiubiz', 'width=' + w + ',height=' + h + ',top=' + top + ',left=' + left + ',resizable=yes,scrollbars=yes');
}

var API_LEADS_URL = '{{ url('api/leads') }}';

async function sendToApps(paramsObj) {
    try {
        Swal.fire({ title: 'Enviando...', text: 'Por favor espere', allowOutsideClick: false, didOpen: () => Swal.showLoading() });
        const resp = await fetch(API_LEADS_URL, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            },
            body: JSON.stringify(paramsObj)
        });
        if (!resp.ok) {
            const errText = await resp.text();
            console.error('API error:', resp.status, errText);
            Swal.fire({ icon: 'error', title: 'Error al enviar', text: 'El servidor respondió con error: ' + resp.status, confirmButtonColor: '#dc3545' });
            return false;
        }
        await new Promise(resolve => setTimeout(resolve, 1500));
        Swal.close();
        const modalGraciasEl = document.getElementById('modalGracias');
        if (modalGraciasEl && typeof bootstrap !== 'undefined') {
            const modalGracias = bootstrap.Modal.getInstance(modalGraciasEl) || new bootstrap.Modal(modalGraciasEl);
            modalGracias.show();
        }
        return true;
    } catch (err) {
        console.error('Error:', err);
        Swal.fire({ icon: 'error', title: 'Error al enviar', text: 'Inténtalo nuevamente más tarde.', confirmButtonColor: '#dc3545' });
        return false;
    }
}

function handleLead(e) {
    e.preventDefault();
    const form = e.target;
    const nombre = form.querySelector('input[name="nombre"]')?.value || '';
    const correo = form.querySelector('input[name="correo"]')?.value || '';
    const celular = form.querySelector('input[name="celular"]')?.value || '';
    const payload = { origen: 'Formulario Web', nombre: nombre, correo: correo, celular: celular, curso: "{{ $curso->title }}", consulta: '', advisor_id: {{ $curso->asesora_id ?? 'null' }} };
    sendToApps(payload).then(ok => { if (ok) form.reset(); });
    return false;
}

function handleInhouseLead(e) {
    e.preventDefault();
    const form = e.target;
    const payload = {
        origen: 'INHOUSE - SOLICITUD PROFORMA',
        nombre: form.querySelector('input[name="nombres"]')?.value || '',
        correo: form.querySelector('input[name="correo"]')?.value || '',
        celular: form.querySelector('input[name="telefono"]')?.value || '',
        institucion: form.querySelector('input[name="institucion"]')?.value || '',
        cantidadAlumnos: form.querySelector('select[name="cantidadAlumnos"]')?.value || '',
        nivelCurso: form.querySelector('select[name="nivelCurso"]')?.value || '',
        curso: "{{ $curso->title }}",
        consulta: 'Solicitud de proforma In House',
        advisor_id: {{ $curso->asesora_id ?? 'null' }}
    };
    sendToApps(payload).then(ok => {
        if (ok) {
            try {
                const modalEl = document.getElementById('inhouseModal');
                if (modalEl && typeof bootstrap !== 'undefined') {
                    const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                    modal.hide();
                }
            } catch (err) { console.warn('Error al cerrar modal inhouse', err); }
            form.reset();
        }
    });
    return false;
}

document.addEventListener('DOMContentLoaded', function () {
    const hero = document.getElementById('inicio');
    const videoContainer = document.getElementById('videoContainer');
    if (hero && videoContainer) {
        function toggleVideoVisibility() {
            var rect = hero.getBoundingClientRect();
            videoContainer.style.display = rect.bottom < 0 ? 'none' : '';
        }
        toggleVideoVisibility();
        window.addEventListener('scroll', toggleVideoVisibility, { passive: true });
    }
    if (videoContainer) {
        videoContainer.addEventListener('click', function () {
            @if($videoUrl)
            var iframe = document.createElement('iframe');
            iframe.src = "{!! $videoUrl !!}";
            iframe.style.position = "absolute";
            iframe.style.top = "0";
            iframe.style.left = "0";
            iframe.style.width = "100%";
            iframe.style.height = "100%";
            iframe.setAttribute('frameborder', '0');
            iframe.setAttribute('allow', 'autoplay; fullscreen; picture-in-picture');
            iframe.setAttribute('allowfullscreen', '');
            this.innerHTML = '';
            this.appendChild(iframe);
            @endif
        });
    }
});

(function () {
    var data = [
        { txt: '"Gracias a R&C Consulting fortalecí mis conocimientos y accedí a oportunidades laborales."', name: 'Landy Chong Bartra', cargo: 'Dirección General de Contabilidad Pública<br>Ministerio de Economía y Finanzas', img: '{{ asset("img/testimonio-1.png") }}' },
        { txt: '"Los cursos de R&C Consulting complementaron mi formación como Abogada con 28 años en el Sector Público."', name: 'Ysabel Fernández Larrea', cargo: 'Secretaria Técnica - STPAD<br>Autoridad Nacional de Infraestructura', img: '{{ asset("img/testimonio-2.png") }}' },
        { txt: '"Experiencia enriquecedora que permitió a nuestros colaboradores capacitarse y a la empresa competir y ganar."', name: 'Corina Ramos', cargo: 'Gerencia de Recursos del Talento Humano<br>VIR&COR ASOCIADOS S.A.C', img: '{{ asset("img/testimonio-3.png") }}' },
        { txt: '"R&C Consulting me ayudó a mejorar criterios y entender mediante casos prácticos las nuevas normativas."', name: 'Mag. Juan J. Alva Isuiza', cargo: 'Coordinador de Presupuesto<br>Municipalidad Distrital de San Miguel', img: '{{ asset("img/testimonio-4.png") }}' }
    ];
    var pairs = [[0, 1], [2, 3]], current = 0;
    var cA = document.getElementById('testiA'), cB = document.getElementById('testiB'), dw = document.getElementById('testiDots');
    function render(i) {
        current = i; var p = pairs[i], a = data[p[0]], b = data[p[1]];
        cA.style.opacity = 0; cB.style.opacity = 0;
        setTimeout(function () {
            cA.querySelector('p').textContent = a.txt;
            cA.querySelector('h5').textContent = a.name;
            cA.querySelector('small').innerHTML = a.cargo;
            cA.querySelector('.testi-foto').innerHTML = '<img src="' + a.img + '" alt="' + a.name + '">';
            cB.querySelector('p').textContent = b.txt;
            cB.querySelector('h5').textContent = b.name;
            cB.querySelector('small').innerHTML = b.cargo;
            cB.querySelector('.testi-foto').innerHTML = '<img src="' + b.img + '" alt="' + b.name + '">';
            cA.style.opacity = 1; cB.style.opacity = 1;
        }, 300);
        dw.innerHTML = '';
        for (var j = 0; j < pairs.length; j++) {
            var d = document.createElement('button'); d.className = 'testi-dot' + (j === current ? ' active' : ''); d.setAttribute('data-i', j);
            d.onclick = function () { render(parseInt(this.getAttribute('data-i'))); }; dw.appendChild(d);
        }
    }
    render(0);
    var t = setInterval(function () { render(current >= pairs.length - 1 ? 0 : current + 1); }, 5000);
    var g = document.getElementById('testiGrid');
    g.addEventListener('mouseenter', function () { clearInterval(t); });
    g.addEventListener('mouseleave', function () { t = setInterval(function () { render(current >= pairs.length - 1 ? 0 : current + 1); }, 5000); });
})();

document.addEventListener("DOMContentLoaded", function () {
    const temarioHeader = document.querySelector('.temario-header[data-bs-target="#temarioContent"]');
    const temarioContent = document.querySelector('#temarioContent');
    if (window.innerWidth >= 768) {
        if (temarioHeader && temarioContent) {
            temarioHeader.classList.remove('collapsed');
            temarioHeader.setAttribute('aria-expanded', 'true');
            temarioContent.classList.add('show');
        }
    }
});

function hidePanelAmarillo() {
    const width = window.innerWidth;
    const panel = document.querySelector('.panel-amarillo');
    if (panel) { panel.style.display = width <= 1024 ? 'none' : ''; }
}
window.addEventListener('load', hidePanelAmarillo);
window.addEventListener('resize', hidePanelAmarillo);
</script>
@endsection
