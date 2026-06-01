@extends('layouts.app-main')

@section('title', 'Gestor de Profesores | R&C Consulting')

@section('styles')
<link href="{{ asset('css/curso/admin.css') }}" rel="stylesheet">
<style>
:root {
  --azul: #03206A;
  --rojo: #DE004B;
  --gris: #f3f4f6;
  --gris-medio: #9ca3af;
  --texto: #1f2937;
  --texto-medio: #6b7280;
  --borde: #e5e7eb;
  --sombra: 0 1px 3px rgba(0,0,0,0.08), 0 1px 2px rgba(0,0,0,0.06);
}
body { background: #fafafa; font-family: 'Poppins', sans-serif; }
.profesores-container { max-width: 1200px; margin: 2rem auto; padding: 0 1rem; }
.header-profesores {
  display: flex; justify-content: space-between; align-items: center;
  margin-bottom: 2rem; padding: 2rem; background: #fff;
  border-radius: 12px; box-shadow: var(--sombra);
}
.header-profesores h1 { font-weight: 800; font-size: 1.75rem; margin: 0; color: var(--azul); }
.header-profesores p { font-size: 13px; color: var(--texto-medio); margin: 4px 0 0; }
.btn-primary { background: var(--azul); border: none; border-radius: 8px; padding: 10px 20px; font-weight: 700; font-size: 14px; color: #fff; cursor: pointer; transition: background 0.15s; font-family: 'Poppins', sans-serif; }
.btn-primary:hover { background: #041f52; }
.btn-secondary { background: #6b7280; border: none; border-radius: 8px; padding: 10px 20px; font-weight: 600; font-size: 13px; color: #fff; cursor: pointer; transition: background 0.15s; font-family: 'Poppins', sans-serif; }
.btn-secondary:hover { background: #4b5563; }
.alert { padding: 12px 20px; border-radius: 10px; margin-bottom: 20px; font-size: 13px; font-weight: 600; }
.alert-success { background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }
.prof-no-photo {
  width: 120px; height: 120px; border-radius: 12px; background: #e5e7eb;
  display: flex; align-items: center; justify-content: center;
  color: var(--gris-medio); font-size: 40px; border: 1px solid var(--borde);
}
.prof-card-img-wrap { width: 120px; height: 120px; border-radius: 12px; }
</style>
@endsection

@section('content')
<div class="profesores-container">
  <div class="header-profesores">
    <div>
      <h1>👨‍🏫 Gestor de Profesores</h1>
      <p>Administra los profesores disponibles globalmente.</p>
    </div>
    <button class="btn-primary" onclick="ProfesorManager.abrirModal()">
      + Nuevo Profesor
    </button>
  </div>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <div class="prof-cards-grid" id="profesoresGrid">
    @forelse($professors as $prof)
      <div class="prof-card" data-id="{{ $prof->id }}">
        @if($prof->photo)
          <div class="prof-card-img-wrap">
            <img src="{{ filter_var($prof->photo, FILTER_VALIDATE_URL) ? $prof->photo : asset('storage/' . $prof->photo) }}" alt="{{ $prof->name }}">
          </div>
        @else
          <div class="prof-no-photo">📷</div>
        @endif
        <div class="prof-card-info">
          <h4>{{ $prof->name }}</h4>
          @if($prof->secciones)
            @php
              $total = collect($prof->secciones)->sum(fn($s) => count($s['elementos'] ?? []));
            @endphp
            <small style="color:var(--texto-medio);font-size:11px;">{{ count($prof->secciones) }} secciones · {{ $total }} elementos</small>
          @endif
          @php $courseCount = $prof->courses()->count(); @endphp
          @if($courseCount > 0)
            <small style="color:var(--azul);font-size:11px;display:block;margin-top:2px;">{{ $courseCount }} curso(s) asignado(s)</small>
          @endif
        </div>
        <div class="prof-card-actions">
          <button class="btn-edit" onclick="ProfesorManager.abrirModal({{ $prof->id }})">Editar</button>
          <form action="{{ route('admin.profesores.destroy', $prof->id) }}" method="POST" onsubmit="return confirm('¿Eliminar este profesor?')" style="display:inline">
            @csrf @method('DELETE')
            <button class="btn-delete">Eliminar</button>
          </form>
        </div>
      </div>
    @empty
      <div style="grid-column:1/-1;text-align:center;padding:60px 20px;color:var(--texto-medio);">
        <div style="font-size:48px;margin-bottom:16px;">👨‍🏫</div>
        <h3 style="font-weight:600;margin-bottom:8px;">No hay profesores registrados</h3>
        <p style="font-size:13px;">Crea tu primer profesor para empezar.</p>
      </div>
    @endforelse
  </div>
</div>

{{-- Modal Profesor Global (Add/Edit) --}}
<div class="modal fade" id="modalProfesorGlobal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <form id="profesorForm" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="_method" id="prof_method" value="POST">
        <input type="hidden" name="secciones" id="seccionesInput" value="">
        <div class="modal-header">
          <h5 class="modal-title" id="modalProfesorGlobalTitle">Agregar Profesor</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="prof-form-group">
            <label>Grado y nombre completo</label>
            <input type="text" name="name" id="prof-name" placeholder="DR. MARLON PRIETO HORMAZA" required>
          </div>
          <div class="prof-form-group">
            <label>Primer nombre (ID modal)</label>
            <input type="text" name="primer_nombre" id="prof-primerNombre" placeholder="Marlon">
            <small style="color:var(--texto-medio);font-size:11px;">Se usa para identificar al profesor en landing. Si se deja vacío, se extrae automáticamente.</small>
          </div>
          <div class="prof-form-group">
            <label>Foto del profesor</label>
            <div class="prof-img-upload-row">
              <div class="prof-img-preview-wrap">
                <img id="prof-img-preview" class="prof-img-preview" src="{{ asset('img/default-avatar.png') }}" alt="Preview">
              </div>
              <div class="prof-img-inputs">
                <input type="file" id="prof-img-file" name="photo" accept="image/*" onchange="ProfesorManager.previewFile(this)">
                <small style="color:var(--texto-medio);font-size:11px;">Máx 2MB. Si no subes archivo, ingresa una URL:</small>
                <input type="text" id="prof-img-url" name="photo_url" placeholder="https://... o ./img/profesor/profesor-01.jpg" oninput="ProfesorManager.previewUrl(this.value)">
              </div>
            </div>
          </div>
          <div class="prof-form-group">
            <label>Secciones del profesor</label>
            <div id="prof-secciones-container"></div>
            <button type="button" class="btn-add" onclick="ProfesorManager.addSeccion()" style="margin-top:8px;">+ Crear Sección</button>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="button" class="btn-primary" onclick="ProfesorManager.guardar()">Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- Templates --}}
<template id="prof-seccion-template">
  <div class="prof-seccion-card">
    <div class="prof-seccion-header">
      <input type="text" class="prof-seccion-titulo" placeholder="Título de la sección (ej: Formación Profesional)">
      <button type="button" class="btn-delete-sm" onclick="ProfesorManager.removeSeccion(this)">✕</button>
    </div>
    <div class="prof-seccion-elementos"></div>
    <button type="button" class="btn-add-sm" onclick="ProfesorManager.addElemento(this)" style="margin-top:6px;">+ Elemento</button>
  </div>
</template>

<template id="prof-elemento-template">
  <div class="prof-elemento-row">
    <input type="text" class="prof-elemento-input" placeholder="Texto del elemento">
    <button type="button" class="btn-remove-xs" onclick="ProfesorManager.removeElemento(this)">✕</button>
  </div>
</template>
@endsection

@section('scripts')
<script>
var ProfesorManager = {
  editId: null,
  professors: @json($professors),

  abrirModal: function(id) {
    this.editId = id || null;
    var form = document.getElementById('profesorForm');
    var container = document.getElementById('prof-secciones-container');
    container.innerHTML = '';

    if (id) {
      var prof = this.professors.find(function(p) { return p.id == id; });
      if (!prof) return;
      document.getElementById('modalProfesorGlobalTitle').textContent = 'Editar Profesor';
      document.getElementById('prof_method').value = 'PUT';
      form.action = '{{ route("admin.profesores.update", "__ID__") }}'.replace('__ID__', id);
      document.getElementById('prof-name').value = prof.name;
      document.getElementById('prof-primerNombre').value = prof.primer_nombre || '';

      var preview = document.getElementById('prof-img-preview');
      if (prof.photo) {
        var src = prof.photo.match(/^https?:\/\//) ? prof.photo : '{{ asset("storage") }}/' + prof.photo;
        preview.src = src;
      } else {
        preview.src = '{{ asset("img/default-avatar.png") }}';
      }

      if (prof.secciones && Array.isArray(prof.secciones)) {
        prof.secciones.forEach(function(sec) {
          var secCard = this._crearSeccionCard(sec.titulo || '');
          var elemContainer = secCard.querySelector('.prof-seccion-elementos');
          (sec.elementos || []).forEach(function(elem) {
            var row = this._crearElementoRow(elem);
            elemContainer.appendChild(row);
          }.bind(this));
          container.appendChild(secCard);
        }.bind(this));
      }
    } else {
      document.getElementById('modalProfesorGlobalTitle').textContent = 'Agregar Profesor';
      document.getElementById('prof_method').value = 'POST';
      form.action = '{{ route("admin.profesores.store") }}';
      document.getElementById('prof-name').value = '';
      document.getElementById('prof-primerNombre').value = '';
      document.getElementById('prof-img-preview').src = '{{ asset("img/default-avatar.png") }}';
      document.getElementById('prof-img-file').value = '';
      document.getElementById('prof-img-url').value = '';
    }

    var modal = new bootstrap.Modal(document.getElementById('modalProfesorGlobal'));
    modal.show();
  },

  _crearSeccionCard: function(titulo) {
    var tpl = document.getElementById('prof-seccion-template');
    var clone = tpl.content.cloneNode(true);
    var card = clone.querySelector('.prof-seccion-card');
    if (titulo) card.querySelector('.prof-seccion-titulo').value = titulo;
    return card;
  },

  _crearElementoRow: function(texto) {
    var tpl = document.getElementById('prof-elemento-template');
    var clone = tpl.content.cloneNode(true);
    var row = clone.querySelector('.prof-elemento-row');
    if (texto) row.querySelector('.prof-elemento-input').value = texto;
    return row;
  },

  addSeccion: function() {
    var container = document.getElementById('prof-secciones-container');
    container.appendChild(this._crearSeccionCard(''));
  },

  removeSeccion: function(btn) {
    btn.closest('.prof-seccion-card').remove();
  },

  addElemento: function(btn) {
    var container = btn.closest('.prof-seccion-card').querySelector('.prof-seccion-elementos');
    container.appendChild(this._crearElementoRow(''));
  },

  removeElemento: function(btn) {
    btn.closest('.prof-elemento-row').remove();
  },

  previewFile: function(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        document.getElementById('prof-img-preview').src = e.target.result;
      };
      reader.readAsDataURL(input.files[0]);
      document.getElementById('prof-img-url').value = '';
    }
  },

  previewUrl: function(url) {
    if (url) {
      document.getElementById('prof-img-preview').src = url;
      document.getElementById('prof-img-file').value = '';
    }
  },

  guardar: function() {
    var container = document.getElementById('prof-secciones-container');
    var secciones = [];
    container.querySelectorAll('.prof-seccion-card').forEach(function(card) {
      var titulo = card.querySelector('.prof-seccion-titulo').value.trim();
      if (!titulo) return;
      var elementos = [];
      card.querySelectorAll('.prof-elemento-input').forEach(function(inp) {
        var val = inp.value.trim();
        if (val) elementos.push(val);
      });
      secciones.push({ titulo: titulo, elementos: elementos });
    });
    document.getElementById('seccionesInput').value = JSON.stringify(secciones);
    document.getElementById('profesorForm').submit();
  }
};
</script>
@endsection
