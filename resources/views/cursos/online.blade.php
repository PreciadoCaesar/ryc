@extends('layouts.app-main')

@section('title', ($curso->page?->content['seo_title'] ?? $curso->seo_title ?? $curso->title) . ' | R&C Consulting')
@section('meta_description', $curso->page?->content['seo_description'] ?? $curso->seo_description ?? Str::limit(strip_tags($curso->description ?? ''), 160))
@section('meta_keywords', $curso->seo_keywords ?? '')
@section('canonical', route('curso.mostrar', $curso->slug))
@section('og_title', ($curso->page?->content['seo_title'] ?? $curso->seo_title ?? $curso->title) . ' | R&C Consulting')
@section('og_description', $curso->page?->content['seo_description'] ?? $curso->seo_description ?? Str::limit(strip_tags($curso->description ?? ''), 160))
@section('og_type', 'article')
@section('og_image', $curso->page?->content['og_image'] ?? asset($curso->image_cover ?? $curso->image_promotion ?? 'img/og-default.svg'))

@php
    $page = $curso->page?->content ?? [];
    $precioRegular = $page['price'] ?? $curso->precio_regular ?? 0;
    $precioOferta = $page['price_offer'] ?? $curso->precio_flash ?? $curso->precio_regular ?? 0;
    $tieneOferta = $precioOferta < $precioRegular && $precioRegular > 0;
    $sesiones = $page['sessions'] ?? $curso->sessions ?? 0;
    $horas = $page['hours'] ?? $curso->hours ?? 0;
    $inicia = $page['start'] ?? ($curso->start_date ? 'Inicio: ' . $curso->start_date : 'Acceso Inmediato');
    $horario = $page['schedule'] ?? 'Disponible 24/7';
    $videoUrl = $page['video_url'] ?? '';
    $brochureUrl = $page['brochure_url'] ?? $curso->link_brochure ?? '';
    $objetivos = $page['objetivos'] ?? [];
    $participantes = $page['participantes'] ?? $curso->participantes->pluck('descripcion')->toArray() ?? [];
    $topics = $page['topics'] ?? [];
    $teachers = $page['teachers'] ?? [];
    $testimonios = $page['testimonios'] ?? [];
    $faq = $page['faq'] ?? [];
    $diferenciadores = $page['diferenciadores'] ?? [];
    $whatsapp = $curso->advisor->whatsapp ?? '950883155';
    $whatsappName = $curso->advisor->name ?? 'Asesora';
@endphp

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link href="{{ asset('css/curso/online.css') }}" rel="stylesheet">
<style>
    .extra-notch{display:inline-block;background:#FF044D;color:#fff;font-size:11px;font-weight:700;padding:3px 12px;border-radius:50px;margin-bottom:6px}
    .video-container{position:relative;padding-bottom:56.25%;height:0;overflow:hidden;border-radius:12px}
    .video-container iframe{position:absolute;top:0;left:0;width:100%;height:100%}
    .objetivos-grid{display:grid;grid-template-columns:1fr 1fr;gap:16px;max-width:800px;margin:0 auto}
    .objetivos-grid .item{background:#fff;border-radius:12px;padding:18px;box-shadow:0 2px 8px rgba(0,0,0,.05);border:1.5px solid var(--gris-medio)}
    .participantes-box{background:#F0F4FF;border-radius:16px;padding:24px 28px;border:1.5px solid #D1D9E6}
    .accordion-temario .accordion-item{border:2px solid #e0e0e0;margin-bottom:10px;border-radius:10px!important;overflow:hidden}
    .accordion-temario .accordion-button{font-weight:700;color:#03206A;font-size:14px;padding:14px 18px}
    .accordion-temario .accordion-button:not(.collapsed){background:#FFF3F5;color:#C8102E}
    .accordion-temario .accordion-body{font-size:13px;color:#4A5568;line-height:1.7}
    .porque-item{display:flex;align-items:flex-start;gap:16px;padding:16px 0;border-bottom:1.5px solid #D1D9E6}
    .porque-item:last-child{border-bottom:none}
    .porque-icon{background:#03206A;color:#FFB800;width:44px;height:44px;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:20px}
    .faq-accordion .accordion-item{border:2px solid #e0e0e0;margin-bottom:10px;border-radius:10px!important;overflow:hidden}
    .faq-accordion .accordion-button{font-weight:600;color:#03206A;font-size:14px;padding:14px 18px}
    .faq-accordion .accordion-button:not(.collapsed){background:#FFF3F5;color:#C8102E;text-decoration:underline}
    .faq-accordion .accordion-body{font-size:13px;color:#4A5568;line-height:1.7}
    .inversion-fondo{position:absolute;top:0;left:0;width:120vw;margin-left:calc(-60vw + 50%);height:100%;background:#F0F4FF;z-index:-1}
    .sec-inversion{position:relative;overflow:visible;z-index:1}
</style>
@endsection

@section('content')
<div class="main-container">
    {{-- PANEL LATERAL DERECHO (sticky) --}}
    <aside class="panel-amarillo" id="panelSticky">
        <div class="panel-oferta-tag">
            <i class="fas fa-bolt me-1"></i> OFERTA POR TIEMPO LIMITADO
        </div>
        <div class="panel-price-box">
            <div class="panel-price-label">
                <div class="panel-price-main">
                    @if($tieneOferta)
                        S/{{ number_format($precioOferta, 0) }}<span>.00</span>
                        <div class="panel-price-regular">
                            <div class="precio-tachado">S/{{ number_format($precioRegular, 0) }}</div>
                            <div style="font-weight:700;color:#000;font-size:.9rem;text-transform:uppercase">
                                {{ round((1 - $precioOferta / $precioRegular) * 100) }}% OFF
                            </div>
                        </div>
                    @else
                        S/{{ number_format($precioRegular, 0) }}<span>.00</span>
                    @endif
                </div>
            </div>
            <div class="contain-btn-pago">
                <form action="{{ route('carrito.add', $curso->slug) }}" method="POST" style="display:inline">
                    @csrf
                    <button type="submit" class="btn-pago-tarjeta">
                        <i class="fas fa-shopping-cart"></i> AGREGAR AL CARRITO
                    </button>
                </form>
            </div>
            <div class="panel-logos">
                <img src="{{ asset('images/pagos/visa-mastercard-amex.png') }}" alt="Visa, Mastercard, Amex" style="height:32px" onerror="this.style.display='none'">
                <div style="margin-top:8px">
                    <img src="{{ asset('images/pagos/izipay.png') }}" alt="Izipay" style="height:18px" onerror="this.style.display='none'">
                </div>
            </div>
        </div>

        <div class="panel-registro-box">
            <div class="panel-registro-text">Prefieres pagar por transferencia o Yape?</div>
            <form method="POST" action="#" id="form-panel-registro" onsubmit="return guardarLead(this)">
                @csrf

                <input type="text" name="contact_name" placeholder="Nombre completo" required>
                <input type="email" name="contact_email" placeholder="Correo electrnico" required>
                <input type="tel" name="contact_phone" placeholder="WhatsApp / Celular" required>

                <label class="panel-check">
                    <input type="checkbox" name="accept_terms" value="1" required>
                    Acepto las <a href="#" style="color:#0A1F5C;font-weight:600">Politicas de Privacidad</a>
                </label>

                <button type="submit" class="btn-panel-submit1">
                    <i class="fas fa-lock me-1"></i> SOLICITAR INSCRIPCION
                </button>
            </form>
        </div>
    </aside>

    {{-- CONTENIDO PRINCIPAL --}}
    <div class="content-wrapper">
        {{-- HERO --}}
        <section class="hero">
            <div class="hero-fondo"></div>
            <div class="hero-contenido">
                <div class="hero-body">
                    <div class="badge-curso">
                        <i class="fas fa-video me-1"></i> CURSO ONLINE GRABADO
                    </div>
                    <h1>{{ $curso->title }}</h1>
                    @if($curso->subtitle)
                        <div class="hero-sub">{{ $curso->subtitle }}</div>
                    @endif
                    <div class="hero-desc">{{ $curso->description }}</div>
                    <div class="hero-stats">
                        <span class="stat-pill"><i class="fas fa-clock me-1"></i> {{ $horas > 0 ? $horas.' horas' : 'Acceso Inmediato' }}</span>
                        <span class="stat-pill"><i class="fas fa-calendar-alt me-1"></i> {{ $inicia }}</span>
                        <span class="stat-pill"><i class="fas fa-video me-1"></i> {{ $sesiones > 0 ? $sesiones.' sesiones grabadas' : 'Clases grabadas' }}</span>
                        <span class="stat-pill stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></span>
                    </div>
                </div>
            </div>
        </section>

        {{-- QUICK BAR --}}
        <section class="quick-bar">
            <div class="quick-bar-inner">
                <div class="qitem"><span class="qicon">📺</span><div class="qtitle">Acceso Inmediato</div></div>
                <div class="qitem"><span class="qicon">🎓</span><div class="qtitle">Certificado Profesional</div></div>
                <div class="qitem"><span class="qicon">📱</span><div class="qtitle">Soporte Permanente</div></div>
                <div class="qitem"><span class="qicon">🔐</span><div class="qtitle">Pago 100% Seguro</div></div>
            </div>
        </section>

        {{-- VIDEO --}}
        @if($videoUrl)
        <section class="sec" id="video">
            <h2 class="section-title">Video del Curso</h2>
            <div class="video-container">
                {!! $videoUrl !!}
            </div>
        </section>
        @endif

        {{-- OBJETIVOS --}}
        @if(count($objetivos) > 0)
        <section class="sec" id="objetivos">
            <h2 class="section-title">Que logrars con este curso?</h2>
            <div class="objetivos-grid">
                @foreach($objetivos as $obj)
                    <div class="item"><i class="fas fa-check-circle" style="color:#22C55E;margin-right:8px"></i>{{ is_string($obj) ? $obj : ($obj['texto'] ?? $obj['titulo'] ?? '') }}</div>
                @endforeach
            </div>
        </section>
        @endif

        {{-- DIRIGIDO A --}}
        @if(count($participantes) > 0)
        <section class="sec" id="participantes">
            <h2 class="section-title">A quin est dirigido?</h2>
            <div class="participantes-box">
                @if(is_string($participantes[0] ?? ''))
                    {!! nl2br(implode("\n", $participantes)) !!}
                @else
                    <ul>
                        @foreach($participantes as $par)
                            <li>{{ is_string($par) ? $par : ($par['descripcion'] ?? '') }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </section>
        @endif

        {{-- TEMARIO --}}
        @if(count($topics) > 0 || $curso->temario->count() > 0)
        <section class="sec" id="temario">
            <h2 class="section-title">Contenido del Curso</h2>
            <div class="temario-wrap">
                <div class="temario-header collapsed" onclick="toggleTemario(this)">
                    <span><i class="fas fa-book me-2"></i> TEMARIO DEL CURSO</span>
                    <span class="pill-sesiones"><i class="far fa-file-alt me-1"></i> {{ $sesiones > 0 ? $sesiones.' SESIONES' : 'GRABADO' }}</span>
                    <i class="fas fa-chevron-down temario-arrow"></i>
                </div>
                <div class="temario-body" style="display:none">
                    <div class="accordion accordion-temario" id="accordionTemario">
                        @if(count($topics) > 0)
                            @foreach($topics as $index => $modulo)
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingT{{ $index }}">
                                        <button class="accordion-button @if($index > 0) collapsed @endif" type="button" data-bs-toggle="collapse" data-bs-target="#collapseT{{ $index }}" aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" aria-controls="collapseT{{ $index }}">
                                            {{ is_array($modulo) ? ($modulo['title'] ?? $modulo['titulo'] ?? 'Modulo '.($index + 1)) : $modulo }}
                                        </button>
                                    </h2>
                                    <div id="collapseT{{ $index }}" class="accordion-collapse collapse @if($index === 0) show @endif" aria-labelledby="headingT{{ $index }}" data-bs-parent="#accordionTemario">
                                        <div class="accordion-body">
                                            @if(is_array($modulo) && isset($modulo['items']) && count($modulo['items']) > 0)
                                                <ul>
                                                    @foreach($modulo['items'] as $item)
                                                        <li>{{ $item }}</li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                Contenido disponible en la plataforma.
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            @foreach($curso->temario as $sesion)
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingS{{ $sesion->id }}">
                                        <button class="accordion-button @if(!$loop->first) collapsed @endif" type="button" data-bs-toggle="collapse" data-bs-target="#collapseS{{ $sesion->id }}" aria-expanded="{{ $loop->first ? 'true' : 'false' }}">
                                            Sesin {{ $sesion->numero }}: {{ $sesion->titulo }}
                                        </button>
                                    </h2>
                                    <div id="collapseS{{ $sesion->id }}" class="accordion-collapse collapse @if($loop->first) show @endif" data-bs-parent="#accordionTemario">
                                        <div class="accordion-body">
                                            @if(is_array($sesion->temas) && count($sesion->temas) > 0)
                                                <ul>
                                                    @foreach($sesion->temas as $tema)
                                                        <li>{{ $tema }}</li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                Contenido disponible en la plataforma.
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </section>
        @endif

        {{-- BROCHURE --}}
        @if($brochureUrl)
        <section class="sec">
            <a href="{{ $brochureUrl }}" class="btn-brochure" target="_blank">
                <i class="fas fa-download me-2"></i> DESCARGAR BROCHURE DEL CURSO
            </a>
        </section>
        @endif

        {{-- PROFESORES --}}
        @if(count($teachers) > 0 || $curso->profesores->count() > 0)
        <section class="sec" id="profesores">
            <h2 class="section-title">Docentes</h2>
            <div class="prof-scroll">
                @if(count($teachers) > 0)
                    @foreach($teachers as $teacher)
                        <div class="col-prof">
                            <div class="prof-card">
                                <div class="prof-card__imgWrap">
                                    <img class="prof-card__img" src="{{ $teacher['foto'] ?? $teacher['photo'] ?? asset('images/default-teacher.jpg') }}" alt="{{ $teacher['nombre'] ?? $teacher['name'] ?? '' }}">
                                </div>
                                <div class="prof-card__body">
                                    <div class="prof-card__name">{{ $teacher['nombre'] ?? $teacher['name'] ?? '' }}</div>
                                    @if($teacher['perfil_url'] ?? $teacher['url'] ?? false)
                                        <a href="{{ $teacher['perfil_url'] ?? $teacher['url'] }}" class="btn-ver-perfil" target="_blank">Ver Perfil</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    @foreach($curso->profesores as $profesor)
                        <div class="col-prof">
                            <div class="prof-card">
                                <div class="prof-card__imgWrap">
                                    <img class="prof-card__img" src="{{ asset($profesor->photo) }}" alt="{{ $profesor->name }}">
                                </div>
                                <div class="prof-card__body">
                                    <div class="prof-card__name">{{ $profesor->name }}</div>
                                    <button class="btn-ver-perfil" data-bs-toggle="modal" data-bs-target="#modalProfesor{{ $profesor->id }}">Ver Perfil</button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </section>
        @endif

        {{-- CERTIFICACION --}}
        <section class="sec" id="certificacion">
            <h2 class="cert-section-title">Certificacion Profesional</h2>
            <p class="cert-section-desc">Al culminar el curso obtendrs un Certificado Profesional que acredita tu participacin y logros.</p>
            <div class="cert-box">
                <div class="badge-solicitado"><i class="fas fa-star me-1"></i> Certificado Incluido</div>
                <div class="cert-box-title">Certificado del Curso</div>
                <div class="cert-box-sub">Con validez curricular y descargable en PDF.</div>
                <div class="cert-box-note">* El certificado es enviado de forma digital a tu correo y tambin est disponible en nuestra plataforma.</div>
                <ul class="cert-list">
                    <li><i class="fas fa-check-circle"></i> Certificado digital en PDF</li>
                    <li><i class="fas fa-check-circle"></i> Cdigo de verificacin nico</li>
                    <li><i class="fas fa-check-circle"></i> Carga horaria: {{ $horas > 0 ? $horas.' horas' : 'Disponible en plataforma' }}</li>
                    <li><i class="fas fa-check-circle"></i> Firmado por la direccin acadmica</li>
                </ul>
            </div>
        </section>

        {{-- VALOR DIFERENCIAL --}}
        @if(count($diferenciadores) > 0)
        <section class="sec bg-rojo" id="porque">
            <div class="valor-fondo"></div>
            <div class="content-info" style="padding:30px 0">
                <h2 class="section-title white">Por qu llevar este curso con nosotros?</h2>
                <div style="max-width:750px;margin:0 auto">
                    @foreach($diferenciadores as $dif)
                        <div class="porque-item">
                            <div class="porque-icon"><i class="fas fa-check"></i></div>
                            <div>
                                <strong style="color:#FFB800;font-size:14px">{{ $dif['titulo'] ?? $dif['title'] ?? '' }}</strong>
                                <p style="font-size:13px;color:rgba(255,255,255,.9);margin:5px 0 0">{{ $dif['texto'] ?? $dif['text'] ?? '' }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        {{-- INVERSION --}}
        <section class="sec sec-inversion" id="inversion">
            <div class="inversion-fondo"></div>
            <div class="content-info" style="padding:30px 0">
                <h2 class="section-title">Inversion</h2>
                <div class="inversion-wrap">
                    <div class="inversion-main">
                        <div class="inversion-left">
                            <h3><i class="fas fa-graduation-cap me-2"></i> Incluye:</h3>
                            <ul>
                                <li>Acceso inmediato al curso grabado</li>
                                <li>Material de lectura descargable</li>
                                <li>Certificado profesional digital</li>
                                <li>Soporte acadmico va WhatsApp</li>
                                <li>Acceso desde cualquier dispositivo</li>
                            </ul>
                        </div>
                        <div class="inversion-right">
                            <div class="inv-title">PRECIO DEL CURSO</div>
                            @if($tieneOferta)
                                <div class="inv-regular-price">S/ {{ number_format($precioRegular, 0) }}</div>
                                <div class="inv-discount-badge">{{ round((1 - $precioOferta / $precioRegular) * 100) }}% DE DESCUENTO</div>
                            @endif
                            <div class="inv-price-main">S/<span>{{ number_format($tieneOferta ? $precioOferta : $precioRegular, 0) }}</span></div>
                            <form action="{{ route('carrito.add', $curso->slug) }}" method="POST" style="display:inline">
                                @csrf
                                <button type="submit" class="btn-acceder-card">
                                    <i class="fas fa-shopping-cart me-1"></i> AGREGAR AL CARRITO
                                </button>
                            </form>
                            <div class="inv-secure"><i class="fas fa-lock me-1"></i> Pago 100% seguro</div>
                            <div class="inv-igv">* Incluye IGV</div>
                        </div>
                    </div>

                    <div style="text-align:center;margin-top:25px">
                        <p style="font-size:13px;color:#4A5568">Prefieres pagar por transferencia o Yape?<br>Contctanos por WhatsApp y te enviaremos los datos.</p>
                        <a href="https://wa.me/51{{ $whatsapp }}?text=Hola%2C%20quiero%20inscribirme%20en%20el%20curso%20{{ urlencode($curso->title) }}" class="btn-wsp-inversion" target="_blank">
                            <i class="fab fa-whatsapp fa-lg"></i> ESCRIBENOS POR WHATSAPP
                        </a>
                    </div>
                </div>
            </div>
        </section>

        {{-- TESTIMONIOS --}}
        @if(count($testimonios) > 0)
        <section class="sec" id="testimonio-seccion">
            <div class="testimonios-fondo"></div>
            <div class="content-info" style="padding:30px 0">
                <h2 class="section-title">Lo que dicen nuestros alumnos</h2>
                <div class="testi-grid" id="testiGrid">
                    @foreach($testimonios as $i => $testimonio)
                        <div class="testi-card {{ $i >= 4 ? 'd-none' : '' }}" data-index="{{ $i }}">
                            <p>"{{ $testimonio['texto'] ?? $testimonio['text'] ?? '' }}"</p>
                            <div class="testi-foto">
                                <img src="{{ $testimonio['foto'] ?? $testimonio['photo'] ?? asset('images/default-testimonial.jpg') }}" alt="{{ $testimonio['nombre'] ?? $testimonio['name'] ?? '' }}">
                            </div>
                            <h5>{{ $testimonio['nombre'] ?? $testimonio['name'] ?? '' }}</h5>
                            <small>{{ $testimonio['cargo'] ?? $testimonio['role'] ?? '' }}</small>
                        </div>
                    @endforeach
                </div>
                @if(count($testimonios) > 4)
                <div class="testi-dots">
                    <button class="testi-dot active" onclick="showTestimonios(1)"></button>
                    <button class="testi-dot" onclick="showTestimonios(2)"></button>
                    @if(count($testimonios) > 8)
                        <button class="testi-dot" onclick="showTestimonios(3)"></button>
                    @endif
                </div>
                @endif
            </div>
        </section>
        @endif

        {{-- IN-HOUSE --}}
        <section class="sec sec-asesora" id="inhouse">
            <div class="asesora-fondo"></div>
            <div class="content-info" style="padding:30px 0">
                <div class="asesora-title">Buscas una capacitacin <span style="color:#FFB800">IN-HOUSE</span>?</div>
                <p class="asesora-subtitle">Lleva este curso de forma privada para toda tu institucin.</p>
                <div class="asesora-card-wrap">
                    <a href="https://wa.me/51{{ $whatsapp }}?text=Hola%2C%20quiero%20informaci%C3%B3n%20sobre%20el%20curso%20IN-HOUSE%20{{ urlencode($curso->title) }}" target="_blank">
                        <img src="{{ asset('images/ryc/asesora-inhouse-cta.jpg') }}" alt="Asesora InHouse" class="asesora-full-img" onerror="this.style.display='none'">
                    </a>
                </div>
            </div>
        </section>

        {{-- FAQ --}}
        @if(count($faq) > 0)
        <section class="sec" id="faq">
            <h2 class="section-title">Preguntas Frecuentes</h2>
            <div style="max-width:750px;margin:0 auto">
                <div class="accordion faq-accordion" id="accordionFaq">
                    @foreach($faq as $index => $faqItem)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingF{{ $index }}">
                                <button class="accordion-button @if($index > 0) collapsed @endif" type="button" data-bs-toggle="collapse" data-bs-target="#collapseF{{ $index }}" aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" aria-controls="collapseF{{ $index }}">
                                    {{ $faqItem['pregunta'] ?? $faqItem['question'] ?? $faqItem['title'] ?? '' }}
                                </button>
                            </h2>
                            <div id="collapseF{{ $index }}" class="accordion-collapse collapse @if($index === 0) show @endif" aria-labelledby="headingF{{ $index }}" data-bs-parent="#accordionFaq">
                                <div class="accordion-body">
                                    {{ $faqItem['respuesta'] ?? $faqItem['answer'] ?? $faqItem['text'] ?? '' }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        {{-- WHATSAPP FLOTANTE --}}
        <a href="https://wa.me/51{{ $whatsapp }}?text=Hola%2C%20quiero%20informaci%C3%B3n%20sobre%20{{ urlencode($curso->title) }}" class="wa-float" target="_blank">
            <i class="fab fa-whatsapp fa-lg"></i> Tienes dudas? Escrbenos
        </a>

        {{-- MOBILE STICKY BAR --}}
        <div class="mobile-sticky-bar">
            <div class="msb-price">S/<span>{{ number_format($tieneOferta ? $precioOferta : $precioRegular, 0) }}</span></div>
            <form action="{{ route('carrito.add', $curso->slug) }}" method="POST" style="display:inline">
                @csrf
                <button type="submit" class="btn-acceder-card-no-margin">
                    <i class="fas fa-shopping-cart me-1"></i> AGREGAR AL CARRITO
                </button>
            </form>
        </div>
    </div>
</div>

{{-- MODALES PROFESORES --}}
@if(count($teachers) === 0 && $curso->profesores->count() > 0)
    @foreach($curso->profesores as $profesor)
    <div class="modal fade" id="modalProfesor{{ $profesor->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">{{ $profesor->name }}</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if($profesor->formacion)
                    <h4>Formacin Profesional</h4>
                    <ul>
                        @foreach($profesor->formacion as $form)
                            <li>{{ $form }}</li>
                        @endforeach
                    </ul>
                    @endif
                    @if($profesor->experiencia)
                    <h4>Experiencia Profesional</h4>
                    <ul>
                        @foreach($profesor->experiencia as $exp)
                            <li>{{ $exp }}</li>
                        @endforeach
                    </ul>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    @endforeach
@endif

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/js/bootstrap.bundle.min.js"></script>
<script>
    function toggleTemario(header) {
        header.classList.toggle('collapsed');
        const body = header.nextElementSibling;
        body.style.display = (body.style.display === 'none' || body.style.display === '') ? 'block' : 'none';
    }

    function showTestimonios(page) {
        const cards = document.querySelectorAll('.testi-card');
        const perPage = 4;
        const start = (page - 1) * perPage;
        const end = start + perPage;
        cards.forEach((card, idx) => {
            card.classList.toggle('d-none', idx < start || idx >= end);
        });
        document.querySelectorAll('.testi-dot').forEach((dot, idx) => {
            dot.classList.toggle('active', idx === page - 1);
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        const panel = document.getElementById('panelSticky');
        if (panel) {
            panel.style.top = '195px';
        }
    });

    function guardarLead(form) {
        event.preventDefault();

        var xhr = new XMLHttpRequest();
        xhr.open('POST', '/ryc/api/leads', true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]')?.content || '');
        xhr.onload = function() {
            if (xhr.status === 201 || xhr.status === 200) {
                form.reset();
                alert('Gracias por tu solicitud. Te contactaremos pronto por WhatsApp.');
            } else {
                alert('Hubo un error. Intntalo de nuevo o escrbenos directamente por WhatsApp.');
            }
        };
        xhr.onerror = function() {
            alert('Error de conexin. Escrbenos directamente por WhatsApp.');
        };
        xhr.send(JSON.stringify({
            nombre: form.contact_name.value,
            correo: form.contact_email.value,
            celular: form.contact_phone.value,
            curso: '{{ $curso->title }}',
            consulta: 'Solicitud de inscripcin - Curso Online'
        }));
        return false;
    }
</script>
@endsection
