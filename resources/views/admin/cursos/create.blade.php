@extends('layouts.app-main')

@section('title', 'Crear Curso | R&C Consulting')

@section('styles')
<style>
/* Vercel-inspired Design */
:root {
    --vercel-black: #171717;
    --vercel-white: #ffffff;
    --vercel-blue: #0a72ef;
    --shadow-border: 0px 0px 0px 1px rgba(0,0,0,0.08), 0px 2px 2px rgba(0,0,0,0.04);
}

body { background: var(--vercel-white); color: var(--vercel-black); }

.form-card {
    background: var(--vercel-white);
    border-radius: 12px;
    box-shadow: var(--shadow-border);
    border: none;
    padding: 2rem;
}

.form-label {
    font-weight: 600;
    font-size: 0.875rem;
    letter-spacing: -0.02em;
    margin-bottom: 0.5rem;
}

.form-control, .form-select {
    border: none;
    box-shadow: var(--shadow-border);
    border-radius: 8px;
    padding: 0.75rem 1rem;
    font-size: 1rem;
    transition: all 0.2s;
}

.form-control:focus, .form-select:focus {
    box-shadow: 0 0 0 2px rgba(10, 114, 239, 0.3), var(--shadow-border);
    outline: none;
}

.btn-primary {
    background: var(--vercel-black);
    border: none;
    border-radius: 8px;
    padding: 0.75rem 2rem;
    font-weight: 600;
    transition: all 0.2s;
}

.btn-primary:hover {
    background: #333;
    transform: translateY(-1px);
}

.image-preview {
    width: 100%;
    max-height: 300px;
    object-fit: cover;
    border-radius: 8px;
    box-shadow: var(--shadow-border);
    display: none;
}

.section-title {
    font-size: 1.25rem;
    font-weight: 700;
    letter-spacing: -0.03em;
    margin-bottom: 1.5rem;
    padding-bottom: 0.75rem;
    border-bottom: 1px solid #e5e5e5;
}
</style>
@endsection

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <h1 class="mb-4" style="font-weight: 800; letter-spacing: -0.04em;">Crear Nuevo Curso</h1>

            <form action="{{ route('cursos.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Información Básica -->
                <div class="form-card mb-4">
                    <h3 class="section-title">Información Básica</h3>

                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label">Título del Curso</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Tipo</label>
                            <select name="type" class="form-select" required>
                                <option value="curso">Curso</option>
                                <option value="diplomado">Diplomado</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Subtítulo</label>
                            <input type="text" name="subtitle" class="form-control">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Descripción</label>
                            <textarea name="description" class="form-control" rows="4"></textarea>
                        </div>
                    </div>
                </div>

                <!-- Miniatura (Reemplaza cursos.php) -->
                <div class="form-card mb-4">
                    <h3 class="section-title">Imagen de Miniatura (Home)</h3>
                    <p class="text-muted mb-3" style="font-size: 0.875rem;">Esta imagen se mostrará en la página principal, reemplazando el sistema cursos.php</p>

                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <input type="file" name="image_promotion" id="imageInput" class="form-control" accept="image/*" onchange="previewImage(event)">
                            <small class="text-muted mt-2 d-block">Formatos: JPG, PNG, WebP. Recomendado: 400x300px</small>
                        </div>
                        <div class="col-md-8">
                            <img id="imagePreview" class="image-preview" alt="Vista previa">
                        </div>
                    </div>
                </div>

                <!-- Asesora Asignada -->
                <div class="form-card mb-4">
                    <h3 class="section-title">Asesora Responsable</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Seleccionar Asesora</label>
                            <select name="asesora_id" class="form-select" required>
                                <option value="">-- Seleccionar --</option>
                                @foreach($asesoras as $asesora)
                                    <option value="{{ $asesora->id }}">{{ $asesora->name }} - {{ $asesora->cargo }}</option>
                                @endforeach
                            </select>
                            <small class="text-muted mt-2 d-block">Los leads de este curso se asignarán automáticamente a esta asesora</small>
                        </div>
                    </div>
                </div>

                <!-- Precios y Fechas -->
                <div class="form-card mb-4">
                    <h3 class="section-title">Precios y Fechas</h3>

                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Precio Regular</label>
                            <input type="number" name="precio_regular" class="form-control" step="0.01">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Precio Pronto Pago</label>
                            <input type="number" name="precio_pronto" class="form-control" step="0.01">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Precio Flash</label>
                            <input type="number" name="precio_flash" class="form-control" step="0.01">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Fecha Inicio</label>
                            <input type="date" name="start_date" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Sesiones</label>
                            <input type="number" name="sessions" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Horas</label>
                            <input type="number" name="hours" class="form-control">
                        </div>
                    </div>
                </div>

                <!-- SEO -->
                <div class="form-card mb-4">
                    <h3 class="section-title">SEO</h3>
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Título SEO</label>
                            <input type="text" name="seo_title" class="form-control">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Descripción SEO</label>
                            <textarea name="seo_description" class="form-control" rows="2"></textarea>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-2"></i>Crear Curso
                </button>
                <a href="{{ route('cursos.index') }}" class="btn btn-light ms-2">Cancelar</a>
            </form>
        </div>
    </div>
</div>

<script>
function previewImage(event) {
    const input = event.target;
    const preview = document.getElementById('imagePreview');

    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
