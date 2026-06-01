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

/* ─── Header del Perfil ─── */
.profile-header {
    background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
    padding: 3rem 2rem;
    border-radius: 16px;
    margin: 2rem auto;
    max-width: 1100px;
    color: white;
    box-shadow: var(--shadow-border);
    position: relative;
    overflow: hidden;
}

.profile-header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -20%;
    width: 400px;
    height: 400px;
    background: radial-gradient(circle, rgba(80,68,194,0.15) 0%, transparent 70%);
    border-radius: 50%;
}

.profile-avatar {
    width: 88px;
    height: 88px;
    border-radius: 50%;
    border: 3px solid rgba(255,255,255,0.25);
    object-fit: cover;
    flex-shrink: 0;
}

.profile-section {
    max-width: 1100px;
    margin: 0 auto 2rem;
    padding: 2rem;
    background: var(--vercel-white);
    border-radius: 16px;
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

/* ─── Grid de Cards ─── */
.cursos-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 1.25rem;
}

.curso-card {
    background: #fff;
    border-radius: 14px;
    overflow: hidden;
    border: 1px solid #e8edf4;
    transition: all 0.3s ease;
    display: flex;
    flex-direction: column;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
}

.curso-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 32px rgba(0,0,0,0.1);
    border-color: transparent;
}

/* Imagen del curso */
.curso-card__img {
    position: relative;
    width: 100%;
    height: 180px;
    overflow: hidden;
    background: #f0f2f5;
}

.curso-card__img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.curso-card:hover .curso-card__img img {
    transform: scale(1.06);
}

/* Badge flotante sobre la imagen */
.curso-card__badge-status {
    position: absolute;
    top: 12px;
    right: 12px;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    backdrop-filter: blur(8px);
    box-shadow: 0 2px 8px rgba(0,0,0,0.15);
}

.curso-card__badge-status.activo {
    background: rgba(22, 163, 74, 0.9);
    color: #fff;
}

.curso-card__badge-status.completado {
    background: rgba(37, 99, 235, 0.9);
    color: #fff;
}

.curso-card__badge-status.pendiente {
    background: rgba(245, 158, 11, 0.9);
    color: #fff;
}

.curso-card__badge-status.rechazado,
.curso-card__badge-status.cancelado {
    background: rgba(239, 68, 68, 0.85);
    color: #fff;
}

/* Overlay gradiente en la parte inferior de la imagen */
.curso-card__img-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 60%;
    background: linear-gradient(transparent, rgba(0,0,0,0.4));
}

/* Cuerpo de la card */
.curso-card__body {
    padding: 1.25rem 1.25rem 1.25rem;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.curso-card__title {
    font-size: 1.05rem;
    font-weight: 600;
    line-height: 1.3;
    margin-bottom: 0.5rem;
    color: #1a1a1a;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.curso-card__meta {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.8rem;
    color: #6b7280;
    margin-bottom: 0.5rem;
}

.curso-card__meta i {
    font-size: 0.75rem;
    color: #9ca3af;
}

.curso-card__footer {
    margin-top: auto;
    padding-top: 1rem;
    display: flex;
    gap: 0.5rem;
    align-items: center;
}

.btn-card {
    flex: 1;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.6rem 1rem;
    border-radius: 10px;
    font-size: 0.85rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.25s ease;
    border: none;
    cursor: pointer;
}

.btn-card-primary {
    background: linear-gradient(135deg, #5044c2 0%, #3d2db5 100%);
    color: #fff;
}

.btn-card-primary:hover {
    background: linear-gradient(135deg, #3d2db5 0%, #2d1fa5 100%);
    transform: translateY(-1px);
    color: #fff;
    box-shadow: 0 4px 14px rgba(80,68,194,0.35);
}

.btn-card-outline {
    background: transparent;
    color: #5044c2;
    border: 1.5px solid #5044c2;
}

.btn-card-outline:hover {
    background: #5044c2;
    color: #fff;
    transform: translateY(-1px);
}

.btn-card-success {
    background: linear-gradient(135deg, #16a34a 0%, #15803d 100%);
    color: #fff;
}

.btn-card-success:hover {
    transform: translateY(-1px);
    color: #fff;
    box-shadow: 0 4px 14px rgba(22,163,74,0.35);
}

/* ─── Empty State ─── */
.empty-state {
    text-align: center;
    padding: 4rem 1rem;
    color: #94a3b8;
}

.empty-state i {
    font-size: 3.5rem;
    margin-bottom: 1rem;
    display: block;
    color: #cbd5e1;
}

/* ─── Certificados ─── */
.certificate-placeholder {
    border: 2px dashed #e2e8f0;
    border-radius: 12px;
    padding: 2rem;
    text-align: center;
    color: #94a3b8;
}

/* ─── Aula Virtual ─── */
.btn-aula-link {
    background: linear-gradient(135deg, #0a72ef 0%, #0056b3 100%);
    color: white;
    border: none;
    border-radius: 12px;
    padding: 0.85rem 2rem;
    font-weight: 600;
    font-size: 0.95rem;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.6rem;
    transition: all 0.25s ease;
}

.btn-aula-link:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(10,114,239,0.35);
    color: white;
}

/* ─── Responsive ─── */
@media (max-width: 768px) {
    .profile-header {
        padding: 2rem 1.25rem;
        flex-direction: column;
        text-align: center;
    }

    .cursos-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endsection

@section('content')
<div class="container">
    {{-- ══════ HEADER DEL PERFIL ══════ --}}
    <div class="profile-header d-flex align-items-center gap-4">
        <img src="{{ $user->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=5044c2&color=fff&size=128' }}"
             alt="{{ $user->name }}" class="profile-avatar">
        <div style="position:relative;z-index:1;">
            <h2 class="fw-bold mb-1" style="font-size:1.6rem;">{{ $user->name }}</h2>
            <p class="mb-0 opacity-75">{{ $user->email }}</p>
            <span class="badge bg-white bg-opacity-15 text-white mt-2 px-3 py-2 rounded-pill" style="font-weight:500;font-size:0.8rem;backdrop-filter:blur(4px);">
                <i class="fas fa-graduation-cap me-1"></i> Estudiante
            </span>
        </div>
    </div>

    {{-- ══════ MIS CURSOS COMPRADOS ══════ --}}
    <div class="profile-section">
        <div class="section-title">
            <i class="fas fa-book text-primary" style="color:#5044c2;"></i> Mis Cursos Comprados
            @if($purchases->isNotEmpty())
                <span class="badge bg-dark rounded-pill ms-2" style="font-weight:600;">{{ $purchases->count() }}</span>
            @endif
        </div>

        @if($purchases->isNotEmpty())
        <div class="cursos-grid">
            @foreach($purchases as $purchase)
            @php
                $course = $purchase->course;
                $s = $purchase->status;
                $imgSrc = $course && $course->image_promotion ? asset($course->image_promotion) : 'https://placehold.co/600x340/5044c2/ffffff?text=R&C';
                $fechaCompra = $purchase->purchased_at?->format('d/m/Y') ?? $purchase->created_at->format('d/m/Y');

                $statusLabel = match($s) {
                    'activo' => 'Activo',
                    'completado' => 'Completado',
                    'pendiente' => 'Pendiente',
                    'rechazado' => 'Rechazado',
                    'cancelado' => 'Cancelado',
                    default => $s
                };

                $tipoLabel = '';
                if ($course) {
                    if ($course->type === 'curso') $tipoLabel = 'Curso';
                    elseif ($course->type === 'diplomado') $tipoLabel = 'Diplomado';
                    else $tipoLabel = $course->type;
                    if ($course->mode === 'grabado') $tipoLabel .= ' Online';
                    elseif ($course->mode === 'en_vivo') $tipoLabel .= ' en Vivo';
                }
            @endphp

            <div class="curso-card">
                {{-- Imagen del curso --}}
                <div class="curso-card__img">
                    <img src="{{ $imgSrc }}" alt="{{ $course->title ?? 'Curso' }}" loading="lazy">
                    <div class="curso-card__img-overlay"></div>
                    <span class="curso-card__badge-status {{ $s }}">
                        {{ $statusLabel }}
                    </span>
                </div>

                {{-- Contenido --}}
                <div class="curso-card__body">
                    @if($tipoLabel)
                        <span style="font-size:0.72rem;font-weight:600;color:#5044c2;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:0.25rem;">
                            {{ $tipoLabel }}
                        </span>
                    @endif

                    <h3 class="curso-card__title">{{ $course->title ?? 'Curso sin título' }}</h3>

                    <div class="curso-card__meta">
                        @if($course->hours)
                            <span><i class="fas fa-clock me-1"></i>{{ $course->hours }}h</span>
                        @endif
                        @if($course->sessions)
                            <span><i class="fas fa-calendar-alt me-1"></i>{{ $course->sessions }} sesiones</span>
                        @endif
                        <span><i class="fas fa-cart-plus me-1"></i>{{ $fechaCompra }}</span>
                    </div>

                    <div class="curso-card__footer">
                        @if($s === 'activo')
                            {{-- Curso activo → Ir al curso --}}
                            <a href="{{ $course->link ?? 'https://rc-consulting.edu.pe/' }}" target="_blank" class="btn-card btn-card-primary">
                                <i class="fas fa-play-circle"></i> Ir al curso
                            </a>
                        @elseif($s === 'completado')
                            {{-- Curso completado → Descargar certificado --}}
                            <a href="#" class="btn-card btn-card-success">
                                <i class="fas fa-download"></i> Certificado
                            </a>
                            <a href="{{ $course->link ?? 'https://rc-consulting.edu.pe/' }}" target="_blank" class="btn-card btn-card-outline">
                                <i class="fas fa-external-link-alt"></i> Ver curso
                            </a>
                        @elseif($s === 'pendiente')
                            {{-- Pago pendiente --}}
                            <span class="btn-card" style="background:#fef3c7;color:#92400e;border:none;cursor:default;flex:1;text-align:center;">
                                <i class="fas fa-hourglass-half"></i> Pago en proceso
                            </span>
                        @else
                            {{-- Rechazado / Cancelado --}}
                            <span class="btn-card" style="background:#fee2e2;color:#991b1b;border:none;cursor:default;flex:1;text-align:center;">
                                <i class="fas fa-times-circle"></i> {{ $s === 'rechazado' ? 'Pago rechazado' : 'Pago cancelado' }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
            <div class="empty-state">
                <i class="fas fa-shopping-cart"></i>
                <h5 class="fw-semibold mb-2" style="color:#334155;">Aún no tienes cursos comprados</h5>
                <p class="text-muted mb-3">Explora nuestros cursos y diplomados para comenzar tu capacitación.</p>
                <a href="{{ url('/') }}" class="btn btn-card-primary px-4 py-2" style="display:inline-flex;text-decoration:none;">
                    <i class="fas fa-search me-2"></i> Ver Cursos
                </a>
            </div>
        @endif
    </div>

    {{-- ══════ CERTIFICADOS ══════ --}}
    <div class="profile-section">
        <div class="section-title">
            <i class="fas fa-award text-success"></i> Certificados
        </div>

        @php
            $completed = $purchases->where('status', 'completado');
        @endphp

        @if($completed->isNotEmpty())
            <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:1rem;">
                @foreach($completed as $purchase)
                    <div style="display:flex;align-items:center;justify-content:space-between;padding:1rem 1.25rem;border:1px solid #e2e8f0;border-radius:12px;gap:1rem;">
                        <div style="min-width:0;">
                            <h6 style="font-weight:600;margin:0 0 0.25rem;font-size:0.9rem;">{{ $purchase->course->title }}</h6>
                            <small class="text-muted">Completado el {{ $purchase->completed_at?->format('d/m/Y') ?? $purchase->purchased_at?->format('d/m/Y') ?? $purchase->created_at->format('d/m/Y') }}</small>
                        </div>
                        <a href="#" class="btn-card btn-card-success" style="flex:none;white-space:nowrap;padding:0.5rem 1rem;font-size:0.8rem;">
                            <i class="fas fa-download"></i> PDF
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <div class="certificate-placeholder">
                <i class="fas fa-award fs-1 d-block mb-2"></i>
                <p class="mb-1 fw-semibold" style="color:#475569;">Completa tus cursos para obtener tus certificados</p>
                <p class="mb-0" style="font-size:0.85rem;">Al finalizar un curso recibirás tu certificado digital.</p>
            </div>
        @endif
    </div>

    {{-- ══════ AULA VIRTUAL ══════ --}}
    <div class="profile-section d-flex flex-wrap align-items-center justify-content-between gap-3">
        <div>
            <div class="section-title mb-2">
                <i class="fas fa-play-circle" style="color:#0a72ef;"></i> Aula Virtual
            </div>
            <p class="text-muted mb-0" style="max-width:420px;">Accede a todas tus clases grabadas, materiales y recursos educativos.</p>
        </div>
        <a href="https://rc-consulting.edu.pe/" target="_blank" class="btn-aula-link">
            <i class="fas fa-external-link-alt"></i> Ir al Aula Virtual
        </a>
    </div>
</div>
@endsection
