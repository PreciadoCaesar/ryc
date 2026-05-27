@extends('layouts.app-main')

@section('title', 'Panel de Reclamos | R&C Consulting')

@section('styles')
<style>
    .admin-section {
        padding: 40px 0 60px;
        min-height: 60vh;
    }
    .admin-table th {
        background: #0A1F5C;
        color: white;
        font-family: 'Montserrat', sans-serif;
        font-size: 13px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        vertical-align: middle;
    }
    .admin-table td {
        vertical-align: middle;
        font-size: 14px;
    }
    .admin-table .estado-select {
        padding: 4px 8px;
        border-radius: 6px;
        border: 2px solid #dee2e6;
        font-weight: 600;
        font-size: 12px;
        cursor: pointer;
        min-width: 120px;
    }
    .estado-PENDIENTE { background: #fff3cd; color: #856404; border-color: #ffc107; }
    .estado-EN_REVISION { background: #cce5ff; color: #004085; border-color: #17a2b8; }
    .estado-ATENDIDO { background: #d4edda; color: #155724; border-color: #28a745; }
    .estado-ARCHIVADO { background: #e2e3e5; color: #383d41; border-color: #6c757d; }
    .badge-archivos {
        background: #e9ecef;
        color: #495057;
        padding: 2px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }
    .search-box {
        max-width: 400px;
    }
    .toast-estado {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        min-width: 250px;
    }
    .admin-table .row-num {
        font-weight: 700;
        color: #6c757d;
        font-size: 13px;
    }
    .admin-table .codigo-link {
        font-family: 'Montserrat', sans-serif;
        font-weight: 700;
        color: #0A1F5C;
        text-decoration: none;
    }
    .admin-table .codigo-link:hover {
        text-decoration: underline;
    }
    .table-responsive {
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    }
    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }
    .empty-state i {
        font-size: 48px;
        color: #dee2e6;
    }
    @media (max-width: 768px) {
        .admin-section { padding: 20px 0 40px; }
        .admin-table th, .admin-table td { font-size: 12px; }
        .admin-table .estado-select { min-width: 100px; font-size: 11px; }
    }
</style>
@endsection

@section('content')
<section class="admin-section">
    <div class="container">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
            <div>
                <h1 class="fw-bold" style="font-family:'Montserrat',sans-serif;color:#0A1F5C;">
                    <i class="bi bi-clipboard-data"></i> Panel de Reclamos
                </h1>
                <p class="text-muted">{{ count($reclamos) }} reclamo(s) registrado(s)</p>
            </div>
            <div class="search-box">
                <input type="text" id="searchInput" class="form-control" placeholder="Buscar por código o nombre..." onkeyup="filtrarTabla()">
            </div>
        </div>

        <div id="toastContainer" class="toast-estado"></div>

        @if (!empty($error))
            <div class="alert alert-danger">{{ $error }}</div>
        @elseif (empty($reclamos))
            <div class="empty-state">
                <i class="bi bi-inbox"></i>
                <h4 class="mt-3 text-muted">No hay reclamos registrados</h4>
            </div>
        @else
        <div class="table-responsive">
            <table class="table table-hover table-bordered bg-white mb-0 admin-table" id="tablaReclamos">
                <thead>
                    <tr>
                        <th style="width:50px;">#</th>
                        <th style="width:160px;">Código</th>
                        <th>Nombre / Razón Social</th>
                        <th>Documento</th>
                        <th style="width:90px;">Fecha</th>
                        <th style="width:140px;">Estado</th>
                        <th style="width:80px;">Archivos</th>
                        <th style="width:60px;">Ver</th>
                        <th style="width:80px;">Descargar</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 1; @endphp
                    @foreach ($reclamos as $r)
                    @php
                        $searchStr = strtolower(($r['codigo_seguimiento'] ?? '') . ' ' . ($r['nombre_visible'] ?? ''));
                        $docPdf = $r['tipo_persona'] === 'natural' ? ($r['doc_numero_natural'] ?? '') : ($r['ruc_juridica'] ?? '');
                        $estadoKey = str_replace(' ', '_', $r['estado'] ?? 'PENDIENTE');
                    @endphp
                    <tr data-search="{{ $searchStr }}">
                        <td class="row-num text-center">{{ $i++ }}</td>
                        <td><a href="{{ route('libro-reclamaciones.detalle', ['codigo' => $r['codigo_seguimiento']]) }}" class="codigo-link">{{ $r['codigo_seguimiento'] }}</a></td>
                        <td>{{ $r['nombre_visible'] ?? '-' }}</td>
                        <td>{{ $r['doc_visible'] ?? '-' }}</td>
                        <td style="font-size:12px;">{{ date('d/m/Y', strtotime($r['fecha_creacion'])) }}</td>
                        <td>
                            <select class="estado-select estado-{{ $estadoKey }}" data-codigo="{{ $r['codigo_seguimiento'] }}" onchange="cambiarEstado(this)">
                                <option value="PENDIENTE" {{ ($r['estado'] ?? '') === 'PENDIENTE' ? 'selected' : '' }}>PENDIENTE</option>
                                <option value="EN REVISION" {{ ($r['estado'] ?? '') === 'EN REVISION' ? 'selected' : '' }}>EN REVISION</option>
                                <option value="ATENDIDO" {{ ($r['estado'] ?? '') === 'ATENDIDO' ? 'selected' : '' }}>ATENDIDO</option>
                                <option value="ARCHIVADO" {{ ($r['estado'] ?? '') === 'ARCHIVADO' ? 'selected' : '' }}>ARCHIVADO</option>
                            </select>
                        </td>
                        <td class="text-center">
                            @if (($r['total_archivos'] ?? 0) > 0)
                                <a href="{{ route('libro-reclamaciones.detalle', ['codigo' => $r['codigo_seguimiento']]) }}#archivos" class="badge-archivos text-decoration-none">
                                    <i class="bi bi-paperclip"></i> {{ $r['total_archivos'] }}
                                </a>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{ route('libro-reclamaciones.detalle', ['codigo' => $r['codigo_seguimiento']]) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('libro-reclamaciones.pdf', ['codigo' => $r['codigo_seguimiento'], 'documento' => $docPdf]) }}" class="btn btn-sm btn-danger" target="_blank">
                                <i class="bi bi-file-pdf"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</section>
@endsection

@section('scripts')
<script>
function cambiarEstado(select) {
    const codigo = select.dataset.codigo;
    const estado = select.value;
    const toastContainer = document.getElementById('toastContainer');

    fetch('{{ route('libro-reclamaciones.update-estado') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ codigo, estado })
    })
    .then(r => r.json())
    .then(data => {
        select.className = 'estado-select estado-' + estado.replace(/ /g, '_');
        mostrarToast(data.status === 'ok' ? 'success' : 'danger', data.mensaje);
    })
    .catch(() => {
        mostrarToast('danger', 'Error de conexión');
    });
}

function mostrarToast(tipo, mensaje) {
    const container = document.getElementById('toastContainer');
    const bg = tipo === 'success' ? '#28a745' : '#dc3545';
    const icono = tipo === 'success' ? 'bi-check-circle' : 'bi-exclamation-circle';
    container.innerHTML = `
        <div style="background:${bg};color:#fff;padding:12px 20px;border-radius:8px;box-shadow:0 4px 12px rgba(0,0,0,0.15);display:flex;align-items:center;gap:10px;">
            <i class="bi ${icono}"></i> ${mensaje}
        </div>
    `;
    setTimeout(() => container.innerHTML = '', 3000);
}

function filtrarTabla() {
    const q = document.getElementById('searchInput').value.toLowerCase();
    document.querySelectorAll('#tablaReclamos tbody tr').forEach(row => {
        row.style.display = row.dataset.search.includes(q) ? '' : 'none';
    });
}
</script>
@endsection
