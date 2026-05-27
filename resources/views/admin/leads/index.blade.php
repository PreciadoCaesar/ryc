@extends('layouts.app-main')

@section('title', 'Gestión de Leads | R&C Consulting')

@section('styles')
<style>
:root {
    --vercel-black: #171717;
    --vercel-white: #ffffff;
    --vercel-blue: #0a72ef;
    --shadow-border: 0px 0px 0px 1px rgba(0,0,0,0.08), 0px 2px 2px rgba(0,0,0,0.04);
}

body { background: #fafafa; }

.leads-container {
    max-width: 1400px;
    margin: 2rem auto;
    padding: 0 1rem;
}

.header-leads {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
    padding: 2rem;
    background: var(--vercel-white);
    border-radius: 12px;
    box-shadow: var(--shadow-border);
}

.header-leads h1 {
    font-weight: 800;
    letter-spacing: -0.04em;
    font-size: 1.75rem;
    margin: 0;
}

/* === Filtros === */
.filtros-bar {
    display: flex;
    gap: 1rem;
    align-items: center;
    flex-wrap: wrap;
    padding: 1rem 2rem;
    background: var(--vercel-white);
    border-radius: 12px;
    box-shadow: var(--shadow-border);
    margin-bottom: 1.5rem;
}

.filtros-bar .filtro-label {
    font-size: 0.8rem;
    font-weight: 600;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-right: 0.25rem;
}

.filtros-bar select {
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 0.5rem 2rem 0.5rem 0.75rem;
    font-size: 0.85rem;
    background: #f8fafc;
    cursor: pointer;
    min-width: 180px;
    appearance: auto;
}

.filtros-bar .filtro-count {
    font-size: 0.85rem;
    color: #64748b;
    margin-left: auto;
}

.btn-limpiar {
    background: none;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 0.5rem 1rem;
    font-size: 0.8rem;
    color: #64748b;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-limpiar:hover {
    background: #f1f5f9;
    border-color: #cbd5e1;
}

/* === Excel container === */
.excel-container {
    background: var(--vercel-white);
    border-radius: 12px;
    box-shadow: var(--shadow-border);
    padding: 1.5rem;
    margin-bottom: 2rem;
    overflow-x: auto;
}

.course-group {
    margin-bottom: 2.5rem;
}

.course-group:last-child {
    margin-bottom: 0;
}

.course-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 1.25rem;
    background: #f8fafc;
    border-radius: 8px;
    margin-bottom: 1rem;
    border: 1px solid #e2e8f0;
}

.course-header h3 {
    font-weight: 700;
    font-size: 1.1rem;
    margin: 0;
    color: #0f172a;
}

.course-count {
    font-size: 0.8rem;
    color: #64748b;
    font-weight: 500;
}

.btn-export {
    background: #10b981;
    color: white;
    border: none;
    border-radius: 8px;
    padding: 0.75rem 1.5rem;
    font-weight: 600;
    transition: all 0.2s;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
}

.btn-export:hover {
    background: #059669;
    transform: translateY(-1px);
    color: white;
}

.btn-export-sm {
    background: #10b981;
    color: white;
    border: none;
    border-radius: 6px;
    padding: 0.4rem 0.9rem;
    font-weight: 600;
    font-size: 0.75rem;
    transition: all 0.2s;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
}

.btn-export-sm:hover {
    background: #059669;
    color: white;
}

.status-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.7rem;
    font-weight: 600;
    white-space: nowrap;
}

.status-ingreso { background: #dbeafe; color: #1e40af; }
.status-contacto { background: #fef3c7; color: #92400e; }
.status-respondido { background: #d1fae5; color: #065f46; }
.status-venta-cerrada { background: #10b981; color: white; }
.status-no-interesado { background: #fee2e2; color: #991b1b; }

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

.table th {
    font-weight: 600;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: #64748b;
    border-bottom: 2px solid #e2e8f0;
    vertical-align: middle;
    white-space: nowrap;
}

.table td {
    vertical-align: middle;
    font-size: 0.82rem;
}

.form-select-sm {
    font-size: 0.7rem;
    padding: 0.2rem 0.5rem;
}

.advisor-mini {
    display: flex;
    align-items: center;
    gap: 8px;
}

.advisor-mini-avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    object-fit: cover;
    background: #e2e8f0;
    flex-shrink: 0;
}

.advisor-mini-placeholder {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: #5044c2;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.7rem;
    font-weight: 700;
    flex-shrink: 0;
}

.btn-wsp-lead {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 5px 12px;
    border-radius: 20px;
    background: #25D366;
    color: white;
    border: none;
    font-size: 0.75rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s;
    cursor: pointer;
}

.btn-wsp-lead:hover {
    background: #1da851;
    color: white;
    transform: scale(1.03);
}

.btn-wsp-lead.small {
    padding: 3px 10px;
    font-size: 0.65rem;
}

.lead-cell-phone {
    font-size: 0.8rem;
    color: #334155;
}

.lead-actions {
    display: flex;
    align-items: center;
    gap: 6px;
    flex-wrap: nowrap;
}

/* === Tiempo respuesta badge === */
.tiempo-badge {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 2px 8px;
    border-radius: 12px;
    font-size: 0.7rem;
    font-weight: 600;
    white-space: nowrap;
}

.tiempo-rapido {
    background: #d1fae5;
    color: #065f46;
}

.tiempo-lento {
    background: #fee2e2;
    color: #991b1b;
}

.tiempo-pendiente {
    background: #f1f5f9;
    color: #94a3b8;
}

.tiempo-check {
    font-size: 0.65rem;
}

/* === Notificación toast === */
.toast-notif {
    position: fixed;
    bottom: 24px;
    right: 24px;
    background: #1e293b;
    color: white;
    padding: 16px 20px;
    border-radius: 12px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.2);
    z-index: 9999;
    max-width: 360px;
    transform: translateY(120px);
    opacity: 0;
    transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    pointer-events: none;
}

.toast-notif.show {
    transform: translateY(0);
    opacity: 1;
    pointer-events: auto;
}

.toast-notif .toast-title {
    font-weight: 700;
    font-size: 0.9rem;
    margin-bottom: 4px;
}

.toast-notif .toast-body {
    font-size: 0.8rem;
    color: #cbd5e1;
}

.toast-notif .toast-close {
    position: absolute;
    top: 8px;
    right: 12px;
    background: none;
    border: none;
    color: #94a3b8;
    cursor: pointer;
    font-size: 1.1rem;
}
</style>
@endsection

@section('content')
<div class="leads-container">
    <div class="header-leads">
        <div>
            <h1>Gestión de Leads</h1>
            @if($asesora)
                <p class="text-muted mt-2 mb-0">Asesora: <strong>{{ $asesora->name }}</strong></p>
            @else
                <p class="text-muted mt-2 mb-0">Vista general de todos los leads</p>
            @endif
        </div>
        <div class="d-flex gap-3 align-items-center">
            @if($asesora)
                <a href="{{ route('leads.export', ['advisorId' => $asesora->id]) }}" class="btn-export">
                    <i class="bi bi-download me-2"></i>Exportar Todo
                </a>
            @endif
            <div class="live-indicator">
                <span class="pulse-dot"></span> Tiempo Real Activo
            </div>
        </div>
    </div>

    {{-- Filtros para admin --}}
    @if(!$asesora)
    <form class="filtros-bar" method="GET" action="{{ route('leads.index') }}">
        <span class="filtro-label">Filtrar por:</span>

        <select name="asesora_id" onchange="this.form.submit()">
            <option value="">Todas las asesoras</option>
            @foreach($asesoras as $adv)
                <option value="{{ $adv->id }}" {{ request('asesora_id') == $adv->id ? 'selected' : '' }}>
                    {{ $adv->name }}
                </option>
            @endforeach
        </select>

        <select name="curso" onchange="this.form.submit()">
            <option value="">Todos los cursos</option>
            @foreach($todosCursos as $c)
                <option value="{{ $c }}" {{ request('curso') == $c ? 'selected' : '' }}>
                    {{ $c }}
                </option>
            @endforeach
        </select>

        @if(request()->filled('asesora_id') || request()->filled('curso'))
            <a href="{{ route('leads.index') }}" class="btn-limpiar">✕ Limpiar filtros</a>
        @endif

        <span class="filtro-count">{{ $leads->count() }} lead(s) encontrados</span>
    </form>
    @endif

    @php
        $grouped = $leads->groupBy('curso');
    @endphp

    @foreach($grouped as $courseName => $courseLeads)
        <div class="course-group">
            <div class="course-header">
                <div>
                    <h3>{{ $courseName }}</h3>
                    <span class="course-count">{{ $courseLeads->count() }} lead(s)</span>
                </div>
                <a href="{{ route('leads.export.course', ['courseName' => urlencode($courseName)]) }}" class="btn-export-sm">
                    <i class="bi bi-download"></i> Exportar Excel
                </a>
            </div>

            <div class="excel-container">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            @if(!$asesora)
                            <th>Asesora</th>
                            @endif
                            <th>Nombre</th>
                            <th>Celular</th>
                            <th>Correo</th>
                            <th>Status</th>
                            <th>⏱ Tiempo Resp.</th>
                            <th>WhatsApp</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($courseLeads as $lead)
                            <tr>
                                @if(!$asesora)
                                <td>
                                    @if($lead->advisor)
                                        <div class="advisor-mini">
                                            <img src="{{ asset($lead->advisor->photo_web ?? $lead->advisor->photo ?? '') }}"
                                                 alt=""
                                                 class="advisor-mini-avatar"
                                                 onerror="this.style.display='none';this.nextElementSibling.style.display='flex'"
                                                 style="{{ !$lead->advisor->photo && !$lead->advisor->photo_web ? 'display:none' : '' }}">
                                            <div class="advisor-mini-placeholder"
                                                 style="{{ $lead->advisor->photo || $lead->advisor->photo_web ? 'display:none' : '' }}">
                                                {{ substr($lead->advisor->name, 0, 2) }}
                                            </div>
                                            <span>{{ $lead->advisor->name }}</span>
                                        </div>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                @endif
                                <td><strong>{{ $lead->nombre }}</strong></td>
                                <td class="lead-cell-phone">{{ $lead->celular }}</td>
                                <td>{{ $lead->correo ?? '-' }}</td>
                                <td>
                                    <span class="status-badge status-{{ str_replace(' ', '-', $lead->status) }}">
                                        {{ ucfirst($lead->status) }}
                                    </span>
                                </td>
                                <td>
                                    @php
                                        $tiempoRespuesta = $lead->tiempo_respuesta;
                                        $rapido = $lead->respuesta_rapida;
                                    @endphp
                                    @if($tiempoRespuesta)
                                        <span class="tiempo-badge {{ $rapido ? 'tiempo-rapido' : 'tiempo-lento' }}">
                                            @if($rapido)<span class="tiempo-check">✅</span>@else<span class="tiempo-check">⚠️</span>@endif
                                            {{ $tiempoRespuesta }}
                                            @if($rapido)
                                                <span style="font-size:0.6rem;opacity:0.7;">≤6min</span>
                                            @endif
                                        </span>
                                    @else
                                        <span class="tiempo-badge tiempo-pendiente">—</span>
                                    @endif
                                </td>
                                <td>
                                    @if($lead->is_whatsapp)
                                        <span class="text-success" style="font-size:0.75rem;font-weight:600;">Sí</span>
                                    @else
                                        <span class="text-muted" style="font-size:0.75rem;">No</span>
                                    @endif
                                </td>
                                <td style="font-size:0.78rem;color:#64748b;">{{ $lead->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <div class="lead-actions">
                                        <select class="form-select form-select-sm" onchange="updateStatus({{ $lead->id }}, this.value)" style="width:auto;min-width:90px;">
                                            <option value="ingreso" {{ $lead->status == 'ingreso' ? 'selected' : '' }}>Ingreso</option>
                                            <option value="contacto" {{ $lead->status == 'contacto' ? 'selected' : '' }}>Contacto</option>
                                            <option value="respondido" {{ $lead->status == 'respondido' ? 'selected' : '' }}>Respondido</option>
                                            <option value="venta cerrada" {{ $lead->status == 'venta cerrada' ? 'selected' : '' }}>Venta Cerrada</option>
                                            <option value="no interesado" {{ $lead->status == 'no interesado' ? 'selected' : '' }}>No Interesado</option>
                                        </select>

                                        @php
                                            $phoneRaw = $lead->celular;
                                            $phoneClean = preg_replace('/[^0-9]/', '', $phoneRaw);
                                            if (!str_starts_with($phoneClean, '51') && strlen($phoneClean) == 9) {
                                                $phoneClean = '51' . $phoneClean;
                                            }
                                            $leadName = urlencode($lead->nombre);
                                            $courseNameEnc = urlencode($courseName);
                                            $waMsg = urlencode("Hola $lead->nombre, soy asesor(a) de R&C Consulting. Me comunico por tu consulta sobre el $courseNameEnc. ¿Podemos coordinar?");
                                        @endphp

                                        <a href="https://wa.me/{{ $phoneClean }}?text={{ $waMsg }}"
                                           class="btn-wsp-lead"
                                           target="_blank"
                                           rel="noopener"
                                           onclick="marcarContacto({{ $lead->id }})">
                                            <i class="fab fa-whatsapp" style="font-size:13px;"></i>
                                            <span>WhatsApp</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endforeach

    @if($leads->isEmpty())
        <div class="excel-container text-center py-5">
            <p class="text-muted mb-0">No hay leads registrados.</p>
        </div>
    @endif
</div>

{{-- Toast de notificación para nuevos leads --}}
<div id="leadToast" class="toast-notif">
    <button class="toast-close" onclick="cerrarToast()">✕</button>
    <div class="toast-title" id="toastTitle">Nuevo Lead</div>
    <div class="toast-body" id="toastBody">Cargando...</div>
</div>

<script>
var LEAD_UPDATE_URL = '{{ route('leads.updateStatus', ['id' => '__ID__']) }}';
var API_LEADS_URL = '{{ url('api/leads') }}';
var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]')?.content || '';
var latestId = {{ $leads->max('id') ?? 0 }};
var toastEl = document.getElementById('leadToast');
var toastTimer = null;

// === Status Update ===
function updateStatus(leadId, newStatus) {
    fetch(LEAD_UPDATE_URL.replace('__ID__', leadId), {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': CSRF_TOKEN
        },
        body: JSON.stringify({ status: newStatus })
    })
    .then(function(res) { return res.json(); })
    .then(function(data) {
        if (data.success) {
            location.reload();
        }
    });
}

function marcarContacto(leadId) {
    // Auto-marcar como "contacto" + registrar contacted_at
    fetch(LEAD_UPDATE_URL.replace('__ID__', leadId), {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': CSRF_TOKEN
        },
        body: JSON.stringify({ status: 'contacto' })
    })
    .then(function(res) { return res.json(); })
    .catch(function(err) { console.warn('Error al marcar contacto:', err); });
}

// === Toast notification ===
function mostrarToast(titulo, mensaje) {
    document.getElementById('toastTitle').textContent = titulo;
    document.getElementById('toastBody').textContent = mensaje;
    toastEl.classList.add('show');

    if (toastTimer) clearTimeout(toastTimer);
    toastTimer = setTimeout(cerrarToast, 10000);
}

function cerrarToast() {
    toastEl.classList.remove('show');
    if (toastTimer) clearTimeout(toastTimer);
}

// === Chrome Notifications ===
function pedirPermisoNotificacion() {
    if ('Notification' in window) {
        if (Notification.permission === 'default') {
            Notification.requestPermission();
        }
    }
}

function enviarNotificacion(titulo, cuerpo, icono) {
    if (!('Notification' in window)) return;
    if (Notification.permission !== 'granted') return;

    try {
        var notif = new Notification(titulo, {
            body: cuerpo,
            icon: icono || '/ryc/img/og-default.svg',
            tag: 'lead-' + Date.now(),
            requireInteraction: true
        });

        notif.onclick = function() {
            window.focus();
            this.close();
        };

        setTimeout(function() { notif.close(); }, 15000);
    } catch(e) {
        console.warn('Notificación falló:', e);
    }
}

// === Polling en tiempo real ===
function checkNewLeads() {
    var url = API_LEADS_URL + '?since_id=' + latestId;
    @if(!$asesora)
        var asesoraFiltro = '{{ request('asesora_id') }}';
        if (asesoraFiltro) url += '&advisor_id=' + asesoraFiltro;
    @endif

    fetch(url, { headers: { 'Accept': 'application/json' } })
    .then(function(res) { return res.json(); })
    .then(function(data) {
        if (Array.isArray(data) && data.length > 0) {
            var newLeads = data.filter(function(l) { return l.id > latestId; });
            newLeads.forEach(function(lead) {
                if (lead.id > latestId) latestId = lead.id;

                var titulo = '🆕 Nuevo Lead: ' + (lead.curso || 'Curso');
                var cuerpo = lead.nombre + ' - ' + (lead.celular || '');
                var icono = lead.advisor?.photo_web
                    ? '/ryc/' + lead.advisor.photo_web
                    : (lead.advisor?.photo ? '/ryc/' + lead.advisor.photo : '/ryc/img/og-default.svg');

                enviarNotificacion(titulo, cuerpo, icono);
                mostrarToast(titulo, cuerpo);
            });

            // Recargar si hay nuevos leads y la pestaña está visible
            if (newLeads.length > 0 && !document.hidden) {
                setTimeout(function() { location.reload(); }, 4000);
            }
        }
    })
    .catch(function(err) { /* silent */ });
}

// === Service Worker para notificaciones offline ===
if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('/ryc/service-worker.js').catch(function(err) {
        console.warn('ServiceWorker no disponible:', err);
    });
}

// === Inicializar ===
pedirPermisoNotificacion();
setInterval(checkNewLeads, 15000);
setTimeout(checkNewLeads, 3000);

// Recargar al volver a la pestaña si pasaron más de 30s
var lastActive = Date.now();
document.addEventListener('visibilitychange', function() {
    if (!document.hidden) {
        var elapsed = Date.now() - lastActive;
        if (elapsed > 30000) {
            location.reload();
        }
        lastActive = Date.now();
    } else {
        lastActive = Date.now();
    }
});
</script>
@endsection
