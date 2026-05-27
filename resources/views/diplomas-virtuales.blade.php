@extends('layouts.app-main')

@section('title', 'Diplomados Online SIAF SIGA SEACE Perú 2026 | R&C Consulting')

@section('meta_description', 'Diplomados online SIAF, SIGA, SEACE, Presupuesto Público y Contrataciones del Estado en Perú. Capacitación virtual con certificación oficial. ¡Inscríbete ahora!')

@section('styles')
<style>
.seccion-titulo { padding: 60px 20px 0; text-align: center; background-color: #fff; }
.seccion-titulo h2 { font-family: 'Poppins', sans-serif; font-weight: 700; color: #0A1F5C; font-size: 38px; margin-bottom: 10px; text-transform: uppercase; }
.seccion-titulo p { font-family: 'Poppins', sans-serif; color: #0A1F5C; font-size: 16px; white-space: nowrap; margin: 0 auto 35px; }

.buscador-container-custom { max-width: 950px; margin: 0 auto; padding: 0 15px; }
.buscador-wrapper { position: relative; width: 100%; display: flex; align-items: center; }
.buscador-wrapper i { position: absolute; left: 22px; color: #0A1F5C !important; font-size: 22px; z-index: 10; pointer-events: none; }
#inputBuscadorCursos { width: 100%; padding: 16px 25px 16px 65px; border: 1px solid #0A1F5C !important; border-radius: 8px; font-weight: 300; font-size: 18px; color: #0A1F5C !important; outline: none; }
#inputBuscadorCursos::placeholder { color: #0A1F5C; opacity: 1; }

.filtro-tabs {
    display: flex; justify-content: center; flex-wrap: wrap; gap: 12px;
    margin: 30px auto 40px; max-width: 1200px;
    background: transparent !important; border: none !important; box-shadow: none !important; padding: 0;
}
.filtro-tab {
    padding: 4px 22px; min-width: 130px; text-align: center;
    font-family: 'Poppins', sans-serif; font-size: 13px; font-weight: 700;
    color: #0A1F5C; background: #EAEAEA; cursor: pointer; border: none; border-radius: 8px; transition: all 0.3s ease;
}
.filtro-tab.active { background: #FF044D; color: #fff; box-shadow: 0 2px 6px rgba(255, 4, 77, 0.2); }

.cursos-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 28px; max-width: 1200px; margin: 0 auto; padding: 0 20px 50px; }
.curso-card { background: #E9E9E9; border-radius: 14px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,.08); display: flex; flex-direction: column; }
.curso-card__img { position: relative; width: 100%; padding: 15px 15px 5px; background: #E9E9E9; display: flex; justify-content: center; align-items: center; }
.curso-card__img img { width: 100%; height: auto; object-fit: contain; border-radius: 10px; display: block; }
.curso-card__body { padding: 10px 18px 20px; display: flex; flex-direction: column; flex: 1; }

.info-asinc-grid {
    display: grid; grid-template-columns: 1fr 1fr; gap: 15px 75px; margin-bottom: 20px; padding: 0 20px;
}
.info-asinc-item { display: flex; align-items: center; gap: 10px; justify-content: flex-start; }
.info-asinc-text { font-family: 'Poppins', sans-serif; font-size: 12px; line-height: 1.2; color: #1a1a1a; font-weight: 500; }
.icon-asinc-custom { width: 22px; height: auto; object-fit: contain; flex-shrink: 0; }
.badge-tipo-asinc { background: #0A1F5C; color: #fff; padding: 4px 10px; border-radius: 2px; font-size: 12.5px; font-weight: 500; }
.badge-disp-red { background: #FF044D; color: #fff; padding: 4px 10px; border-radius: 2px; font-size: 12.5px; font-weight: 500; }

.btn-mas-info-asinc { display: block; width: 100%; padding: 10px; text-align: center; border: 2px solid #0A1F5C; color: #0A1F5C; border-radius: 4px; font-weight: 700; text-decoration: none; margin-top: auto; transition: all 0.3s ease; }
.btn-mas-info-asinc:hover { background-color: #0A1F5C; color: #ffffff; transform: scale(1.05); box-shadow: 0 4px 8px rgba(0,0,0,0.2); }

.curso-card__overlay-title {
    position: absolute; top: 45%; left: 50%; transform: translate(-50%, -50%);
    width: 90%; color: #ffffff; font-family: 'Poppins', sans-serif;
    font-size: 20px; font-weight: 800; text-transform: uppercase; line-height: 1.1; text-align: center;
    background: rgba(10, 31, 92, 0.2); padding: 10px; border-radius: 4px;
    text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.8), 0px 0px 15px rgba(10, 31, 92, 0.6);
    z-index: 10; pointer-events: none; transition: all 0.3s ease;
}
.curso-card:hover .curso-card__overlay-title {
    transform: translate(-50%, -60%) scale(1.05);
    text-shadow: 2px 2px 12px rgba(255, 4, 77, 0.8);
}

@media(max-width:991px){
    .cursos-grid { grid-template-columns: repeat(2, 1fr); }
    .seccion-titulo p { white-space: normal; }
}
@media(max-width:576px){
    .cursos-grid { grid-template-columns: 1fr; }
    .filtro-tabs { justify-content: flex-start; flex-wrap: nowrap; overflow-x: auto; padding: 10px 5px; }
    .filtro-tab { min-width: auto; white-space: nowrap; }
}
</style>
@endsection

@section('content')
<div class="seccion-titulo">
    <h2>DIPLOMADOS DE ESPECIALIZACIÓN ONLINE</h2>
    <p>Programas avanzados diseñados para fortalecer tu perfil profesional en la gestión pública.</p>
    <div class="buscador-container-custom">
        <div class="buscador-wrapper">
            <i class="fas fa-search"></i>
            <input type="text" id="inputBuscadorCursos" placeholder="Buscar por diplomado, sistema, área o palabra clave" onkeyup="filtrarPorTexto()">
        </div>
    </div>
</div>

<span class="titulo-filtro-mobile">Filtrar diplomados:</span>
<div class="filtro-tabs" id="filtroTabs">
    <button class="filtro-tab active" data-filter="todo">Todos</button>
    <button class="filtro-tab" data-filter="SistemasMEF">Sistemas MEF</button>
    <button class="filtro-tab" data-filter="Contrataciones">Contrataciones</button>
    <button class="filtro-tab" data-filter="Presupuesto">Presupuesto</button>
    <button class="filtro-tab" data-filter="Gestion">Gestión pública</button>
    <button class="filtro-tab" data-filter="Ofimatica">Ofimática</button>
    <button class="filtro-tab" data-filter="SeguridadSST">Seguridad y SST</button>
</div>

<div class="cursos-grid" id="cursosGrid">
    @foreach($cursos as $curso)
    <div class="curso-card" data-category="todo {{ $curso->specialization_name ?? 'Gestion' }}">
        <div class="curso-card__img">
            <img src="{{ asset($curso->image_promotion ?? 'img/curso/default.svg') }}" alt="{{ $curso->title }}" loading="lazy">
            <div class="curso-card__overlay-title">{{ $curso->title }}</div>
        </div>
        <div class="curso-card__body">
            <span class="visually-hidden">{{ $curso->title }} {{ $curso->seo_keywords ?? '' }}</span>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="badge-tipo-asinc">Curso asincrónico</span>
                <span class="badge-disp-red">Disp. 24/7</span>
            </div>
            <div class="info-asinc-grid">
                <div class="info-asinc-item">
                    <img src="{{ asset('img/diplomas-virtuales/iconos/calendario.webp') }}" alt="Calendario" class="icon-asinc-custom">
                    <div class="info-asinc-text">¡Inicia<br>ahora!</div>
                </div>
                <div class="info-asinc-item">
                    <img src="{{ asset('img/diplomas-virtuales/iconos/tiempo.webp') }}" alt="Tiempo" class="icon-asinc-custom">
                    <div class="info-asinc-text">Duración:<br><span>{{ $curso->sessions ?? 12 }} sesiones</span></div>
                </div>
                <div class="info-asinc-item">
                    <img src="{{ asset('img/diplomas-virtuales/iconos/online.webp') }}" alt="Online" class="icon-asinc-custom">
                    <div class="info-asinc-text"><span class="color-red">Modalidad<br>online</span></div>
                </div>
                <div class="info-asinc-item">
                    <img src="{{ asset('img/diplomas-virtuales/iconos/certificado.webp') }}" alt="Certificado" class="icon-asinc-custom">
                    <div class="info-asinc-text">{{ $curso->hours }} Horas<br><span>Certificadas</span></div>
                </div>
            </div>
            <a href="{{ route('curso.mostrar', $curso->slug) }}" class="btn-mas-info-asinc">Más información</a>
        </div>
    </div>
    @endforeach
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const tabs = document.querySelectorAll('.filtro-tab');
    const cards = document.querySelectorAll('.curso-card');

    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            tabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            const filter = this.getAttribute('data-filter');
            cards.forEach(card => {
                const categories = card.getAttribute('data-category');
                card.style.display = (filter === 'todo' || categories.includes(filter)) ? '' : 'none';
            });
        });
    });
});

function filtrarPorTexto() {
    const busqueda = document.getElementById('inputBuscadorCursos').value.toLowerCase();
    const cards = document.querySelectorAll('.curso-card');
    const filtroActivo = document.querySelector('.filtro-tab.active').getAttribute('data-filter');

    cards.forEach(card => {
        const textoCard = card.innerText.toLowerCase();
        const categoriaCard = card.getAttribute('data-category');
        const coincideTexto = textoCard.includes(busqueda);
        const coincideFiltro = (filtroActivo === 'todo' || categoriaCard.includes(filtroActivo));
        card.style.display = (coincideTexto && coincideFiltro) ? '' : 'none';
    });
}

document.addEventListener('click', function(e) {
    const container = document.querySelector('.filtro-tabs');
    if (!container) return;
    const isTabActive = e.target.classList.contains('active');
    const isTabOption = e.target.classList.contains('filtro-tab');
    if (isTabActive) {
        container.classList.toggle('abierto');
    } else if (isTabOption) {
        container.classList.remove('abierto');
    } else {
        container.classList.remove('abierto');
    }
});
</script>
@endsection