@extends('layouts.app-main')

@section('title', 'Gestión de Leads | R&C Consulting')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/asesora/leads.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.css">
@endsection

@section('content')
<div class="container-leads">
    <div class="header-leads">
        <h1>📊 Gestión de Leads - Asesora</h1>
        <div class="header-actions">
            <div class="status-filter">
                <button class="filter-btn active" data-filter="all">Todos</button>
                <button class="filter-btn" data-filter="ingreso">Ingreso</button>
                <button class="filter-btn" data-filter="contacto">Contacto</button>
                <button class="filter-btn" data-filter="venta cerrada">Venta Cerrada</button>
                <button class="filter-btn" data-filter="no interesado">No Interesado</button>
            </div>
            <div class="live-indicator">
                <span class="pulse-dot"></span> Tiempo Real Activo
            </div>
        </div>
    </div>

    <div class="excel-container">
        <div id="spreadsheet"></div>
    </div>

    <div class="legend">
        <span class="legend-item"><span class="color-box whatsapp"></span> Cliente WhatsApp</span>
        <span class="legend-item"><span class="color-box ingreso"></span> Ingreso</span>
        <span class="legend-item"><span class="color-box contacto"></span> Contacto</span>
        <span class="legend-item"><span class="color-box venta"></span> Venta Cerrada</span>
        <span class="legend-item"><span class="color-box no-interesado"></span> No Interesado</span>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.js"></script>
<script src="{{ asset('js/asesora-spreadsheet.js') }}"></script>
@endsection
