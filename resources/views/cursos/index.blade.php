<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Cursos | R&C Consulting</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background: #f5f7fa; font-family: 'Poppins', sans-serif; }
        .admin-container { max-width: 1200px; margin: 40px auto; }
        .card { border: none; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
        .table { margin-bottom: 0; }
        .table thead th { background: #0A1F5C; color: #fff; border: none; padding: 14px; font-weight: 600; }
        .table tbody td { padding: 14px; vertical-align: middle; border-color: #E5E7EB; }
        .badge-activo { background: #10B981; color: #fff; padding: 5px 12px; border-radius: 20px; font-size: 12px; }
        .badge-inactivo { background: #6B7280; color: #fff; padding: 5px 12px; border-radius: 20px; font-size: 12px; }
        .btn-acciones { display: flex; gap: 8px; }
        .btn-edit { background: #0A1F5C; color: #fff; border: none; padding: 6px 12px; border-radius: 6px; font-size: 12px; }
        .btn-edit:hover { background: #1A3A7A; }
        .btn-delete { background: #EF4444; color: #fff; border: none; padding: 6px 12px; border-radius: 6px; font-size: 12px; }
        .btn-delete:hover { background: #DC2626; }
    </style>
</head>
<body>

<div class="admin-container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 style="color: #0A1F5C;">
            <i class="fas fa-graduation-cap"></i> Administración de Cursos
        </h2>
        <div>
            <a href="{{ route('cursos.create') }}" class="btn btn-primary" style="background: #FF044D; border: none; padding: 10px 20px; border-radius: 8px;">
                <i class="fas fa-plus"></i> Nuevo Curso
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Tipo</th>
                        <th>Precio</th>
                        <th>Asesora</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cursos as $curso)
                    <tr>
                        <td>{{ $curso->id }}</td>
                        <td>
                            <strong>{{ $curso->title }}</strong><br>
                            <small class="text-muted">/curso/{{ $curso->slug }}</small>
                        </td>
                        <td>{{ $curso->type }}</td>
                        <td>
                            @if($curso->precio_flash)
                                <span style="color: #10B981; font-weight: 600;">S/ {{ $curso->precio_flash }}</span>
                                <small class="text-muted text-decoration-line-through">S/ {{ $curso->precio_regular }}</small>
                            @else
                                S/ {{ $curso->precio_regular }}
                            @endif
                        </td>
                        <td>{{ $curso->advisor->name ?? '—' }}</td>
                        <td>
                            <span class="badge-{{ $curso->status == 'activo' ? 'activo' : 'inactivo' }}">
                                {{ $curso->status ?? 'activo' }}
                            </span>
                        </td>
                        <td>
                            <div class="btn-acciones">
                                <a href="{{ route('curso.mostrar', $curso->slug) }}" target="_blank" class="btn-edit">
                                    <i class="fas fa-eye"></i> Ver
                                </a>
                                <a href="{{ route('cursos.editar', $curso->id) }}" class="btn-edit">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                                <form action="{{ route('cursos.destroy', $curso->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete" onclick="return confirm('¿Estás seguro de eliminar este curso?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <p class="text-muted mb-0">No hay cursos registrados</p>
                            <a href="{{ route('cursos.create') }}" class="btn btn-primary mt-3" style="background: #FF044D; border: none;">
                                Crear primer curso
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>