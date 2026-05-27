<?php
include '../cursos.php';
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

<!-- BANNER PÚRPURA -->
<div class="banner-purpura">
    <div class="contenido-banner-purpura">
        <div class="banner-item">
            <div class="banner-icon"><img src="Recurso 85@4x.webp" alt="PDP"></div>
            <div class="banner-text"><b>Cumple con el PDP 2026</b><span>Alinea tu capacitación In-House</span></div>
        </div>
        <div class="banner-item">
            <div class="banner-icon"><img src="Recurso 86@4x.webp" alt="Directiva"></div>
            <div class="banner-text"><b class="highlight-yellow">CURSOS IN HOUSE</b><span>Nueva Directiva 00214-2025-SERVIR-PE</span></div>
        </div>
        <div class="banner-action">
            <a href="https://wa.me/51948163352?text=Hola%20Arnaldo,%20vengo%20de%20la%20web.%20Me%20interesa%20solicitar%20una%20Propuesta%20In%20House%20para%20mi%20instituci%C3%B3n%20alineada%20al%20PDP%202026.%20%C2%BFPodr%C3%ADas%20ayudarme?" class="btn-cotizar" target="_blank"><i class="fas fa-handshake"></i> ¡Cotizalo aqui!</a>
        </div>
    </div>
</div>

<!-- NAVBAR COMPLETA -->
<nav class="navbar navbar-expand-lg rc-navbar">
    <div class="container-fluid px-4">
        <a class="navbar-brand" href="https://rc-consulting.org">
            <img src="./img/logo-rc-consulting-sin-fondo.webp" class="rc-logo" alt="R&C Consulting" width="180" height="50" fetchpriority="high">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item"><a class="nav-link" href="https://rc-consulting.org">Inicio</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Nosotros</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="https://rc-consulting.org/nosotros/">Sobre Nosotros</a></li>
                        <li><a class="dropdown-item" href="https://rc-consulting.org/experiencia/">Experiencia y Alianzas</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Programas</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="https://rc-consulting.org/cursos-virtuales/">Cursos</a></li>
                        <li><a class="dropdown-item" href="https://rc-consulting.org/diplomas-virtuales/">Diplomados</a></li>
                        <li><a class="dropdown-item" href="https://www.rc-consulting.edu.pe/">Aula Virtual</a></li>
                        <li><a class="dropdown-item" href="https://rc-consulting.org/suscripciones/">Membresía Premium</a></li>
                        <li><a class="dropdown-item" href="https://rc-consulting.org/preguntas-frecuentes/">Preguntas Frecuentes</a></li>
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link" href="https://rc-consulting.org/cursos-inhouse/" target="_blank">In House</a></li>
            </ul>
            <div class="rc-buttons">
                <!-- WhatsApp con mensaje personalizado e icono SVG -->
                <a href="https://api.whatsapp.com/send?phone=51950883155&text=Buen%20d%C3%ADa,%20he%20visitado%20la%20web%20de%20*R%26C%20Consulting*" target="_blank" class="btn-wsp">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16"><path d="M13.601 2.326A7.85 7.85 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.9 7.9 0 0 0 13.6 2.326zM7.994 14.521a6.6 6.6 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.56 6.56 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592m3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.73.73 0 0 0-.529.247c-.182.198-.691.677-.691 1.654s.71 1.916.81 2.049c.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232"/></svg> 
                    950 883 155
                </a>
                <!-- Aula Virtual con icono SVG -->
                <a href="https://www.rc-consulting.edu.pe/" target="_blank" class="btn-aula">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16"><path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 1 1-1 0v-1h-1a.5.5 0 1 1 0-1h1v-1a.5.5 0 0 1 1 0"/><path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L8 2.207l6.646 6.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293z"/><path d="m8 3.293 4.712 4.712A4.5 4.5 0 0 0 8.758 15H3.5A1.5 1.5 0 0 1 2 13.5V9.293z"/></svg> 
                    Aula Virtual
                </a>
                <!-- Tienda Virtual con icono SVG -->
                <a href="https://escueladegobierno.edu.pe/tienda/" target="_blank" class="btn-tienda">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16"><path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0m7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0M9 5.5V7h1.5a.5.5 0 0 1 0 1H9v1.5a.5.5 0 0 1-1 0V8H6.5a.5.5 0 0 1 0-1H8V5.5a.5.5 0 0 1 1 0"/></svg> 
                    Tienda Virtual
                </a>
            </div>
        </div>
    </div>
</nav>

<!-- TÍTULO + BUSCADOR -->
<div class="seccion-titulo">
    <h2>CURSOS DE ESPECIALIZACIÓN ONLINE</h2>
    <p>Capacítate a tu ritmo con programas online en gestión pública, actualizados y orientados a la práctica.</p>
    <div class="buscador-container-custom">
        <div class="buscador-wrapper">
            <i class="fas fa-search"></i>
            <input type="text" id="inputBuscadorCursos" placeholder="Buscar por curso, sistema, área o palabra clave" onkeyup="filtrarPorTexto()">
        </div>
    </div>
</div>

<!-- FILTROS -->
<span class="titulo-filtro-mobile">Filtrar cursos:</span>
<div class="filtro-tabs" id="filtroTabs">
    <button class="filtro-tab active" data-filter="todo">Todos</button>
    <button class="filtro-tab" data-filter="SiafSiga">SIGA/SIAF</button>
    <button class="filtro-tab" data-filter="Contrataciones">Contrataciones</button>
    <button class="filtro-tab" data-filter="Presupuesto">Presupuesto</button>
    <button class="filtro-tab" data-filter="Gestion">Gestión Pública</button>
    <button class="filtro-tab" data-filter="Planeamiento">Planeamiento</button>
    <button class="filtro-tab" data-filter="Rrhh">R.R.H.H./Control</button>
</div>

<!-- GRID DE CURSOS -->
<div class="cursos-grid" id="cursosGrid">
    <?php foreach ($cursosOnline as $curso) { ?>
    <div class="curso-card" data-category="todo <?php echo $curso['area'] ?? 'Gestion'; ?>">
        
        <div class="curso-card__img">
            <img src="../img/curso/<?php echo $curso['image']; ?>" alt="<?php echo $curso['title']; ?>" loading="lazy">
            
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

<!-- FOOTER (Index 1) -->
<footer class="main-footer">
    <div class="footer-container-full">
        <div class="row g-4">
            <div class="col-md-3">
                <div class="footer-logo-box">
                    <img src="./img/added/logofooter.webp" alt="R&C Consulting" class="footer-logo">
                </div>
                <h3>Contáctanos:</h3>
                <div class="contact-info">
                    <p>Av. Petit Thouars 2166.<br/>Lince, Lima - Perú</p>
                    <p>Lunes a Viernes de 8:30 a 6:00 pm</p>
                    <p><a href="mailto:informes@rc-consulting.org" class="email-link">informes@rc-consulting.org</a></p>
                    <p>012661067 anexo: 100, 101, 104</p>
                </div>
            </div>

            <div class="col-md-3">
                <h3>Enlaces</h3>
                <ul class="footer-links">
                    <li><a href="https://rc-consulting.org/cursos-virtuales/">Cursos</a></li>
                    <li><a href="https://rc-consulting.org/diplomas-virtuales/">Diplomados</a></li>
                    <li><a href="https://rc-consulting.org/cursos-inhouse/">Inhouse</a></li>
                    <li><a href="https://rc-consulting.org/consultoria-asistencia-tecnica/">Consultorías</a></li>
                </ul>
            </div>

            <div class="col-md-3">
                <h3>Información</h3>
                <ul class="footer-links mb-4">
                    <li><a href="https://rc-consulting.org/politicas-de-proteccion-de-datos/">Políticas de privacidad</a></li>
                    <li><a href="https://escueladegobierno.edu.pe/terminos-y-condiciones/">Términos y condiciones</a></li>
                    <li><a href="#">Contáctanos</a></li>
                </ul>
                <h4 class="payment-title">Métodos de pago</h4>
                <img src="./img/added/payment.webp" alt="Métodos de pago" class="payment-img">
            </div>

            <div class="col-md-3">
                <h3>Certificados</h3>
                <a href="https://rc-consulting.org/app-certificados/version1/" class="btn-cert-f" target="_blank">
                    <i class="fas fa-search"></i> Consulta tu certificado
                </a>
                
                <div class="reclamaciones-box">
                    <img src="./img/added/lreclamaciones.svg" alt="Libro de reclamaciones">
                    <a href="https://rc-consulting.org/libro-de-reclamaciones/">Libro de reclamaciones</a>
                </div>

                <div class="social-icons">
                    <a href="https://pe.linkedin.com/company/ryc-consulting" target="_blank" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                    <a href="https://www.instagram.com/rycconsulting_/" target="_blank" title="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="https://www.youtube.com/@CursosGestionPublica" target="_blank" title="YouTube"><i class="fab fa-youtube"></i></a>
                    <a href="https://www.facebook.com/rcconsultingperu/" target="_blank" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://www.tiktok.com/@ryc_consulting" target="_blank" title="TikTok"><i class="fab fa-tiktok"></i></a>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <p>R&C Consulting 2026 — Todos los derechos reservados</p>
        </div>
    </div>
</footer>

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