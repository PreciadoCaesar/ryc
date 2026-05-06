@extends('layouts.app')

@section('title', 'Experiencia y Alianzas | R&C Consulting')

@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css">
<link rel="stylesheet" href="{{ asset('css/experiencia/styles.css') }}">

<style>
:root {
    --rojo:#C8102E; --rojo-dark:#9E0A22;
    --azul:#0A1F5C; --azul-medio:#1A3A7A;
    --verde-wsp:#25D366; --verde-wsp-dark:#1DA851;
    --azul-btn:#1565C0; --rojo-tienda:#E53935;
    --gris-claro:#F5F7FA; --gris-medio:#E8ECF0;
    --texto-oscuro:#1A1A2E; --texto-medio:#4A5568;
    --amarillo:#FFB800;
}

body{font-family:'Poppins',sans-serif;color:#03206A;background:#fff;overflow-x:hidden;}

/* ══ HERO GARANTIA ══ */
.hero-garantia{
    background:linear-gradient(135deg,#071540 0%,#03206A 50%,var(--azul-medio) 100%);
    position:relative;overflow:hidden;padding:60px 0 70px;
}
.hero-garantia::before{content:'';position:absolute;top:-80px;right:-80px;width:380px;height:380px;background:radial-gradient(circle,rgba(200,16,46,.14) 0%,transparent 70%);pointer-events:none;}
.hero-garantia .container{position:relative;z-index:2;}
.hero-label{color:rgba(255,255,255,.7);font-size:13px;font-weight:500;margin-bottom:6px;}
.hero-title{font-family:'Poppins',sans-serif;color:#fff;font-size:clamp(24px,3.5vw,38px);font-weight:800;line-height:1.15;margin-bottom:16px;text-transform:uppercase;}
.hero-desc{font-size:13.5px;color:rgba(255,255,255,.8);line-height:1.65;max-width:440px;margin-bottom:24px;}
.hero-stats{display:flex;gap:20px;flex-wrap:wrap;}
.hero-stat{display:flex;align-items:center;gap:10px;}
.hero-stat-icon{width:auto;height:auto;max-width:200px;flex-shrink:0;}
.hero-stat-icon img{width:100%;height:auto;display:block;}
.hero-photo-box{background:#fff;border-radius:14px;width:100%;aspect-ratio:4/3;box-shadow:0 16px 40px rgba(0,0,0,.25);overflow:hidden;}

/* ══ ENTIDADES ══ */
.section-entidades{background:var(--gris-claro);padding:50px 0 45px;text-align:center;}
.section-entidades h2{font-family:'Poppins',sans-serif;font-size:clamp(22px,3vw,32px);font-weight:700;color:#03206A;margin-bottom:8px;}
.section-entidades .subtitle{font-size:14px;color:var(--texto-medio);max-width:650px;margin:0 auto 30px;line-height:1.6;}
.carousel-outer{position:relative;overflow:hidden;padding:0;}
.carousel-track{display:flex;gap:20px;animation:scrollLogos 15s linear infinite;}
@keyframes scrollLogos{0%{transform:translateX(0);}100%{transform:translateX(-190%);}}
.carousel-card{flex:0 0 170px;height:85px;background:#fff;border-radius:10px;display:flex;align-items:center;justify-content:center;box-shadow:0 2px 8px rgba(0,0,0,.05);transition:box-shadow .2s,transform .2s;}
.carousel-card:hover{box-shadow:0 4px 16px rgba(0,0,0,.1);transform:translateY(-2px);}
.carousel-card img{max-height:58px;max-width:130px;width:auto;height:auto;object-fit:contain;}

/* ══ ESTRUCTURA ══ */
.section-estructura{position:relative;width:100%;overflow:hidden;}
.estructura-bg{width:100%;line-height:0;}
.estructura-bg img{width:100%;height:auto;display:block;object-fit:contain;}
.estructura-bg .img-mobile{display:none;}
.estructura-bg .img-desktop{display:block;}
.img-desktop-link,.img-mobile-link{display:block;position:relative;overflow:hidden;}
.img-mobile-link{display:none;}
.overlay-ver{position:absolute;bottom:0;left:0;right:0;background:linear-gradient(transparent,rgba(0,0,0,0.7));padding:40px 20px 20px;text-align:center;opacity:0;transition:opacity 0.3s ease;}
.overlay-ver span{background:rgba(255,255,255,0.95);color:#333;padding:12px 25px;border-radius:30px;font-size:16px;font-weight:600;box-shadow:0 4px 15px rgba(0,0,0,0.2);}
.img-desktop-link:hover .overlay-ver,.img-mobile-link:hover .overlay-ver{opacity:1;}
.img-desktop-link:hover img,.img-mobile-link:hover img{transform:scale(1.02);}

/* ══ EQUIPO ACADÉMICO ══ */
.section-equipo{background:#E4F0FE;padding:50px 0 60px;}
.equipo-title{font-family:'Poppins',sans-serif;font-size:clamp(24px,3.5vw,36px);font-weight:800;color:#03206A;text-align:center;margin-bottom:8px;}
.equipo-desc{font-size:13.5px;color:var(--texto-medio);text-align:center;max-width:650px;margin:0 auto 20px;line-height:1.65;}
.equipo-requisitos{border-radius:14px;padding:24px 28px;margin-bottom:24px;}
.equipo-requisitos ul{list-style:none;padding:0;margin:0;columns:2;column-gap:30px;}
.equipo-requisitos li{font-size:12.5px;color:var(--texto-medio);line-height:1.7;margin-bottom:8px;padding-left:16px;position:relative;break-inside:avoid;}
.equipo-requisitos li::before{content:'•';position:absolute;left:0;color:#03206A;font-weight:700;}
.btn-postular{display:inline-flex;align-items:center;gap:8px;background:var(--rojo);color:#fff;font-family:'Poppins',sans-serif;font-size:13px;font-weight:700;padding:11px 28px;border-radius:50px;text-decoration:none;border:none;cursor:pointer;transition:background .2s,transform .15s;margin-bottom:6px;}
.btn-postular:hover{background:var(--rojo-dark);color:#fff;transform:translateY(-1px);}
.equipo-email{font-size:12px;color:var(--texto-medio);}
.equipo-email a{color:#03206A;font-weight:600;text-decoration:none;}

/* Grid de profesores */
.prof-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:32px 28px;margin-top:30px;max-width:100%;margin-left:auto;margin-right:auto;}
@media(max-width:991px){.prof-grid{grid-template-columns:repeat(3,1fr);max-width:650px;}}
@media(max-width:767px){.prof-grid{grid-template-columns:repeat(2,1fr);gap:20px 16px;max-width:400px;}}
.prof-card{background:#fff;border-radius:10px;overflow:hidden;box-shadow:0 3px 12px rgba(0,0,0,.08);transition:transform .2s,box-shadow .2s;display:flex;flex-direction:column;max-width:190px;margin:0 auto;width:100%;}
.prof-card:hover{transform:translateY(-3px);box-shadow:0 8px 24px rgba(0,0,0,.14);}
.prof-card__img-wrap{width:100%;aspect-ratio:3/4;overflow:hidden;background:var(--gris-medio);}
.prof-card__img-wrap img{width:100%;height:100%;object-fit:cover;object-position:top center;}
.prof-card__body{padding:10px 8px 12px;text-align:center;flex:1;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:6px;}
.prof-card__name{font-family:'Poppins',sans-serif;font-size:12px;font-weight:700;color:#000000;padding:5px 8px;border-radius:5px;line-height:1.3;width:100%;}
.btn-ver-perfil{display:inline-flex;align-items:center;gap:5px;background:#03206A;color:#fff;font-family:'Poppins',sans-serif;font-size:10px;font-weight:700;padding:5px 14px;border-radius:5px;text-decoration:none;border:none;cursor:pointer;transition:background .2s,transform .15s;}
.btn-ver-perfil:hover{background:var(--azul-medio);color:#fff;transform:translateY(-1px);}
.prof-grid.collapsed .prof-card:nth-child(n+9){display:none;}
@media(max-width:991px){.prof-grid.collapsed .prof-card:nth-child(n+7){display:none;}}
@media(max-width:767px){.prof-grid.collapsed .prof-card:nth-child(n+5){display:none;}}
.btn-ver-todo{display:inline-flex;align-items:center;gap:8px;background:#03206A;color:#fff;font-family:'Poppins',sans-serif;font-size:13px;font-weight:700;padding:12px 32px;border-radius:50px;border:none;cursor:pointer;margin-top:28px;transition:background .2s,transform .15s;}
.btn-ver-todo:hover{background:var(--azul-medio);transform:translateY(-1px);}
.btn-ver-todo i{transition:transform .3s;}
.btn-ver-todo.expanded i{transform:rotate(180deg);}
.prof-card.skeleton .prof-card__img-wrap{background:linear-gradient(90deg,#e0e8f0 25%,#edf2f7 50%,#e0e8f0 75%);background-size:200% 100%;animation:shimmer 1.5s infinite;}
.prof-card.skeleton .prof-card__name{background:#e0e8f0;color:transparent;height:32px;}
@keyframes shimmer{0%{background-position:200% 0;}100%{background-position:-200% 0;}}

/* ══ EQUIPO CONSULTING ══ */
.section-equipo-consulting{background:#E4F0FE;padding:50px 0 60px;}
.equipo-consulting-title{font-family:'Poppins',sans-serif;font-size:clamp(24px,3.5vw,36px);font-weight:800;color:#03206A;text-align:center;margin-bottom:8px;}
.equipo-consulting-desc{font-size:13.5px;color:var(--texto-medio);text-align:center;max-width:650px;margin:0 auto 30px;line-height:1.65;}
.equipo-subtitle{font-family:'Poppins',sans-serif;font-size:16px;font-weight:700;color:#03206A;margin:30px 0 16px;text-align:center;}
.equipo-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:24px;max-width:900px;margin:0 auto;}
@media(max-width:768px){.equipo-grid{grid-template-columns:repeat(2,1fr);}}
.member-card{background:#fff;border-radius:12px;overflow:hidden;box-shadow:0 3px 12px rgba(0,0,0,.08);transition:transform .2s,box-shadow .2s;}
.member-card:hover{transform:translateY(-3px);box-shadow:0 8px 24px rgba(0,0,0,.14);}
.member-photo{width:100%;aspect-ratio:3/4;overflow:hidden;background:var(--gris-medio);}
.member-photo img{width:100%;height:100%;object-fit:cover;object-position:top center;}
.member-photo.no-photo{display:flex;align-items:center;justify-content:center;color:var(--texto-medio);font-size:12px;}
.member-info{padding:12px;text-align:center;}
.member-info h4{font-family:'Poppins',sans-serif;font-size:13px;font-weight:700;color:#03206A;margin-bottom:4px;}
.member-cargo{font-size:11px;color:var(--texto-medio);margin-bottom:2px;}
.member-formacion{font-size:10px;color:#999;}

/* RESPONSIVE */
@media(max-width:991px){.hero-garantia{padding:40px 0 50px;}.hero-photo-box{margin-top:24px;}.hero-stat-icon{max-width:160px;}}
@media(max-width:767px){.equipo-requisitos ul{columns:1;}.carousel-outer{padding:0 36px;}.carousel-card{flex:0 0 140px;height:72px;}.hero-stat-icon{max-width:140px;}}
@media(max-width:768px){.img-desktop-link{display:none;}.img-mobile-link{display:block;}.overlay-ver{opacity:1;padding:30px 15px 15px;}.overlay-ver span{font-size:14px;padding:10px 20px;}}
</style>
@endsection

@section('content')

<!-- SECCIÓN 1 — GARANTÍA INSTITUCIONAL -->
<section class="hero-garantia">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <p class="hero-label">Con garantía institucional</p>
                <h1 class="hero-title">Respaldo Humano y<br>Experiencia Academica</h1>
                <p class="hero-desc">Un equipo interno comprometido y docentes especialistas que convierten la normativa en resultados aplicables para tu entidad.</p>
                <div class="hero-stats">
                    <div class="hero-stat">
                        <div class="hero-stat-icon">
                            <img src="{{ asset('img/alianzas/4x/1.5x/Recurso 52@1.5x.webp') }}" alt="+15 Colaboradores">
                        </div>
                    </div>
                    <div class="hero-stat">
                        <div class="hero-stat-icon">
                            <img src="{{ asset('img/alianzas/4x/1.5x/Recurso 53@1.5x.webp') }}" alt="+30 Expositores">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="hero-photo-box"></div>
            </div>
        </div>
    </div>
</section>


<!-- SECCIÓN 2 — ENTIDADES CARRUSEL -->
<section class="section-entidades">
    <div class="container">
        <h2>Entidades que ya nos eligieron</h2>
        <p class="subtitle">Instituciones del Estado con las que R&C CONSULTING ha trabajado y más de 1000 instituciones públicas y privadas.</p>
        <div class="carousel-outer">
            <div class="carousel-track" id="carouselTrack">
                <div class="carousel-card"><img src="{{ asset('img/alianzas/Logo de entidades/Recurso 54@4x.webp') }}" alt="OECE"></div>
                <div class="carousel-card"><img src="{{ asset('img/alianzas/Logo de entidades/Recurso 55@4x.webp') }}" alt="OECE"></div>
                <div class="carousel-card"><img src="{{ asset('img/alianzas/Logo de entidades/Recurso 56@4x.webp') }}" alt="OECE"></div>
                <div class="carousel-card"><img src="{{ asset('img/alianzas/Logo de entidades/Recurso 57@4x.webp') }}" alt="OECE"></div>
                <div class="carousel-card"><img src="{{ asset('img/alianzas/Logo de entidades/Recurso 58@4x.webp') }}" alt="OECE"></div>
                <div class="carousel-card"><img src="{{ asset('img/alianzas/Logo de entidades/Recurso 59@4x.webp') }}" alt="OECE"></div>
                <div class="carousel-card"><img src="{{ asset('img/alianzas/Logo de entidades/Recurso 60@4x.webp') }}" alt="OECE"></div>
                <div class="carousel-card"><img src="{{ asset('img/alianzas/Logo de entidades/Recurso 61@4x.webp') }}" alt="OECE"></div>
                <div class="carousel-card"><img src="{{ asset('img/alianzas/Logo de entidades/Recurso 62@4x.webp') }}" alt="OECE"></div>
                <div class="carousel-card"><img src="{{ asset('img/alianzas/Logo de entidades/Recurso 63@4x.webp') }}" alt="OECE"></div>
                <div class="carousel-card"><img src="{{ asset('img/alianzas/Logo de entidades/Recurso 54@4x.webp') }}" alt="OECE"></div>
                <div class="carousel-card"><img src="{{ asset('img/alianzas/Logo de entidades/Recurso 55@4x.webp') }}" alt="OECE"></div>
                <div class="carousel-card"><img src="{{ asset('img/alianzas/Logo de entidades/Recurso 56@4x.webp') }}" alt="OECE"></div>
                <div class="carousel-card"><img src="{{ asset('img/alianzas/Logo de entidades/Recurso 57@4x.webp') }}" alt="OECE"></div>
                <div class="carousel-card"><img src="{{ asset('img/alianzas/Logo de entidades/Recurso 58@4x.webp') }}" alt="OECE"></div>
                <div class="carousel-card"><img src="{{ asset('img/alianzas/Logo de entidades/Recurso 59@4x.webp') }}" alt="OECE"></div>
                <div class="carousel-card"><img src="{{ asset('img/alianzas/Logo de entidades/Recurso 60@4x.webp') }}" alt="OECE"></div>
                <div class="carousel-card"><img src="{{ asset('img/alianzas/Logo de entidades/Recurso 61@4x.webp') }}" alt="OECE"></div>
                <div class="carousel-card"><img src="{{ asset('img/alianzas/Logo de entidades/Recurso 62@4x.webp') }}" alt="OECE"></div>
                <div class="carousel-card"><img src="{{ asset('img/alianzas/Logo de entidades/Recurso 63@4x.webp') }}" alt="OECE"></div>
            </div>
        </div>
    </div>
</section>


<!-- SECCIÓN 3 — ESTRUCTURA ORGANIZACIONAL -->
<section class="section-estructura">
    <div class="estructura-bg">
        <a href="{{ asset('img/alianzas/Organigrama Web.webp') }}" data-fancybox="organigrama" data-caption="Organigrama R&C" class="img-desktop-link">
            <img class="img-desktop" src="{{ asset('img/alianzas/4x/1.5x/Recurso 54gaaa.webp') }}" alt="Equipo institucional R&C">
            <div class="overlay-ver"><span>Ver Organigrama</span></div>
        </a>
        <a href="{{ asset('img/alianzas/Organigrama Responsive.webp') }}" data-fancybox="organigrama-mobile" data-caption="Organigrama R&C" class="img-mobile-link">
            <img class="img-mobile" src="{{ asset('img/alianzas/4x/1.5x/Recurso 55xw.webp') }}" alt="Equipo institucional R&C">
            <div class="overlay-ver"><span>Ver Organigrama</span></div>
        </a>
    </div>
</section>


<!-- SECCIÓN 4 — NUESTRO EQUIPO ACADÉMICO -->
<section class="section-equipo">
    <div class="container">
        <h2 class="equipo-title">Nuestro equipo académico</h2>
        <p class="equipo-desc">Seleccionamos docentes con sólida formación académica y experiencia comprobada en el sector público, bajo criterios de idoneidad y ética profesional.</p>

        <div class="equipo-requisitos">
            <ul>
                <li>+10 años de experiencia en el sector público.</li>
                <li>Maestría en su especialidad.</li>
                <li>Funcionario/servidor público activo o consultor internacional en su campo.</li>
                <li>Docencia en postgrado (mín. 5 años) en instituciones de reconocido prestigio.</li>
                <li>Experiencia mínima de 5 años en el ente rector del sistema administrativo a enseñar.</li>
                <li>Conducta ética intachable (sin denuncias por corrupción u otros delitos aplicables).</li>
            </ul>
        </div>

        <div class="text-center" style="margin-bottom:10px;">
            <a href="mailto:capacitacion@rc-consulting.com" class="btn-postular">Postula como expositor</a>
            <p class="equipo-email">Envía tu CV a <a href="mailto:capacitacion@rc-consulting.com">capacitacion@rc-consulting.com</a></p>
        </div>

        <div class="prof-grid collapsed" id="profGrid"></div>

        <div class="text-center" id="verTodoWrap" style="display:none;">
            <button class="btn-ver-todo" id="btnVerTodo" onclick="toggleProfesores()">
                Ver todos los docentes <i class="fas fa-chevron-down"></i>
            </button>
        </div>
    </div>
</section>


<!-- SECCIÓN 5 — EQUIPO CONSULTING -->
<section class="section-equipo-consulting">
    <div class="container">
        <h2 class="equipo-consulting-title">Equipo Consulting</h2>
        <p class="equipo-consulting-desc">Conoce a nuestro equipo humano que hace posible la excelencia en cada programa de capacitación.</p>
        
        <div class="equipo-subtitle">Equipo Directivo</div>
        <div class="equipo-grid">
            <div class="member-card">
                <div class="member-photo">
                    <img src="{{ asset('img/equipo/Mag. MISAEL RIVERA CARHUAPUMA.jpg') }}" alt="Mg Misael Rivera">
                </div>
                <div class="member-info">
                    <h4>Mg Misael Rivera</h4>
                    <p class="member-cargo">Gerente General</p>
                    <p class="member-formacion">Formación: [por confirmar]</p>
                </div>
            </div>
            <div class="member-card">
                <div class="member-photo">
                    <img src="{{ asset('img/equipo/Mg. Vlado Castañeda.jpg') }}" alt="Mg Vlado Castañeda">
                </div>
                <div class="member-info">
                    <h4>Mg Vlado Castañeda</h4>
                    <p class="member-cargo">Director Académico</p>
                    <p class="member-formacion">Formación: [por confirmar]</p>
                </div>
            </div>
            <div class="member-card">
                <div class="member-photo">
                    <img src="{{ asset('img/equipo/Iris.png') }}" alt="Mg Ibeth Angulo">
                </div>
                <div class="member-info">
                    <h4>Mg Ibeth Angulo</h4>
                    <p class="member-cargo">Gestión de RRHH del Conocimiento</p>
                    <p class="member-formacion">Formación: [por confirmar]</p>
                </div>
            </div>
        </div>

        <div class="equipo-subtitle">Equipo Comercial</div>
        <div class="equipo-grid">
            <div class="member-card">
                <div class="member-photo"><img src="{{ asset('img/equipo/Estefani.jpg') }}" alt="Estefany Espejo"></div>
                <div class="member-info"><h4>Estefany Espejo</h4><p class="member-cargo">Coordinadora de Ventas</p><p class="member-formacion">Formación: [por confirmar]</p></div>
            </div>
            <div class="member-card">
                <div class="member-photo"><img src="{{ asset('img/equipo/Romina.jpg') }}" alt="Romina Sirlopú"></div>
                <div class="member-info"><h4>Romina Sirlopú</h4><p class="member-cargo">Asesora Comercial</p><p class="member-formacion">Formación: [por confirmar]</p></div>
            </div>
            <div class="member-card">
                <div class="member-photo"><img src="{{ asset('img/equipo/Vanessa.jpg') }}" alt="Vanessa Vértiz"></div>
                <div class="member-info"><h4>Vanessa Vértiz</h4><p class="member-cargo">Asesora Comercial</p><p class="member-formacion">Formación: [por confirmar]</p></div>
            </div>
            <div class="member-card">
                <div class="member-photo"><img src="{{ asset('img/equipo/Yajaira.jpg') }}" alt="Yajaira Hinostroza"></div>
                <div class="member-info"><h4>Yajaira Hinostroza</h4><p class="member-cargo">Asesora Comercial</p><p class="member-formacion">Formación: [por confirmar]</p></div>
            </div>
            <div class="member-card">
                <div class="member-photo"><img src="{{ asset('img/equipo/Arnaldo.jpg') }}" alt="Arnaldo Montaño"></div>
                <div class="member-info"><h4>Arnaldo Montaño</h4><p class="member-cargo">Asesor Comercial</p><p class="member-formacion">Formación: [por confirmar]</p></div>
            </div>
            <div class="member-card">
                <div class="member-photo"><img src="{{ asset('img/equipo/Melany.jpg') }}" alt="Melany La hoz"></div>
                <div class="member-info"><h4>Melany La hoz</h4><p class="member-cargo">Asesora Comercial</p><p class="member-formacion">Formación: [por confirmar]</p></div>
            </div>
        </div>

        <div class="equipo-subtitle">Equipo de Marketing y Programación</div>
        <div class="equipo-grid">
            <div class="member-card">
                <div class="member-photo"><img src="{{ asset('img/equipo/Joao.jpg') }}" alt="Joao Huerta"></div>
                <div class="member-info"><h4>Joao Huerta</h4><p class="member-cargo">Diseñador Gráfico</p><p class="member-formacion">Formación: [por confirmar]</p></div>
            </div>
            <div class="member-card">
                <div class="member-photo"><img src="{{ asset('img/equipo/Cesar.jpg') }}" alt="Cesar Preciado"></div>
                <div class="member-info"><h4>Cesar Preciado</h4><p class="member-cargo">Desarrollador Web</p><p class="member-formacion">Formación: [por confirmar]</p></div>
            </div>
            <div class="member-card">
                <div class="member-photo"><img src="{{ asset('img/equipo/Marco.jpg') }}" alt="Marco Zarate"></div>
                <div class="member-info"><h4>Marco Zarate</h4><p class="member-cargo">Desarrollador Web</p><p class="member-formacion">Formación: [por confirmar]</p></div>
            </div>
        </div>

        <div class="equipo-subtitle">Área Académica Inhouse</div>
        <div class="equipo-grid">
            <div class="member-card">
                <div class="member-photo"><img src="{{ asset('img/equipo/Marsebith.jpg') }}" alt="Marsebith"></div>
                <div class="member-info"><h4>Marsebith</h4><p class="member-cargo">Coordinadora Académica</p><p class="member-formacion">Formación: [por confirmar]</p></div>
            </div>
        </div>

        <div class="equipo-subtitle">Área de Gestión y Soporte</div>
        <div class="equipo-grid">
            <div class="member-card">
                <div class="member-photo"><img src="{{ asset('img/equipo/Joel.jpg') }}" alt="Joel Paniora"></div>
                <div class="member-info"><h4>Joel Paniora</h4><p class="member-cargo">Soporte Técnico</p><p class="member-formacion">Formación: [por confirmar]</p></div>
            </div>
            <div class="member-card">
                <div class="member-photo"><img src="{{ asset('img/equipo/Bianca.jpg') }}" alt="Bianca Fretel"></div>
                <div class="member-info"><h4>Bianca Fretel</h4><p class="member-cargo">Secretaria Administrativa</p><p class="member-formacion">Formación: [por confirmar]</p></div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
<script>
Fancybox.bind("[data-fancybox]", {
    Images: { zoom: true, Panzoom: { maxScale: 0.5, panMode: "mousemove", mouseMoveFactor: 1.1, mouseMoveFriction: 0.2 } },
    showClass: "fancybox-fadeIn",
    hideClass: "fancybox-fadeOut",
    Toolbar: { display: { left: [], middle: [], right: ["zoomIn", "zoomOut", "close"] } },
    closeButton: "top",
    dragToClose: true,
    idle: false
});

const profGrid = document.getElementById('profGrid');
const btnVerTodo = document.getElementById('btnVerTodo');
const verTodoWrap = document.getElementById('verTodoWrap');

function showSkeletons(n) {
    let html = '';
    for (let i = 0; i < n; i++) {
        html += '<div class="prof-card skeleton"><div class="prof-card__img-wrap"></div><div class="prof-card__body"><div class="prof-card__name">Cargando...</div></div></div>';
    }
    profGrid.innerHTML = html;
}

function renderProfesores(profesores) {
    let html = '';
    profesores.forEach(function(p) {
        var url = p.linkedin || '#';
        var tgt = p.linkedin ? ' target="_blank"' : '';
        html += '<div class="prof-card">' +
            '<div class="prof-card__img-wrap">' +
                '<img src="' + p.foto + '" alt="' + p.nombre + '" loading="lazy" onerror="this.parentElement.classList.add(\'no-foto\'); this.style.display=\'none\'">' +
            '</div>' +
            '<div class="prof-card__body">' +
                '<div class="prof-card__name">' + p.nombre + '</div>' +
                '<a href="' + url + '"' + tgt + ' class="btn-ver-perfil"><i class="fab fa-linkedin-in"></i> Ver perfil</a>' +
            '</div>' +
        '</div>';
    });
    profGrid.innerHTML = html;
    if (profesores.length > 8) { verTodoWrap.style.display = 'block'; }
}

function toggleProfesores() {
    var isCollapsed = profGrid.classList.contains('collapsed');
    profGrid.classList.toggle('collapsed');
    btnVerTodo.classList.toggle('expanded');
    btnVerTodo.innerHTML = isCollapsed ? 'Ocultar docentes <i class="fas fa-chevron-up"></i>' : 'Ver todos los docentes <i class="fas fa-chevron-down"></i>';
}

function cargarDatosRespaldo() {
    var datos = [
        { nombre: 'Ing. Howard Hans Flores Cortez',        foto: '{{ asset("img/alianzas/Profesores/Ing. Howard Hans Flores Cortez.jpg") }}',        linkedin: null },
        { nombre: 'CPC. Amelia Quispe Mendiburo',          foto: '{{ asset("img/alianzas/Profesores/CPC. AMELIA QUISPE MENDIBURO.jpg") }}',          linkedin: null },
        { nombre: 'Mag. Angel Reto Quintanilla',           foto: '{{ asset("img/alianzas/Profesores/Mag. Angel Reto Quintanilla.jpg") }}',           linkedin: null },
        { nombre: 'Lic. Antonio De Loayza Conterno',       foto: '{{ asset("img/alianzas/Profesores/Lic. ANTONIO DE LOAYZA CONTERNO.jpg") }}',       linkedin: null },
        { nombre: 'Mag. Elard Zalazar La Rosa',            foto: '{{ asset("img/alianzas/Profesores/Mag. ELARD ZALAZAR LA ROSA.jpg") }}',            linkedin: null },
        { nombre: 'Abog. Tammy Lorena Quintanilla Zapata', foto: '{{ asset("img/alianzas/Profesores/ABOG. TAMMY LORENA QUINTANILLA ZAPATA.jpg") }}', linkedin: null },
        { nombre: 'Dr. Guido Palomino Hernández',          foto: '{{ asset("img/alianzas/Profesores/DR. GUIDO PALOMINO HERNÁNDEZ.jpg") }}',          linkedin: null },
        { nombre: 'Mg. Jesús Ruitón Cabanillas',           foto: '{{ asset("img/alianzas/Profesores/Mg. JESÚS RUITÓN CABANILLAS.jpg") }}',           linkedin: null },
        { nombre: 'Mag. Aaron Ruiz',                       foto: '{{ asset("img/alianzas/Profesores/Mag. Aaron Ruiz.jpg") }}',                       linkedin: null },
        { nombre: 'Mg. Vlado Castañeda',                   foto: '{{ asset("img/alianzas/Profesores/Mg. Vlado Castañeda.jpg") }}',                   linkedin: null },
        { nombre: 'Econ. José Guillén Rueda',              foto: '{{ asset("img/alianzas/Profesores/Econ. JOSE GUILLEN RUEDA.jpg") }}',              linkedin: null },
        { nombre: 'Dr. Pablo Vílchez',                     foto: '{{ asset("img/alianzas/Profesores/DR. PABLO VILCHEZ.jpg") }}',                     linkedin: null },
        { nombre: 'Lic. César Oseda Samaniego',            foto: '{{ asset("img/alianzas/Profesores/Lic. Cesar Oseda Samaniego.jpg") }}',            linkedin: null },
        { nombre: 'Ing. Michelle Alvarez Roberto',         foto: '{{ asset("img/alianzas/Profesores/ING. MICHELLE ALVAREZ ROBERTO.jpg") }}',         linkedin: null },
        { nombre: 'Abg. Marco Montoya Lazarte',            foto: '{{ asset("img/alianzas/Profesores/ABG. MARCO MONTOYA LAZARTE.jpg") }}',            linkedin: null },
        { nombre: 'Dr. Juan Araníbar Romero',              foto: '{{ asset("img/alianzas/Profesores/Dr. Juan Araníbar Romero.jpg") }}',              linkedin: null },
        { nombre: 'Mag. Edith Huancaqui Rodriguez',        foto: '{{ asset("img/alianzas/Profesores/Mag. Edith Huancaqui Rodriguez.jpg") }}',        linkedin: null },
        { nombre: 'Mag. Evelyn Meres Morales',             foto: '{{ asset("img/alianzas/Profesores/Mag. Evelyn Meres Morales.jpg") }}',             linkedin: null },
        { nombre: 'Mag. Ramiro Culqui Ramírez',            foto: '{{ asset("img/alianzas/Profesores/Mag. Ramiro Culqui Ramirez.jpg") }}',            linkedin: null },
        { nombre: 'Mag. Misael Rivera Carhuapuma',         foto: '{{ asset("img/alianzas/Profesores/Mag. MISAEL RIVERA CARHUAPUMA.jpg") }}',         linkedin: null },
        { nombre: 'Ing. Víctor Manuel Morales Palacios',   foto: '{{ asset("img/alianzas/Profesores/ING. VICTOR MANUEL MORALES PALACIOS.jpg") }}',   linkedin: null },
        { nombre: 'Mag. Miguel Salas Macchiavello',        foto: '{{ asset("img/alianzas/Profesores/MAG. Miguel Salas Macchiavello.jpg") }}',        linkedin: null },
        { nombre: 'Dr. Marlon Prieto Hormaza',             foto: '{{ asset("img/alianzas/Profesores/DR. MARLON PRIETO HORMAZA.jpg") }}',             linkedin: null },
        { nombre: 'Mag. Edgar Maguiña Roca',               foto: '{{ asset("img/alianzas/Profesores/Mag. Edgar Maguiña Roca.jpg") }}',               linkedin: null },
        { nombre: 'Ing. Ronald Vásquez Guerra',            foto: '{{ asset("img/alianzas/Profesores/ING. RONALD VASQUEZ GUERRA.jpg") }}',            linkedin: null },
        { nombre: 'Mag. Rosario Zavaleta Meza',            foto: '{{ asset("img/alianzas/Profesores/MAG. ROSARIO ZAVALETA MEZA.jpg") }}',            linkedin: null },
    ];
    renderProfesores(datos);
}

showSkeletons(8);
cargarDatosRespaldo();
</script>
@endsection