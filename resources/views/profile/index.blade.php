@extends('layouts.app-main')

@section('title', 'Mi Perfil | R&C Consulting')

@section('styles')
<style>
:root {
    --vercel-black: #171717;
    --vercel-white: #ffffff;
    --shadow-border: 0px 0px 0px 1px rgba(0,0,0,0.08), 0px 2px 2px rgba(0,0,0,0.04);
}

body { background: #fafafa; }

.profile-header {
    background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
    padding: 3rem 2rem;
    border-radius: 16px;
    margin: 2rem auto;
    max-width: 1000px;
    color: white;
    box-shadow: var(--shadow-border);
}

.profile-avatar {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    border: 3px solid rgba(255,255,255,0.3);
    object-fit: cover;
}

.profile-section {
    max-width: 1000px;
    margin: 0 auto 2rem;
    padding: 2rem;
    background: var(--vercel-white);
    border-radius: 12px;
    box-shadow: var(--shadow-border);
}

.section-title {
    font-weight: 700;
    font-size: 1.25rem;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.course-card {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 1.25rem;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    margin-bottom: 0.75rem;
    transition: all 0.2s;
}

.course-card:hover {
    border-color: #0a72ef;
    box-shadow: 0 2px 8px rgba(10,114,239,0.08);
}

.course-card h5 {
    font-weight: 600;
    margin: 0;
    font-size: 1rem;
}

.course-card .badge {
    font-size: 0.75rem;
    padding: 0.35rem 0.75rem;
}

.btn-aula-link {
    background: #0a72ef;
    color: white;
    border: none;
    border-radius: 8px;
    padding: 0.75rem 2rem;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.2s;
}

.btn-aula-link:hover {
    background: #0056b3;
    transform: translateY(-1px);
    color: white;
}

.empty-state {
    text-align: center;
    padding: 3rem 1rem;
    color: #94a3b8;
}

.empty-state i {
    font-size: 3rem;
    margin-bottom: 1rem;
    display: block;
}

.certificate-placeholder {
    border: 2px dashed #e2e8f0;
    border-radius: 10px;
    padding: 1.5rem;
    text-align: center;
    color: #94a3b8;
}
</style>
@endsection

@section('content')
<div class="container">
    <div class="profile-header d-flex align-items-center gap-4">
        <img src="{{ $user->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=0a72ef&color=fff' }}"
             alt="{{ $user->name }}" class="profile-avatar">
        <div>
            <h2 class="fw-bold mb-1">{{ $user->name }}</h2>
            <p class="mb-0 opacity-75">{{ $user->email }}</p>
            <span class="badge bg-light text-dark mt-2">Estudiante</span>
        </div>
    </div>

    <div class="profile-section">
        <div class="section-title">
            <i class="bi bi-book-fill text-primary"></i> Mis Cursos Comprados
        </div>

        @forelse($purchases as $purchase)
            <div class="course-card">
                <div>
                    <h5>{{ $purchase->course->title }}</h5>

                    @php $s = $purchase->status; @endphp

                    @if($s === 'activo')
                        <small class="text-muted">Comprado el {{ $purchase->purchased_at?->format('d/m/Y') ?? $purchase->created_at->format('d/m/Y') }}</small>
                    @elseif($s === 'completado')
                        <small class="text-muted">Comprado el {{ $purchase->purchased_at?->format('d/m/Y') ?? $purchase->created_at->format('d/m/Y') }} — Completado</small>
                    @elseif($s === 'pendiente')
                        <small class="text-muted">Pago en proceso — {{ $purchase->created_at->format('d/m/Y') }}</small>
                    @elseif($s === 'rechazado')
                        <small class="text-muted">Pago rechazado — {{ $purchase->created_at->format('d/m/Y') }}</small>
                    @elseif($s === 'cancelado')
                        <small class="text-muted">Pago cancelado — {{ $purchase->created_at->format('d/m/Y') }}</small>
                    @endif
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-{{ $s === 'activo' ? 'success' : ($s === 'completado' ? 'info' : ($s === 'pendiente' ? 'warning text-dark' : ($s === 'rechazado' ? 'danger' : 'secondary'))) }}">
                        {{ $s === 'activo' ? 'Activo' : ($s === 'completado' ? 'Completado' : ($s === 'pendiente' ? 'Pendiente' : ($s === 'rechazado' ? 'Rechazado' : 'Cancelado'))) }}
                    </span>
                    @if($s === 'activo' || $s === 'completado')
                        <a href="{{ $purchase->course->link ?? 'https://rc-consulting.edu.pe/' }}" class="btn btn-sm btn-outline-primary" target="_blank">
                            Ir al curso
                        </a>
                    @endif
                </div>
            </div>
        @empty
            <div class="empty-state">
                <i class="bi bi-cart-x"></i>
                <p class="fw-semibold">Aún no tienes cursos comprados</p>
                <p class="text-muted">Explora nuestros cursos y diplomados para comenzar tu capacitación.</p>
                <a href="{{ url('/') }}" class="btn btn-primary mt-2">Ver Cursos</a>
            </div>
        @endforelse
    </div>

    <div class="profile-section">
        <div class="section-title">
            <i class="bi bi-patch-check-fill text-success"></i> Certificados
        </div>

        @php
            $completed = $purchases->where('status', 'completado');
        @endphp

        @if($completed->isNotEmpty())
            @foreach($completed as $purchase)
                <div class="course-card">
                    <div>
                        <h5>{{ $purchase->course->title }}</h5>
                        <small class="text-muted">Completado el {{ $purchase->completed_at?->format('d/m/Y') }}</small>
                    </div>
                    <a href="#" class="btn btn-sm btn-success">
                        <i class="bi bi-download"></i> Descargar Certificado
                    </a>
                </div>
            @endforeach
        @else
            <div class="certificate-placeholder">
                <i class="bi bi-award fs-1 d-block mb-2"></i>
                <p class="mb-0">Completa tus cursos para obtener tus certificados.</p>
            </div>
        @endif
    </div>

    <div class="profile-section">
        <div class="section-title">
            <i class="bi bi-play-circle-fill text-danger"></i> Aula Virtual
        </div>
        <p class="text-muted mb-3">Accede a todas tus clases grabadas, materiales y recursos educativos.</p>
        <a href="https://rc-consulting.edu.pe/" target="_blank" class="btn-aula-link">
            <i class="bi bi-box-arrow-up-right"></i> Ir al Aula Virtual
        </a>
    </div>
</div>
@endsection
