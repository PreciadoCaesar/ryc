@extends('layouts.app-main')

@section('title', 'Buscar Reclamo | R&C Consulting')

@section('styles')
<style>
    .hidden-field { display: none !important; }
    .search-section {
        background-color: #f4f7f6;
        padding: 60px 0;
        font-family: 'Poppins', sans-serif;
        min-height: 60vh;
    }
    .search-card {
        background: #fff;
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        max-width: 600px;
        margin: 0 auto;
        padding: 40px;
    }
    .search-card h1 {
        font-family: 'Montserrat', sans-serif;
        font-weight: 800;
        color: #212529;
        text-align: center;
        margin-bottom: 8px;
    }
    .search-card p {
        text-align: center;
        color: #6c757d;
        margin-bottom: 30px;
    }
    .search-card .form-control {
        border-radius: 10px;
        padding: 14px 18px;
        font-size: 16px;
        border: 2px solid #e1e1e1;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-weight: 600;
    }
    .search-card .form-control:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.15);
    }
    .search-card .btn-buscar {
        border-radius: 10px;
        padding: 14px;
        font-weight: 700;
        font-size: 16px;
        width: 100%;
    }
</style>
@endsection

@section('content')
<section class="search-section">
    <div class="container">
        <div class="search-card">
            <h1>Buscar Reclamo</h1>
            <p>Ingresa tu número de documento y código de seguimiento para consultar el estado de tu reclamo.</p>
            <form action="{{ route('libro-reclamaciones.seguimiento') }}" method="GET" onsubmit="return validarBusqueda()">
                <div class="mb-4">
                    <label for="documento" class="form-label fw-bold">N° Documento (DNI o RUC)</label>
                    <input type="text" class="form-control text-center" id="documento" name="documento"
                           placeholder="Ingrese su DNI o RUC" required
                           maxlength="11" pattern="[0-9]{8,11}"
                           inputmode="numeric"
                           onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                </div>
                <div class="mb-4">
                    <label for="codigo" class="form-label fw-bold">Código de seguimiento</label>
                    <input type="text" class="form-control text-center" id="codigo" name="codigo"
                           placeholder="RC-2026-0001" required
                           maxlength="12" pattern="[RC\d\-]{12}"
                           oninput="this.value = this.value.toUpperCase()">
                </div>
                <div id="errorBusqueda" class="alert alert-danger d-none"></div>
                <button type="submit" class="btn btn-primary btn-buscar">
                    Consultar
                </button>
            </form>
            <div class="text-center mt-4 pt-3 border-top">
                <p class="text-muted mb-3">¿Desea realizar un reclamo?</p>
                <a href="{{ route('libro-reclamaciones.index') }}" class="btn btn-success btn-buscar">
                    Registrar Reclamo
                </a>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
function validarBusqueda() {
    const doc = document.getElementById('documento');
    const cod = document.getElementById('codigo');
    const err = document.getElementById('errorBusqueda');

    if (!/^[0-9]{8,11}$/.test(doc.value)) {
        err.textContent = 'El documento debe tener entre 8 y 11 dígitos numéricos.';
        err.classList.remove('d-none');
        doc.focus();
        return false;
    }

    if (!/^[RC\d\-]{12}$/.test(cod.value)) {
        err.textContent = 'El código debe tener 12 caracteres y solo puede contener R, C, números y guiones.';
        err.classList.remove('d-none');
        cod.focus();
        return false;
    }

    err.classList.add('d-none');
    return true;
}
</script>
@endsection
