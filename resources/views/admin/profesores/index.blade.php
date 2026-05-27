@extends('layouts.app-main')

@section('title', 'Gestión de Profesores | R&C Consulting')

@section('styles')
<style>
:root {
    --vercel-black: #171717;
    --vercel-white: #ffffff;
    --shadow-border: 0px 0px 0px 1px rgba(0,0,0,0.08), 0px 2px 2px rgba(0,0,0,0.04);
}

body { background: #fafafa; }

.profesores-container {
    max-width: 1200px;
    margin: 2rem auto;
    padding: 0 1rem;
}

.header-profesores {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    padding: 2rem;
    background: var(--vercel-white);
    border-radius: 12px;
    box-shadow: var(--shadow-border);
}

.header-profesores h1 {
    font-weight: 800;
    letter-spacing: -0.04em;
    font-size: 1.75rem;
    margin: 0;
}

.table-container {
    background: var(--vercel-white);
    border-radius: 12px;
    box-shadow: var(--shadow-border);
    padding: 1.5rem;
    overflow-x: auto;
}

.table th {
    font-weight: 600;
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: #64748b;
    border-bottom: 2px solid #e2e8f0;
}

.avatar-prof {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
    background: #f1f5f9;
}

.avatar-placeholder {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #94a3b8;
    font-size: 1rem;
}

.form-label {
    font-weight: 600;
    font-size: 0.875rem;
    color: #374151;
}

.form-control, .form-select {
    border-radius: 8px;
    border: 1px solid #d1d5db;
    padding: 0.6rem 0.75rem;
}

.form-control:focus, .form-select:focus {
    border-color: #0a72ef;
    box-shadow: 0 0 0 3px rgba(10,114,239,0.1);
}

.modal-content {
    border: none;
    border-radius: 12px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.15);
}

.modal-header {
    border-bottom: 1px solid #e2e8f0;
    padding: 1.5rem;
}

.modal-body {
    padding: 1.5rem;
}

.modal-footer {
    border-top: 1px solid #e2e8f0;
    padding: 1rem 1.5rem;
}

.btn-primary {
    background: #0a72ef;
    border: none;
    border-radius: 8px;
    padding: 0.5rem 1.25rem;
    font-weight: 600;
}

.btn-primary:hover { background: #0056b3; }

.alert {
    border-radius: 10px;
    border: none;
}

.modal {
    align-items: flex-start !important;
    padding-top: 20vh;
}

.modal-dialog {
    margin-top: 0 !important;
}
</style>
@endsection

@section('content')
<div class="profesores-container">
    <div class="header-profesores">
        <div>
            <h1>Panel de Profesores</h1>
            <p class="text-muted mt-1 mb-0">Gestiona los profesores y sus CVs</p>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
            <i class="bi bi-plus-lg me-1"></i> Nuevo Profesor
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success mb-4">{{ session('success') }}</div>
    @endif

    <div class="table-container">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Foto</th>
                    <th>Nombre</th>
                    <th>Formación</th>
                    <th>Experiencia</th>
                    <th>Cursos</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($professors as $prof)
                    <tr>
                        <td>
                            @if($prof->photo)
                                <img src="{{ Storage::url($prof->photo) }}" alt="{{ $prof->name }}" class="avatar-prof">
                            @else
                                <div class="avatar-placeholder">
                                    <i class="bi bi-person"></i>
                                </div>
                            @endif
                        </td>
                        <td><strong>{{ $prof->name }}</strong></td>
                        <td>
                            @if($prof->formacion)
                                @foreach(array_slice($prof->formacion, 0, 1) as $f)
                                    <small class="d-block">{{ $f['titulo'] ?? '' }}</small>
                                @endforeach
                                @if(count($prof->formacion) > 1)
                                    <small class="text-muted">+{{ count($prof->formacion) - 1 }} más</small>
                                @endif
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>
                            @if($prof->experiencia)
                                @foreach(array_slice($prof->experiencia, 0, 1) as $e)
                                    <small class="d-block">{{ $e['rol'] ?? '' }} en {{ $e['empresa'] ?? '' }}</small>
                                @endforeach
                                @if(count($prof->experiencia) > 1)
                                    <small class="text-muted">+{{ count($prof->experiencia) - 1 }} más</small>
                                @endif
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>
                            @php $courseCount = $prof->courses()->count(); @endphp
                            @if($courseCount > 0)
                                <span class="badge bg-info">{{ $courseCount }}</span>
                            @else
                                <span class="text-muted">0</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <button class="btn btn-sm btn-outline-primary"
                                    data-bs-toggle="modal" data-bs-target="#editModal"
                                    data-id="{{ $prof->id }}"
                                    data-name="{{ $prof->name }}"
                                    data-photo="{{ $prof->photo ? Storage::url($prof->photo) : '' }}"
                                    data-formacion='{{ json_encode($prof->formacion) }}'
                                    data-experiencia='{{ json_encode($prof->experiencia) }}'>
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <form action="{{ route('admin.profesores.destroy', $prof->id) }}" method="POST"
                                    onsubmit="return confirm('¿Eliminar este profesor?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">
                            No hay profesores registrados
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Create Modal --}}
<div class="modal fade" id="createModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('admin.profesores.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Nuevo Profesor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nombre completo</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Foto</label>
                        <input type="file" name="photo" class="form-control" accept=".webp">
                        <small class="text-muted">Opcional. Solo WebP, máx 2MB</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Formación</label>
                        <div class="border rounded p-3 bg-light">
                            <div class="row g-2 mb-2 formacion-item">
                                <div class="col-5"><input type="text" name="formacion[0][titulo]" class="form-control" placeholder="Título"></div>
                                <div class="col-4"><input type="text" name="formacion[0][institucion]" class="form-control" placeholder="Institución"></div>
                                <div class="col-3"><input type="text" name="formacion[0][anio]" class="form-control" placeholder="Año"></div>
                            </div>
                            <div class="row g-2 mb-2 formacion-item">
                                <div class="col-5"><input type="text" name="formacion[1][titulo]" class="form-control" placeholder="Título"></div>
                                <div class="col-4"><input type="text" name="formacion[1][institucion]" class="form-control" placeholder="Institución"></div>
                                <div class="col-3"><input type="text" name="formacion[1][anio]" class="form-control" placeholder="Año"></div>
                            </div>
                            <div class="row g-2 formacion-item">
                                <div class="col-5"><input type="text" name="formacion[2][titulo]" class="form-control" placeholder="Título"></div>
                                <div class="col-4"><input type="text" name="formacion[2][institucion]" class="form-control" placeholder="Institución"></div>
                                <div class="col-3"><input type="text" name="formacion[2][anio]" class="form-control" placeholder="Año"></div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Experiencia</label>
                        <div class="border rounded p-3 bg-light">
                            <div class="row g-2 mb-2 exp-item">
                                <div class="col-4"><input type="text" name="experiencia[0][rol]" class="form-control" placeholder="Rol"></div>
                                <div class="col-4"><input type="text" name="experiencia[0][empresa]" class="form-control" placeholder="Empresa"></div>
                                <div class="col-4"><input type="text" name="experiencia[0][periodo]" class="form-control" placeholder="Periodo"></div>
                            </div>
                            <div class="row g-2 mb-2 exp-item">
                                <div class="col-4"><input type="text" name="experiencia[1][rol]" class="form-control" placeholder="Rol"></div>
                                <div class="col-4"><input type="text" name="experiencia[1][empresa]" class="form-control" placeholder="Empresa"></div>
                                <div class="col-4"><input type="text" name="experiencia[1][periodo]" class="form-control" placeholder="Periodo"></div>
                            </div>
                            <div class="row g-2 exp-item">
                                <div class="col-4"><input type="text" name="experiencia[2][rol]" class="form-control" placeholder="Rol"></div>
                                <div class="col-4"><input type="text" name="experiencia[2][empresa]" class="form-control" placeholder="Empresa"></div>
                                <div class="col-4"><input type="text" name="experiencia[2][periodo]" class="form-control" placeholder="Periodo"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Crear Profesor</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Edit Modal --}}
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="" method="POST" id="editForm" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Editar Profesor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nombre completo</label>
                        <input type="text" name="name" id="edit_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Foto</label>
                        <div id="edit_photo_preview" class="mb-2"></div>
                        <input type="file" name="photo" class="form-control" accept=".webp">
                        <small class="text-muted">Solo WebP, máx 2MB. Dejar vacío para mantener la actual.</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Formación</label>
                        <div id="edit_formacion_container" class="border rounded p-3 bg-light"></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Experiencia</label>
                        <div id="edit_experiencia_container" class="border rounded p-3 bg-light"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const editModal = document.getElementById('editModal');
    editModal.addEventListener('show.bs.modal', function (event) {
        const btn = event.relatedTarget;
        const id = btn.dataset.id;
        const name = btn.dataset.name;
        const photo = btn.dataset.photo;

        document.getElementById('edit_name').value = name;

        const preview = document.getElementById('edit_photo_preview');
        if (photo) {
            preview.innerHTML = `<img src="${photo}" class="avatar-prof" style="width:80px;height:80px;border-radius:8px;">`;
        } else {
            preview.innerHTML = '';
        }

        let formacion = [];
        try { formacion = JSON.parse(btn.dataset.formacion || '[]'); } catch(e) {}
        let experiencia = [];
        try { experiencia = JSON.parse(btn.dataset.experiencia || '[]'); } catch(e) {}

        renderEditFormacion(formacion);
        renderEditExperiencia(experiencia);

        document.getElementById('editForm').action = '{{ route("admin.profesores.update", "__ID__") }}'.replace('__ID__', id);
    });
});

function renderEditFormacion(data) {
    const container = document.getElementById('edit_formacion_container');
    const items = data.length > 0 ? data : [{}, {}, {}];
    container.innerHTML = items.map((item, i) => `
        <div class="row g-2 mb-2">
            <div class="col-5"><input type="text" name="formacion[${i}][titulo]" class="form-control" placeholder="Título" value="${item.titulo || ''}"></div>
            <div class="col-4"><input type="text" name="formacion[${i}][institucion]" class="form-control" placeholder="Institución" value="${item.institucion || ''}"></div>
            <div class="col-3"><input type="text" name="formacion[${i}][anio]" class="form-control" placeholder="Año" value="${item.anio || ''}"></div>
        </div>
    `).join('');
}

function renderEditExperiencia(data) {
    const container = document.getElementById('edit_experiencia_container');
    const items = data.length > 0 ? data : [{}, {}, {}];
    container.innerHTML = items.map((item, i) => `
        <div class="row g-2 mb-2">
            <div class="col-4"><input type="text" name="experiencia[${i}][rol]" class="form-control" placeholder="Rol" value="${item.rol || ''}"></div>
            <div class="col-4"><input type="text" name="experiencia[${i}][empresa]" class="form-control" placeholder="Empresa" value="${item.empresa || ''}"></div>
            <div class="col-4"><input type="text" name="experiencia[${i}][periodo]" class="form-control" placeholder="Periodo" value="${item.periodo || ''}"></div>
        </div>
    `).join('');
}
</script>
@endsection
