@extends('layouts.app')

@section('title', $curso->seo_title ?? $curso->title . ' | R&C Consulting')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/curso/styles.css') }}">
@endsection

@section('content')

<!-- CONTENEDOR PRINCIPAL -->
<div class="main-container">

    <!-- PANEL AMARILLO (DERECHA) -->
    <div class="panel-amarillo" id="solicitar">
        <div class="panel-oferta-tag">
            🔥 OFERTA FLASH <br>CONSULTA CON TU ASESORA
        </div>

        <div class="panel-price-box">
            <div class="panel-price-label" style="display: flex; justify-content: center; align-items: center; padding-bottom: 10px; font-size: 15px;">
                Oferta hasta el {{ $curso->precio_flash_fecha ?? 'próximamente' }}
            </div>

            <div class="panel-price-main">
                <span>S/.</span> {{ $curso->precio_flash ?? '0' }}
                <div class="panel-price-regular">
                    Precio regular:<br>
                    <span class="precio-tachado">s/. {{ $curso->precio_regular ?? '0' }}</span>
                </div>
            </div>

            <div class="contain-btn-pago" style="width: 100%; margin: 25px 0 15px 0; background: white; border-radius: 12px;">
                <a href="#" class="btn btn-pago-tarjeta" onclick="abrirPagoNiubiz(); return false;">
                    <i class="fas fa-credit-card"></i>
                    <span>Pagar con tarjeta</span>
                </a>
            </div>

            <div class="panel-logos">
                <img src="{{ asset('img/added/payment.webp') }}" alt="Métodos de pago">
            </div>
        </div>

        <div class="panel-registro-box">
            <p class="panel-registro-text">
                Registra tus datos y un asesor especializado te contactará para ayudarte
            </p>

            <form onsubmit="return handleLead(event)" id="formRegistroPanel">
                <input type="text" name="nombre" placeholder="Ingresa nombre completo" required>
                <input type="email" name="correo" placeholder="Ingresa correo electrónico" required>
                <input type="tel" name="celular" placeholder="Ingresa celular/WhatsApp" required>

                <label class="panel-check">
                    <input type="checkbox" required checked>
                    <span>Acepto las políticas de privacidad de datos</span>
                </label>

                <button type="submit" class="btn-panel-submit1" style="display: flex; align-items: center; justify-content: center; gap: 8px;">
                    <img src="{{ asset('img/added/flecha.webp') }}" alt="Icono" class="btn-submit-icon">
                    <span>Solicitar información</span>
                </button>
            </form>
        </div>
    </div>
    <!-- FIN PANEL AMARILLO -->

    <!-- WRAPPER: contenido centrado -->
    <div class="content-wrapper">

        <!-- DIV 1: CONTENIDO / INFORMACIÓN -->
        <div class="content-info">

            <!-- HERO - FULL WIDTH -->
            <section class="hero" id="inicio">
                <div class="hero-fondo"></div>
                <div class="hero-contenido">
                    <div class="inner-wrap">
                        <div class="hero-body">
                            <span class="badge-curso">{{ $curso->type ?? 'Curso de Especialización Virtual' }}</span>
                            <h1>{{ $curso->title }} <span>{{ $curso->subtitle ?? '' }}</span></h1>
                            <p class="hero-sub">{{ $curso->phrase ?? '' }}</p>
                            <p class="hero-desc">{{ $curso->description ?? '' }}</p>
                            <div class="hero-stats">
                                <span class="stat-pill"><span class="stars">★★★★★</span>&nbsp; 4.8 de calificación</span>
                                <span class="stat-pill">👥 +350 alumnos capacitados en este curso</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- QUICK BAR -->
            <div class="quick-bar">
                <div class="inner-wrap">
                    <div class="quick-bar-inner">
                        <div class="qitem">
                            <div class="qicon"><img src="{{ asset('img/SVG/Recurso 49.svg') }}" width="24" height="24" alt=""></div>
                            <div>
                                <div class="qtitle">Inicio</div>
                                <div class="qtitle">{{ $curso->start_date ?? 'Próximamente' }}</div>
                            </div>
                        </div>
                        <div class="qitem">
                            <div class="qicon"><img src="{{ asset('img/SVG/Recurso 50.svg') }}" width="24" height="24" alt=""></div>
                            <div>
                                <div class="qtitle">Duración</div>
                                <div class="qtitle">{{ $curso->sessions ?? 0 }} sesiones</div>
                            </div>
                        </div>
                        <div class="qitem">
                            <div class="qicon"><img src="{{ asset('img/SVG/Recurso 51.svg') }}" width="24" height="24" alt=""></div>
                            <div>
                                <div class="qtitle">Clases</div>
                                <div class="qtitle">en vivo</div>
                            </div>
                        </div>
                        <div class="qitem">
                            <div class="qicon"><img src="{{ asset('img/SVG/Recurso 52.svg') }}" width="24" height="24" alt=""></div>
                            <div>
                                <div class="qtitle">{{ $curso->hours ?? 0 }} Horas</div>
                                <div class="qtitle">Certificadas</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- IMAGEN PROMOCIÓN -->
            @if($curso->image_promotion)
            <div class="promo-wrap">
                <div class="inner-wrap">
                    <img src="{{ asset($curso->image_promotion) }}" width="100%" alt="Bono de regalo" style="border-radius: 5px; box-shadow: 0 4px 10px rgba(0,0,0,0.6); display: block;">
                </div>
            </div>
            @endif

            <!-- OBJETIVOS Y PARTICIPANTES -->
            <section class="sec bg-white">
                <div class="inner-wrap">
                    <div class="temario-wrap" style="max-width: 100%;">
                        <div class="accordion" id="indispensableAcc">
                            @if($curso->objetivos->count() > 0)
                            <div class="accordion-item" style="border: none; margin-bottom: 20px;">
                                <div class="temario-header collapsed" data-bs-toggle="collapse" data-bs-target="#indispensable" aria-expanded="false" style="cursor:pointer; border-radius: 12px; background: #eaeaea; color: black;">
                                    <span style="color: black;">Objetivos de aprendizaje</span>
                                    <div style="display:flex;align-items:center;gap:8px;">
                                        <i style="color:black;" class="fas fa-chevron-down temario-arrow"></i>
                                    </div>
                                </div>
                                <div id="indispensable" class="accordion-collapse collapse" data-bs-parent="#indispensableAcc">
                                    <div class="temario-body" style="background:white; border-radius: 0 0 12px 12px; padding: 10px 0;">
                                        @foreach($curso->objetivos as $objetivo)
                                        <div class="valor-item" style="padding: 18px 22px; border-bottom: 1.5px solid #D1D9E6;">
                                            <strong style="color:#03206A; font-size:13px; display:block; margin-bottom:8px;">● {{ $objetivo->titulo }}</strong>
                                            <p style="font-size:12.5px; color:#4A5568; line-height:1.7; margin:0;">{{ $objetivo->descripcion }}</p>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @endif

                            @if($curso->participantes->count() > 0)
                            <div class="accordion-item" style="border: none;">
                                <div class="temario-header collapsed" data-bs-toggle="collapse" data-bs-target="#quienes" aria-expanded="false" style="cursor:pointer; border-radius: 12px; background: #eaeaea; color: black;">
                                    <span style="color: black;">¿Quiénes deben participar?</span>
                                    <div style="display:flex;align-items:center;gap:8px;">
                                        <i style="color:black;" class="fas fa-chevron-down temario-arrow"></i>
                                    </div>
                                </div>
                                <div id="quienes" class="accordion-collapse collapse" data-bs-parent="#indispensableAcc">
                                    <div class="temario-body" style="background:white; border-radius: 0 0 12px 12px; padding: 10px 0;">
                                        @foreach($curso->participantes as $participante)
                                        <div class="valor-item" style="padding: 18px 22px;">
                                            <strong style="color:#03206A; font-size:13px; display:block; margin-bottom:8px;">●</strong>
                                            <p style="font-size:12.5px; color:#4A5568; line-height:1.7; margin:0;">{{ $participante->descripcion }}</p>
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

            <!-- TEMARIO -->
            @if($curso->temario->count() > 0)
            <section class="sec bg-white">
                <div class="inner-wrap">
                    <h2 style="text-align: center;" class="section-title left">Temario del curso</h2>
                    <br>
                    @if($curso->link_brochure)
                    <a class="btn-brochure" href="{{ $curso->link_brochure }}" target="_blank" rel="noopener">
                        <i class="fas fa-download"></i> DESCARGAR BROCHURE (PDF)
                    </a>
                    <br>
                    @endif

                    <div class="temario-wrap">
                        <div class="temario-header collapsed" data-bs-toggle="collapse" data-bs-target="#temarioContent" aria-expanded="false" style="border-radius: 12 0 0 12px;">
                            <span>{{ $curso->specialization_name ?? $curso->title }}</span>
                            <div style="display:flex;align-items:center;gap:8px;">
                                <span class="pill-sesiones">{{ $curso->temario->count() }} Sesiones</span>
                                <i style="color:#fff;" class="fas fa-chevron-down temario-arrow"></i>
                            </div>
                        </div>

                        <div class="collapse" id="temarioContent">
                            <div class="temario-body" style="background:#E9E9E9; border-radius: 0 0 12px 12px; padding: 15px;">
                                <div class="accordion" id="sesAcc" style="border:none; background:transparent;">
                                    @foreach($curso->temario as $sesion)
                                    <div class="accordion-item" style="border: none; background: transparent; margin-bottom: 12px;">
                                        <h3 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#s{{ $sesion->numero }}" style="border-radius: 10px; border: none; box-shadow: none;">
                                                Sesión {{ $sesion->numero }}: {{ $sesion->titulo }}
                                            </button>
                                        </h3>
                                        <div id="s{{ $sesion->numero }}" class="accordion-collapse collapse" data-bs-parent="#sesAcc">
                                            <div class="accordion-body" style="background: white; border-radius: 0 0 10px 10px; margin-top: -5px;">
                                                <ul>
                                                    @if(is_array($sesion->temas))
                                                        @foreach($sesion->temas as $tema)
                                                            <li>{{ $tema }}</li>
                                                        @endforeach
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            @endif

            <!-- CERTIFICACIÓN -->
            <section style="color:#03206A;" class="sec bg-white">
                <div class="inner-wrap">
                    <h2 class="cert-section-title">Certifícate y mejora<br>tus oportunidades</h2>
                    <p class="cert-section-desc">Obtén tu certificación acreditada con {{ $curso->hours ?? 90 }} horas académicas, válida tanto para el sector público como para el privado. Respaldado por la RPE Nº 000214-2025-SERVIR-PE, garantizamos reconocimiento en el mercado laboral.</p>
                    <div class="cert-box">
                        <span class="badge-solicitado">Más solicitado</span>
                        <div class="row g-4 align-items-center">
                            <div class="col-md-6">
                                <h3 class="cert-box-title">Certificación Profesional</h3>
                                <p class="cert-box-sub">Otorgado por: Escuela de Gobierno y Gestión Pública</p>
                                <p class="cert-box-note">Precio de derecho de trámite incluido<br>en la inversión del programa</p>
                                <ul class="cert-list">
                                    <li><i class="fas fa-check-circle"></i> Certificado físico y digital</li>
                                    <li><i class="far fa-clock" style="color:#03206A;"></i> Duración de trámite: 24 horas</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <div class="cert-img-ph">
                                    <div><span><img src="{{ asset('img/curso-certificado.png') }}" alt="Certificado" class="cert-img-real"></span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- PROFESORES -->
            @if($curso->profesores->count() > 0)
            <section class="sec">
                <div class="inner-wrap">
                    <h2 class="section-title">PROFESORES</h2>
                    <div class="prof-scroll">
                        @foreach($curso->profesores as $index => $profesor)
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

            <!-- VALOR DIFERENCIAL -->
            <section class="sec bg-rojo">
                <div class="valor-fondo"></div>
                <div class="inner-wrap">
                    <h2 class="section-title white">NUESTRO VALOR DIFERENCIAL</h2>
                    <div class="row g-3 justify-content-center">
                        <div class="col-md-6">
                            <div class="dif-card">
                                <div class="dif-icon"><img src="{{ asset('img/SVG/1x/Recurso 46.webp') }}" alt=""></div>
                                <div><p>23 años liderando el desarrollo de capacidades en gestión pública en el Perú.</p></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="dif-card">
                                <div class="dif-icon" style="margin-top: 10px;"><img src="{{ asset('img/SVG/1x/Recurso 47.webp') }}" alt=""></div>
                                <div><p>Power Skills y Liderazgo para la Gestión Pública Moderna.</p></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="dif-card">
                                <div class="dif-icon" style="margin-top: 10px;"><img src="{{ asset('img/SVG/1x/Recurso 48.webp') }}" alt=""></div>
                                <div><p>Expertos del MEF con Grado de Maestría.</p></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="dif-card">
                                <div class="dif-icon"><img src="{{ asset('img/SVG/1x/Recurso 49.webp') }}" alt=""></div>
                                <div><p>Acceso ilimitado 24/7 a clases grabadas y materiales durante un año.</p></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="dif-card">
                                <div class="dif-icon"><img src="{{ asset('img/SVG/1x/Recurso 51.webp') }}" alt=""></div>
                                <div><p>Doble certificación (física y digital) con código QR verificable al instante.</p></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="dif-card">
                                <div class="dif-icon" style="margin-top: 10px;"><img src="{{ asset('img/SVG/1x/Recurso 52.webp') }}" alt=""></div>
                                <div><p>Innovación y calidad educativa garantizada.</p></div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- FORMAS DE PAGO -->
            <section class="rc-pay py-5" id="pago">
                <div class="inner-wrap">
                    <div class="text-center mb-4">
                        <h2 class="rc-title mb-2">Inversión y formas de pago</h2>
                    </div>

                    <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 20px; width: 100%;">
                        <div style="flex: 1; min-width: 300px; max-width: 550px;">
                            <div style="background: #eaeaea; border-radius: 12px; padding: 25px; height: 100%;">
                                <div class="rc-block">
                                    <h3 class="rc-h4 mb-2">Pago por Aplicativo</h3>
                                    <p class="rc-p mb-3">Puedes pagar usando medios digitales como Yape, Plin o transferencia bancaria.</p>
                                    <div class="d-flex flex-wrap gap-2 justify-content-center mb-3" style="max-width: 400px; margin: 0 auto;">
                                        <img src="{{ asset('img/icons/bancos/bcp.png') }}" class="rc-pay-logo" alt="BCP">
                                        <img src="{{ asset('img/icons/bancos/Scotiabank.png') }}" class="rc-pay-logo" alt="Scotiabank">
                                        <img src="{{ asset('img/icons/bancos/interbank.png') }}" class="rc-pay-logo" alt="Interbank">
                                        <img src="{{ asset('img/icons/bancos/bbva.png') }}" class="rc-pay-logo" alt="BBVA">
                                        <img src="{{ asset('img/icons/bancos/yape.png') }}" class="rc-pay-logo" alt="Yape">
                                        <img src="{{ asset('img/icons/bancos/plim.png') }}" class="rc-pay-logo" alt="Plin">
                                    </div>
                                    <br>
                                    <button style="color: white;" class="btn rc-btn-primary w-100" type="button" data-bs-toggle="modal" data-bs-target="#modalCuentas">
                                        <img src="{{ asset('img/added/ojo.webp') }}" alt="Icono Cuentas" class="btn-icon-adjust">
                                        Ver Cuentas disponibles
                                    </button>
                                </div>
                                <hr class="rc-hr">
                                <div class="rc-block">
                                    <h3 class="rc-h4 mb-2">Pago en línea con tarjeta <br />crédito y/o débito</h3>
                                    <p class="rc-p mb-3">Aceptamos NIUBIZ (PagoLink) con transacciones seguras.</p>
                                    <div class="contain-btn-pago" style="width: 100%;">
                                        <a href="#" class="btn btn-pago-tarjeta" onclick="abrirPagoNiubiz(); return false;">
                                            <i class="fas fa-credit-card"></i>
                                            <span>Pagar con tarjeta</span>
                                        </a>
                                    </div>
                                    <div class="rc-safe mt-3">
                                        Pagos seguros encriptados con seguridad SSL
                                        <div class="mt-2">
                                            <img src="{{ asset('img/tarjetas.png') }}" class="img-fluid" alt="Tarjetas aceptadas">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div style="flex: 1; min-width: 300px; max-width: 550px;">
                            <div style="background: #eaeaea; border-radius: 12px; padding: 25px; height: 100%;">
                                <div class="rc-right-top">
                                    <h3 class="rc-h4 mb-3">Invierta en su futuro y <span style="color: #de004b;">ahorre hasta S/ 200</span> con nuestras promociones vigentes</h3>

                                    <div class="rc-price rc-price--promo mb-3">
                                        <div class="d-flex align-items-center gap-3">
                                            <span class="rc-coin-rosa">S/</span>
                                            <div>
                                                <div class="rc-price__name" style="color: #FF044D;">Oferta Flash:</div>
                                                <div class="rc-price__sub" style="color: #FF044D; font-size: 0.8rem;">Hasta el {{ $curso->precio_flash_fecha ?? 'próximamente' }}<br>o primeros 20 cupos</div>
                                            </div>
                                        </div>
                                        <div class="rc-price__amount" style="color: #FF044D;">S/ {{ $curso->precio_flash ?? '0' }}</div>
                                    </div>

                                    @if($curso->precio_pronto)
                                    <div class="rc-price rc-price--normal mb-3">
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="rc-coin">S/</span>
                                            <div>
                                                <div class="rc-price__name">Pronto Pago:</div>
                                                <div class="rc-price__sub">{{ $curso->precio_pronto_fecha ?? 'Preventa disponible' }}</div>
                                            </div>
                                        </div>
                                        <div class="rc-price__amount">S/ {{ $curso->precio_pronto }}</div>
                                    </div>
                                    @endif

                                    <div class="rc-price rc-price--normal mb-3">
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="rc-coin">S/</span>
                                            <div>
                                                <div class="rc-price__name">Inversión Regular:</div>
                                                <div class="rc-price__sub">Precio base</div>
                                            </div>
                                        </div>
                                        <div class="rc-price__amount">S/ {{ $curso->precio_regular ?? '0' }}</div>
                                    </div>

                                    @if($curso->advisor)
                                    <div style="text-align: center; width: 100%; margin-top: 20px;">
                                        <a href="https://wa.me/51{{ $curso->advisor->whatsapp }}?text=Hola%20{{ urlencode($curso->advisor->name) }}%2C%20deseo%20informaci%C3%B3n%20para%20pagar%20el%20curso%20de%20{{ urlencode($curso->title) }}." class="btn-wsp-inversion" target="_blank" rel="noopener">
                                            <i class="fab fa-whatsapp"></i>
                                            <span>Contacta con una asesora</span>
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

            <!-- ASESORA CONSULTA -->
            @if($curso->advisor)
            <section class="sec-asesora">
                <div class="asesora-fondo"></div>
                <div class="inner-wrap">
                    <h2 class="asesora-title">¿Prefieres hablar por WhatsApp?</h2>
                    <p class="asesora-subtitle">Nuestros asesores están disponibles para brindarte asesoría personalizada.<br>¡Comunícate con nosotros ahora mismo!</p>
                    <div class="asesora-card-wrap">
                        <a href="https://wa.me/51{{ $curso->advisor->whatsapp }}?text=Hola%20{{ urlencode($curso->advisor->name) }}%2C%20consulta%20sobre%20el%20curso%20de%20{{ urlencode($curso->title) }}." target="_blank">
                            <img src="{{ asset($curso->advisor->photo) }}" alt="Asesora de WhatsApp" class="asesora-full-img">
                        </a>
                    </div>
                </div>
            </section>
            @endif

            <!-- TESTIMONIOS -->
            <section class="sec" id="testimonio-seccion">
                <div class="testimonios-fondo"></div>
                <div class="inner-wrap">
                    <h2 class="section-title">TESTIMONIOS: 23 AÑOS GENERANDO VALOR</h2>
                    <div class="testi-grid" id="testiGrid">
                        <div class="testi-card" id="testiA">
                            <p></p>
                            <div class="testi-foto"></div>
                            <h5></h5>
                            <small></small>
                        </div>
                        <div class="testi-card" id="testiB">
                            <p></p>
                            <div class="testi-foto"></div>
                            <h5></h5>
                            <small></small>
                        </div>
                    </div>
                    <div class="testi-dots" id="testiDots"></div>
                </div>
            </section>

            <!-- INVERSIÓN -->
            <section class="sec" style="background-color: white;">
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
                                    <li><strong>{{ $curso->sessions ?? 6 }} sesiones en vivo</strong> (tiempo real) para aprender y resolver dudas al momento.</li>
                                    <li><strong>Plataforma exclusiva</strong> para estudiar fácil, repasar y aplicar.</li>
                                </ul>
                            </div>
                            <div class="inversion-right">
                                <div class="inv-title">Compra segura con tarjeta.</div>
                                <div class="inv-regular-price">Precio regular: S/. {{ $curso->precio_regular ?? '0' }}</div>
                                <div class="inv-discount-badge">¡Oferta Flash!</div>
                                <div class="inv-price-main">
                                    <span>S/.</span> {{ $curso->precio_flash ?? '0' }}
                                </div>
                                <a href="#" class="btn-acceder-card" onclick="abrirPagoNiubiz(); return false;">
                                    <i class="fas fa-credit-card"></i> Pagar con tarjeta
                                </a>
                                <br>
                                <div class="inv-secure">Pagos seguros encriptados con seguridad SSL</div>
                                <div class="inv-igv">Todos los precios incluyen IGV</div>
                            </div>
                        </div>
                        @if($curso->advisor)
                        <div style="width: 100%; max-width: 750px; margin: 30px auto 0; display: flex; justify-content: center;">
                            <a href="https://wa.me/51{{ $curso->advisor->whatsapp }}?text=Hola%20{{ urlencode($curso->advisor->name) }}%2C%20quiero%20reservar%20mi%20vacante%20del%20curso%20{{ urlencode($curso->title) }}%2C%20por%20favor." class="btn-wsp-inversion btn-wsp-asegura" style="justify-content: center;" target="_blank" rel="noopener">
                                <i class="fab fa-whatsapp"></i>
                                <span>Escríbenos por WhatsApp y asegura tu vacante hoy</span>
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </section>

            <!-- INHOUSE -->
            @if($curso->inhouse_web || $curso->inhouse_mobile)
            <div class="inhouse-section">
                <div class="inhouse-wrap" data-bs-toggle="modal" data-bs-target="#inhouseModal">
                    <div class="inhouse-ph">
                        <picture>
                            @if($curso->inhouse_mobile)
                            <source media="(max-width: 768px)" srcset="{{ asset($curso->inhouse_mobile) }}">
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

<!-- BARRA FIJA INFERIOR MÓVIL -->
<div class="mobile-sticky-bar">
    <div class="msb-price"><span>S/.</span> {{ $curso->precio_regular ?? '0' }}</div>
    <a href="#" class="btn-acceder-card-no-margin" onclick="abrirPagoNiubiz(); return false;">
        <i class="fas fa-credit-card"></i> Pagar con tarjeta
    </a>
</div>

<!-- MODAL REGISTRAR DATOS -->
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

<!-- MODALES PROFESORES -->
@foreach($curso->profesores as $index => $profesor)
<div class="modal fade" id="modalProfesor{{ $index + 1 }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">{{ $profesor->name }}</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h4>Formación Profesional</h4>
                <ul>
                    @if(is_array($profesor->formacion))
                        @foreach($profesor->formacion as $form)
                            <li>{{ $form }}</li>
                        @endforeach
                    @endif
                </ul>
                <h4>Experiencia Profesional</h4>
                <ul>
                    @if(is_array($profesor->experiencia))
                        @foreach($profesor->experiencia as $exp)
                            <li>{{ $exp }}</li>
                        @endforeach
                    @endif
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
@endforeach

<!-- MODAL INHOUSE -->
<div class="modal fade" id="inhouseModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content border-0" style="border-radius: 15px; overflow: hidden;">
            <div class="modal-body p-0">
                <div class="c-main-layout">
                    <div class="c-design-column">
                        <div class="c-top-banner" style="margin-top: 40px;">
                            <img src="{{ asset('img/inhouse-01.jpg') }}" alt="Personas con laptop" class="c-hero-img">
                            <div class="c-badge-tag">CURSO ESPECIALIZADO</div>
                        </div>
                        <div class="c-navy-bar">
                            <span>Evita observaciones. Estandariza tu equipo.</span>
                        </div>
                        <div class="c-fucsia-content">
                            <h2 class="c-fucsia-text">Modalidad In-House: Un solo curso, un solo estándar: todo tu equipo alineado y operativo.</h2>
                            <div class="c-fucsia-footer">
                                <a href="mailto:inhouse@rc-consulting.org" class="c-btn-white">
                                    <span class="icon-mail"></span> inhouse@rc-consulting.org
                                </a>
                                <a href="https://wa.me/51948163352?text=Hola%20Arnaldo,%20vengo%20de%20la%20web.%20Me%20interesa%20solicitar%20una%20Propuesta%20In%20House%20alineada%20al%20PDP%202026." class="c-btn-whatsapp" target="_blank">
                                    <span class="icon-wa"></span> WhatsApp directo
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="c-form-column">
                        <span class="c-pill">Programa In House</span>
                        <h1 class="c-title">{{ $curso->title }}</h1>
                        <p class="c-description">{{ $curso->description }}</p>
                        <div class="c-form-container">
                            <h3>Solicita una proforma aquí</h3>
                            <form id="inhouseForm" class="c-form-grid">
                                <input type="text" placeholder="Ingresa nombre completo" name="nombres">
                                <input type="email" placeholder="Ingresa correo electrónico" name="correo">
                                <input type="tel" placeholder="Ingresa celular/WhatsApp" name="telefono">
                                <input type="text" placeholder="Nombre de tu empresa" name="institucion">
                                <select name="cantidadAlumnos">
                                    <option value="">Cantidad de alumnos</option>
                                    <option value="5-10">5-10 alumnos</option>
                                    <option value="11-20">11-20 alumnos</option>
                                    <option value="21-30">21-30 alumnos</option>
                                    <option value="31-50">31-50 alumnos</option>
                                    <option value="50+">50+ alumnos</option>
                                </select>
                                <select name="nivelCurso">
                                    <option value="">Nivel de curso</option>
                                    <option value="Básico">Básico</option>
                                    <option value="Intermedio">Intermedio</option>
                                    <option value="Avanzado">Avanzado</option>
                                    <option value="Personalizado">Personalizado</option>
                                </select>
                                <button type="submit" class="c-btn-submit">Enviar proforma</button>
                            </form>
                            <div class="c-check-area">
                                <input type="checkbox" id="terms" name="terminos">
                                <label for="terms">Acepto términos, condiciones y las políticas de privacidad</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- BOTÓN FLOTANTE WHATSAPP -->
@if($curso->advisor)
<a class="wa-float" href="https://wa.me/51{{ $curso->advisor->whatsapp }}?text=Hola%20{{ urlencode($curso->advisor->name) }}%2C%20consulta%20sobre%20el%20curso%20de%20{{ urlencode($curso->title) }}." target="_blank" rel="noopener">
    <span>🎁 PROMO ACTIVA</span>
    <i class="fab fa-whatsapp" style="font-size:17px;"></i>
</a>
@endif

<!-- Scripts -->
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

const APPS_SCRIPT_URL = "https://script.google.com/macros/s/AKfycbyuLzGRFAnaiJ_IUT6eiO2jqEFoQiy0qTrHmDXPHk9cmsEQOs4n4QC1uV7dOXPctl8/exec";

async function sendToApps(paramsObj) {
    const params = new URLSearchParams(paramsObj);
    try {
        await fetch(APPS_SCRIPT_URL, { method: 'POST', headers: { 'Content-Type': 'application/x-www-form-urlencoded' }, body: params.toString() });
        return true;
    } catch (err) {
        console.error('Error:', err);
        return false;
    }
}

function handleLead(e) {
    e.preventDefault();
    const form = e.target;
    const nombre = form.querySelector('input[name="nombre"]')?.value || '';
    const correo = form.querySelector('input[name="correo"]')?.value || '';
    const celular = form.querySelector('input[name="celular"]')?.value || '';
    const payload = { origen: "{{ $curso->title }}", nombreCompleto: nombre, correo: correo, celular: celular, curso: "{{ $curso->title }}", urlWha: window.location.href };
    sendToApps(payload);
    
    // Guardar en base de datos local
    fetch('/api/leads', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
        },
        body: JSON.stringify({
            nombre: nombre,
            correo: correo,
            celular: celular,
            curso: "{{ $curso->title }}",
            consulta: ''
        })
    }).then(() => { form.reset(); }).catch(err => console.error('Error saving lead:', err));
    return false;
}

document.addEventListener('DOMContentLoaded', function () {
    const inhouseForm = document.getElementById('inhouseForm');
    if (inhouseForm) {
        inhouseForm.addEventListener('submit', function (ev) {
            ev.preventDefault();
            const payload = {
                origen: 'INHOUSE - SOLICITUD PROFORMA',
                nombres: inhouseForm.querySelector('input[name="nombres"]')?.value,
                correo: inhouseForm.querySelector('input[name="correo"]')?.value,
                telefono: inhouseForm.querySelector('input[name="telefono"]')?.value,
                institucion: inhouseForm.querySelector('input[name="institucion"]')?.value,
                cantidadAlumnos: inhouseForm.querySelector('select[name="cantidadAlumnos"]')?.value,
                nivelCurso: inhouseForm.querySelector('select[name="nivelCurso"]')?.value,
                curso: "{{ $curso->title }}",
                urlWha: window.location.href
            };
            sendToApps(payload).then(ok => { if (ok) inhouseForm.reset(); });
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
    }
    render(0);
    setInterval(function () { render(current >= pairs.length - 1 ? 0 : current + 1); }, 5000);
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
    const panel = document.querySelector('.mobile-panel-wrap');
    if (panel) {
        panel.style.display = width <= 1024 ? 'none' : '';
    }
}
window.addEventListener('load', hidePanelAmarillo);
window.addEventListener('resize', hidePanelAmarillo);
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@endsection