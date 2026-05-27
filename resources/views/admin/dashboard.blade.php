@extends('layouts.app-main')

@section('title', 'Dashboard | R&C Consulting')

@section('styles')
<style>
:root {
    --vercel-black: #171717;
    --vercel-white: #ffffff;
    --vercel-blue: #0a72ef;
    --shadow-border: 0px 0px 0px 1px rgba(0,0,0,0.08), 0px 2px 2px rgba(0,0,0,0.04);
}

body { background: #fafafa; }

.dashboard-header {
    padding: 2rem;
    background: var(--vercel-white);
    border-radius: 12px;
    box-shadow: var(--shadow-border);
    margin-bottom: 2rem;
}

.dashboard-header h1 {
    font-weight: 800;
    letter-spacing: -0.04em;
    font-size: 2rem;
    margin: 0;
}

.module-card {
    background: var(--vercel-white);
    border-radius: 12px;
    box-shadow: var(--shadow-border);
    border: none;
    padding: 1.5rem;
    transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    height: 100%;
}

.module-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(10, 114, 239, 0.1);
    border-color: var(--vercel-blue) !important;
}

.icon-box {
    width: 52px;
    height: 52px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
    font-size: 1.5rem;
}

.stat-number {
    font-size: 2rem;
    font-weight: 800;
    letter-spacing: -0.03em;
    margin: 0;
}

.stat-label {
    font-size: 0.875rem;
    color: #666;
    font-weight: 500;
}
</style>
@endsection

@section('content')
<div class="container py-4">
    <div class="dashboard-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1>Bienvenido, {{ auth()->user()->name }}</h1>
                <span class="badge bg-dark mt-2">{{ strtoupper(auth()->user()->rol) }}</span>
            </div>
            <div class="live-indicator">
                <span class="pulse-dot"></span> Sistema Activo
            </div>
        </div>
    </div>

    <!-- Estadísticas -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="module-card">
                <div class="d-flex align-items-center gap-3">
                    <div class="icon-box bg-primary text-white">
                        <i class="bi bi-book-fill"></i>
                    </div>
                    <div>
                        <p class="stat-number">{{ $totalCursos ?? 0 }}</p>
                        <p class="stat-label">Cursos Activos</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="module-card">
                <div class="d-flex align-items-center gap-3">
                    <div class="icon-box bg-success text-white">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <div>
                        <p class="stat-number">{{ $totalLeads ?? 0 }}</p>
                        <p class="stat-label">Leads Totales</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="module-card">
                <div class="d-flex align-items-center gap-3">
                    <div class="icon-box bg-warning text-white">
                        <i class="bi bi-person-check-fill"></i>
                    </div>
                    <div>
                        <p class="stat-number">{{ $totalAdvisors ?? 0 }}</p>
                        <p class="stat-label">Asesoras</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="module-card">
                <div class="d-flex align-items-center gap-3">
                    <div class="icon-box bg-info text-white">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <div>
                        <p class="stat-number">{{ $ventasCerradas ?? 0 }}</p>
                        <p class="stat-label">Ventas Cerradas</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Módulos de Gestión -->
    <div class="row g-3">
        @if(!in_array(auth()->user()->rol, ['asesora']))
        <div class="col-md-4">
            <a href="{{ route('cursos.create') }}" class="module-card d-block text-decoration-none text-dark">
                <div class="d-flex align-items-center gap-3">
                    <div class="icon-box bg-primary text-white">
                        <i class="bi bi-plus-circle-fill"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-1">Crear Curso</h5>
                        <small class="text-muted">Nuevo curso con miniatura</small>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="{{ route('cursos.index') }}" class="module-card d-block text-decoration-none text-dark">
                <div class="d-flex align-items-center gap-3">
                    <div class="icon-box bg-dark text-white">
                        <i class="bi bi-grid-fill"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-1">Gestionar Cursos</h5>
                        <small class="text-muted">Editar y eliminar</small>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="{{ route('admin.profesores.index') }}" class="module-card d-block text-decoration-none text-dark">
                <div class="d-flex align-items-center gap-3">
                    <div class="icon-box bg-warning text-white">
                        <i class="bi bi-person-fill"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-1">Panel Profesores</h5>
                        <small class="text-muted">Gestionar CVs (MongoDB)</small>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="{{ route('admin.users.index') }}" class="module-card d-block text-decoration-none text-dark">
                <div class="d-flex align-items-center gap-3">
                    <div class="icon-box bg-danger text-white">
                        <i class="bi bi-shield-lock-fill"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-1">Accesos y Roles</h5>
                        <small class="text-muted">Configurar usuarios</small>
                    </div>
                </div>
            </a>
        </div>
        @endif

        <div class="col-md-4">
            <a href="{{ route('admin.advisors.index') }}" class="module-card d-block text-decoration-none text-dark">
                <div class="d-flex align-items-center gap-3">
                    <div class="icon-box" style="background: #5044c2; color: white;">
                        <i class="bi bi-person-badge-fill"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-1">Asesoras</h5>
                        <small class="text-muted">Foto, celular y perfil</small>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="{{ route('leads.index') }}" class="module-card d-block text-decoration-none text-dark">
                <div class="d-flex align-items-center gap-3">
                    <div class="icon-box bg-success text-white">
                        <i class="bi bi-table"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-1">Mis Leads</h5>
                        <small class="text-muted">Ver y exportar leads de mis cursos</small>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>

<style>
.live-indicator {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    color: #10b981;
    font-weight: 600;
}

.pulse-dot {
    width: 8px;
    height: 8px;
    background: #10b981;
    border-radius: 50%;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
}
</style>
@endsection
