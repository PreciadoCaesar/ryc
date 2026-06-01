<?php
/**
 * Diplomas Virtuales - Carga desde base de datos Laravel
 */
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Course;

// Cargar diplomados online (grabados) desde la base de datos
$cursosDB = Course::where('type', 'diplomado')
    ->where('mode', 'grabado')
    ->where(function ($q) {
        $q->where('status', 'activo')->orWhereNull('status');
    })
    ->orderBy('title')
    ->get();

// Construir array con la misma estructura que espera el template
$diplomadosOnline = [];
foreach ($cursosDB as $c) {
    $imgSrc = $c->image_promotion;
    if ($imgSrc && !filter_var($imgSrc, FILTER_VALIDATE_URL)) {
        $imgSrc = '../' . ltrim($imgSrc, '/');
    } elseif (!$imgSrc) {
        $imgSrc = '../img/curso/default.svg';
    }

    $diplomadosOnline[] = [
        'title'        => $c->title,
        'image'        => $imgSrc,
        'hours'        => $c->hours ?? 90,
        'link'         => 'https://rc-consulting.org/curso/' . $c->slug,
        'area'         => $c->specialization_name ?? 'Gestion',
        'sesiones'     => $c->sessions ?? 12,
        'keywords'     => $c->seo_keywords ?? '',
        'muestratitulo'=> false,
    ];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cursos SIAF SIGA SEACE Perú 2026 | Diplomados Gestión Pública | R&C Consulting</title>
    <meta name="description" content="Cursos y diplomados SIAF, SIGA, SEACE, Presupuesto Público y Contrataciones del Estado en Perú. Capacitación virtual con certificación oficial SERVIR. ¡Inscríbete ahora!">
    
    <!-- CSS externo -->
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/rc-main.css?v=14">
    <link rel="stylesheet" href="./css/responsive.css?v=1">

    <style>
    /* ══ RESET & BASE ══ */
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: 'Poppins', sans-serif; color: #1A1A2E; background: #fff; overflow-x: hidden; }

    /* ══ BANNER PÚRPURA ══ */
    .banner-purpura { 
        background: #5044c2; 
        color: #fff; 
        padding: 12px 0; 
        font-family: 'Poppins', sans-serif; 
        position: relative; 
        z-index: 1100; 
    }
    .contenido-banner-purpura { 
        display: flex; 
        justify-content: space-evenly; 
        align-items: center; 
        gap: 20px; 
        max-width: 1200px; 
        margin: 0 auto; 
        padding: 0 20px; 
    }
    .banner-item { display: flex; align-items: center; gap: 12px; }
    .banner-icon img { width: 32px; height: auto; filter: brightness(0) invert(1); }
    .banner-text b { display: block; font-size: 13px; line-height: 1.2; }
    .banner-text span { font-size: 11px; opacity: .9; }
    .highlight-yellow { color: #FFD700; }
    .btn-cotizar { 
        background: #FFD700; 
        color: #5044c2 !important; 
        padding: 8px 20px; 
        border-radius: 6px; 
        font-weight: 800; 
        text-decoration: none; 
        font-size: 13px; 
        display: flex; 
        align-items: center; 
        gap: 8px; 
        box-shadow: 0 3px 0 #ccac00; 
        transition: transform .2s; 
    }
    .btn-cotizar:hover { transform: translateY(-2px); }

    /* ══ NAVBAR ══ */
    .rc-navbar { 
        background: #fff !important; 
        box-shadow: 0 2px 12px rgba(0,0,0,.08); 
        position: sticky; 
        top: 0; 
        z-index: 1050; 
        padding: 10px 0; 
    }
    .rc-logo { height: 50px; width: auto; }
    .rc-navbar .nav-link { 
        font-family: 'Poppins', sans-serif; 
        font-size: 14px; 
        font-weight: 700; 
        color: #0A1F5C !important; 
        padding: 8px 15px !important; 
    }
    .rc-buttons { display: flex; gap: 10px; align-items: center; }
    .rc-buttons a { 
        border-radius: 50px; 
        padding: 10px 20px; 
        font-size: 13px; 
        font-weight: 700; 
        font-family: 'Poppins', sans-serif; 
        display: flex; 
        align-items: center; 
        gap: 8px; 
        text-decoration: none; 
        color: #fff; 
        transition: transform .2s; 
    }
    .btn-wsp { background: #25D366; }
    .btn-aula { background: #136EF0; }
    .btn-tienda { background: #FF044D; }

    /* ══ SECCIÓN TÍTULO Y BUSCADOR ══ */
    .seccion-titulo { padding: 60px 20px 0; text-align: center; background-color: #fff; }
    .seccion-titulo h2 { font-family: 'Poppins', sans-serif; font-weight: 700; color: #0A1F5C; font-size: 38px; margin-bottom: 10px; text-transform: uppercase; }
    .seccion-titulo p { font-family: 'Poppins', sans-serif; color: #0A1F5C; font-size: 16px; white-space: nowrap; margin: 0 auto 35px; }

    .buscador-container-custom { max-width: 950px; margin: 0 auto; padding: 0 15px; }
    .buscador-wrapper { position: relative; width: 100%; display: flex; align-items: center; }
    .buscador-wrapper i { position: absolute; left: 22px; color: #0A1F5C !important; font-size: 22px; z-index: 10; pointer-events: none; }
    #inputBuscadorCursos { width: 100%; padding: 16px 25px 16px 65px; border: 1px solid #0A1F5C !important; border-radius: 8px; font-weight: 300; font-size: 18px; color: #0A1F5C !important; outline: none; }
	/* Para navegadores modernos (Chrome, Firefox, Edge, Safari) */
	#inputBuscadorCursos::placeholder {
		color: #0A1F5C; /* El color que desees */
		opacity: 1;    /* Aquí controlas la transparencia (1 es sólido, 0 es invisible) */
	}

	/* Específico para Internet Explorer/Edge antiguo (opcional) */
	#inputBuscadorCursos:-ms-input-placeholder {
		color: #0A1F5C;
		opacity: 1;
	}
    /* ══ FILTROS CORREGIDOS (Sin barra azul de fondo) ══ */
    .filtro-tabs { 
        display: flex; 
        justify-content: center; 
        flex-wrap: wrap; 
        gap: 12px; 
        margin: 30px auto 40px; 
        max-width: 1200px; 
        background: transparent !important; /* Eliminamos cualquier color de fondo */
        border: none !important; /* Eliminamos cualquier borde azul */
        box-shadow: none !important; /* Eliminamos sombras raras */
        padding: 0;
    }
    .filtro-tab { 
        padding: 4px 22px; 
        min-width: 130px; 
        text-align: center; 
        font-family: 'Poppins', sans-serif; 
        font-size: 13px; 
        font-weight: 700; 
        color: #0A1F5C; 
        background: #EAEAEA; 
        cursor: pointer; 
        border: none; 
        border-radius: 8px; 
        transition: all 0.3s ease; 
    }
    .filtro-tab.active { 
        background: #FF044D; 
        color: #fff; 
        box-shadow: 0 2px 6px rgba(255, 4, 77, 0.2); 
    }

    /* ══ GRID Y CARDS ══ */
    .cursos-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 28px; max-width: 1200px; margin: 0 auto; padding: 0 20px 50px; }
    .curso-card { background: #E9E9E9; border-radius: 14px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,.08); display: flex; flex-direction: column; }
    .curso-card__img { position: relative; width: 100%; padding: 15px 15px 5px; background: #E9E9E9; }
    .curso-card__img img { width: 100%; height: auto; object-fit: contain; border-radius: 10px; display: block; }
    .curso-card__body { padding: 10px 18px 20px; display: flex; flex-direction: column; flex: 1; }

    .info-asinc-grid { 
        display: grid; 
        grid-template-columns: 1fr 1fr; 
        gap: 15px 75px; 
        margin-bottom: 20px; 
        /* Añadimos padding a los lados para que no toque los bordes de la card */
        padding: 0 20px; 
    }

    .info-asinc-item { display: flex; align-items: center; gap: 10px; }
    .info-asinc-item i { font-size: 22px !important; color: #0A1F5C; width: 25px; text-align: center; }
    .info-asinc-item .icon-red { color: #FF044D; }
    .info-asinc-text { font-family: 'Poppins', sans-serif; font-size: 12px; line-height: 1.2; color: #1a1a1a; font-weight: 500; }
    
.icon-asinc-custom {
    width: 22px; /* Ajusta según el diseño */
    height: auto;
    object-fit: contain;
    flex-shrink: 0;
}

/* Asegura que el contenedor de los items mantenga la alineación */
    .info-asinc-item { 
        display: flex; 
        align-items: center; 
        gap: 10px; 
        /* Esto asegura que si el texto es muy largo, el icono no se mueva */
        justify-content: flex-start; 
    }
    .badge-tipo-asinc { background: #0A1F5C; color: #fff; padding: 4px 10px; border-radius: 2px; font-size: 12.5px; font-weight: 500; }
    .badge-disp-red { background: #FF044D; color: #fff; padding: 4px 10px; border-radius: 2px; font-size: 12.5px; font-weight: 500; }

    .btn-mas-info-asinc { display: block; width: 100%; padding: 10px; text-align: center; border: 2px solid #0A1F5C; color: #0A1F5C; border-radius: 4px; font-weight: 700; text-decoration: none; margin-top: auto; }
    /* Efecto al pasar el mouse */
    .btn-mas-info-asinc:hover {
        background-color: #0A1F5C; /* Invertimos: el fondo se vuelve azul */
        color: #ffffff;            /* Invertimos: el texto se vuelve blanco */
        transform: scale(1.05);    /* Se agranda un 5% */
        box-shadow: 0 4px 8px rgba(0,0,0,0.2); /* Opcional: sombra para dar profundidad */
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
	/* Contenedor relativo para poder posicionar el título */
/* --- Ajuste del Título sobre la Imagen --- */
.curso-card__img {
    position: relative;
    display: flex;
    justify-content: center;
    align-items: center; /* Centra el contenido verticalmente */
}

.curso-card__overlay-title {
    position: absolute;
    /* Posicionamiento: un poco más arriba de la mitad */
    top: 45%; 
    left: 50%;
    transform: translate(-50%, -50%);
    
    width: 90%;
    color: #ffffff;
    
    /* Tipografía más grande y fuerte */
    font-family: 'Poppins', sans-serif;
    font-size: 20px; /* Tamaño aumentado */
    font-weight: 800;
    text-transform: uppercase;
    line-height: 1.1;
    text-align: center;
    
    /* Fondo casi transparente */
    background: rgba(10, 31, 92, 0.2); 
    padding: 10px;
    border-radius: 4px;
    
    /* Truco para que la letra se note mucho sobre cualquier fondo */
    text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.8), 0px 0px 15px rgba(10, 31, 92, 0.6);
    
    z-index: 10;
    pointer-events: none; /* No estorba al hacer click en la card */
    transition: all 0.3s ease;
}

/* Efecto opcional al pasar el mouse */
.curso-card:hover .curso-card__overlay-title {
    transform: translate(-50%, -60%) scale(1.05); /* Sube un poquito más y se agranda */
    text-shadow: 2px 2px 12px rgba(255, 4, 77, 0.8); /* Brillo fucsia al pasar el mouse */
}
    </style>
</head>
<body>

 
<!-- TÍTULO + BUSCADOR -->
<div class="seccion-titulo">
    <h2>DIPLOMADOS DE ESPECIALIZACIÓN ONLINE</h2>
    <p>Programas avanzados diseñados para fortalecer tu perfil profesional en la gestión pública.</p>
    <div class="buscador-container-custom">
        <div class="buscador-wrapper">
            <i class="fas fa-search"></i>
            <!-- IMPORTANTE: Mantén el placeholder largo para escritorio -->
            <input type="text" id="inputBuscadorCursos" placeholder="Buscar por diplomado, sistema, área o palabra clave" onkeyup="filtrarPorTexto()">
        </div>
    </div>
</div>

<!-- FILTROS -->
<span class="titulo-filtro-mobile">Filtrar diplomados:</span>
<div class="filtro-tabs" id="filtroTabs">
    <button class="filtro-tab active" data-filter="todo">Todos</button>
    <button class="filtro-tab" data-filter="SiafSiga">SIGA/SIAF</button>
    <button class="filtro-tab" data-filter="Contrataciones">Contrataciones</button>
    <button class="filtro-tab" data-filter="Presupuesto">Presupuesto</button>
    <button class="filtro-tab" data-filter="Gestion">Gestión Pública</button>
    <button class="filtro-tab" data-filter="Planeamiento">Planeamiento</button>
    <button class="filtro-tab" data-filter="Rrhh">R.R.H.H./Control</button>
</div>

<!-- GRID DE DIPLOMADOS -->
<div class="cursos-grid" id="cursosGrid">
    <?php foreach ($diplomadosOnline as $curso) { ?>
    <div class="curso-card" data-category="todo <?php echo $curso['area'] ?? 'Gestion'; ?>">
        
        <div class="curso-card__img">
            <img src="<?php echo $curso['image']; ?>" alt="<?php echo $curso['title']; ?>" loading="lazy">
            
            <?php if (isset($curso['muestratitulo']) && $curso['muestratitulo'] === true): ?>
                <div class="curso-card__overlay-title">
                    <?php echo $curso['title']; ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="curso-card__body">
            <span class="visually-hidden">
                <?php echo ($curso['title'] ?? '') . ' ' . ($curso['keywords'] ?? ''); ?>
            </span>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="badge-tipo-asinc">Curso asincrónico</span>
                <span class="badge-disp-red">Disp. 24/7</span>
            </div>

            <div class="info-asinc-grid">
                <!-- Calendario -->
                <div class="info-asinc-item">
                    <img src="./img/iconos/calendario.webp" alt="Calendario" class="icon-asinc-custom">
                    <div class="info-asinc-text">¡Inicia<br>ahora!</div>
                </div>
                <!-- Tiempo / Horas -->
                <div class="info-asinc-item">
                    <img src="./img/iconos/tiempo.webp" alt="Tiempo" class="icon-asinc-custom">
                    <div class="info-asinc-text">Duración:<br><span><?php echo $curso['sesiones'] ?? '12'; ?> sesiones</span></div>
                </div>
                <!-- Modalidad Online -->
                <div class="info-asinc-item">
                    <img src="./img/iconos/online.webp" alt="Online" class="icon-asinc-custom">
                    <div class="info-asinc-text"><span class="color-red">Modalidad<br>online</span></div>
                </div>
                <!-- Certificado -->
                <div class="info-asinc-item">
                    <img src="./img/iconos/certificado.webp" alt="Certificado" class="icon-asinc-custom">
                    <div class="info-asinc-text"><?php echo $curso['hours']; ?> Horas<br><span>Certificadas</span></div>
                </div>
            </div>
            <a href="<?php echo $curso['link']; ?>" target="_blank" class="btn-mas-info-asinc">Más información</a>
        </div>
    </div>
    <?php } ?>
</div>


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
        
        // Verifica si coincide con el texto Y con el filtro de categoría activo
        const coincideTexto = textoCard.includes(busqueda);
        const coincideFiltro = (filtroActivo === 'todo' || categoriaCard.includes(filtroActivo));

        if (coincideTexto && coincideFiltro) {
            card.style.display = '';
        } else {
            card.style.display = 'none';
        }
    });
}
document.addEventListener('click', function(e) {
    const container = document.querySelector('.filtro-tabs');
    if (!container) return;

    const isTabActive = e.target.classList.contains('active');
    const isTabOption = e.target.classList.contains('filtro-tab');

    // 1. Si toca el botón activo (el que se ve cuando está cerrado), abrimos/cerramos
    if (isTabActive) {
        container.classList.toggle('abierto');
    } 
    // 2. Si toca una opción que NO es la activa, dejamos que el filtro actúe y cerramos
    else if (isTabOption) {
        container.classList.remove('abierto');
    } 
    // 3. Si toca en cualquier otro lado de la pantalla, cerramos
    else {
        container.classList.remove('abierto');
    }
});
</script>

<script defer src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>