@extends('layouts.app-main')

@section('title', 'Libro de Reclamaciones | R&C Consulting')

@section('styles')
<style>
    .hidden-field { display: none !important; }
    .card-title { color: #136EF0 !important; }
    #btnEnviar { background-color: #136EF0 !important; border-color: #136EF0 !important; }
    .upload-form-section {
        background-color: #f4f7f6;
        padding: 40px 0;
        font-family: 'Poppins', sans-serif;
        min-height: 60vh;
    }
    .header-logo h1 {
        font-family: 'Montserrat', sans-serif;
        font-weight: 800;
        color: #212529;
        font-size: 28px;
    }
    .header-logo p {
        color: #6c757d;
        font-size: 14px;
    }
    .loading-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.5);
        z-index: 9999;
        display: none;
        align-items: center;
        justify-content: center;
    }
    .loading-overlay.show {
        display: flex;
    }
    .loading-content {
        background: white;
        padding: 40px 50px;
        border-radius: 16px;
        text-align: center;
        box-shadow: 0 8px 32px rgba(0,0,0,0.2);
    }
    .spinner {
        width: 50px;
        height: 50px;
        border: 5px solid #e0e0e0;
        border-top-color: #136EF0;
        border-radius: 50%;
        animation: girar 0.7s linear infinite;
        margin: 0 auto 16px;
    }
    @keyframes girar {
        to { transform: rotate(360deg); }
    }
</style>
@endsection

@section('content')
<div class="upload-form-section">
    <header class="header-logo text-center py-4">
        <h1>LIBRO DE RECLAMACIONES</h1>
        <p>Conforme a lo establecido en el Código de Protección y Defensa del Consumidor</p>
    </header>

    <div class="container text-start mb-3">
        <a href="{{ route('libro-reclamaciones.buscar') }}" class="btn btn-success btn-lg">
            <i class="bi bi-search"></i> Buscar Reclamo
        </a>
    </div>

    <div class="container mb-5">
        <form id="formReclamo">
            @csrf
            <div class="row g-4">
                <div class="col-lg-12">
                    <div class="card p-4">
                        <h4 class="card-title mb-4"><i class="bi bi-person-fill"></i> 1. Identificación del Consumidor Reclamante</h4>

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
                                    <input type="text" name="doc_numero_natural" class="form-control" placeholder="N° Documento" inputmode="numeric" pattern="[0-9]{8}" maxlength="8" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Nombres y Apellidos</label>
                                    <input type="text" name="nombre_completo_natural" class="form-control" placeholder="Nombres y Apellidos">
                                </div>
                            </div>

                            <div id="fieldsJuridica" class="row g-3 m-0 p-0 hidden-field">
                                <div class="col-md-4">
                                    <label class="form-label">Tipo de Documento</label>
                                    <input type="text" class="form-control" value="RUC" placeholder="RUC" readonly>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Número de RUC</label>
                                    <input 
  type="text" 
  name="ruc_juridica" 
  class="form-control" 
  placeholder="N° RUC"
  maxlength="11"
  oninput="this.value = this.value.replace(/[^0-9]/g, '');"
>
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
                                    <input 
  type="text" 
  name="doc_num_contacto" 
  class="form-control" 
  placeholder="N° Documento"
  maxlength="12"
>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Nombres del Contacto</label>
                                    <input type="text" name="nombre_contacto" class="form-control" placeholder="Nombres y Apellidos">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Teléfono / Celular</label>
                                <input type="text" name="telefono" class="form-control" placeholder="999888777 o (01) 4445566" inputmode="tel" oninput="this.value = this.value.replace(/[^0-9+() ]/g, '').replace(/(\s.*)\s/g, '$1')">
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

        <div id="loadingOverlay" class="loading-overlay">
            <div class="loading-content">
                <div class="spinner"></div>
                <p style="font-size:18px; font-weight:600; margin:0;">Enviando...</p>
            </div>
        </div>
    </div>
</div>

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
@endsection

@section('scripts')
<script>
    let archivosSeleccionados = [];
    let inputFiles = document.getElementById('inputFiles');
    const fileList = document.getElementById('fileList');
    const form = document.getElementById('formReclamo');
    const btnEnviar = document.getElementById('btnEnviar');

    const radioNatural = document.getElementById('personaNatural');
    const radioJuridica = document.getElementById('personaJuridica');
    const fieldsNatural = document.getElementById('fieldsNatural');
    const fieldsJuridica = document.getElementById('fieldsJuridica');

    function toggleFields() {
        const esNatural = radioNatural.checked;
        fieldsNatural.classList.toggle('hidden-field', !esNatural);
        fieldsJuridica.classList.toggle('hidden-field', esNatural);
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
    document.addEventListener('DOMContentLoaded', toggleFields);

    window.addEventListener('pageshow', () => {
        if (sessionStorage.getItem('reclamo_submitted')) {
            sessionStorage.removeItem('reclamo_submitted');
            form.reset();
            archivosSeleccionados = [];
            renderFiles();
            toggleFields();
        }
    });

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

    function initFileInput(el) {
        el.addEventListener('change', function () {
            const files = Array.from(this.files);
            for (let file of files) {
                if (archivosSeleccionados.length >= 5) {
                    mostrarModal('Solo se permiten hasta 5 archivos PDF.');
                    break;
                }
                const esPdfMime = file.type === "application/pdf";
                const esPdfExt = file.name.toLowerCase().endsWith('.pdf');
                if (!esPdfMime && !esPdfExt) {
                    mostrarModal('El archivo "' + file.name + '" no es un PDF. Solo se aceptan archivos PDF.');
                    continue;
                }
                if (file.size > 2097152) {
                    mostrarModal('El archivo "' + file.name + '" supera los 2MB. Cada archivo debe pesar máximo 2MB.');
                    continue;
                }
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
            const span = document.createElement('span');
            const icon = document.createElement('i');
            icon.className = 'bi bi-file-pdf text-danger me-2';
            span.appendChild(icon);
            span.appendChild(document.createTextNode(file.name));
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
    window.removeFile = removeFile;

    initFileInput(inputFiles);

    const loadingOverlay = document.getElementById('loadingOverlay');

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        btnEnviar.disabled = true;
        loadingOverlay.classList.add('show');

        const formData = new FormData(form);
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);

        for (let i = 0; i < archivosSeleccionados.length; i++) {
            formData.append('mis_archivos[]', archivosSeleccionados[i]);
        }

        try {
            const res = await fetch('{{ route('libro-reclamaciones.upload') }}', { method: 'POST', body: formData });
            const data = await res.json();
            if (data.status === 'ok') {
                sessionStorage.setItem('reclamo_submitted', '1');
                window.location.href = data.redirect;
            } else {
                loadingOverlay.classList.remove('show');
                mostrarModal('Error: ' + data.mensaje);
                btnEnviar.disabled = false;
            }
        } catch (err) {
            loadingOverlay.classList.remove('show');
            mostrarModal('Error de conexión. Intente nuevamente.');
            btnEnviar.disabled = false;
        }
    });
</script>
@endsection
