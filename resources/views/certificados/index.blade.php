@extends('layouts.app-main')

@section('title', 'Consulta de Certificados - R&C Consulting')

@section('meta_description', 'Consulta y verifica tus certificados obtenidos en R&C Consulting.')

@section('meta_keywords', 'Consulta de certificados, R&C Consulting, Certificados de capacitación')

@section('canonical', route('certificados'))

@section('og_title', 'Consulta de Certificados - R&C Consulting')

@section('og_description', 'Consulta y verifica tus certificados obtenidos en R&C Consulting.')

@section('styles')
<link rel="stylesheet" href="{{ asset('certificados/css/certificados.css') }}">
<style>
    li:has(a[href*="alquiler-de-aulas"]) {
        display: none !important;
    }
</style>
@endsection

@section('content')

<div id="cert-bg"></div>

<div class="container text-center" style="padding-top: 80px; padding-bottom: 60px; max-width: 1400px;">

    <div class="header-title mb-5 text-center">
        <h1 class="text-white fw-bold display-4" style="letter-spacing: 2px; margin-top: 40px;">
            VERIFICA TU CERTIFICADO
        </h1>
        <p class="text-white custom-margin fs-5" id="subtitulo">
            Consulta la validez de tus acreditaciones de capacitación y especialización.
            Nuestras certificaciones y diplomados se emiten en el marco de la Formación Laboral.
        </p>
    </div>

    <div class="row g-4 align-items-start justify-content-center mb-5" id="div-app">
        <div class="col-12 col-lg-4">
            <div class="card-glass h-100">
                <div class="card-header-white">
                    <p class="div-subtitulo mb-0">REGISTRO NACIONAL DE CERTIFICACIONES</p>
                </div>
                <div class="consulta p-4">
                    <form onsubmit="event.preventDefault();">
                        <div class="mb-3">
                            <input type="text" class="form-control input-custom" id="inputDni"
                                style="font-size: 30px;" placeholder="INGRESE SU DNI" maxlength="8"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 8);">
                        </div>

                        <div class="captcha-container mb-3">
                            <input type="text"
                                class="form-control input-custom-left input-custom justify-content-center"
                                id="cpatchaTextBox" style="font-size: 30px;" placeholder="INGRESE EL CODIGO">
                            <div id="captcha" class="captcha-box">ZYNDX</div>
                        </div>

                        <div class="mb-4 form-check text-start d-flex align-items-center justify-content-center">
                            <input type="checkbox" class="form-check-input me-2" id="exampleCheck1">
                            <label class="form-check-label text-white" for="exampleCheck1">Aceptar políticas
                                de datos</label>
                        </div>
                        <div class="d-flex gap-3">
                            <button type="button" class="btn btn-search" onclick="verificarDatos()">Buscar</button>
                            <button type="button" class="btn btn-clear" onclick="limpiarDatos()">Limpiar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6" id="verright">
            <div class="card-glass h-100">
                <div class="card-header-white">
                    <p class="div-subtitulo mb-0">RESULTADO DE CERTIFICADOS OBTENIDOS</p>
                </div>
                <div class="visualizador" id="todatabla"
                    style="padding: 15px; background: transparent !important; max-height: 480px; overflow-y: auto; overflow-x: hidden;">
                </div>
            </div>
        </div>
    </div>

    <div class="how-to-section mt-5 w-100">
        <div class="row justify-content-center">
            <div class="col-12 text-center">
                <h2 id="sub-2" class="text-white fw-bold mb-5" style="font-size: 2.5rem; width: 100%;">¿Cómo
                    verificar tu certificado?</h2>
            </div>
        </div>

        <div class="row g-4 justify-content-center align-items-start">
            <div class="col-6 col-md-3 text-center">
                <p class="text-white-2 fw-bold mb-1">1. Ingrese tu DNI</p>
                <p class="text-white-2 text-white-3 fw-bold mb-3 small-text-mobile">Introduce el DNI y presiona
                    buscar</p>
                <img src="{{ asset('certificados/img/iconos/1.png') }}" class="img-fluid step-icon" alt="DNI">
            </div>

            <div class="col-6 col-md-3 text-center">
                <p class="text-white-2 fw-bold mb-1">2. Revisa resultados</p>
                <p class="text-white-2 text-white-3 fw-bold mb-3 small-text-mobile">Aparecerán los certificados</p>
                <img src="{{ asset('certificados/img/iconos/2.png') }}" class="img-fluid step-icon" alt="Certificados">
            </div>

            <div class="col-12 col-md-3 text-center mt-4 mt-md-0">
                <p class="text-white-2 fw-bold mb-1" style="margin-top: 24px;">3. Ver certificado</p>
                <p class="text-white-2 text-white-3 fw-bold mb-3 small-text-mobile">Haz clic en "Ver en
                    certificados"</p>
                <img src="{{ asset('certificados/img/iconos/3.png') }}" class="img-fluid step-icon-2" alt="Click">
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalCertificado" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content"
            style="background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(15px); border: 1px solid rgba(255,255,255,0.2); border-radius: 15px;">
            <div class="modal-header border-0">
                <h5 class="modal-title text-white fw-bold">Visualización de Certificado</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body p-0" id="bodyModalPDF">
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-light rounded-pill px-4 fw-bold"
                    data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script src="{{ asset('certificados/js/captcha.js') }}"></script>
<script src="{{ asset('certificados/js/funcionamiento.js') }}"></script>
<script src="{{ asset('certificados/js/botones.js') }}"></script>
<script src="{{ asset('certificados/js/app.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        createCaptcha();
    });
</script>
@endsection
