@extends('layouts.app-main')

@section('title', 'Gestión de Asesoras | R&C Consulting')

@section('styles')
<style>
:root {
    --vercel-black: #171717;
    --vercel-white: #ffffff;
    --shadow-border: 0px 0px 0px 1px rgba(0,0,0,0.08), 0px 2px 2px rgba(0,0,0,0.04);
}

body { background: #fafafa; }

.advisors-container {
    max-width: 1200px;
    margin: 2rem auto;
    padding: 0 1rem;
}

.header-advisors {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    padding: 2rem;
    background: var(--vercel-white);
    border-radius: 12px;
    box-shadow: var(--shadow-border);
}

.header-advisors h1 {
    font-weight: 800;
    letter-spacing: -0.04em;
    font-size: 1.75rem;
    margin: 0;
}

.advisors-table-container {
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

.table td {
    vertical-align: middle;
}

.advisor-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
    background: #f1f5f9;
}

.advisor-avatar-placeholder {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: linear-gradient(135deg, #5044c2, #7c3aed);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 0.9rem;
}

.tipo-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 600;
}

.tipo-asesora { background: #d1fae5; color: #065f46; }
.tipo-inhouse { background: #dbeafe; color: #1e40af; }

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
    border-color: #5044c2;
    box-shadow: 0 0 0 3px rgba(80,68,194,0.1);
}

.alert {
    border-radius: 10px;
    border: none;
}

.btn-primary {
    background: #5044c2;
    border: none;
    border-radius: 8px;
    padding: 0.5rem 1.25rem;
    font-weight: 600;
}

.btn-primary:hover { background: #3b32a1; }

.photo-preview {
    width: 80px;
    height: 80px;
    border-radius: 12px;
    object-fit: cover;
    border: 2px solid #e2e8f0;
}

.photo-preview-sm {
    width: 50px;
    height: 50px;
    border-radius: 8px;
    object-fit: cover;
    border: 2px solid #e2e8f0;
}

.photo-preview-placeholder {
    width: 80px;
    height: 80px;
    border-radius: 12px;
    background: #f1f5f9;
    border: 2px dashed #d1d5db;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #94a3b8;
    font-size: 0.75rem;
    text-align: center;
}

.photo-preview-placeholder-sm {
    width: 50px;
    height: 50px;
    border-radius: 8px;
    background: #f1f5f9;
    border: 2px dashed #d1d5db;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #94a3b8;
    font-size: 0.65rem;
    text-align: center;
}

.photo-badge {
    display: inline-block;
    font-size: 0.6rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    padding: 2px 6px;
    border-radius: 4px;
    margin-top: 2px;
}

.photo-badge-perfil { background: #e0e7ff; color: #3730a3; }
.photo-badge-web { background: #d1fae5; color: #065f46; }

.photo-section-title {
    font-weight: 700;
    font-size: 0.9rem;
    color: #1f2937;
    border-bottom: 1px solid #e5e7eb;
    padding-bottom: 0.5rem;
    margin-bottom: 1rem;
}

.current-photo-label {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-size: 0.75rem;
    color: #6b7280;
    margin-top: 4px;
}

.current-photo-label i {
    font-size: 0.7rem;
}
</style>
@endsection

@section('content')
<div class="advisors-container">
    <div class="header-advisors">
        <div>
            <h1>Gestión de Asesoras</h1>
            <p class="text-muted mt-1 mb-0">Administra los perfiles de las asesoras: foto de perfil, foto web, celular y datos de contacto</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success mb-4">{{ session('success') }}</div>
    @endif

    <div class="advisors-table-container">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Asesora</th>
                    <th>Celular</th>
                    <th>Email / Cargo</th>
                    <th>Tipo</th>
                    <th>Foto Perfil</th>
                    <th>Foto Web</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($advisors as $advisor)
                    @php
                        $photoUrl = $advisor->photo ? (str_starts_with($advisor->photo, 'http') ? $advisor->photo : asset($advisor->photo)) : '';
                        $photoWebUrl = $advisor->photo_web ? (str_starts_with($advisor->photo_web, 'http') ? $advisor->photo_web : asset($advisor->photo_web)) : '';
                    @endphp
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                @if($photoUrl)
                                    <img src="{{ $photoUrl }}" alt="" class="advisor-avatar"
                                        onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                                    <div class="advisor-avatar-placeholder" style="display:none">
                                        {{ substr($advisor->name, 0, 2) }}
                                    </div>
                                @else
                                    <div class="advisor-avatar-placeholder">
                                        {{ substr($advisor->name, 0, 2) }}
                                    </div>
                                @endif
                                <strong>{{ $advisor->name }}</strong>
                            </div>
                        </td>
                        <td>
                            @if($advisor->whatsapp && $advisor->whatsapp !== '+51999999999')
                                <a href="https://wa.me/{{ $advisor->whatsapp }}" target="_blank" class="text-success text-decoration-none">
                                    <i class="bi bi-whatsapp me-1"></i>{{ $advisor->whatsapp }}
                                </a>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>
                            <div class="small">
                                <div class="text-muted">{{ $advisor->email ?? '—' }}</div>
                                <div class="text-muted" style="font-size:0.75rem">{{ $advisor->cargo ?? '' }}</div>
                            </div>
                        </td>
                        <td>
                            <span class="tipo-badge tipo-{{ $advisor->tipo ?? 'asesora' }}">
                                {{ ucfirst($advisor->tipo ?? 'asesora') }}
                            </span>
                        </td>
                        <td>
                            @if($photoUrl)
                                <img src="{{ $photoUrl }}" alt="perfil" class="photo-preview-sm"
                                    onerror="this.outerHTML='<div class=\\'photo-preview-placeholder-sm\\'>Sin foto</div>'">
                            @else
                                <div class="photo-preview-placeholder-sm">Sin foto</div>
                            @endif
                        </td>
                        <td>
                            @if($photoWebUrl)
                                <img src="{{ $photoWebUrl }}" alt="web" class="photo-preview-sm"
                                    onerror="this.outerHTML='<div class=\\'photo-preview-placeholder-sm\\'>Sin foto web</div>'">
                            @else
                                <div class="photo-preview-placeholder-sm">Sin foto web</div>
                            @endif
                        </td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                data-bs-target="#editAdvisorModal"
                                data-id="{{ $advisor->id }}"
                                data-name="{{ $advisor->name }}"
                                data-whatsapp="{{ $advisor->whatsapp }}"
                                data-photo="{{ $advisor->photo }}"
                                data-photo_web="{{ $advisor->photo_web }}"
                                data-email="{{ $advisor->email }}"
                                data-cargo="{{ $advisor->cargo }}"
                                data-tipo="{{ $advisor->tipo ?? 'asesora' }}">
                                <i class="bi bi-pencil"></i> Editar
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">
                            No hay asesoras registradas. Crea un usuario con rol "Asesor" desde Accesos y Roles.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Edit Modal --}}
<div class="modal fade" id="editAdvisorModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="" method="POST" id="editAdvisorForm" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Editar Asesora</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <!-- Nombre -->
                        <div class="col-md-6">
                            <label class="form-label">Nombre completo</label>
                            <input type="text" name="name" id="edit_name" class="form-control" required>
                        </div>

                        <!-- Celular -->
                        <div class="col-md-6">
                            <label class="form-label">Celular (WhatsApp)</label>
                            <input type="text" name="whatsapp" id="edit_whatsapp" class="form-control"
                                placeholder="950883155" required>
                            <small class="text-muted">Se agregará <strong>+51</strong> automáticamente</small>
                        </div>

                        <!-- Email -->
                        <div class="col-md-6">
                            <label class="form-label">Correo electrónico</label>
                            <input type="email" name="email" id="edit_email" class="form-control">
                        </div>

                        <!-- Cargo -->
                        <div class="col-md-6">
                            <label class="form-label">Cargo</label>
                            <input type="text" name="cargo" id="edit_cargo" class="form-control"
                                placeholder="Ej: Asesora Comercial">
                        </div>

                        <!-- Tipo -->
                        <div class="col-md-6">
                            <label class="form-label">Tipo</label>
                            <select name="tipo" id="edit_tipo" class="form-select">
                                <option value="asesora">Asesora</option>
                                <option value="inhouse">Inhouse</option>
                            </select>
                        </div>

                        <!-- Separación visual -->
                        <div class="col-12 mt-3">
                            <div class="photo-section-title">
                                <i class="bi bi-camera me-1"></i> Fotos
                            </div>
                        </div>

                        <!-- Foto de Perfil (sistema) -->
                        <div class="col-md-6">
                            <label class="form-label">
                                Foto de Perfil <span class="photo-badge photo-badge-perfil">Sistema</span>
                            </label>
                            <input type="file" name="photo" id="edit_photo" class="form-control"
                                accept="image/jpeg,image/png,image/jpg,image/gif,image/webp">
                            <small class="text-muted">Foto para el panel admin y avatares del sistema</small>
                            <div class="current-photo-label" id="current_photo_label" style="display:none">
                                <i class="bi bi-image"></i> Foto actual
                            </div>
                            <div class="mt-2">
                                <img id="photo_preview_img" src="" alt="Vista previa perfil"
                                    class="photo-preview" style="display:none">
                                <div id="photo_preview_placeholder" class="photo-preview-placeholder">
                                    Sin foto de perfil
                                </div>
                            </div>
                        </div>

                        <!-- Foto Web (página web) -->
                        <div class="col-md-6">
                            <label class="form-label">
                                Foto Web <span class="photo-badge photo-badge-web">Web</span>
                            </label>
                            <input type="file" name="photo_web" id="edit_photo_web" class="form-control"
                                accept="image/jpeg,image/png,image/jpg,image/gif,image/webp">
                            <small class="text-muted">Foto que aparecerá en la página web pública</small>
                            <div class="current-photo-label" id="current_photo_web_label" style="display:none">
                                <i class="bi bi-image"></i> Foto actual
                            </div>
                            <div class="mt-2">
                                <img id="photo_web_preview_img" src="" alt="Vista previa web"
                                    class="photo-preview" style="display:none">
                                <div id="photo_web_preview_placeholder" class="photo-preview-placeholder">
                                    Sin foto web
                                </div>
                            </div>
                        </div>
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
    const editModal = document.getElementById('editAdvisorModal');

    function showPhotoPreview(imgEl, placeholderEl, photoData) {
        if (photoData) {
            const photoSrc = photoData.startsWith('http') ? photoData : '{{ asset("") }}' + photoData;
            imgEl.src = photoSrc;
            imgEl.style.display = '';
            placeholderEl.style.display = 'none';
        } else {
            imgEl.style.display = 'none';
            placeholderEl.style.display = 'flex';
        }
    }

    function setupFilePreview(inputId, imgId, placeholderId, labelId) {
        const input = document.getElementById(inputId);
        const img = document.getElementById(imgId);
        const placeholder = document.getElementById(placeholderId);
        const label = document.getElementById(labelId);

        input.addEventListener('change', function () {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    img.src = e.target.result;
                    img.style.display = '';
                    placeholder.style.display = 'none';
                    if (label) label.style.display = 'none';
                };
                reader.readAsDataURL(file);
            }
        });
    }

    setupFilePreview('edit_photo', 'photo_preview_img', 'photo_preview_placeholder', 'current_photo_label');
    setupFilePreview('edit_photo_web', 'photo_web_preview_img', 'photo_web_preview_placeholder', 'current_photo_web_label');

    editModal.addEventListener('show.bs.modal', function (event) {
        const btn = event.relatedTarget;
        const id = btn.dataset.id;
        const name = btn.dataset.name;
        const whatsapp = btn.dataset.whatsapp;
        const photo = btn.dataset.photo;
        const photoWeb = btn.dataset.photo_web;
        const email = btn.dataset.email;
        const cargo = btn.dataset.cargo;
        const tipo = btn.dataset.tipo;

        document.getElementById('edit_name').value = name;
        // Strip +51 prefix for editing if present
        document.getElementById('edit_whatsapp').value = whatsapp.replace(/^\+51/, '');
        document.getElementById('edit_email').value = email || '';
        document.getElementById('edit_cargo').value = cargo || '';
        document.getElementById('edit_tipo').value = tipo || 'asesora';

        // Clear file inputs
        document.getElementById('edit_photo').value = '';
        document.getElementById('edit_photo_web').value = '';

        // Show current photo labels
        const photoLabel = document.getElementById('current_photo_label');
        const photoWebLabel = document.getElementById('current_photo_web_label');
        if (photo) photoLabel.style.display = 'inline-flex'; else photoLabel.style.display = 'none';
        if (photoWeb) photoWebLabel.style.display = 'inline-flex'; else photoWebLabel.style.display = 'none';

        // Photo previews
        showPhotoPreview(
            document.getElementById('photo_preview_img'),
            document.getElementById('photo_preview_placeholder'),
            photo
        );
        showPhotoPreview(
            document.getElementById('photo_web_preview_img'),
            document.getElementById('photo_web_preview_placeholder'),
            photoWeb
        );

        document.getElementById('editAdvisorForm').action =
            '{{ route("admin.advisors.update", "__ID__") }}'.replace('__ID__', id);
    });
});
</script>
@endsection
