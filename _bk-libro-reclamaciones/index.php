<?php ob_start(function($h) {
    // Proteger contenido de <script>, <pre>, <textarea> para que el minificador no rompa el JS
    $placeholders = [];
    $h = preg_replace_callback('/<(script|pre|textarea)\b[^>]*>[\s\S]*?<\/\1>/i', function($m) use (&$placeholders) {
        $key = '___PLACEHOLDER_' . count($placeholders) . '___';
        $placeholders[$key] = $m[0];
        return $key;
    }, $h);

    $h = preg_replace(
        ['/\/\*.*?\*\//s', '/\>[^\S ]+/s', '/[^\S ]+\</s', '/(\s)+/s', '/<!--(.|\s)*?-->/'],
        ['', '>', '<', '\\1', ''],
        $h
    );

    // Restaurar scripts/pre/textarea intactos
    return strtr($h, $placeholders);
}); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>Libro de Reclamaciones | R&C Consulting</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    <link href="./css/header.css" rel="stylesheet">
    <link href="./styles.css" rel="stylesheet">

    <!-- Favicon -->
    <link rel="icon" href="./img/logo-rc-consulting-icono.ico" sizes="32x32">

    <!-- CSS Externo -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/responsive.css">
    <link href="header/header.css" rel="stylesheet">

    <!-- Estilo necesario para ocultar campos dinámicos -->
    <style>
        .hidden-field {
            display: none !important;
        }
        .card-title {
            color: #136EF0 !important;
        }
        #btnEnviar {
            background-color: #136EF0 !important;
            border-color: #136EF0 !important;
        }
    </style>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
</head>

<body>

    <!-- NUEVO BANNER MORADO CODE-->
    <div class="banner-purpura">
        <div class="inner-wrap">
            <div class="contenido-banner-purpura">
                <div class="banner-item">
                    <div class="banner-icon">
                        <img src="./img/icons/casa.svg" alt="PDP">
                    </div>
                    <div class="banner-text">
                        <b>Cumple con el PDP 2026</b>
                        <span>Alinea tu capacitación In-House</span>
                    </div>
                </div>

                <div class="banner-item">
                    <div class="banner-icon">
                        <img src="./img/icons/merito.svg" alt="Directiva">
                    </div>
                    <div class="banner-text">
                        <b class="highlight-yellow">CURSOS IN HOUSE</b>
                        <span>Nueva Directiva 00214-2025-SERVIR-PE</span>
                    </div>
                </div>

                <div class="banner-action">
                    <a href="https://wa.me/51948163352?text=Hola%20Arnaldo%2C%20vengo%20de%20la%20web.%20Me%20interesa%20solicitar%20una%20Propuesta%20In%20House%20del%20Curso%20SIAF%20WEB%202026%3A%20Pr%C3%A1ctica%20en%20Administrativo%2C%20Presupuesto%2C%20Contable%20y%20Tesorer%C3%ADa%20para%20mi%20instituci%C3%B3n%20alineada%20al%20PDP%202026.%20%C2%BFPodr%C3%ADas%20ayudarme%3F"
                        class="btn-cotizar" style="color: #5044c2;" target="_blank">
                        <i class="fas fa-handshake"></i> ¡Cotizalo aqui!
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Navegación -->
    <nav class="navbar navbar-expand-lg rc-navbar">
        <div class="container">
            <a class="navbar-brand" href="/">
                <img src="img/logo-rc-consulting-sin-fondo.webp" class="rc-logo" alt="R&C Consulting">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav mx-auto w-100 justify-content-evenly">
                    <li class="nav-item">
                        <a class="nav-link" href="https://rc-consulting.org">Inicio</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Nosotros</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/nosotros">Sobre Nosotros</a></li>
                            <li><a class="dropdown-item" href="/experiencia">Experiencia y Alianzas</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Programas</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="https://rc-consulting.org/cursos-virtuales/">Cursos</a></li>
                            <li><a class="dropdown-item" href="https://rc-consulting.org/diplomas-virtuales/">Diplomas</a></li>
                            <li><a class="dropdown-item" href="https://www.rc-consulting.edu.pe/">Aula Virtual</a></li>
                            <li><a class="dropdown-item" href="https://rc-consulting.org/suscripcion/">Membresía Premium</a></li>
                            <li><a class="dropdown-item" href="https://rc-consulting.org/preguntas-frecuentes/">Preguntas Frecuentes</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://rc-consulting.org/cursos-inhouse/">In House</a>
                    </li>
                </ul>

                <div class="rc-buttons">
                    <a href="https://api.whatsapp.com/send?phone=51950883155" target="_blank" class="btn-wsp">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-whatsapp" viewBox="0 0 16 16">
                            <path d="M13.601 2.326A7.85 7.85 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.9 7.9 0 0 0 13.6 2.326zM7.994 14.521a6.6 6.6 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.56 6.56 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592m3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.73.73 0 0 0-.529.247c-.182.198-.691.677-.691 1.654s.71 1.916.81 2.049c.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232" />
                        </svg>
                        950 883 155
                    </a>
                    <a href="https://rc-consulting.edu.pe/" target="_blank" class="btn-aula">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-house-add-fill" viewBox="0 0 16 16">
                            <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 1 1-1 0v-1h-1a.5.5 0 1 1 0-1h1v-1a.5.5 0 0 1 1 0" />
                            <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L8 2.207l6.646 6.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293z" />
                            <path d="m8 3.293 4.712 4.712A4.5 4.5 0 0 0 8.758 15H3.5A1.5 1.5 0 0 1 2 13.5V9.293z" />
                        </svg>
                        Aula Virtual
                    </a>
                    <a href="https://escueladegobierno.edu.pe/tienda/" target="_blank" class="btn-tienda">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-cart-plus-fill" viewBox="0 0 16 16">
                            <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0m7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0M9 5.5V7h1.5a.5.5 0 0 1 0 1H9v1.5a.5.5 0 0 1-1 0V8H6.5a.5.5 0 0 1 0-1H8V5.5a.5.5 0 0 1 1 0" />
                        </svg>
                        Tienda Virtual
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- ===== LIBRO DE RECLAMACIONES ===== -->
    <div class="upload-form-section">
        <header class="header-logo text-center py-4">
            <h1>LIBRO DE RECLAMACIONES</h1>
            <p>Conforme a lo establecido en el Código de Protección y Defensa del Consumidor</p>
        </header>

        <div class="container text-start mb-3">
            <a href="buscar-reclamo.php" class="btn btn-success btn-lg">
                <i class="bi bi-search"></i> Buscar Reclamo
            </a>
        </div>

        <div class="container mb-5">
            <form id="formReclamo">
                <div class="row g-4">
                    <!-- 1. IDENTIFICACIÓN DEL CONSUMIDOR -->
                    <div class="col-lg-12">
                        <div class="card p-4">
                            <h4 class="card-title mb-4"><i class="bi bi-person-fill"></i> 1. Identificación del Consumidor Reclamante</h4>
                            
                            <!-- Selectores de Tipo de Persona -->
                            <div class="mb-4 d-flex gap-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="tipo_persona" id="personaNatural" value="natural" checked>
                                    <label class="form-check-label" for="personaNatural">Persona Natural</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="tipo_persona" id="personaJuridica" value="juridica">
                                    <label class="form-check-label" for="personaJuridica">Persona Jurídica</label>
                                </div>
                            </div>

                            <div class="row g-3">
                                <!-- Campos dinámicos para Persona Natural -->
                                <div id="fieldsNatural" class="row g-3 m-0 p-0">
                                    <div class="col-md-4">
                                        <label class="form-label">Tipo de Documento</label>
                                        <select class="form-select" name="doc_tipo_natural">
                                            <option value="" selected disabled hidden>Seleccionar Documento</option>
                                            <option value="DNI">DNI</option> 
                                            <option value="Pasaporte">Pasaporte</option>
                                            <option value="Carnet Extranjeria">Carnet Extranjería</option>
                                            <option value="Cedula de Identidad">Cédula de identidad</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Número de Documento</label>
                                        <input 
                                            type="text" 
                                            name="doc_numero_natural" 
                                            class="form-control" 
                                            placeholder="N° Documento"
                                            inputmode="numeric"
                                            pattern="[0-9]{8}"
                                            maxlength="8"
                                            onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                        >
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Nombres y Apellidos</label>
                                        <input type="text" name="nombre_completo_natural" class="form-control" placeholder="Nombres y Apellidos">
                                    </div>
                                </div>

                                <!-- Campos dinámicos para Persona Jurídica -->
                                <div id="fieldsJuridica" class="row g-3 m-0 p-0 hidden-field">
                                    <div class="col-md-4">
                                        <label class="form-label">Tipo de Documento</label>
                                        <input type="text" class="form-control" value="RUC" placeholder="RUC" readonly>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Número de RUC</label>
                                        <input type="text" name="ruc_juridica" class="form-control" placeholder="N° RUC">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Razón Social</label>
                                        <input type="text" name="razon_social" class="form-control" placeholder="Razón Social">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Doc. del Contacto</label>
                                        <select class="form-select" name="doc_tipo_contacto">
                                            <option value="" selected disabled hidden>Seleccionar Documento</option>
                                            <option value="DNI">DNI</option> 
                                            <option value="Pasaporte">Pasaporte</option>
                                            <option value="Carnet Extranjeria">Carnet Extranjería</option>
                                            <option value="Cedula de Identidad">Cédula de identidad</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Núm. Documento Contacto</label>
                                        <input type="text" name="doc_num_contacto" class="form-control" placeholder="N° Documento">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Nombres del Contacto</label>
                                        <input type="text" name="nombre_contacto" class="form-control" placeholder="Nombres y Apellidos">
                                    </div>
                                </div>

                                <!-- Campos comunes (Eliminado Distrito) -->
                                <div class="col-md-4">
                                    <label class="form-label">Teléfono / Celular</label>
                                    <input 
                                        type="text" 
                                        name="telefono" 
                                        class="form-control" 
                                        placeholder="999888777 o (01) 4445566"
                                        inputmode="tel"
                                        oninput="this.value = this.value.replace(/[^0-9+() ]/g, '').replace(/(\s.*)\s/g, '$1')"
                                    >
                                </div>
                                <div class="col-md-8">
                                    <label class="form-label">Correo Electrónico</label>
                                    <div class="input-group">
                                        <input type="email" name="email" class="form-control" placeholder="nombre@correo.com" required>
                                        <span class="input-group-text"><i class="bi bi-info-circle"></i></span>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Dirección de Domicilio</label>
                                    <input type="text" name="direccion" class="form-control" placeholder="Dirección completa">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 2. DETALLE DEL RECLAMO -->
                    <div class="col-lg-12">
                        <div class="card p-4">
                            <h4 class="card-title mb-4"><i class="bi bi-file-earmark-text-fill"></i> 2. DETALLE DE LA RECLAMACIÓN Y PEDIDO DEL CONSUMIDOR</h4>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label">Servicio Contratado</label>
                                    <select name="servicio_contratado" class="form-select" required>
                                        <option value="" selected disabled hidden>Seleccionar Servicio</option>
                                        <option value="Cursos">Cursos</option>
                                        <option value="Diplomas">Diplomas</option>
                                        <option value="Otros">Otros</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Tipo de Reclamación</label>
                                    <select name="tipo_reclamacion" class="form-select" required>
                                        <option value="" selected disabled hidden>Seleccionar Tipo de Reclamo</option>
                                        <option value="Reclamo">Reclamo</option>
                                        <option value="Queja">Queja</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Monto Reclamado (S/.)</label>
                                    <input type="text" name="monto" class="form-control" placeholder="0.00">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Nombre del Evento / Producto</label>
                                    <input type="text" name="nombre_evento" class="form-control" placeholder="Nombre del curso o producto">
                                </div>
                                <div class="leyenda mt-4 p-3 bg-light border-start border-4 border-primary">
                                    <strong>RECLAMO:</strong> Disconformidad relacionada a los productos o servicios.<br>
                                    <strong>QUEJA:</strong> Disconformidad no relacionada a los productos o servicios; o, malestar o descontento respecto a la atención al público.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 3. DESCRIPCIÓN Y ARCHIVOS -->
                    <div class="col-12">
                        <div class="card p-4">
                            <div class="row g-3">
                                <div class="col-md-7">
                                    <label class="form-label fw-bold">Descripción del incidente</label>
                                    <textarea name="descripcion" class="form-control mb-3" rows="3" placeholder="Detalle qué sucedió..." required></textarea>
                                    <label class="form-label fw-bold">Pedido concreto</label>
                                    <textarea name="pedido" class="form-control mb-3" rows="2" placeholder="¿Qué solución solicita?" required></textarea>
                                </div>
                                <div class="col-md-5">
                                    <label class="form-label fw-bold">Adjuntar PDFs (Máx. 5 - Máx. 2MB c/u)</label>
                                    <div class="input-group mb-2">
                                        <input type="file" id="inputFiles" class="form-control" accept=".pdf">
                                    </div>
                                    <div id="fileList" class="small"></div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <div class="border p-3 rounded mb-3 bg-white shadow-sm">
                                    <p class="mb-0 text-muted" style="font-size: 0.9rem;">
                                        <strong>Observaciones y acciones tomadas por el proveedor.</strong><br>
                                        La respuesta a la presente será atendida mediante correo electrónico a la dirección que usted ha consignado.
                                    </p>
                                </div>
                                <div class="border p-3 rounded mb-3 bg-white shadow-sm" style="font-size: 0.85rem;">
                                    <p class="mb-1">1. La formulación de reclamo no impide acudir a otras vías de solución de controversias ni es requisito previo para INDECOPI.</p>
                                    <p class="mb-0">2. El proveedor deberá dar respuesta al reclamo en un plazo no mayor a quince (15) días hábiles.</p>
                                </div>
                                <div class="form-check mb-4">
                                    <input class="form-check-input" type="checkbox" id="checkConsentimiento" required>
                                    <label class="form-check-label text-muted" for="checkConsentimiento" style="font-size: 0.95rem;">
                                        Declaro ser el titular del contenido del presente formulario, y autorizo el tratamiento de mis datos personales.
                                    </label>
                                </div>
                            </div>

                            <div class="text-center mt-4">
                                <button type="submit" id="btnEnviar" class="btn btn-primary btn-lg w-50">ENVIAR</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal de alerta para validación de archivos -->
    <div class="modal fade" id="modalAlerta" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title"><i class="bi bi-exclamation-triangle"></i> Archivo no válido</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p id="modalMensaje" class="mb-0"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        // ===== Variables globales =====
        let archivosSeleccionados = [];
        let inputFiles = document.getElementById('inputFiles');
        const fileList = document.getElementById('fileList');
        const form = document.getElementById('formReclamo');
        const btnEnviar = document.getElementById('btnEnviar');

        // ===== Lógica para cambio dinámico Persona Natural / Jurídica =====
        const radioNatural   = document.getElementById('personaNatural');
        const radioJuridica  = document.getElementById('personaJuridica');
        const fieldsNatural  = document.getElementById('fieldsNatural');
        const fieldsJuridica = document.getElementById('fieldsJuridica');

        function toggleFields() {
            const esNatural = radioNatural.checked;

            // Mostrar / ocultar bloques
            fieldsNatural.classList.toggle('hidden-field', !esNatural);
            fieldsJuridica.classList.toggle('hidden-field', esNatural);

            // Habilitar/deshabilitar campos según el tipo seleccionado
            setFieldsState(fieldsNatural, esNatural);
            setFieldsState(fieldsJuridica, !esNatural);
        }

        function setFieldsState(container, activo) {
            const inputs = container.querySelectorAll('input, select, textarea');
            inputs.forEach(el => {
                el.disabled = !activo;
                if (!activo) {
                    if (el.tagName === 'SELECT') {
                        el.selectedIndex = 0;
                    } else if (el.type !== 'radio' && el.type !== 'checkbox') {
                        el.value = '';
                    }
                }
            });
        }

        radioNatural.addEventListener('change', toggleFields);
        radioJuridica.addEventListener('change', toggleFields);

        // Ejecutar una vez al cargar para dejar el estado consistente
        document.addEventListener('DOMContentLoaded', toggleFields);

        // Limpiar formulario al volver con el botón atrás (evita datos cacheados)
        window.addEventListener('pageshow', (e) => {
            if (e.persisted) {
                form.reset();
                archivosSeleccionados = [];
                renderFiles();
                toggleFields();
            }
        });

        // ===== Modal Bootstrap reutilizable =====
        function mostrarModal(mensaje) {
            const modalEl = document.getElementById('modalAlerta');
            document.getElementById('modalMensaje').textContent = mensaje;
            try {
                const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                modal.show();
            } catch (e) {
                alert(mensaje);
            }
        }

        // ===== Lógica de archivos =====
        function initFileInput(el) {
            el.addEventListener('change', function () {
                const files = Array.from(this.files);
                for (let file of files) {
                    if (archivosSeleccionados.length >= 5) {
                        mostrarModal('Solo se permiten hasta 5 archivos PDF.');
                        break;
                    }
                    // Validación por tipo MIME y por extensión (algunos navegadores no setean type)
                    const esPdfMime = file.type === "application/pdf";
                    const esPdfExt  = file.name.toLowerCase().endsWith('.pdf');
                    if (!esPdfMime && !esPdfExt) {
                        mostrarModal('El archivo "' + file.name + '" no es un PDF. Solo se aceptan archivos PDF.');
                        continue;
                    }
                    if (file.size > 2097152) {
                        mostrarModal('El archivo "' + file.name + '" supera los 2MB. Cada archivo debe pesar máximo 2MB.');
                        continue;
                    }
                    // Evitar duplicados por nombre+tamaño
                    const yaExiste = archivosSeleccionados.some(f => f.name === file.name && f.size === file.size);
                    if (yaExiste) {
                        mostrarModal('El archivo "' + file.name + '" ya fue agregado.');
                        continue;
                    }
                    archivosSeleccionados.push(file);
                }
                renderFiles();
                reemplazarInput();
            });
        }

        function reemplazarInput() {
            const container = inputFiles.parentNode;
            const nuevo = document.createElement('input');
            nuevo.type = 'file';
            nuevo.id = 'inputFiles';
            nuevo.className = 'form-control';
            nuevo.accept = '.pdf';
            container.replaceChild(nuevo, inputFiles);
            inputFiles = nuevo;
            initFileInput(inputFiles);
        }

        function renderFiles() {
            fileList.innerHTML = "";
            if (archivosSeleccionados.length === 0) return;

            archivosSeleccionados.forEach((file, index) => {
                const div = document.createElement('div');
                div.className = "d-flex justify-content-between align-items-center bg-light p-2 mb-1 rounded";

                // Lado izquierdo: icono + nombre
                const span = document.createElement('span');
                const icon = document.createElement('i');
                icon.className = 'bi bi-file-pdf text-danger me-2';
                span.appendChild(icon);
                span.appendChild(document.createTextNode(file.name));

                // Lado derecho: botón eliminar
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'btn btn-sm btn-close';
                btn.setAttribute('aria-label', 'Eliminar');
                btn.addEventListener('click', () => removeFile(index));

                div.appendChild(span);
                div.appendChild(btn);
                fileList.appendChild(div);
            });
        }

        function removeFile(index) {
            archivosSeleccionados.splice(index, 1);
            renderFiles();
        }
        // Exponer globalmente por si se necesita desde HTML inline
        window.removeFile = removeFile;

        // Inicializar el input de archivos
        initFileInput(inputFiles);

        // ===== Envío del formulario =====
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            btnEnviar.disabled = true;
            btnEnviar.innerHTML = "Enviando...";

            const formData = new FormData(form);

            // Agregar archivos pendientes
            for (let i = 0; i < archivosSeleccionados.length; i++) {
                formData.append('mis_archivos[]', archivosSeleccionados[i]);
            }

            try {
                const res = await fetch('upload.php', { method: 'POST', body: formData });
                const data = await res.json();

                if (data.status === 'ok') {
                    console.log('Sheets debug:', data.sheets_debug);
                    window.location.href = data.redirect;
                } else {
                    mostrarModal('Error: ' + data.mensaje);
                    btnEnviar.disabled = false;
                    btnEnviar.innerHTML = 'ENVIAR';
                }
            } catch (err) {
                mostrarModal('Error de conexión. Intente nuevamente.');
                btnEnviar.disabled = false;
                btnEnviar.innerHTML = 'ENVIAR';
            }
        });
    </script>

    <!-- Bloque Informativo Post-Registro -->
    <div class="info-post-registro" style="background-color: #212529; color: white; text-align: center; padding: 32px;">
        <div class="container">
            <p>
                Una vez registrada tu reclamación, la empresa la recibirá y dará inicio al proceso de atención. 
                Te enviaremos un correo de confirmación con un código de seguimiento, el cual te permitirá 
                conocer el estado de tu solicitud en todo momento. Recibirás una respuesta en un plazo máximo 
                de 15 días hábiles, conforme a lo establecido por la Ley N.º 29571 - Código de Protección y 
                Defensa del Consumidor.
            </p>
        </div>
    </div>

    <!-- FOOTER -->
    <footer>
        <div class="inner-wrap">
            <div class="row g-4">
                <div class="col-md-3">
                    <img src="./img/added/logofooter.webp" alt="R&C Consulting" style="height:48px;margin-bottom:20px;display:block;">
                    <h3>Contáctanos:</h3>
                    <p>Av. Petit Thouars 2166.<br>Lince, Lima - Perú</p>
                    <p>Lunes a Viernes de 8:30 a 6:00 pm</p>
                    <p><a href="mailto:info@rc-consulting.org">info@rc-consulting.org</a></p>
                    <p>012661067 anexo: 100, 101, 104</p>
                </div>
                <div class="col-md-3">
                    <h3>Enlaces</h3>
                    <ul>
                        <li><a href="https://rc-consulting.org/cursos-virtuales/">Cursos</a></li>
                        <li><a href="https://rc-consulting.org/diplomas-virtuales/">Diplomados</a></li>
                        <li><a href="https://rc-consulting.org/cursos-inhouse/">Inhouse</a></li>
                        <li><a href="https://rc-consulting.org/consultoria-asistencia-tecnica/">Consultorías</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h3>Información</h3>
                    <ul class="mb-3">
                        <li><a href="https://rc-consulting.org/politicas-de-proteccion-de-datos/">Políticas de privacidad</a></li>
                        <li><a href="https://escueladegobierno.edu.pe/terminos-y-condiciones/">Términos y condiciones</a></li>
                        <li><a href="#">Contáctanos</a></li>
                    </ul>
                    <p style="font-size:11px;margin-bottom:5px;">Métodos de pago</p>
                    <img src="./img/added/payment.webp" alt="Métodos de pago" style="max-height:28px;">
                </div>
                <div class="col-md-3">
                    <h3>Certificados</h3>
                    <a href="https://rc-consulting.org/app-certificados/version1/" class="btn-cert-f" target="_blank"><i class="fas fa-search"></i> Consulta tu certificado</a>
                    <div style="display:flex;align-items:center;gap:8px;margin-bottom:14px;">
                        <img src="./img/added/lreclamaciones.svg" alt="Libro de reclamaciones" style="height:32px;">
                        <a href="https://rc-consulting.org/libro-de-reclamaciones/" style="font-size:14px;">Libro de reclamaciones</a>
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

</body>
</html>