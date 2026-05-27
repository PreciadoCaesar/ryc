@extends('layouts.app-main')

@section('title', 'Seguimiento Reclamo ' . ($codigo ?? '') . ' | R&C Consulting')

@section('styles')
<style>
    .result-section {
        background-color: #f4f7f6;
        padding: 40px 0 60px;
        font-family: 'Poppins', sans-serif;
        min-height: 60vh;
    }
    .codigo-badge {
        background: #212529;
        color: #fff;
        font-family: 'Montserrat', sans-serif;
        font-size: 24px;
        font-weight: 800;
        letter-spacing: 3px;
        padding: 16px 32px;
        border-radius: 12px;
        display: inline-block;
        text-align: center;
    }
    .codigo-badge small {
        display: block;
        font-size: 12px;
        font-weight: 400;
        letter-spacing: 1px;
        color: rgba(255,255,255,0.7);
        margin-bottom: 4px;
    }
    .result-card {
        background: #fff;
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        padding: 32px;
        margin-bottom: 20px;
    }
    .result-card .card-title {
        color: #0d6efd;
        font-weight: bold;
        border-bottom: 2px solid #f0f0f0;
        padding-bottom: 10px;
        font-family: 'Montserrat', sans-serif;
        margin-bottom: 20px;
    }
    .result-card .label {
        font-weight: 600;
        color: #495057;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .result-card .value {
        font-weight: 500;
        color: #212529;
        font-size: 15px;
        margin-bottom: 14px;
    }
    .error-box {
        max-width: 600px;
        margin: 60px auto;
        text-align: center;
        padding: 40px;
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    .error-box h2 {
        font-family: 'Montserrat', sans-serif;
        font-weight: 800;
        color: #dc3545;
    }
    .btn-pdf {
        border-radius: 10px;
        padding: 14px 32px;
        font-weight: 700;
        font-size: 16px;
    }
    @media print {
        .no-print { display: none !important; }
        .result-section { padding: 20px 0; background: #fff; }
        .codigo-badge { background: #212529 !important; color: #fff !important; }
    }
</style>
@endsection

@section('content')
<section class="result-section">
    <div class="container">

@if ($error)
        <div class="error-box">
            <i class="bi bi-exclamation-triangle text-danger" style="font-size: 48px;"></i>
            <h2 class="mt-3">Reclamo no encontrado</h2>
            <p class="text-muted">{{ $error }}</p>
            <a href="{{ route('libro-reclamaciones.buscar') }}" class="btn btn-primary btn-lg mt-3">
                <i class="bi bi-search"></i> Intentar de nuevo
            </a>
        </div>
@else
        <div id="pdf-content">
            <div class="text-center mb-4" style="border-bottom: 3px solid #212529; padding-bottom: 20px;">
                <img src="{{ asset('img/logo-rc-consulting-sin-fondo.webp') }}" alt="R&C Consulting" style="height:50px;margin-bottom:10px;">
                <h1 style="font-family:'Montserrat',sans-serif;font-weight:800;color:#212529;font-size:28px;">LIBRO DE RECLAMACIONES</h1>
                <p style="color:#6c757d;font-size:14px;">Código de Protección y Defensa del Consumidor - Ley N° 29571</p>
            </div>

            <div class="text-center mb-4">
                <div class="codigo-badge">
                    <small>Código de seguimiento</small>
                    {{ $reclamo['codigo_seguimiento'] }}
                </div>
                <p class="text-muted mt-2 mb-0">
                    <i class="bi bi-calendar3"></i>
                    Registrado el {{ date('d/m/Y \a \l\a\s H:i', strtotime($reclamo['fecha_creacion'])) }}
                </p>
                <div class="mt-3">
                    @php
                        $estado = $reclamo['estado'] ?? 'PENDIENTE';
                        $badgeColor = match ($estado) {
                            'PENDIENTE' => 'warning',
                            'EN REVISION' => 'info',
                            'ATENDIDO' => 'success',
                            'ARCHIVADO' => 'secondary',
                            default => 'secondary',
                        };
                        $badgeIcon = match ($estado) {
                            'PENDIENTE' => 'bi-clock',
                            'EN REVISION' => 'bi-search',
                            'ATENDIDO' => 'bi-check-circle',
                            'ARCHIVADO' => 'bi-archive',
                            default => 'bi-question-circle',
                        };
                    @endphp
                    <span class="badge bg-{{ $badgeColor }} fs-6 px-3 py-2">
                        <i class="bi {{ $badgeIcon }}"></i>
                        {{ $estado }}
                    </span>
                </div>
            </div>

            <div class="result-card">
                <h4 class="card-title"><i class="bi bi-person-fill"></i> 1. Identificación del Consumidor Reclamante</h4>
                <div class="row">
@if ($reclamo['tipo_persona'] === 'natural')
                    <div class="col-md-4">
                        <div class="label">Tipo de Persona</div>
                        <div class="value">Persona Natural</div>
                    </div>
                    <div class="col-md-4">
                        <div class="label">Tipo de Documento</div>
                        <div class="value">{{ $reclamo['doc_tipo_natural'] ?? '-' }}</div>
                    </div>
                    <div class="col-md-4">
                        <div class="label">Número de Documento</div>
                        <div class="value">{{ $reclamo['doc_numero_natural'] ?? '-' }}</div>
                    </div>
                    <div class="col-md-4">
                        <div class="label">Nombres y Apellidos</div>
                        <div class="value">{{ $reclamo['nombre_completo_natural'] ?? '-' }}</div>
                    </div>
@else
                    <div class="col-md-4">
                        <div class="label">Tipo de Persona</div>
                        <div class="value">Persona Jurídica</div>
                    </div>
                    <div class="col-md-4">
                        <div class="label">RUC</div>
                        <div class="value">{{ $reclamo['ruc_juridica'] ?? '-' }}</div>
                    </div>
                    <div class="col-md-4">
                        <div class="label">Razón Social</div>
                        <div class="value">{{ $reclamo['razon_social'] ?? '-' }}</div>
                    </div>
                    <div class="col-md-4">
                        <div class="label">Doc. del Contacto</div>
                        <div class="value">{{ $reclamo['doc_tipo_contacto'] ?? '-' }}</div>
                    </div>
                    <div class="col-md-4">
                        <div class="label">Núm. Documento Contacto</div>
                        <div class="value">{{ $reclamo['doc_num_contacto'] ?? '-' }}</div>
                    </div>
                    <div class="col-md-4">
                        <div class="label">Nombres del Contacto</div>
                        <div class="value">{{ $reclamo['nombre_contacto'] ?? '-' }}</div>
                    </div>
@endif
                    <div class="col-md-4">
                        <div class="label">Teléfono</div>
                        <div class="value">{{ $reclamo['telefono'] ?? '-' }}</div>
                    </div>
                    <div class="col-md-4">
                        <div class="label">Correo Electrónico</div>
                        <div class="value">{{ $reclamo['email'] ?? '-' }}</div>
                    </div>
                    <div class="col-12">
                        <div class="label">Dirección de Domicilio</div>
                        <div class="value">{{ $reclamo['direccion'] ?? '-' }}</div>
                    </div>
                </div>
            </div>

            <div class="result-card">
                <h4 class="card-title"><i class="bi bi-file-earmark-text-fill"></i> 2. Detalle de la Reclamación y Pedido del Consumidor</h4>
                <div class="row">
                    <div class="col-md-4">
                        <div class="label">Servicio Contratado</div>
                        <div class="value">{{ $reclamo['servicio_contratado'] ?? '-' }}</div>
                    </div>
                    <div class="col-md-4">
                        <div class="label">Tipo de Reclamación</div>
                        <div class="value">
                            <span class="badge bg-{{ $reclamo['tipo_reclamacion'] === 'Reclamo' ? 'danger' : 'warning' }}">
                                {{ $reclamo['tipo_reclamacion'] }}
                            </span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="label">Monto Reclamado (S/.)</div>
                        <div class="value">S/ {{ $reclamo['monto'] ?? '0.00' }}</div>
                    </div>
                    <div class="col-12">
                        <div class="label">Nombre del Evento / Producto</div>
                        <div class="value">{{ $reclamo['nombre_evento'] ?? '-' }}</div>
                    </div>
                </div>
            </div>

            <div class="result-card">
                <h4 class="card-title"><i class="bi bi-chat-dots-fill"></i> 3. Descripción y Pedido</h4>
                <div class="row">
                    <div class="col-12">
                        <div class="label">Descripción del incidente</div>
                        <div class="value" style="background:#f8f9fa;padding:14px;border-radius:8px;white-space:pre-wrap;">{{ $reclamo['descripcion'] ?? '-' }}</div>
                    </div>
                    <div class="col-12 mt-3">
                        <div class="label">Pedido concreto</div>
                        <div class="value" style="background:#f8f9fa;padding:14px;border-radius:8px;white-space:pre-wrap;">{{ $reclamo['pedido'] ?? '-' }}</div>
                    </div>
                </div>
            </div>

@if ($archivos)
            <div class="result-card">
                <h4 class="card-title"><i class="bi bi-paperclip"></i> 4. Archivos Adjuntos</h4>
                <ul class="list-group list-group-flush">
@foreach ($archivos as $a)
                    <li class="list-group-item d-flex align-items-center gap-3">
                        <i class="bi bi-file-pdf text-danger fs-4"></i>
                        <a href="{{ route('libro-reclamaciones.descargar', $a['id']) }}" target="_blank" class="text-decoration-none">
                            {{ $a['nombre_original'] }}
                        </a>
                    </li>
@endforeach
                </ul>
            </div>
@endif

            <div class="result-card">
                <h4 class="card-title"><i class="bi bi-flag-fill"></i> Estado del Reclamo</h4>
                <div class="text-center py-2">
                    @php
                        $estadoFinal = $reclamo['estado'] ?? 'PENDIENTE';
                        $badgeColor2 = match ($estadoFinal) {
                            'PENDIENTE' => 'warning',
                            'EN REVISION' => 'info',
                            'ATENDIDO' => 'success',
                            'ARCHIVADO' => 'secondary',
                            default => 'secondary',
                        };
                        $badgeIcon2 = match ($estadoFinal) {
                            'PENDIENTE' => 'bi-clock',
                            'EN REVISION' => 'bi-search',
                            'ATENDIDO' => 'bi-check-circle',
                            'ARCHIVADO' => 'bi-archive',
                            default => 'bi-question-circle',
                        };
                    @endphp
                    <span class="badge bg-{{ $badgeColor2 }} fs-5 px-4 py-2">
                        <i class="bi {{ $badgeIcon2 }}"></i>
                        {{ $estadoFinal }}
                    </span>
                </div>
            </div>

            <div class="result-card">
                <p class="text-muted mb-0" style="font-size:0.85rem;">
                    <strong>Observaciones:</strong> La respuesta al presente reclamo será atendida mediante correo electrónico a la dirección consignada, en un plazo no mayor a quince (15) días hábiles, conforme a lo establecido en el Código de Protección y Defensa del Consumidor (Ley N° 29571).
                </p>
            </div>
        </div>

        <div class="text-center mt-4 no-print d-flex justify-content-center gap-2">
            <a href="{{ route('libro-reclamaciones.pdf', ['codigo' => $codigo, 'documento' => $documento]) }}" class="btn btn-danger btn-pdf" target="_blank">
                <i class="bi bi-file-pdf"></i> Descargar PDF
            </a>
            <a href="{{ route('libro-reclamaciones.buscar') }}" class="btn btn-primary btn-pdf">
                <i class="bi bi-search"></i> Buscar reclamo
            </a>
        </div>
@endif

    </div>
</section>
@endsection
