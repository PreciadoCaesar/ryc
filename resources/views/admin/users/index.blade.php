@extends('layouts.app-main')

@section('title', 'Gestión de Usuarios | R&C Consulting')

@section('styles')
<style>
:root {
    --vercel-black: #171717;
    --vercel-white: #ffffff;
    --shadow-border: 0px 0px 0px 1px rgba(0,0,0,0.08), 0px 2px 2px rgba(0,0,0,0.04);
}

body { background: #fafafa; }

.users-container {
    max-width: 1200px;
    margin: 2rem auto;
    padding: 0 1rem;
}

.header-users {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    padding: 2rem;
    background: var(--vercel-white);
    border-radius: 12px;
    box-shadow: var(--shadow-border);
}

.header-users h1 {
    font-weight: 800;
    letter-spacing: -0.04em;
    font-size: 1.75rem;
    margin: 0;
}

.users-table-container {
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

.role-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 600;
}

.role-dios { background: #fef2f2; color: #991b1b; }
.role-desarrollador { background: #e0f2fe; color: #075985; }
.role-gerente { background: #fef3c7; color: #92400e; }
.role-asesora { background: #d1fae5; color: #065f46; }
.role-usuario { background: #f1f5f9; color: #475569; }

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
    border-color: #0a72ef;
    box-shadow: 0 0 0 3px rgba(10,114,239,0.1);
}

.alert {
    border-radius: 10px;
    border: none;
}

.btn-primary {
    background: #0a72ef;
    border: none;
    border-radius: 8px;
    padding: 0.5rem 1.25rem;
    font-weight: 600;
}

.btn-primary:hover { background: #0056b3; }

.avatar-sm {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    object-fit: cover;
}
</style>
@endsection

@section('content')
<div class="users-container">
    <div class="header-users">
        <div>
            <h1>Gestión de Usuarios</h1>
            <p class="text-muted mt-1 mb-0">Administra los accesos y roles del sistema</p>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createUserModal">
            <i class="bi bi-plus-lg me-1"></i> Nuevo Usuario
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success mb-4">{{ session('success') }}</div>
    @endif

    <div class="users-table-container">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Usuario</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Asesor</th>
                    <th>Google ID</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                @if($user->avatar)
                                    <img src="{{ $user->avatar }}" alt="" class="avatar-sm">
                                @endif
                                <strong>{{ $user->name }}</strong>
                            </div>
                        </td>
                        <td class="text-muted">{{ $user->email }}</td>
                        <td>
                            <span class="role-badge role-{{ $user->rol }}">
                                {{ ucfirst($user->rol) }}
                            </span>
                        </td>
                        <td>{{ $user->advisor?->name ?? '-' }}</td>
                        <td>
                            @if($user->google_id)
                                <span class="text-success small">Conectado</span>
                            @else
                                <span class="text-muted small">Pendiente</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                    data-bs-target="#editUserModal"
                                    data-id="{{ $user->id }}"
                                    data-name="{{ $user->name }}"
                                    data-email="{{ $user->email }}"
                                    data-rol="{{ $user->rol }}"
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                    onsubmit="return confirm('¿Eliminar este usuario?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Create Modal --}}
<div class="modal fade" id="createUserModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Nuevo Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nombre completo</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Correo electrónico</label>
                        <input type="email" name="email" class="form-control" required>
                        <small class="text-muted">El usuario iniciará sesión con Google usando este correo</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Rol</label>
                        <select name="rol" class="form-select" required>
                            <option value="dios">Superadmin (dios)</option>
                            <option value="desarrollador">Programador (desarrollador)</option>
                            <option value="gerente">Gerente</option>
                            <option value="asesora">Asesor (asesora)</option>
                            <option value="usuario">Usuario</option>
                        </select>
                    </div>
                    <small class="text-muted d-block">Si el rol es "Asesor", se creará automáticamente su perfil de asesor.</small>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Crear Usuario</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Edit Modal --}}
<div class="modal fade" id="editUserModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="" method="POST" id="editUserForm">
                @csrf @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Editar Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nombre completo</label>
                        <input type="text" name="name" id="edit_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Correo electrónico</label>
                        <input type="email" name="email" id="edit_email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Rol</label>
                        <select name="rol" id="edit_rol" class="form-select" required>
                            <option value="dios">Superadmin (dios)</option>
                            <option value="desarrollador">Programador (desarrollador)</option>
                            <option value="gerente">Gerente</option>
                            <option value="asesora">Asesor (asesora)</option>
                            <option value="usuario">Usuario</option>
                        </select>
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
    const editModal = document.getElementById('editUserModal');
    editModal.addEventListener('show.bs.modal', function (event) {
        const btn = event.relatedTarget;
        const id = btn.dataset.id;
        const name = btn.dataset.name;
        const email = btn.dataset.email;
        const rol = btn.dataset.rol;

        document.getElementById('edit_name').value = name;
        document.getElementById('edit_email').value = email;
        document.getElementById('edit_rol').value = rol;

        document.getElementById('editUserForm').action = '{{ route("admin.users.update", "__ID__") }}'.replace('__ID__', id);
    });
});
</script>
@endsection
