@extends('layouts.clean')

@section('title', 'In House | R&C Consulting')

@section('styles')
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
<link href="{{ asset('inhouse/styles.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
<link rel="icon" href="{{ asset('inhouse/img/logo-rc-consulting-icono.ico') }}" sizes="32x32">
@endsection

@section('content')

<div class="banner-purpura">
    <div class="inner-wrap">
        <div class="contenido-banner-purpura">
            <div class="banner-item">
                <div class="banner-icon">
                    <img src="{{ asset('inhouse/img/icons/casa.svg') }}" alt="PDP">
                </div>
                <div class="banner-text">
                    <b>Cumple con el PDP 2026</b>
                    <span>Alinea tu capacitación In-House</span>
                </div>
            </div>

            <div class="banner-item">
                <div class="banner-icon">
                    <img src="{{ asset('inhouse/img/icons/merito.svg') }}" alt="Directiva">
                </div>
                <div class="banner-text">
                    <b class="highlight-yellow">CURSOS IN HOUSE</b>
                    <span>Nueva Directiva 00214-2025-SERVIR-PE</span>
                </div>
            </div>

            <div class="banner-action">
                <a href="https://wa.me/51948163352?text=Hola%20Arnaldo,%20vengo%20de%20la%20web.%20Me%20interesa%20solicitar%20una%20Propuesta%20In%20House%20para%20mi%20instituci%C3%B3n%20alineada%20al%20PDP%202026.%20%C2%BFPodr%C3%ADas%20ayudarme?"
                    class="btn-cotizar" style="color: #5044c2;" target="_blank">
                    <i class="fas fa-handshake"></i> ¡Cotizalo aqui!
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Navegación -->
<nav class="navbar navbar-expand-lg rc-navbar">
    <div class="container" style="background-color: white;">

        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{ asset('inhouse/img/logo-rc-consulting-sin-fondo.webp') }}" class="rc-logo" alt="R&C Consulting">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNav">

            <ul class="navbar-nav mx-auto w-100 justify-content-evenly">
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/') }}">Inicio</a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Nosotros</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ url('/nosotros') }}">Sobre Nosotros</a></li>
                        <li><a class="dropdown-item" href="{{ url('/experiencia') }}">Experiencia y Alianzas</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Programas</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('cursos-virtuales') }}">Cursos</a></li>
                        <li><a class="dropdown-item" href="{{ route('diplomas-virtuales') }}">Diplomas</a></li>
                        <li><a class="dropdown-item" href="https://www.rc-consulting.edu.pe/">Aula Virtual</a></li>
                        <li><a class="dropdown-item" href="{{ route('suscripciones.index') }}">Membresía Premium</a></li>
                        <li><a class="dropdown-item" href="#">Preguntas Frecuentes</a></li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('inhouse') }}">In House</a>
                </li>
            </ul>

            <div class="rc-buttons">
                <a href="https://wa.me/51948163352?text=Hola%20Arnaldo,%20vengo%20de%20la%20web.%20Me%20interesa%20solicitar%20una%20Propuesta%20In%20House%20para%20mi%20instituci%C3%B3n%20alineada%20al%20PDP%202026.%20%C2%BFPodr%C3%ADas%20ayudarme?"
                    class="btn-wsp" target="_blank">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                        class="bi bi-whatsapp" viewBox="0 0 16 16">
                        <path d="M13.601 2.326A7.85 7.85 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.9 7.9 0 0 0 13.6 2.326zM7.994 14.521a6.6 6.6 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.56 6.56 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592m3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.73.73 0 0 0-.529.247c-.182.198-.691.677-.691 1.654s.71 1.916.81 2.049c.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232" />
                    </svg>
                    950 883 155
                </a>
                <a href="https://rc-consulting.edu.pe/" target="_blank" class="btn-aula">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                        class="bi bi-house-add-fill" viewBox="0 0 16 16">
                        <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 1 1-1 0v-1h-1a.5.5 0 1 1 0-1h1v-1a.5.5 0 0 1 1 0" />
                        <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L8 2.207l6.646 6.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293z" />
                        <path d="m8 3.293 4.712 4.712A4.5 4.5 0 0 0 8.758 15H3.5A1.5 1.5 0 0 1 2 13.5V9.293z" />
                    </svg>
                    Aula Virtual
                </a>
                <a href="https://escueladegobierno.edu.pe/tienda/" target="_blank" class="btn-tienda">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                        class="bi bi-cart-plus-fill" viewBox="0 0 16 16">
                        <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0m7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0M9 5.5V7h1.5a.5.5 0 0 1 0 1H9v1.5a.5.5 0 0 1-1 0V8H6.5a.5.5 0 0 1 0-1H8V5.5a.5.5 0 0 1 1 0" />
                    </svg>
                    Tienda Virtual
                </a>
            </div>

        </div>
    </div>
</nav>

<!-- SECCIÓN 1 — HERO PDP -->
<section class="hero-pdp">
    <div class="container-fluid p-0">
        <div class="row align-items-center g-0">
            <div class="col-lg-6">
                <div class="hero-pdp__text-content">
                    <h1 class="hero-pdp__title">
                        EJECUTA TU PDP 2026<br>
                        100% ALINEADO A LAS<br>
                        NORMAS DE SERVIR
                    </h1>
                    <p class="hero-pdp__sub">Programas In-House diseñados según TDR y Directiva</p>
                    <p class="hero-pdp__sub"><strong>RPE 000214-2025-SERVIR-PE</strong></p>
                    <div class="hero-pdp__btns">
                        <a href="#cotizar" class="btn-pdp btn-pdp--rojo"><i class="fas fa-rocket"></i> Cotizar mi PDP ahora</a>
                        <a href="https://drive.google.com/file/d/1E0pmK2xRnsXWfY3z-BD9NKykwJ7FMz5J/view?usp=sharing"
                            class="btn-pdp btn-pdp--blanco" target="_blank">Ver brochure</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="hero-pdp__img-full">
                    <img src="{{ asset('inhouse/img/pdp_2026.png') }}" alt="Capacitación PDP 2026">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SECCIÓN 2 — ¿TU INSTITUCIÓN YA TIENE LISTO SU PDP 2026? -->
<section class="sec-alerta">
    <div class="container">
        <h2 class="sec-alerta__title">¿Tu institución ya tiene listo su PDP 2026?</h2>
        <p class="sec-alerta__sub">Un PDP mal ejecutado puede generar retrasos en el logro de los objetivos de tu institución.</p>
        <div class="alerta-grid">
            <div class="alerta-card">
                <img src="{{ asset('inhouse/img/icons/seccion1/1.svg') }}" alt="Riesgo de incumplimiento de plazos">
            </div>
            <div class="alerta-card">
                <img src="{{ asset('inhouse/img/icons/seccion1/2.svg') }}" alt="Incremento de brechas de falta de capacidades">
            </div>
            <div class="alerta-card">
                <img src="{{ asset('inhouse/img/icons/seccion1/3.svg') }}" alt="Bajo desempeño de los servidores civiles">
            </div>
        </div>

        <div class="text-center mt-5">
            <a href="#cotizar" class="btn-pdp-solicitud">
                <i class="fa-solid fa-paper-plane me-2"></i> Solicitar estructuración del PDP
            </a>
        </div>
    </div>
</section>

<!-- SECCIÓN 3 — SÚMATE A LOS MÁS DE 1200 INSTITUCIONES -->
<section class="sec-sumate">
    <div class="container">
        <h2 class="sec-sumate__title">Súmate a los más de 1200 instituciones<br>que ejecutaron su PDP con nosotros</h2>
        <div class="sumate-stats">
            <div class="sumate-stat-card">
                <div class="stat-icon">
                    <img src="{{ asset('inhouse/img/icons/seccion2/1.svg') }}" alt="Icono Gobierno">
                </div>
                <div class="stat-content">
                    <p class="stat-text"><strong>3 Niveles de<br>gobierno atendidos</strong></p>
                </div>
            </div>

            <div class="sumate-stat-card">
                <div class="stat-icon">
                    <img src="{{ asset('inhouse/img/icons/seccion2/2.svg') }}" alt="Icono TDR">
                </div>
                <div class="stat-content">
                    <p class="stat-text"><strong>Más de 1500 Programas diseñados de acuerdo a los TDR</strong></p>
                </div>
            </div>

            <div class="sumate-stat-card">
                <div class="stat-icon">
                    <img src="{{ asset('inhouse/img/icons/seccion2/3.svg') }}" alt="Icono SEACE">
                </div>
                <div class="stat-content">
                    <p class="stat-text"><strong>Experiencia verificable <br>en el portal del SEACE</strong></p>
                </div>
            </div>
        </div>
        <div class="carousel-outer-pdp">
            <div class="carousel-track-pdp" id="carouselTrackPdp">
                <div class="carousel-card-pdp"><img src="{{ asset('inhouse/img/Logo de entidades/Recurso 54@4x.webp') }}" alt="Entidad"></div>
                <div class="carousel-card-pdp"><img src="{{ asset('inhouse/img/Logo de entidades/Recurso 55@4x.webp') }}" alt="Entidad"></div>
                <div class="carousel-card-pdp"><img src="{{ asset('inhouse/img/Logo de entidades/Recurso 56@4x.webp') }}" alt="Entidad"></div>
                <div class="carousel-card-pdp"><img src="{{ asset('inhouse/img/Logo de entidades/Recurso 57@4x.webp') }}" alt="Entidad"></div>
                <div class="carousel-card-pdp"><img src="{{ asset('inhouse/img/Logo de entidades/Recurso 58@4x.webp') }}" alt="Entidad"></div>
                <div class="carousel-card-pdp"><img src="{{ asset('inhouse/img/Logo de entidades/Recurso 59@4x.webp') }}" alt="Entidad"></div>
                <div class="carousel-card-pdp"><img src="{{ asset('inhouse/img/Logo de entidades/Recurso 60@4x.webp') }}" alt="Entidad"></div>
                <div class="carousel-card-pdp"><img src="{{ asset('inhouse/img/Logo de entidades/Recurso 61@4x.webp') }}" alt="Entidad"></div>
                <div class="carousel-card-pdp"><img src="{{ asset('inhouse/img/Logo de entidades/Recurso 62@4x.webp') }}" alt="Entidad"></div>
                <div class="carousel-card-pdp"><img src="{{ asset('inhouse/img/Logo de entidades/Recurso 64@4x.webp') }}" alt="Entidad"></div>
                <!-- Duplicados para loop infinito -->
                <div class="carousel-card-pdp"><img src="{{ asset('inhouse/img/Logo de entidades/Recurso 54@4x.webp') }}" alt="Entidad"></div>
                <div class="carousel-card-pdp"><img src="{{ asset('inhouse/img/Logo de entidades/Recurso 55@4x.webp') }}" alt="Entidad"></div>
                <div class="carousel-card-pdp"><img src="{{ asset('inhouse/img/Logo de entidades/Recurso 56@4x.webp') }}" alt="Entidad"></div>
                <div class="carousel-card-pdp"><img src="{{ asset('inhouse/img/Logo de entidades/Recurso 57@4x.webp') }}" alt="Entidad"></div>
                <div class="carousel-card-pdp"><img src="{{ asset('inhouse/img/Logo de entidades/Recurso 58@4x.webp') }}" alt="Entidad"></div>
                <div class="carousel-card-pdp"><img src="{{ asset('inhouse/img/Logo de entidades/Recurso 59@4x.webp') }}" alt="Entidad"></div>
                <div class="carousel-card-pdp"><img src="{{ asset('inhouse/img/Logo de entidades/Recurso 60@4x.webp') }}" alt="Entidad"></div>
                <div class="carousel-card-pdp"><img src="{{ asset('inhouse/img/Logo de entidades/Recurso 61@4x.webp') }}" alt="Entidad"></div>
                <div class="carousel-card-pdp"><img src="{{ asset('inhouse/img/Logo de entidades/Recurso 62@4x.webp') }}" alt="Entidad"></div>
                <div class="carousel-card-pdp"><img src="{{ asset('inhouse/img/Logo de entidades/Recurso 64@4x.webp') }}" alt="Entidad"></div>
            </div>
        </div>
    </div>
</section>

<script>
    var swiper = new Swiper(".swiperEntidades", {
        slidesPerView: 2,
        spaceBetween: 30,
        loop: true,
        autoplay: { delay: 2000 },
        breakpoints: {
            640: { slidesPerView: 3 },
            1024: { slidesPerView: 5 },
        },
    });
</script>

<!-- SECCIÓN 4 — ¿POR QUÉ EJECUTAR EL PDP CON R&C CONSULTING? -->
<section class="sec-porque-pdp">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="porque-pdp__title">¿Por qué ejecutar el PDP con R&C Consulting?</h2>
            <p class="porque-pdp__subtitle">Programas diseñados para fortalecer las competencias y capacidades de los servidores públicos.</p>
        </div>

        <div class="row g-4 justify-content-center">
            <div class="col-lg-4 col-md-6">
                <div class="porque-pdp-card">
                    <div class="pdp-card__icon">
                        <img src="{{ asset('inhouse/img/icons/seccion2/1.svg') }}" alt="Experiencia">
                    </div>
                    <h3 class="pdp-card__title">23 Años de experiencia</h3>
                    <div class="pdp-card__content">
                        <p>Capacitaciones y Consultorías diseñadas para fortalecer el talento humano de las organizaciones.</p>
                        <ul class="pdp-card__list">
                            <li>Más de 1200 acciones de capacitación ejecutadas</li>
                            <li>Más de 10 consultorías realizadas</li>
                            <li>Más de 250 consultores disponibles</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="porque-pdp-card">
                    <div class="pdp-card__icon">
                        <img src="{{ asset('inhouse/img/icons/seccion2/2.svg') }}" alt="Certificación">
                    </div>
                    <h3 class="pdp-card__title">Certificación con valor oficial</h3>
                    <div class="pdp-card__content">
                        <p>Capacitaciones reconocidas en el sector público y privado en el desarrollo de educación continua para profesionales.</p>
                        <ul class="pdp-card__list">
                            <li>Cumple la Ley del Servicio Civil</li>
                            <li>Regulado por SERVIR</li>
                            <li>En concordancia con los lineamientos de la OCDE y la OIT</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="porque-pdp-card">
                    <div class="pdp-card__icon">
                        <img src="{{ asset('inhouse/img/icons/seccion2/3.svg') }}" alt="Programas">
                    </div>
                    <h3 class="pdp-card__title">Programas según TDR</h3>
                    <div class="pdp-card__content">
                        <p>Más de 105 cursos y diplomados diseñados para la capacitación del sector público.</p>
                        <ul class="pdp-card__list">
                            <li>Diseño curricular basado en competencias.</li>
                            <li>Metodologías de aprendizaje con mayor autenticidad</li>
                            <li>Programas alineados a requerimientos TDR</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-5">
            <a href="#cotizar" class="btn-pdp-solicitud">
                <i class="fa-solid fa-paper-plane me-2"></i> Solicite sus requerimientos de acuerdo a su PDP
            </a>
            <p class="pdp-neuro-text mt-3">
                Metodología basada en neuroeducación corporativa, que potencia el aprendizaje y la aplicación práctica en el trabajo.
            </p>
        </div>
    </div>
</section>

<!-- CREDENCIALES DE R&C CONSULTING -->
<section class="experiencia-banner">
    <div class="exp-container">
        <div class="exp-image">
            <img src="{{ asset('inhouse/img/consultores.png') }}" alt="Consultores R&C">
        </div>

        <div class="exp-content">
            <div class="exp-inner-padding">
                <h2 class="exp-title">Credenciales de R&C Consulting</h2>
                <p class="exp-text">
                    Más de 1200 instituciones del Gobierno Nacional, Regional y Local han confiado en R&C Consulting para el desarrollo de sus programas de capacitación.
                </p>
                <p class="exp-text">
                    Nuestra experiencia como proveedor de capacitación puede ser verificada en el SEACE, donde las instituciones registran oficialmente los servicios ejecutados.
                </p>

                <div class="exp-stats-grid">
                    <div class="exp-stat-item">
                        <div class="exp-icon">
                            <i class="fa-light fa-building-columns"></i>
                        </div>
                        <div class="exp-info">
                            <strong>+1200 instituciones</strong>
                            <span>atendidas</span>
                        </div>
                    </div>
                    <div class="exp-stat-item">
                        <div class="exp-icon">
                            <i class="fa-light fa-badge-check"></i>
                        </div>
                        <div class="exp-info">
                            <strong>Experiencia verificable</strong>
                            <span>en SEACE</span>
                        </div>
                    </div>
                </div>

                <div class="exp-action">
                    <a href="https://apps.osce.gob.pe/perfilprov-ui/ficha/20506331014/contratos?pageNumber=1"
                        class="btn-exp-inst" target="_blank">
                        <img src="{{ asset('inhouse/img/icons/experienciaIcono.svg') }}" class="form-icon">
                        Experiencia institucional
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SERVICIOS ALINEADOS A REQUERIMIENTOS -->
<section class="servicios-pdp">
    <div class="inner-wrap">
        <div class="text-center mb-5">
            <h2 class="servicios-title">Servicios alineados a tus requerimientos <br><span>de capacitación</span></h2>
            <p class="servicios-sub">Te ayudamos a estructurar, priorizar y ejecutar las acciones de capacitación de tu institución para el PDP 2026, con asesoría especializada y enfoque normativo.</p>
        </div>

        <div class="servicios-grid">
            <div class="servicio-card">
                <div class="s-icon-wrap">
                    <img src="{{ asset('inhouse/img/icons/servicios/PunteroFlecha.svg') }}" alt="Planificación">
                </div>
                <h3>Planificación del PDP 2027</h3>
                <p>Definimos los ejes temáticos, contenidos mínimos y prioridades de capacitación que debe considerar tu institución para estructurar adecuadamente su PDP.</p>
            </div>

            <div class="servicio-card">
                <div class="s-icon-wrap">
                    <img src="{{ asset('inhouse/img/icons/servicios/Engranaje.svg') }}" alt="Ejecución">
                </div>
                <h3>Ejecución de programas de capacitación</h3>
                <p>Diseñamos y ejecutamos cursos, diplomados y programas especializados alineados a los objetivos institucionales y a las acciones de capacitación definidas en el PDP.</p>
            </div>

            <div class="servicio-card">
                <div class="s-icon-wrap">
                    <img src="{{ asset('inhouse/img/icons/servicios/Persona.svg') }}" alt="Asesoría">
                </div>
                <h3>Asesoría especializada</h3>
                <p>Nuestro equipo de consultores expertos en gestión pública acompaña la formulación técnica, priorización y ejecución de las acciones de capacitación.</p>
            </div>
        </div>
    </div>
</section>

<!-- ASESORIA IN-HOUSE ARNALDO -->
<section class="asesoria-inhouse">
    <div class="inner-wrap">
        <div class="text-center mb-5">
            <h2 class="asesoria-title">Solicita una propuesta In House para tu institución</h2>
            <p class="asesoria-sub">Recibe asesoría especializada para estructurar, cotizar y ejecutar tu programa de capacitación alineado a tu PDP 2026.</p>
        </div>

        <div class="asesor-card">
            <div class="asesor-img">
                <img src="{{ asset('inhouse/img/asesor.png') }}" alt="Arnaldo Montaño Rivera">
            </div>

            <div class="asesor-info">
                <div class="asesor-header">
                    <h3>Arnaldo Montaño Rivera</h3>
                    <span>Coordinador Comercial Corporativo</span>
                </div>

                <div class="contact-rows">
                    <div class="contact-box">
                        <i class="fas fa-mobile-alt"></i>
                        <div class="c-detail">
                            <small>Teléfono</small>
                            <strong>948 163 352</strong>
                        </div>
                    </div>

                    <div class="contact-box">
                        <i class="fas fa-envelope"></i>
                        <div class="c-detail">
                            <small>Correo</small>
                            <strong>asesor@rc-consulting.org</strong>
                        </div>
                    </div>
                </div>

                <div class="asesor-actions">
                    <a href="https://wa.me/51948163352?text=Hola%20Arnaldo,%20vengo%20de%20la%20web.%20Me%20interesa%20solicitar%20una%20Propuesta%20In%20House%20para%20mi%20instituci%C3%B3n%20alineada%20al%20PDP%202026.%20%C2%BFPodr%C3%ADas%20ayudarme?"
                        class="btn-wa-asesor" target="_blank">
                        <i class="fab fa-whatsapp"></i> WhatsApp
                    </a>
                    <a href="mailto:asesor@rc-consulting.org?subject=Solicitud%20de%20Propuesta%20In%20House%20-%20PDP%202026&body=Estimado%20Arnaldo%20Monta%C3%B1o%2C%0A%0AHe%20visto%20la%20p%C3%A1gina%20web%20y%20deseo%20solicitar%20una%20propuesta%20especializada%20de%20capacitaci%C3%B3n%20In%20House%20para%20mi%20instituci%C3%B3n.%0A%0ANuestros%20objetivos%20est%C3%A1n%20alineados%20al%20PDP%202026%20y%20necesitamos%20asesor%C3%ADa%20para%20estructurar%2C%20cotizar%20y%20ejecutar%20el%20programa.%0A%0AQuedo%20a%20la%20espera%20de%20los%20pasos%20a%20seguir.%0A%0AAtentamente%2C"
                        class="btn-mail-asesor">
                        Enviar correo
                    </a>
                </div>

                <p class="horario-nota">Respuesta rápida en horario laboral.</p>
            </div>
        </div>
    </div>
</section>

<!-- FORMULARIO -->
<section class="cta-form-section">
    <div id="cotizar" class="form-container-wrap">
        <div class="inner-wrap form-flex">

            <div class="form-info">
                <span class="badge-fucsia">Hablemos</span><br><br>
                <h2 class="form-title" style="font-family: 'Poppins';">Cotiza tu capacitación hoy</h2>
                <p>Cuéntanos el objetivo de tu entidad y te enviaremos una propuesta a medida (temario, modalidad, cronograma y presupuesto) alineada a tus necesidades.</p>

                <p class="form-item">
                    <img src="{{ asset('inhouse/img/icons/check.svg') }}" class="form-icon">
                    <span><b>Respuesta en 24 horas </b>(Según información brindada)</span>
                </p>
                <p class="form-item">
                    <img src="{{ asset('inhouse/img/icons/check.svg') }}" class="form-icon">
                    <span>Modalidad <b>virtual, presencial o mixta</b></span>
                </p>
                <p class="form-item">
                    <img src="{{ asset('inhouse/img/icons/check.svg') }}" class="form-icon">
                    <span>Incluye <b>alcance, contenidos, cronograma y cotización</b></span>
                </p>
            </div>

            <div class="form-card">
                <form id="miFormulario" style="font-family: 'Poppins';">
                    <input type="hidden" name="redirect"
                        value="https://api.whatsapp.com/send?phone=51948163352&text=Hola%20Arnaldo%2C%20vengo%20de%20la%20web.%20Me%20interesa%20solicitar%20una%20Propuesta%20In%20House%20para%20mi%20instituci%C3%B3n%20alineada%20al%20PDP%202026.%20%C2%BFPodr%C3%ADas%20ayudarme%3F" />
                    <input type="hidden" name="fuente" value="WEB" />
                    <div class="input-group input-with-icon">
                        <label>Nombre completo</label>
                        <div class="relative-container">
                            <img src="{{ asset('inhouse/img/icons/user.svg') }}" class="input-icon">
                            <input type="text" name="nombres" placeholder="Ingresa Nombre Completo" required>
                        </div>
                    </div>

                    <div class="input-group input-with-icon">
                        <label>Correo electrónico</label>
                        <div class="relative-container">
                            <img src="{{ asset('inhouse/img/icons/carta.svg') }}" class="input-icon">
                            <input type="email" name="correo" placeholder="Ingresa Correo Electrónico" required>
                        </div>
                    </div>

                    <div class="input-group input-with-icon">
                        <label>Institución pública</label>
                        <div class="relative-container">
                            <img src="{{ asset('inhouse/img/icons/carpeta.svg') }}" class="input-icon">
                            <input type="text" name="institucion" placeholder="Nombre de tu Empresa" required>
                        </div>
                    </div>

                    <div class="input-group input-with-icon">
                        <label>Contacto</label>
                        <div class="relative-container">
                            <img src="{{ asset('inhouse/img/icons/celular.svg') }}" class="input-icon">
                            <input type="number" name="telefono" placeholder="Ingresar Celular / WhatsApp" required>
                        </div>
                    </div>

                    <div class="input-group">
                        <label>Cuéntanos sobre la capacitación</label>
                        <textarea id="input-mensaje" rows="3"
                            placeholder="Describe tus objetivos, cantidad de personas, modalidad preferida, etc."></textarea>
                    </div>

                    <button type="submit" class="btn-submit-blue">Enviar solicitud de cotización</button>
                </form>
                <br>
                <p>Al enviar, aceptas ser contactados por R&C consulting solo con fines de cotización. No spam.</p>
            </div>

        </div>
    </div>
</section>

<!-- MODAL REGISTRO -->
<div class="modal fade" id="modalRegistro" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:420px;">
        <div class="modal-content" id="modalRegistro">
            <div class="modal-header" style="background:var(--azul);border-radius:14px 14px 0 0;">
                <h3 style="color:#fff;font-family:'Montserrat',sans-serif;font-size:15px;font-weight:800;margin:0;">
                    ✉️ Registra tus datos
                </h3>
                <button type="button" class="btn-close" style="filter:invert(1);" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" style="padding:20px 24px;">
                <p style="font-size:12px;color:var(--texto-medio);margin-bottom:16px;">Un asesor especializado te contactará para ayudarte con tu inscripción.</p>
                <form onsubmit="return handleLead(event)" id="formRegistroModal">
                    <input class="form-control" name="nombre" placeholder="Ingresa nombre completo" required
                        style="margin-bottom:10px;border-radius:8px;border:1.5px solid var(--gris-medio);padding:10px 14px;font-size:13px;width:100%;">
                    <input class="form-control" type="email" name="correo" placeholder="Ingresa correo electrónico" required
                        style="margin-bottom:10px;border-radius:8px;border:1.5px solid var(--gris-medio);padding:10px 14px;font-size:13px;width:100%;">
                    <input class="form-control" type="tel" name="celular" placeholder="Ingresa celular/WhatsApp" required
                        style="margin-bottom:12px;border-radius:8px;border:1.5px solid var(--gris-medio);padding:10px 14px;font-size:13px;width:100%;">
                    <label
                        style="display:flex;align-items:flex-start;gap:8px;cursor:pointer;font-size:11px;color:var(--texto-medio);margin-bottom:16px;">
                        <input type="checkbox" required checked style="margin-top:2px;flex-shrink:0;">
                        <span>Acepto las políticas de privacidad de datos</span>
                    </label>
                    <button type="submit"
                        style="width:100%;background:var(--rojo);color:#fff;font-family:'Montserrat',sans-serif;font-size:13px;font-weight:700;padding:12px;border-radius:9px;border:none;cursor:pointer;transition:background .2s;">
                        🚀 Solicitar información
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- MODAL INHOUSE -->
<div class="modal fade" id="inhouseModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="row g-0">
                    <div class="col-md-7" style="background:var(--azul);padding:26px;">
                        <h3 style="color:#fff;font-family:'Montserrat',sans-serif;font-weight:800;margin-bottom:9px;">
                            Modalidad In-House: No te capacites solo, eleva el nivel de toda tu área.</h3>
                        <p style="color:rgba(255,255,255,.78);font-size:13px;line-height:1.7;margin-bottom:15px;">
                            La nueva Ley N° 32069, Reglamento DS Nº 009-2025-EF y Modificación DS Nº 001-2026-EF, trae cambios que impactarán a todo tu equipo.</p>
                        <div style="display:flex;flex-wrap:wrap;gap:8px;">
                            <a href="mailto:asesor@rc-consulting.org"
                                style="background:#fff;color:var(--azul);border-radius:50px;padding:7px 13px;font-size:12px;font-weight:700;font-family:'Montserrat',sans-serif;text-decoration:none;display:flex;align-items:center;gap:5px;"><i class="fas fa-envelope"></i> <span>asesor@rc-consulting.org</span></a>
                            <a href="https://wa.me/51990035466?text=Hola,%20consulta%20INHOUSE%20Excel%20Profesional."
                                style="background:var(--verde-wsp);color:#fff;border-radius:50px;padding:7px 13px;font-size:12px;font-weight:700;font-family:'Montserrat',sans-serif;text-decoration:none;display:flex;align-items:center;gap:5px;" target="_blank"><i class="fab fa-whatsapp"></i> Solicitar por WhatsApp</a>
                        </div>
                    </div>
                    <div class="col-md-5" style="padding:26px;position:relative;">
                        <button type="button" class="btn-close" style="position:absolute;top:12px;right:12px;" data-bs-dismiss="modal"></button>
                        <h3 style="font-family:'Montserrat',sans-serif;font-weight:800;color:var(--azul);margin-bottom:12px;font-size:15px;">
                            Solicita una proforma aquí</h3>
                        <form id="inhouseForm">
                            <div class="mb-2"><input class="form-control" placeholder="Ingresa tu Nombre" required></div>
                            <div class="mb-2"><input class="form-control" type="email" placeholder="Ingresa tu Correo" required></div>
                            <div class="mb-2"><input class="form-control" type="tel" placeholder="Ingresa tu teléfono" required></div>
                            <div class="mb-2"><input class="form-control" placeholder="Entidad (opcional)"></div>
                            <div class="row g-2 mb-2">
                                <div class="col"><select class="form-select" style="font-size:12px;">
                                        <option>Cant. de Alumnos</option>
                                        <option>De 5 a 10</option>
                                        <option>De 10 a 15</option>
                                        <option>De 15 a 20</option>
                                        <option>De 20 a 30</option>
                                    </select></div>
                                <div class="col"><select class="form-select" style="font-size:12px;">
                                        <option>Nivel</option>
                                        <option>Básico</option>
                                        <option>Intermedio</option>
                                        <option>Avanzado</option>
                                    </select></div>
                            </div>
                            <div class="form-check mb-3"><input class="form-check-input" type="checkbox" id="acepto2" checked required><label class="form-check-label" for="acepto2" style="font-size:11px;">Acepto Términos, Condiciones y Políticas de Privacidad</label></div>
                            <button class="btn w-100" type="submit" style="background:var(--amarillo);color:var(--azul);font-family:'Montserrat',sans-serif;font-weight:800;padding:10px;">Enviar Proforma</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<a class="wa-float"
    href="https://wa.me/51990035466?text=Hola%20Yajaira,%20vengo%20de%20la%20landing%20Excel%20Profesional."
    target="_blank" rel="noopener">
    <span>🎁 PROMO ACTIVA</span>
    <i class="fab fa-whatsapp" style="font-size:17px;"></i>
</a>

<!-- FOOTER -->
<footer>
    <div class="inner-wrap">
        <div class="row g-4">
            <div class="col-md-3">
                <img src="{{ asset('inhouse/img/added/logofooter.webp') }}" alt="R&C Consulting"
                    style="height:48px;margin-bottom:20px;display:block;">
                <h3>Contáctanos:</h3>
                <p>Av. Petit Thouars 2166.<br>Lince, Lima - Perú</p>
                <p>Lunes a Viernes de 8:30 a 6:00 pm</p>
                <p><a href="mailto:asesor@rc-consulting.org">asesor@rc-consulting.org</a></p>
                <p>012661067 anexo: 100, 101, 104</p>
            </div>
            <div class="col-md-3">
                <h3>Enlaces</h3>
                <ul>
                    <li><a href="{{ route('cursos-virtuales') }}">Cursos</a></li>
                    <li><a href="{{ route('diplomas-virtuales') }}">Diplomados</a></li>
                    <li><a href="{{ route('inhouse') }}">Inhouse</a></li>
                    <li><a href="#">Consultorías</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <h3>Información</h3>
                <ul class="mb-3">
                    <li><a href="#">Políticas de privacidad</a></li>
                    <li><a href="#">Términos y condiciones</a></li>
                    <li><a href="#">Contáctanos</a></li>
                </ul>
                <p style="font-size:11px;margin-bottom:5px;">Métodos de pago</p>
                <img src="{{ asset('inhouse/img/added/payment.webp') }}" alt="Métodos de pago" style="max-height:28px;">
            </div>
            <div class="col-md-3">
                <h3>Certificados</h3>
                <a href="{{ route('certificados') }}" class="btn-cert-f"><i class="fas fa-search"></i> Consulta tu certificado</a>
                <div style="display:flex;align-items:center;gap:8px;margin-bottom:14px;">
                    <img src="{{ asset('inhouse/img/added/lreclamaciones.svg') }}" alt="Libro de reclamaciones" style="height:32px;">
                    <a href="{{ route('libro-reclamaciones.index') }}" style="font-size:14px;">Libro de reclamaciones</a>
                </div>
                <div class="social-icons">
                    <a href="https://pe.linkedin.com/company/ryc-consulting" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                    <a href="https://www.instagram.com/rycconsulting_/" target="_blank"><i class="fab fa-instagram"></i></a>
                    <a href="https://www.youtube.com/@CursosGestionPublica" target="_blank"><i class="fab fa-youtube"></i></a>
                    <a href="https://www.facebook.com/rcconsultingperu/" target="_blank"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://www.tiktok.com/@ryc_consulting" target="_blank"><i class="fab fa-tiktok"></i></a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>R&C Consulting 2026 — Todos los derechos reservados</p>
        </div>
    </div>
</footer>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    var swiper = new Swiper(".swiperEntidades", {
        slidesPerView: 2,
        spaceBetween: 30,
        loop: true,
        autoplay: { delay: 2000 },
        breakpoints: {
            640: { slidesPerView: 3 },
            1024: { slidesPerView: 5 },
        },
    });
</script>
<script>
    document.getElementById("miFormulario").addEventListener("submit", function (e) {
        e.preventDefault();

        const btn = e.target.querySelector("button");
        const originalText = btn.innerText;
        btn.innerText = "Enviando...";
        btn.disabled = true;

        var formData = new FormData(this);

        fetch("https://script.google.com/macros/s/AKfycbw1yJHtY22cXwnW4XDZo9w2eNckcBMIen9MdcaAEyAHA-0WsOGRJQ_4ClkE_SPoWQgMKg/exec", {
            method: "POST",
            body: formData
        })
            .then(res => res.json())
            .then(data => {
                if (data.resultado === "OK") {
                    const whatsappUrl = this.querySelector('input[name="redirect"]').value;

                    this.reset();

                    window.location.href = whatsappUrl;
                }
            })
            .catch(err => {
                alert("Hubo un error al enviar. Por favor intenta de nuevo.");
                btn.innerText = originalText;
                btn.disabled = false;
            });
    });
</script>
<script src="{{ asset('inhouse/js/jquery-3.2.1.min.js') }}"></script>
<script src="{{ asset('inhouse/js/added.js') }}"></script>
@endsection
