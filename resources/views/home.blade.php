@extends('layouts.app-main')

@section('title', 'Cursos SIAF SIGA SEACE Perú 2026 | Diplomados Gestión Pública | R&C Consulting')

@section('styles')
<!-- Estilos específicos de home.blade.php -->
<style>
.btn-add-cart {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #FF044D;
    color: #fff;
    padding: 8px 16px;
    border: none;
    border-radius: 50px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.3s;
    text-decoration: none;
}
.btn-add-cart:hover {
    opacity: 0.9;
    transform: translateY(-2px);
    color: #fff;
}
.curso-card__actions {
    display: flex;
    gap: 8px;
    margin-top: 10px;
}
</style>
@endsection

@section('content')


<!-- ══ CAROUSEL (Index 2) ══ -->
<div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
	<div class="carousel-inner">
		<div class="carousel-item active"><a class="slidem slide-1 d-block w-100" target="_blank" href="https://rc-consulting.org/online/curso-siaf-sp-rp/"></a></div>
		<div class="carousel-item"><a class="slidem slide-2 d-block w-100" target="_blank" href="https://rc-consulting.org/online/diplomado-contrataciones-publicas/"></a></div>
		<div class="carousel-item"><a class="slidem slide-3 d-block w-100" target="_blank" href="https://rc-consulting.org/cursos-inhouse/"></a></div>
	</div>
	<button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev"><span class="carousel-control-prev-icon" aria-hidden="true"></span><span class="visually-hidden">Anterior</span></button>
	<button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next"><span class="carousel-control-next-icon" aria-hidden="true"></span><span class="visually-hidden">Siguiente</span></button>
</div>

<!-- ══ TÍTULO + TABS + GRID CURSOS (Index 2) ══ -->
<div class="seccion-titulo">
	<h1 class="visually-hidden">Cursos y Diplomados de Gestión Pública en Perú | SIAF, SIGA, SEACE</h1>
	<h2>¿En qué te gustaría capacitarte?</h2>
	<p>Encuentra aquí los <strong>cursos de SIAF</strong>, <strong>SIGA</strong>, <strong>SEACE</strong>, <strong>Presupuesto Público</strong> y más. ¡Cursos de Alta Especialización, Disponibles Ahora!</p>
</div>

<div class="filtro-tabs" id="filtroTabs">
	<button class="filtro-tab active" data-filter="proximos-inicios">Próximos Inicios</button>
	<button class="filtro-tab" data-filter="CursosEnvivo">Cursos</button>
	<button class="filtro-tab" data-filter="todo">Todo</button>
	<button class="filtro-tab" data-filter="DiplomadosEnvivo">Diplomados</button>
</div>

<div class="cursos-grid" id="cursosGrid">
	@foreach($cursosEnVivo ?? [] as $curso)
	<div class="curso-card" data-category="CursosEnvivo proximos-inicios todo" data-fecha="{{ $curso->start_date ?? '' }}">
		<div class="curso-card__img">
			<img src="{{ asset($curso->image_cover ?? 'img/curso/default.svg') }}" alt="{{ $curso->title ?? '' }}">
			<span class="sticker-inicia-hoy">INICIA HOY</span>
			<span class="sticker-progreso">EN PROGRESO</span>
		</div>
		<div class="curso-card__body">
			<div class="curso-card__badges"><span class="badge-tipo curso">Curso</span><span class="badge-dcto">30% Dcto.</span></div>
			<h3 class="curso-card__title">{{ $curso->title }}</h3>
			<div class="curso-card__info">
				<div class="info-item"><i class="fas fa-calendar-alt"></i><span><strong>Inicio:</strong><br/>{{ $curso->start_date ?? '' }}</span></div>
				<div class="info-item"><i class="fas fa-clock"></i><span><strong>Duración:</strong><br/>{{ $curso->sessions ?? '' }} sesiones</span></div>
			</div>
			<div class="curso-card__extra">
				<span class="tag-envivo"><i class="fas fa-circle"></i> Clases en vivo</span>
				<div class="info-item" style="margin-left:auto;"><i class="fas fa-certificate"></i><span>{{ $curso['hours'] ?? 0 }} horas<div>Certificadas</div></span></div>
			</div>
			<div class="curso-card__actions">
				<form action="/ryc/carrito/agregar/{{ $curso->slug }}" method="POST" style="display:inline">
					@csrf
					<button type="submit" class="btn-add-cart"><i class="fas fa-shopping-cart"></i> Agregar</button>
				</form>
				<a href="{{ route('curso.mostrar', $curso->slug) }}" target="_blank" class="curso-card__btn">Mas información</a>
			</div>
		</div>
	</div>
	@endforeach

	@foreach($diplomadosEnVivo ?? [] as $curso)
	<div class="curso-card" data-category="DiplomadosEnvivo proximos-inicios todo" data-fecha="{{ $curso->start_date ?? '' }}">
		<div class="curso-card__img">
			<img src="{{ asset($curso->image_cover ?? 'img/curso/default.svg') }}" alt="{{ $curso->title ?? '' }}">
			<span class="sticker-inicia-hoy">INICIA HOY</span>
			<span class="sticker-progreso">EN PROGRESO</span>
		</div>
		<div class="curso-card__body">
			<div class="curso-card__badges"><span class="badge-tipo diplomado">Diplomado</span><span class="badge-dcto">30% Dcto.</span></div>
			<h3 class="curso-card__title">{{ $curso->title }}</h3>
			<div class="curso-card__info">
				<div class="info-item"><i class="fas fa-calendar-alt"></i><span><strong>Inicio:</strong><br/>{{ $curso->start_date ?? '' }}</span></div>
				<div class="info-item"><i class="fas fa-clock"></i><span><strong>Duración:</strong><br/>{{ $curso->sessions ?? '' }} sesiones</span></div>
			</div>
			<div class="curso-card__extra">
				<span class="tag-envivo"><i class="fas fa-circle"></i> Clases en vivo</span>
				<div class="info-item" style="margin-left:auto;"><i class="fas fa-certificate"></i><span>{{ $curso['hours'] ?? 0 }} horas<div>Certificadas</div></span></div>
			</div>
			<div class="curso-card__actions">
				<form action="/ryc/carrito/agregar/{{ $curso->slug }}" method="POST" style="display:inline">
					@csrf
					<button type="submit" class="btn-add-cart"><i class="fas fa-shopping-cart"></i> Agregar</button>
				</form>
				<a href="{{ route('curso.mostrar', $curso->slug) }}" target="_blank" class="curso-card__btn">Mas información</a>
			</div>
		</div>
	</div>
	@endforeach

	@foreach($cursosOnline ?? [] as $curso)
	<div class="curso-card" data-category="CursosOnline todo">
		<div class="curso-card__img">
			<img src="{{ asset($curso->image_cover ?? 'img/curso/default.svg') }}" alt="{{ $curso->title ?? '' }}">
			@if($curso['featured'] ?? false)
			<span class="badge-proximo">Destacado</span>
			@endif
		</div>
		<div class="curso-card__body">
			<div class="curso-card__badges"><span class="badge-tipo curso">Curso Online</span><span class="badge-dcto">30% Dcto.</span></div>
			<h3 class="curso-card__title">{{ $curso->title }}</h3>
			<div class="curso-card__info"><div class="info-item"><i class="fas fa-play-circle"></i><span><strong>¡Inicia</strong> ahora y capacítate!</span></div></div>
			<div class="curso-card__extra">
				<span class="tag-envivo"><i class="fas fa-play-circle"></i> Clases grabadas</span>
				<div class="info-item" style="margin-left:auto;"><i class="fas fa-certificate"></i><span>{{ $curso['hours'] ?? 0 }} horas<div>Certificadas</div></span></div>
			</div>
			<div class="curso-card__actions">
				<form action="/ryc/carrito/agregar/{{ $curso->slug }}" method="POST" style="display:inline">
					@csrf
					<button type="submit" class="btn-add-cart"><i class="fas fa-shopping-cart"></i> Agregar</button>
				</form>
				<a href="{{ route('curso.mostrar', $curso->slug) }}" target="_blank" class="curso-card__btn">Mas información</a>
			</div>
		</div>
	</div>
	@endforeach

	@foreach($diplomadosOnline ?? [] as $curso)
	<div class="curso-card" data-category="DiplomadosOnline todo">
		<div class="curso-card__img">
			<img src="{{ asset($curso->image_cover ?? 'img/curso/default.svg') }}" alt="{{ $curso->title ?? '' }}">
			@if($curso['featured'] ?? false)
			<span class="badge-proximo">Destacado</span>
			@endif
		</div>
		<div class="curso-card__body">
			<div class="curso-card__badges"><span class="badge-tipo diplomado">Diplomado Online</span><span class="badge-dcto">30% Dcto.</span></div>
			<h3 class="curso-card__title">{{ $curso->title }}</h3>
			<div class="curso-card__info"><div class="info-item"><i class="fas fa-play-circle"></i><span><strong>¡Inicia</strong> ahora y capacítate!</span></div></div>
			<div class="curso-card__extra">
				<span class="tag-envivo"><i class="fas fa-play-circle"></i> Clases grabadas</span>
				<div class="info-item" style="margin-left:auto;"><i class="fas fa-certificate"></i><span>{{ $curso['hours'] ?? 0 }} horas<div>Certificadas</div></span></div>
			</div>
			<div class="curso-card__actions">
				<form action="/ryc/carrito/agregar/{{ $curso->slug }}" method="POST" style="display:inline">
					@csrf
					<button type="submit" class="btn-add-cart"><i class="fas fa-shopping-cart"></i> Agregar</button>
				</form>
				<a href="{{ route('curso.mostrar', $curso->slug) }}" target="_blank" class="curso-card__btn">Mas información</a>
			</div>
		</div>
	</div>
	@endforeach
</div>

<div class="seccion-botones">
	<a href="https://rc-consulting.org/cursos-virtuales/" class="btn-ver-mas cursos">Ver más Cursos Online</a>
	<a href="https://rc-consulting.org/diplomas-virtuales/" class="btn-ver-mas diplomas">Ver más Diplomados Online</a>
</div>

<!-- ═══════════════════════════════════════════════════════════════
     DESDE AQUÍ: SECCIONES DEL INDEX 1
     (Programas especializados → Banner azul → Aprende hoy → Entidades → Ayuda → Footer)
     ═══════════════════════════════════════════════════════════════ -->

<!-- SECCION DE PROGRAMAS ESPECIALIZADOS (Index 1) -->
<section class="programas-container">
    <div class="container text-center">
        <h2 class="titulo-principal">Programas especializados en Gestión Pública</h2>
        <p class="subtitulo">Cursos y diplomados para entidades públicas: SIAF, SIGA, SEACE, Presupuesto Público y más.</p>

        <div class="grid-programas">
			<div class="card-programa">
				<img src="{{ asset('img/icons/1.svg') }}" alt="Cursos Online">
				<a href="https://rc-consulting.org/cursos-virtuales/" class="btn-rojo" target="_blank" rel="noopener">Cursos Online</a>
			</div>
			<div class="card-programa">
				<img src="{{ asset('img/icons/2.svg') }}" alt="Diplomados Online">
				<a href="https://rc-consulting.org/diplomas-virtuales/" class="btn-rojo" target="_blank" rel="noopener">Diplomados Online</a>
			</div>
			<div class="card-programa">
				<img src="{{ asset('img/icons/3.svg') }}" alt="Cursos In House">
				<a href="https://rc-consulting.org/cursos-inhouse/" class="btn-rojo" target="_blank" rel="noopener">Cursos In House</a>
			</div>
			<div class="card-programa card-lower">
				<img src="{{ asset('img/icons/4.svg') }}" alt="Consultorías">
				<a href="https://rc-consulting.org/consultoria-asistencia-tecnica/" class="btn-rojo" target="_blank" rel="noopener">Consultorías</a>
			</div>
			<div class="card-programa card-lower">
				<img src="{{ asset('img/icons/5.svg') }}" alt="Certificación Laboral">
				<a href="https://rc-consulting.org/certificacion-de-competencias-laborales/" class="btn-rojo" target="_blank" rel="noopener">Certificación Laboral</a>
			</div>
		</div>
    </div>
</section>

<!-- BANNER AZUL - INFORMATIVO (Index 1) -->
<section class="banner-azul-full">
    <div class="container-bloques">
        <div class="bloque-item">
            <img src="{{ asset('img/info/info1.png') }}" alt="23 años capacitante">
        </div>
        <div class="bloque-item">
            <img src="{{ asset('img/info/info2.png') }}" alt="Patrocinado por Google">
        </div>
        <div class="bloque-item">
            <img src="{{ asset('img/info/info3.png') }}" alt="Plataforma 24/7">
        </div>
        <div class="bloque-item">
            <img src="{{ asset('img/info/info4.png') }}" alt="+1000 instituciones">
        </div>
    </div>
</section>

<!-- SECCION DE APRENDE HOY (Index 1) -->
<section class="aprende-hoy py-5" style="background-color: #eaeaea;">
    <div class="container">
        <h2 class="titulo-aprende text-center">Capacitación virtual en Gestión Pública</h2>
        <div class="row align-items-center mt-5">
            <div class="col-md-5 pe-md-5">
                <p class="desc-aprende">Conéctate, aprende y certifícate en cursos SIAF, SIGA, SEACE:</p>
				<p class="desc-aprende">desde cualquier lugar y a tu ritmo.</p>
                <div class="lista-checks">
                    <div class="check-item animar-bloque">
                        <img src="{{ asset('img/icons/senial.svg') }}" alt="Clases en vivo" class="img-check">
                        <span>Clases en vivo + grabadas</span></div>
                    <div class="check-item animar-bloque">
                        <img src="{{ asset('img/icons/laptop.svg') }}" alt="Plataforma" class="img-check">
                        <span>Plataforma fácil y rápida.</span>
                    </div>
                    <div class="check-item animar-bloque">
                        <img src="{{ asset('img/icons/cuadrado.svg') }}" alt="Certificado" class="img-check">
                        <span>Certificado digital + físico</span>
                    </div>
                    <div class="check-item animar-bloque">
                        <img src="{{ asset('img/icons/check.svg') }}" alt="Calidad" class="img-check">
                        <span>Calidad respaldada (R&C)</span>
                    </div>
                </div>
            </div>
            <div class="col-md-7 ps-md-5 text-center">
                <img src="{{ asset('img/laptoprc.png') }}" alt="Mockup Campus Virtual" class="img-fluid laptop-mockup">
            </div>
        </div>
    </div>
</section>

<!-- SECCION ENTIDADES (Index 1) -->
<section class="seccion-entidades-carrusel">
    <div class="contenedor-texto-centrado">
        <h2 class="titulo-carrusel">Entidades que ya nos eligieron</h2>
        <p class="subtitulo-carrusel">Instituciones del Estado con las que R&C CONSULTING ha trabajado y más de <strong>1000 instituciones públicas y privadas.</strong></p>
    </div>

    <div class="carousel-outer-pdp">
        <div class="carousel-track-pdp" id="carouselTrackPdp">
            <div class="carousel-card-pdp"><img src="{{ asset('img/entidades/1.webp') }}" alt="Entidad"></div>
            <div class="carousel-card-pdp"><img src="{{ asset('img/entidades/2.webp') }}" alt="Entidad"></div>
            <div class="carousel-card-pdp"><img src="{{ asset('img/entidades/3.webp') }}" alt="Entidad"></div>
            <div class="carousel-card-pdp"><img src="{{ asset('img/entidades/4.webp') }}" alt="Entidad"></div>
            <div class="carousel-card-pdp"><img src="{{ asset('img/entidades/5.webp') }}" alt="Entidad"></div>
            <div class="carousel-card-pdp"><img src="{{ asset('img/entidades/6.webp') }}" alt="Entidad"></div>
            <div class="carousel-card-pdp"><img src="{{ asset('img/entidades/7.webp') }}" alt="Entidad"></div>
            <div class="carousel-card-pdp"><img src="{{ asset('img/entidades/8.webp') }}" alt="Entidad"></div>
            <div class="carousel-card-pdp"><img src="{{ asset('img/entidades/9.webp') }}" alt="Entidad"></div>
            <div class="carousel-card-pdp"><img src="{{ asset('img/entidades/10.webp') }}" alt="Entidad"></div>
            <div class="carousel-card-pdp"><img src="{{ asset('img/entidades/11.webp') }}" alt="Entidad"></div>
            <div class="carousel-card-pdp"><img src="{{ asset('img/entidades/12.png') }}" alt="Entidad"></div>
            <!-- Duplicados para loop infinito -->
            <div class="carousel-card-pdp"><img src="{{ asset('img/entidades/1.webp') }}" alt="Entidad"></div>
            <div class="carousel-card-pdp"><img src="{{ asset('img/entidades/2.webp') }}" alt="Entidad"></div>
            <div class="carousel-card-pdp"><img src="{{ asset('img/entidades/3.webp') }}" alt="Entidad"></div>
            <div class="carousel-card-pdp"><img src="{{ asset('img/entidades/4.webp') }}" alt="Entidad"></div>
            <div class="carousel-card-pdp"><img src="{{ asset('img/entidades/5.webp') }}" alt="Entidad"></div>
            <div class="carousel-card-pdp"><img src="{{ asset('img/entidades/6.webp') }}" alt="Entidad"></div>
            <div class="carousel-card-pdp"><img src="{{ asset('img/entidades/7.webp') }}" alt="Entidad"></div>
            <div class="carousel-card-pdp"><img src="{{ asset('img/entidades/8.webp') }}" alt="Entidad"></div>
            <div class="carousel-card-pdp"><img src="{{ asset('img/entidades/9.webp') }}" alt="Entidad"></div>
            <div class="carousel-card-pdp"><img src="{{ asset('img/entidades/10.webp') }}" alt="Entidad"></div>
            <div class="carousel-card-pdp"><img src="{{ asset('img/entidades/11.webp') }}" alt="Entidad"></div>
            <div class="carousel-card-pdp"><img src="{{ asset('img/entidades/12.png') }}" alt="Entidad"></div>
        </div>
    </div>
</section>

<!-- SECCION AYUDA (Index 1) -->
<section class="ayuda-section py-5">
    <div class="container text-center">
        <h2 class="titulo-ayuda">¿Necesitas información sobre nuestros cursos?</h2>
        
        <div class="row justify-content-center mt-5 gap-4">
            <div class="col-lg-3 col-md-5 help-card">
                <img src="{{ asset('img/icons/help1.svg') }}" alt="Soporte" class="help-icon">
                <h3>Consultas y certificados</h3>
                <p>Revisa tus certificaciones y tu progreso en un solo mensaje.</p>
                <a href="https://wa.me/51950883155?text=Buen%20día,%20tengo%20una%20consulta%20sobre%20mis%20certificados,%20deseo%20que%20me%20ayuden%20por%20favor." target="_blank" class="btn-whatsapp-custom">
					<img src="{{ asset('img/icons/wspBoton.svg') }}" alt="icon" class="btn-icon"> 950 883 155
				</a>
            </div>

            <div class="col-lg-3 col-md-5 help-card">
                <img src="{{ asset('img/icons/help2.svg') }}" alt="Información" class="help-icon">
                <h3>Información de cursos y diplomados</h3>
                <p>Te orientamos para elegir el programa ideal y separas tu vacante.</p>
                <a href="https://wa.me/51950883155?text=Buen%20día,%20solicito%20información%20sobre%20los%20cursos%20y%20diplomados,%20por%20favor." target="_blank" class="btn-whatsapp-custom">
					<img src="{{ asset('img/icons/wspBoton.svg') }}" alt="icon" class="btn-icon"> 950 883 155
				</a>
            </div>

            <div class="col-lg-3 col-md-5 help-card inhouse-gradient">
                <img src="{{ asset('img/icons/help3.svg') }}" alt="In House" class="help-icon white-icon">
                <h3 class="text-white">Capacitación In House para tu entidad</h3>
                <p class="text-white">Diseñamos el programa a medida para tu entidad: fechas, temario y modalidad.</p>
                <a href="https://rc-consulting.org/cursos-inhouse/" class="btn-inhouse-custom" target="_blank" rel="noopener">
					Cotizar In House
				</a>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<!-- Scripts específicos de home.blade.php -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Filtro de tabs (Index 2) -->
<script>
document.addEventListener('DOMContentLoaded',function(){
	/* Ordenar y bloquear cursos por fecha (hora Perú) */
	const DIAS_PARA_BLOQUEAR = 3;
	const DIAS_PARA_BYN = 0;
	
	function getDiasTranscurridos(fechaInicio) {
		const meses = {
		'ENE':0,'ENERO':0,'FEB':1,'FEBRERO':1,'MAR':2,'MARZO':2,'ABR':3,'ABRIL':3,'ABRI':3,
		'MAY':4,'MAYO':4,'JUN':5,'JUNIO':5,'JUL':6,'JULIO':6,'AGO':7,'AGOSTO':7,
		'SET':8,'SEP':8,'SEPTIEMBRE':8,'OCT':9,'OCTUBRE':9,'NOV':10,'NOVIEMBRE':10,'DIC':11,'DICIEMBRE':11
	};
		const match = fechaInicio.match(/(\d+)\s*([A-Z]+)/i);
		if (!match) return -1;
		const fecha = new Date(2026, meses[match[2].toUpperCase()], parseInt(match[1]));
		const ahora = new Date();
		return Math.floor((ahora - fecha) / (1000 * 60 * 60 * 24));
	}
	
	var cards = document.querySelectorAll('.curso-card');
	cards.forEach(function(card) {
		var fecha = card.getAttribute('data-fecha');
		if (!fecha) return;
		var dias = getDiasTranscurridos(fecha);
		if (dias > DIAS_PARA_BLOQUEAR) {
			card.classList.add('oculto-total');
		} else if (dias >= DIAS_PARA_BYN) {
			card.classList.add('ya-iniciado');
		}
	});
	
	var tabs=document.querySelectorAll('.filtro-tab');
	var cards=document.querySelectorAll('.curso-card');
	
	function applyFilter(filter){
		cards.forEach(function(card){
			var cat=card.getAttribute('data-category');
			var yaIniciado=card.classList.contains('ya-iniciado');
			var ocultoTotal=card.classList.contains('oculto-total');
			
			if(ocultoTotal){
				card.style.display='none';
			}
			else if(filter==='todo'){
				card.style.display='';
			}
			else if(cat&&cat.indexOf(filter)!==-1){
				if(yaIniciado){
					card.style.display='';
					card.style.opacity='0.6';
				}else{
					card.style.display='';
					card.style.opacity='1';
				}
			}else{
				card.style.display='none';
			}
		});
	}
	
	tabs.forEach(function(tab){
		tab.addEventListener('click',function(){
			tabs.forEach(function(t){t.classList.remove('active');});
			tab.classList.add('active');
			applyFilter(tab.getAttribute('data-filter'));
		});
	});
	
	applyFilter('proximos-inicios');
	
	/* ========== Chatbot ========== */
	const CONFIG_CHATBOT = {
		wsp: '51950883155',
		posicion: 'derecha',
		mensajeInicial: 'Hola, soy tu asistente de R&C Consulting.',
		titulo: 'Chat R&C Consulting',
		color: '#0A1F5C',
		fontColor: '#fff',
		icon: 'fas fa-comments',
		tooltip: '¿Necesitas ayuda?',
		soloMovil: false,
	};
	
	// ... (resto del script del chatbot)
});
</script>
@endsection