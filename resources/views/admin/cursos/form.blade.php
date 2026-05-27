@extends('layouts.app-main')

@section('content')
@php
    $isEditing = isset($curso) && $curso instanceof \App\Models\Course;
    $course = $isEditing ? $curso : null;

    // Valores harcodeados para nuevo curso
    if (!$isEditing) {
        $curso = (object) [
            'id' => null, 'type' => 'curso', 'mode' => 'en_vivo', 'status' => 'activo',
            'title' => 'CURSO SIAF WEB 2026: Práctica, Teórica y Casuística del Proceso Presupuestario...',
            'subtitle' => 'Curso SIAF WEB 2026',
            'slug' => 'curso-siaf-web-2026',
            'start_date' => '2026-06-23',
            'fecha_inicio_iso' => '2026-06-23',
            'fecha_limite_oferta' => '2026-05-28',
            'seo_description' => 'Domina el SIAF WEB 2026 con nuestro curso práctico y teórico. Aprende a gestionar y ejecutar el presupuesto público eficientemente. ¡Incluye inteligencia artificial aplicada!',
            'seo_keywords' => 'SIAF WEB, gestión pública, presupuesto público, inteligencia artificial',
            'precio_flash' => '197.00', 'precio_pronto' => '237.00', 'precio_regular' => '257.00',
            'precio_flash_fecha' => '2026-06-30',
            'sessions' => '6', 'hours' => '90',
            'tipo_certificado' => 'Curso Especializado',
            'link_brochure' => 'https://drive.google.com/...',
            'temario_titulo' => 'SIAF RP Y WEB 2026 + INTELIGENCIA ARTIFICIAL',
            'url_video_vimeo' => 'https://player.vimeo.com/video/1053551456',
            'temario_hierarchical' => [],
            'objetivos' => collect(), 'participantes' => collect(), 'profesores' => collect(), 'temario' => collect(),
            'asesora_id' => '', 'asesor_inhouse_id' => '',
            'image_promotion' => '', 'inhouse_web' => '', 'inhouse_mobile' => '',
            'specialization_name' => '', 'phrase' => '', 'description' => '',
            'link_niubiz' => '', 'seo_title' => '',
            'precio_pronto_fecha' => '', 'descripcion_inhouse' => '', 'og_image_url' => '',
        ];
    }

    // Preparar datos para las listas dinámicas
    $objetivosData = old('objetivos', $isEditing && $course->objetivos && $course->objetivos->count() > 0 ? $course->objetivos->toArray() : []);
    $participantesData = old('participantes', $isEditing && $course->participantes && $course->participantes->count() > 0 ? $course->participantes->toArray() : []);
    $hierarchicalData = old('temario_hierarchical', $isEditing ? ($curso->temario_hierarchical ?? []) : []);
    $selectedProfesores = old('profesor_ids', $isEditing && $course->profesores && $course->profesores->count() > 0 ? $course->profesores->pluck('id')->toArray() : []);
@endphp

<div class="admin-curso-container">
    <!-- HEADER -->
    <header class="admin-header">
        <h1>
            {{ $isEditing ? '✏️ Editar' : '⚙️ Nuevo' }}
            <small id="headerTypeLabel">{{ $isEditing && $course->type === 'diplomado' ? 'Diplomado' : 'Curso' }}</small>
        </h1>
        <div class="admin-header-actions">
            <button type="submit" form="cursoForm" class="btn-save-header">💾 Guardar</button>
            @if($isEditing)
                <a class="btn-preview" href="{{ route('curso.mostrar', $course->slug) }}" target="_blank">👁️ Vista previa</a>
            @endif
            <a href="{{ route('cursos.index') }}" class="btn-back">← Volver</a>
        </div>
    </header>

    <div class="admin-container">

        <form id="cursoForm" method="POST" action="{{ $isEditing ? route('cursos.update', $course->id) : route('cursos.store') }}" enctype="multipart/form-data">
            @csrf
            @if($isEditing) @method('PUT') @endif

            <!-- ==================== ERRORES ==================== -->
            @if($errors->any())
            <div class="admin-section" style="border-left:4px solid #ef4444;">
                <div class="admin-section-body" style="color:#dc2626;">
                    <ul style="margin:0;padding-left:20px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif

            <!-- ==================== TEMPLATE BAR ==================== -->
            <div class="admin-section">
                <div class="template-bar">
                    <label>Plantilla:</label>
                    <select id="templateSelect" onchange="Admin.loadSelected()">
                        <option value="">-- Nueva plantilla --</option>
                    </select>
                    <input type="text" id="templateNameInput" class="template-name-input"
                           placeholder="Nombre de plantilla"
                           value="{{ $isEditing ? $course->title : 'Mi Curso' }}">
                    <button type="button" class="btn-delete-sm" onclick="Admin.deleteCurrent()">🗑️ Eliminar</button>

                    <div class="template-divider"></div>

                    <div class="template-type-group">
                        <label>Tipo:</label>
                        <div class="type-tabs">
                            <button type="button" class="type-tab {{ !$isEditing || $course->type === 'curso' ? 'active' : '' }}"
                                    data-type="curso" onclick="selectType('curso')">Curso</button>
                            <button type="button" class="type-tab {{ $isEditing && $course->type === 'diplomado' ? 'active' : '' }}"
                                    data-type="diplomado" onclick="selectType('diplomado')">Diplomado</button>
                        </div>
                        <input type="hidden" name="type" id="typeInput" value="{{ $isEditing ? $course->type : 'curso' }}">
                    </div>

                    <div class="template-type-group">
                        <label>Modalidad:</label>
                        <div class="mode-tabs">
                            <button type="button" class="mode-tab {{ !$isEditing || $course->mode === 'en_vivo' ? 'active' : '' }}"
                                    data-mode="en_vivo" onclick="selectMode('en_vivo')">En Vivo</button>
                            <button type="button" class="mode-tab {{ $isEditing && $course->mode === 'grabado' ? 'active' : '' }}"
                                    data-mode="grabado" onclick="selectMode('grabado')">Grabado</button>
                        </div>
                        <input type="hidden" name="mode" id="modeInput" value="{{ $isEditing ? $course->mode : 'en_vivo' }}">
                    </div>
                    <div class="template-type-group">
                        <label>Estado:</label>
                        <select name="status" id="statusCurso">
                            <option value="activo" {{ $isEditing && $course->status === 'activo' ? 'selected' : '' }}>Activo</option>
                            <option value="inactivo" {{ $isEditing && $course->status === 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- ==================== 1. INFORMACIÓN DEL CURSO ==================== -->
            <div class="admin-section">
                <div class="admin-section-header" onclick="Admin.toggleSection(this)">
                    <span>💼 Información del Curso</span>
                    <span class="arrow">▼</span>
                </div>
                <div class="admin-section-body">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Título largo</label>
                            <input type="text" name="title" id="tituloCursoLargo" data-field="tituloCursoLargo"
                                   value="{{ old('title', $isEditing ? $course->title : '') }}"
                                   placeholder="Ej: Curso SIAF WEB 2026: Práctica..."
                                   oninput="Admin.autoSlug(this.value)" required>
                        </div>
                        <div class="form-group">
                            <label>Título corto</label>
                            <input type="text" name="subtitle" id="tituloCursoCorto" data-field="tituloCursoCorto"
                                   value="{{ old('subtitle', $isEditing ? $course->subtitle : '') }}"
                                   placeholder="Ej: Curso SIAF WEB 2026">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Tipo de programa</label>
                            <select id="tipoPrograma" data-field="tipoPrograma" onchange="syncTypeSelect()">
                                <option value="Curso" {{ $isEditing && $course->type === 'curso' ? 'selected' : '' }}>Curso</option>
                                <option value="Diplomado" {{ $isEditing && $course->type === 'diplomado' ? 'selected' : '' }}>Diplomado</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Modalidad</label>
                            <select id="modalidadSelect" data-field="modalidad" onchange="syncModeSelect()">
                                <option value="Online" {{ $isEditing && $course->mode === 'grabado' ? 'selected' : '' }}>Online</option>
                                <option value="En Vivo" {{ $isEditing && $course->mode === 'en_vivo' ? 'selected' : '' }}>En Vivo</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Slug URL</label>
                            <input type="text" name="slug" id="slugUrl" data-field="slugUrl"
                                   value="{{ old('slug', $isEditing ? $course->slug : '') }}"
                                   placeholder="curso-siaf-web-2026">
                        </div>
                        <div class="form-group">
                            <label>Fecha de inicio</label>
                            <input type="date" name="start_date" id="fechaInicio" data-field="fechaInicio"
                                   value="{{ old('start_date', $isEditing ? $course->start_date : '') }}"
                                   placeholder="2026-06-23">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Fecha ISO</label>
                            <input type="date" name="fecha_inicio_iso" id="fechaInicioISO" data-field="fechaInicioISO"
                                   value="{{ old('fecha_inicio_iso', $isEditing ? $course->fecha_inicio_iso : '') }}"
                                   placeholder="2026-06-23">
                        </div>
                        <div class="form-group">
                            <label>Fecha límite oferta</label>
                            <input type="date" name="fecha_limite_oferta" id="fechaLimiteOferta" data-field="fechaLimiteOferta"
                                   value="{{ old('fecha_limite_oferta', $isEditing ? $course->fecha_limite_oferta : '') }}"
                                   placeholder="2026-05-28">
                        </div>
                    </div>
                    <div class="form-row full">
                        <div class="form-group">
                            <label>Descripción del curso</label>
                            <textarea name="description" id="descripcionCurso" data-field="descripcionCurso"
                                      placeholder="Descripción breve del curso que aparece debajo de las estadísticas en la landing" style="min-height:80px;">{{ old('description', $isEditing ? $course->description : '') }}</textarea>
                        </div>
                    </div>
                    <div class="form-row full">
                        <div class="form-group">
                            <label>Descripción SEO</label>
                            <textarea name="seo_description" id="descripcionSEO" data-field="descripcionSEO"
                                      placeholder="Meta description (155 caracteres)">{{ old('seo_description', $isEditing ? $course->seo_description : '') }}</textarea>
                        </div>
                    </div>
                    <div class="form-row full">
                        <div class="form-group">
                            <label>Keywords</label>
                            <input type="text" name="seo_keywords" id="keywords" data-field="keywords"
                                   value="{{ old('seo_keywords', $isEditing ? $course->seo_keywords : '') }}"
                                   placeholder="SIAF WEB, gestión pública, presupuesto">
                        </div>
                    </div>
                </div>
            </div>

            <!-- ==================== 2. PRECIOS ==================== -->
            <div class="admin-section">
                <div class="admin-section-header" onclick="Admin.toggleSection(this)">
                    <span>💰 Precios</span>
                    <span class="arrow">▼</span>
                </div>
                <div class="admin-section-body">
                    <div class="form-row triple">
                        <div class="form-group">
                            <label>Precio Oferta (S/)</label>
                            <input type="number" step="0.01" name="precio_flash" id="precioOferta" data-field="precioOferta"
                                   value="{{ old('precio_flash', $isEditing ? $course->precio_flash : '') }}"
                                   oninput="Admin.calcAhorro()" placeholder="197.00">
                        </div>
                        <div class="form-group">
                            <label>Pronto Pago (S/)</label>
                            <input type="number" step="0.01" name="precio_pronto" id="precioProntoPago" data-field="precioProntoPago"
                                   value="{{ old('precio_pronto', $isEditing ? $course->precio_pronto : '') }}"
                                   placeholder="237.00">
                        </div>
                        <div class="form-group">
                            <label>Precio Regular (S/)</label>
                            <input type="number" step="0.01" name="precio_regular" id="precioRegular" data-field="precioRegular"
                                   value="{{ old('precio_regular', $isEditing ? $course->precio_regular : '') }}"
                                   oninput="Admin.calcAhorro()" placeholder="257.00">
                        </div>
                    </div>
                    <div class="form-row triple">
                        <div class="form-group">
                            <label>Ahorro (auto)</label>
                            <input type="text" id="ahorro" readonly
                                   value="{{ $isEditing && $course->precio_regular && $course->precio_flash ? max(0, round($course->precio_regular - $course->precio_flash)) : '60' }}">
                        </div>
                        <div class="form-group">
                            <label>Válido oferta hasta</label>
                            <input type="date" name="precio_flash_fecha" id="precioFlashFecha" data-field="precioFlashFecha"
                                   value="{{ old('precio_flash_fecha', $isEditing ? $course->precio_flash_fecha : '') }}"
                                   placeholder="2026-06-30">
                        </div>
                        <div class="form-group">
                            <label>Válido pronto pago hasta</label>
                            <input type="date" name="precio_pronto_fecha" id="precioProntoFecha" data-field="precioProntoFecha"
                                   value="{{ old('precio_pronto_fecha', $isEditing ? $course->precio_pronto_fecha : '') }}"
                                   placeholder="2026-06-30">
                        </div>
                    </div>
                </div>
            </div>

            <!-- ==================== 3. SESIONES Y CONTENIDO ==================== -->
            <div class="admin-section">
                <div class="admin-section-header" onclick="Admin.toggleSection(this)">
                    <span>📚 Sesiones y Contenido</span>
                    <span class="arrow">▼</span>
                </div>
                <div class="admin-section-body">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Número de sesiones</label>
                            <input type="number" name="sessions" id="numeroSesiones" data-field="numeroSesiones"
                                   value="{{ old('sessions', $isEditing ? $course->sessions : '') }}"
                                   placeholder="6">
                        </div>
                        <div class="form-group">
                            <label>Horas de certificación</label>
                            <input type="number" name="hours" id="horasCertificacion" data-field="horasCertificacion"
                                   value="{{ old('hours', $isEditing ? $course->hours : '') }}"
                                   placeholder="90">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Tipo de certificado</label>
                            <input type="text" name="tipo_certificado" id="tipoCertificado" data-field="tipoCertificado"
                                   value="{{ old('tipo_certificado', $isEditing ? $course->tipo_certificado : '') }}"
                                   placeholder="Curso Especializado / Diploma Especializado">
                        </div>
                        <div class="form-group">
                            <label>URL Brochure PDF</label>
                            <input type="url" name="link_brochure" id="urlBrochurePDF" data-field="urlBrochurePDF"
                                   value="{{ old('link_brochure', $isEditing ? $course->link_brochure : '') }}"
                                   placeholder="https://drive.google.com/...">
                        </div>
                    </div>
                    <div class="form-row full">
                        <div class="form-group">
                            <label>Título del temario</label>
                            <input type="text" name="temario_titulo" id="temarioTitulo" data-field="temarioTitulo"
                                   value="{{ old('temario_titulo', $isEditing ? $course->temario_titulo : '') }}"
                                   placeholder="SIAF RP Y WEB 2026 + INTELIGENCIA ARTIFICIAL">
                        </div>
                    </div>
                </div>
            </div>

            <!-- ==================== 4. MULTIMEDIA ==================== -->
            <div class="admin-section">
                <div class="admin-section-header" onclick="Admin.toggleSection(this)">
                    <span>📷 Multimedia</span>
                    <span class="arrow">▼</span>
                </div>
                <div class="admin-section-body">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Imagen portada video</label>
                            <input type="text" name="image_promotion_text" id="imgPortadaVideo" data-field="imgPortadaVideo"
                                   value="{{ old('image_promotion_text', $isEditing ? ($course->image_promotion ?? '') : '') }}"
                                   placeholder="./img/portada.jpg" class="mb-1">
                            <input type="file" name="image_promotion" accept="image/*" onchange="previewFile(this, 'promoPreview')">
                            @if($isEditing && $course->image_promotion)
                                <img id="promoPreview" src="{{ asset($course->image_promotion) }}" class="preview-img-sm">
                            @else
                                <img id="promoPreview" class="preview-img-sm" style="display:none">
                            @endif
                        </div>
                        <div class="form-group">
                            <label>URL Video Vimeo</label>
                            <input type="url" name="url_video_vimeo" id="urlVideoVimeo" data-field="urlVideoVimeo"
                                   value="{{ old('url_video_vimeo', $isEditing ? $course->url_video_vimeo : '') }}"
                                   placeholder="https://player.vimeo.com/video/...">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>OG Image URL</label>
                            <input type="url" name="og_image_url" id="ogImageURL" data-field="ogImageURL"
                                   value="{{ old('og_image_url', $isEditing ? $course->og_image_url : '') }}"
                                   placeholder="https://...og-image.jpg">
                        </div>
                        <div class="form-group">
                            <label>Imagen InHouse Desktop</label>
                            <input type="file" name="inhouse_web" id="imgInhouseDesktop" data-field="imgInhouseDesktop"
                                   accept="image/*" onchange="previewFile(this, 'inhouseWebPreview')">
                            @if($isEditing && $course->inhouse_web)
                                <img id="inhouseWebPreview" src="{{ asset($course->inhouse_web) }}" class="preview-img-sm">
                            @else
                                <img id="inhouseWebPreview" class="preview-img-sm" style="display:none">
                            @endif
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Imagen InHouse Mobile</label>
                            <input type="file" name="inhouse_mobile" id="imgInhouseMobile" data-field="imgInhouseMobile"
                                   accept="image/*" onchange="previewFile(this, 'inhouseMobilePreview')">
                            @if($isEditing && $course->inhouse_mobile)
                                <img id="inhouseMobilePreview" src="{{ asset($course->inhouse_mobile) }}" class="preview-img-sm">
                            @else
                                <img id="inhouseMobilePreview" class="preview-img-sm" style="display:none">
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Descripción InHouse</label>
                            <input type="text" name="descripcion_inhouse" id="descripcionInhouse" data-field="descripcionInhouse"
                                   value="{{ old('descripcion_inhouse', $isEditing ? $course->descripcion_inhouse : '') }}"
                                   placeholder="Texto promocional corto...">
                        </div>
                    </div>
                </div>
            </div>

            <!-- ==================== 5. ASESORA ==================== -->
            <div class="admin-section">
                <div class="admin-section-header" onclick="Admin.toggleSection(this)">
                    <span>👩 Asesora</span>
                    <span class="arrow">▼</span>
                </div>
                <div class="admin-section-body">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Seleccionar asesora</label>
                            <select name="asesora_id" id="asesoraId">
                                <option value="">-- Seleccionar asesora --</option>
                                @foreach($asesoras as $asesora)
                                    <option value="{{ $asesora->id }}" {{ old('asesora_id', $curso->asesora_id ?? '') == $asesora->id ? 'selected' : '' }}>
                                        {{ $asesora->name }} {{ $asesora->whatsapp ? '- ' . $asesora->whatsapp : '' }}
                                    </option>
                                @endforeach
                            </select>
                            <small style="color:#6b7280;font-size:11px;">Nombre, teléfono y foto se toman del perfil de la asesora</small>
                        </div>
                    </div>
                    @if($isEditing && $course->advisor)
                    <div style="display:flex;align-items:center;gap:12px;margin-top:8px;padding:8px 12px;background:#f3f4f6;border-radius:8px;">
                        @if($course->advisor->photo)
                            <img src="{{ asset($course->advisor->photo) }}" style="width:48px;height:48px;border-radius:50%;object-fit:cover;">
                        @endif
                        <div>
                            <strong>{{ $course->advisor->name }}</strong><br>
                            <span style="font-size:12px;color:#6b7280;">{{ $course->advisor->whatsapp ?? '' }}</span>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- ==================== 6. ASESOR INHOUSE ==================== -->
            <div class="admin-section">
                <div class="admin-section-header" onclick="Admin.toggleSection(this)">
                    <span>👨‍💼 Asesor InHouse</span>
                    <span class="arrow">▼</span>
                </div>
                <div class="admin-section-body">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Seleccionar asesor InHouse</label>
                            <select name="asesor_inhouse_id" id="asesorInhouseId">
                                <option value="">-- Seleccionar asesor InHouse --</option>
                                @foreach($asesoresInhouse as $inhouse)
                                    <option value="{{ $inhouse->id }}" {{ old('asesor_inhouse_id', $curso->asesor_inhouse_id ?? '') == $inhouse->id ? 'selected' : '' }}>
                                        {{ $inhouse->name }} {{ $inhouse->whatsapp ? '- ' . $inhouse->whatsapp : '' }}
                                    </option>
                                @endforeach
                            </select>
                            <small style="color:#6b7280;font-size:11px;">Nombre, teléfono y foto se toman del perfil del asesor</small>
                        </div>
                    </div>
                    @if($isEditing && $course->asesorInhouse)
                    <div style="display:flex;align-items:center;gap:12px;margin-top:8px;padding:8px 12px;background:#f3f4f6;border-radius:8px;">
                        @if($course->asesorInhouse->photo)
                            <img src="{{ asset($course->asesorInhouse->photo) }}" style="width:48px;height:48px;border-radius:50%;object-fit:cover;">
                        @endif
                        <div>
                            <strong>{{ $course->asesorInhouse->name }}</strong><br>
                            <span style="font-size:12px;color:#6b7280;">{{ $course->asesorInhouse->whatsapp ?? '' }}</span>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- ==================== 7. OBJETIVOS ==================== -->
            <div class="admin-section">
                <div class="admin-section-header" onclick="Admin.toggleSection(this)">
                    <span>🎯 Objetivos de Aprendizaje</span>
                    <span class="arrow">▼</span>
                </div>
                <div class="admin-section-body">
                    <div class="dynamic-list" id="objetivosList">
                        @if(count($objetivosData) > 0)
                            @foreach($objetivosData as $idx => $obj)
                            <div class="dynamic-item" data-index="{{ $idx }}">
                                <button type="button" class="btn-remove" onclick="Admin.removeItem('objetivos', this)">✕</button>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Título</label>
                                        <input type="text" name="objetivos[{{ $idx }}][titulo]" class="field-titulo"
                                               value="{{ $obj['titulo'] ?? '' }}"
                                               placeholder="Ej: Excelencia en la Formación de Funcionarios:">
                                    </div>
                                    <div class="form-group">
                                        <label>Descripción</label>
                                        <input type="text" name="objetivos[{{ $idx }}][descripcion]" class="field-descripcion"
                                               value="{{ $obj['descripcion'] ?? '' }}"
                                               placeholder="Texto del objetivo">
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @else
                        <div class="dynamic-item" data-index="0">
                            <button type="button" class="btn-remove" onclick="Admin.removeItem('objetivos', this)">✕</button>
                            <div class="form-row">
                                <div class="form-group">
                                    <label>Título</label>
                                    <input type="text" name="objetivos[0][titulo]" class="field-titulo"
                                           placeholder="Ej: Excelencia en la Formación de Funcionarios:">
                                </div>
                                <div class="form-group">
                                    <label>Descripción</label>
                                    <input type="text" name="objetivos[0][descripcion]" class="field-descripcion"
                                           placeholder="Texto del objetivo">
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    <button type="button" class="btn-add" onclick="Admin.addItem('objetivos', {titulo:'', descripcion:''})">+ Añadir objetivo</button>
                </div>
            </div>

            <!-- ==================== 8. PARTICIPANTES ==================== -->
            <div class="admin-section">
                <div class="admin-section-header" onclick="Admin.toggleSection(this)">
                    <span>👥 ¿Quiénes deben participar?</span>
                    <span class="arrow">▼</span>
                </div>
                <div class="admin-section-body">
                    <div class="dynamic-list" id="participantesList">
                        @if(count($participantesData) > 0)
                            @foreach($participantesData as $idx => $part)
                            <div class="dynamic-item" data-index="{{ $idx }}">
                                <button type="button" class="btn-remove" onclick="Admin.removeItem('participantes', this)">✕</button>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Título</label>
                                        <input type="text" name="participantes[{{ $idx }}][titulo]" class="field-titulo"
                                               value="{{ $part['titulo'] ?? '' }}"
                                               placeholder="Ej: Servidores Públicos y Planeamiento:">
                                    </div>
                                    <div class="form-group">
                                        <label>Descripción</label>
                                        <input type="text" name="participantes[{{ $idx }}][descripcion]"
                                               value="{{ $part['descripcion'] ?? '' }}"
                                               class="field-descripcion" placeholder="Texto del perfil">
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @else
                        <div class="dynamic-item" data-index="0">
                            <button type="button" class="btn-remove" onclick="Admin.removeItem('participantes', this)">✕</button>
                            <div class="form-row">
                                <div class="form-group">
                                    <label>Título</label>
                                    <input type="text" name="participantes[0][titulo]" class="field-titulo"
                                           placeholder="Ej: Servidores Públicos y Planeamiento:">
                                </div>
                                <div class="form-group">
                                    <label>Descripción</label>
                                    <input type="text" name="participantes[0][descripcion]" class="field-descripcion"
                                           placeholder="Texto del perfil">
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    <button type="button" class="btn-add" onclick="Admin.addItem('participantes', {titulo:'', descripcion:''})">+ Añadir participante</button>
                </div>
            </div>

            <!-- ==================== 9. TEMARIO JERÁRQUICO ==================== -->
            <div class="admin-section">
                <div class="admin-section-header" onclick="Admin.toggleSection(this)">
                    <span>📖 Temario Jerárquico (Cursos ➔ Módulos ➔ Sesiones)</span>
                    <span class="arrow">▼</span>
                </div>
                <div class="admin-section-body">
                    <p style="font-size:12px;color:#6b7280;margin-bottom:12px;">
                        Estructura: <strong>Curso</strong> → <strong>Módulo</strong> → <strong>Sesión</strong>.
                        Dentro de cada sesión agrega <strong>Subtítulo</strong>, <strong>Texto</strong> o <strong>Lista</strong>.
                    </p>
                    <input type="hidden" name="temario_hierarchical" id="temarioHierarchicalInput" value="">
                    <div class="dynamic-list" id="temarioHierarchy"></div>
                    <div style="display:flex;gap:8px;flex-wrap:wrap;margin-top:4px;">
                        <button type="button" class="btn-add" onclick="Admin.addCurso()">+ Añadir Curso</button>
                        <button type="button" class="btn-add" onclick="Admin.addModuloGlobal()">+ Añadir Módulo</button>
                        <button type="button" class="btn-add" onclick="Admin.addSesionGlobal()">+ Añadir Sesión</button>
                    </div>
                </div>
            </div>

            <!-- ==================== 10. PROFESORES ==================== -->
            <div class="admin-section">
                <div class="admin-section-header" onclick="Admin.toggleSection(this)">
                    <span>👨‍🏫 Profesores</span>
                    <span class="arrow">▼</span>
                </div>
                <div class="admin-section-body">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Seleccionar profesores</label>
                            <select name="profesor_ids[]" multiple style="min-height:150px;width:100%;">
                                @foreach($profesores as $profesor)
                                    <option value="{{ $profesor->id }}" {{ in_array($profesor->id, $selectedProfesores) ? 'selected' : '' }}>
                                        {{ $profesor->name }}
                                    </option>
                                @endforeach
                            </select>
                            <small style="color:#6b7280;font-size:11px;">Mantén presionada Ctrl (Windows) o Cmd (Mac) para seleccionar múltiples</small>
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>

<!-- Toast -->
<div id="toast" class="toast"></div>

<style>
/* ─── INLINE CSS (misma apariencia que admin.css) ─── */
*, *::before, *::after { box-sizing: border-box; }

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

.admin-curso-container {
  font-family: 'Poppins', sans-serif;
  background: var(--gris);
  color: var(--texto);
  line-height: 1.5;
  min-height: 100vh;
}

.admin-header {
  background: var(--azul);
  color: #fff;
  padding: 16px 24px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  position: sticky;
  top: 0;
  z-index: 100;
  box-shadow: 0 2px 8px rgba(0,0,0,0.15);
}
.admin-header h1 { font-size: 18px; font-weight: 700; display: flex; align-items: center; gap: 10px; margin:0; }
.admin-header h1 small { font-weight: 400; font-size: 13px; opacity: 0.7; }
.admin-header-actions { display: flex; gap: 10px; align-items: center; }
.admin-header-actions button,
.admin-header-actions a {
  padding: 8px 16px; border-radius: 8px; border: none; font-size: 13px;
  font-weight: 600; cursor: pointer; text-decoration: none;
  display: inline-flex; align-items: center; gap: 6px; transition: all 0.15s;
}
.btn-save-header { background: #10b981; color: #fff; }
.btn-save-header:hover { background: #059669; }
.btn-preview { background: #3b82f6; color: #fff; }
.btn-preview:hover { background: #2563eb; }
.btn-back { background: rgba(255,255,255,0.15); color: #fff; border:1px solid rgba(255,255,255,0.3) !important; }
.btn-back:hover { background: rgba(255,255,255,0.25); }

.admin-container { max-width: 960px; margin: 24px auto; padding: 0 16px; }

.admin-section {
  background: #fff; border-radius: 12px; margin-bottom: 16px;
  box-shadow: var(--sombra); overflow: hidden;
}
.admin-section-header {
  padding: 14px 20px; font-size: 14px; font-weight: 700; color: var(--azul);
  cursor: pointer; display: flex; align-items: center; justify-content: space-between;
  user-select: none; border-bottom: 1px solid var(--borde); transition: background 0.15s;
}
.admin-section-header:hover { background: #f9fafb; }
.admin-section-header .arrow { transition: transform 0.2s; font-size: 12px; }
.admin-section-header.collapsed .arrow { transform: rotate(-90deg); }
.admin-section-body { padding: 16px 20px; }
.admin-section-body.hidden { display: none; }

.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 12px; }
.form-row.full { grid-template-columns: 1fr; }
.form-row.triple { grid-template-columns: 1fr 1fr 1fr; }

.form-group { display: flex; flex-direction: column; gap: 4px; }
.form-group label {
  font-size: 12px; font-weight: 600; color: var(--texto-medio);
  text-transform: uppercase; letter-spacing: 0.3px;
}
.form-group input, .form-group select, .form-group textarea {
  padding: 8px 12px; border: 1.5px solid var(--borde); border-radius: 8px;
  font-size: 13px; font-family: 'Poppins', sans-serif; transition: border-color 0.15s; background: #fff;
}
.form-group input:focus, .form-group select:focus, .form-group textarea:focus {
  outline: none; border-color: var(--azul); box-shadow: 0 0 0 3px rgba(3,32,106,0.08);
}
.form-group input[readonly] { background: var(--gris); color: var(--texto-medio); cursor: not-allowed; }
.form-group textarea { min-height: 60px; resize: vertical; }

.dynamic-list { display: flex; flex-direction: column; gap: 12px; }
.dynamic-item {
  background: var(--gris); border-radius: 8px; padding: 12px; position: relative; border: 1px solid var(--borde);
}
.dynamic-item .btn-remove {
  position: absolute; top: 8px; right: 8px; width: 24px; height: 24px; border-radius: 50%;
  border: none; background: #ef4444; color: #fff; font-size: 14px; cursor: pointer;
  display: flex; align-items: center; justify-content: center; transition: background 0.15s;
}
.dynamic-item .btn-remove:hover { background: #dc2626; }

.btn-add {
  padding: 8px 16px; border: 2px dashed var(--borde); border-radius: 8px;
  background: transparent; color: var(--texto-medio); font-size: 13px; font-weight: 600;
  cursor: pointer; transition: all 0.15s; display: inline-flex; align-items: center; gap: 6px; margin-top: 4px;
}
.btn-add:hover { border-color: var(--azul); color: var(--azul); background: rgba(3,32,106,0.04); }

.preview-img-sm { max-width: 150px; max-height: 100px; border-radius: 6px; margin-top: 6px; border:1px solid var(--borde); }

/* Template bar */
.template-bar {
  display: flex; gap: 10px; align-items: center; flex-wrap: wrap;
  padding: 12px 20px; background: #f9fafb;
}
.template-bar select {
  padding: 8px 12px; border: 1.5px solid var(--borde); border-radius: 8px;
  font-size: 13px; font-family: 'Poppins', sans-serif; min-width: 200px;
}
.template-bar select:focus { outline: none; border-color: var(--azul); }
.template-bar label { font-size: 12px; font-weight: 600; color: var(--texto-medio); white-space:nowrap; }
.template-name-input {
  padding: 8px 12px; border: 1.5px solid var(--borde); border-radius: 8px;
  font-size: 13px; font-family: 'Poppins', sans-serif; min-width: 180px;
}
.template-name-input:focus { outline: none; border-color: var(--azul); }
.btn-delete-sm { background: #ef4444; color: #fff; border: none; padding:6px 12px; border-radius:6px; cursor:pointer; font-size:13px; }
.btn-delete-sm:hover { background: #dc2626; }
.template-divider { width:1px; height:30px; background:var(--borde); }
.template-type-group { display:flex; align-items:center; gap:8px; }
.type-tabs, .mode-tabs { display:flex; gap:4px; }
.type-tab, .mode-tab {
  padding:6px 14px; border:1.5px solid var(--borde); border-radius:6px;
  background:#fff; cursor:pointer; font-size:12px; font-weight:600; color:var(--texto-medio);
  transition:all 0.15s;
}
.type-tab.active, .mode-tab.active { background:var(--azul); color:#fff; border-color:var(--azul); }
.type-tab:hover:not(.active), .mode-tab:hover:not(.active) { border-color:var(--azul); color:var(--azul); }

/* Toast */
.toast {
  position: fixed; bottom: 24px; right: 24px; padding: 12px 20px; border-radius: 8px;
  color: #fff; font-size: 13px; font-weight: 600; box-shadow: 0 4px 12px rgba(0,0,0,0.15);
  opacity: 0; transform: translateY(20px); transition: all 0.3s; z-index: 999;
}
.toast.show { opacity: 1; transform: translateY(0); }
.toast.success { background: #10b981; }
.toast.error { background: #ef4444; }

/* === HIERARCHICAL TEMARIO === */
.h-level { margin-bottom:10px; border-radius:8px; border:1px solid var(--borde); overflow:hidden; }
.curso-level { background:#eef2ff; border-left:4px solid #1a252f; }
.standalone-modulo-level { background:#fef9e7; border-left:4px solid #f59e0b; }
.standalone-sesion-level { background:#f0fdf4; border-left:4px solid #10b981; }
.modulo-level { background:#f8fafc; border-left:4px solid #2c3e50; margin:8px 0 8px 16px; }
.sesion-level { background:#fff; border-left:4px solid #3b82f6; margin:6px 0 6px 32px; }

.h-header { display:flex; align-items:center; gap:8px; padding:8px 10px; flex-wrap:wrap; cursor:pointer; user-select:none; }
.h-arrow { font-size:10px; transition:transform .2s; flex-shrink:0; color:var(--texto-medio); }
.h-header.collapsed .h-arrow { transform:rotate(-90deg); }
.h-body.hidden { display:none; }
.h-badge { font-size:10px; font-weight:700; padding:2px 8px; border-radius:4px; text-transform:uppercase; letter-spacing:0.5px; white-space:nowrap; flex-shrink:0; }
.curso-badge { background:#1a252f; color:#fff; }
.modulo-badge { background:#2c3e50; color:#fff; }
.sesion-badge { background:#3b82f6; color:#fff; }
.subtitulo-badge { background:#8b5cf6; color:#fff; }
.lista-badge { background:#10b981; color:#fff; }
.texto-badge { background:#6b7280; color:#fff; }

.h-input { flex:1; min-width:120px; padding:6px 10px; border:1.5px solid var(--borde); border-radius:6px; font-size:13px; font-family:'Poppins',sans-serif; background:#fff; }
.h-input:focus { outline:none; border-color:var(--azul); box-shadow:0 0 0 2px rgba(3,32,106,0.08); }
.h-textarea { width:100%; padding:6px 10px; border:1.5px solid var(--borde); border-radius:6px; font-size:13px; font-family:'Poppins',sans-serif; resize:vertical; background:#fff; }
.h-textarea:focus { outline:none; border-color:var(--azul); box-shadow:0 0 0 2px rgba(3,32,106,0.08); }
.h-lecturas { padding:4px 10px 8px 10px; }
.h-lecturas label { font-size:11px; font-weight:600; color:var(--texto-medio); text-transform:uppercase; letter-spacing:0.3px; display:block; margin-bottom:3px; }
.h-children { padding:4px 10px 8px 10px; }
.h-contenido-items { padding:4px 10px 8px 10px; }
.h-contenido-item { display:flex; flex-direction:column; gap:2px; margin-bottom:4px; padding:3px 0; }
.h-contenido-header { display:flex; align-items:center; gap:6px; }
.h-contenido-item .h-input { font-size:12px; }
.h-add-bar { display:flex; gap:6px; margin-top:6px; flex-wrap:wrap; }
.btn-remove-sm, .btn-remove-xs { border-radius:50%; border:none; background:#ef4444; color:#fff; cursor:pointer; display:inline-flex; align-items:center; justify-content:center; flex-shrink:0; transition:background 0.15s; }
.btn-remove-sm { width:24px; height:24px; font-size:12px; }
.btn-remove-xs { width:20px; height:20px; font-size:10px; }
.btn-remove-sm:hover, .btn-remove-xs:hover { background:#dc2626; }
.btn-add-sm {
  padding:6px 14px; border:2px dashed var(--borde); border-radius:6px; background:transparent;
  color:var(--texto-medio); font-size:12px; font-weight:600; cursor:pointer; transition:all 0.15s; margin:4px 0;
}
.btn-add-sm:hover { border-color:var(--azul); color:var(--azul); background:rgba(3,32,106,0.04); }
.btn-move-sm, .btn-move-xs {
  border-radius:4px; border:1px solid var(--borde); background:#fff; color:var(--texto-medio);
  font-size:11px; cursor:pointer; display:inline-flex; align-items:center; justify-content:center; flex-shrink:0; padding:0; line-height:1; transition:all 0.15s;
}
.btn-move-sm { width:22px; height:22px; }
.btn-move-xs { width:20px; height:20px; font-size:10px; }
.btn-move-sm:hover:not(:disabled), .btn-move-xs:hover:not(:disabled) { background:var(--gris); color:var(--azul); border-color:var(--azul); }
.btn-move-sm:disabled, .btn-move-xs:disabled { opacity:0.3; cursor:not-allowed; }
.btn-add-xs {
  padding:4px 10px; border:1.5px dashed var(--borde); border-radius:4px; background:transparent;
  color:var(--texto-medio); font-size:11px; font-weight:600; cursor:pointer; transition:all 0.15s;
}
.btn-add-xs:hover { border-color:var(--azul); color:var(--azul); background:rgba(3,32,106,0.04); }
.h-elementos-wrap { margin-left:28px; padding:2px 0; display:flex; flex-direction:column; gap:2px; }
.h-elemento-row { display:flex; align-items:center; gap:6px; }
.h-elem-bullet { width:5px; height:5px; border-radius:50%; background:var(--texto-medio); flex-shrink:0; display:inline-block; }
.h-elemento-row .h-input { font-size:12px; }

@media (max-width: 768px) {
  .form-row { grid-template-columns: 1fr; }
  .form-row.triple { grid-template-columns: 1fr; }
  .admin-header { flex-direction: column; gap: 12px; }
  .admin-header-actions { width: 100%; justify-content: center; flex-wrap: wrap; }
  .template-bar { flex-direction: column; align-items: stretch; }
  .template-bar select, .template-name-input { min-width: auto; }
  .template-type-group { flex-direction: column; align-items: flex-start; }
  .h-header { flex-wrap: wrap; }
  .h-input { min-width: 80px; }
  .modulo-level { margin-left: 8px; }
  .sesion-level { margin-left: 16px; }
}
</style>

<script>
// ======================================================================
// ADMIN.JS PORTED TO LARAVEL FORM (alineado con cesar-plantilla/admin.js)
// ======================================================================

var Admin = {
  currentState: {},

  init: function() {
    var self = this;
    var last = RCEngine ? RCEngine.loadLastTemplate() : null;
    this.currentState = last ? JSON.parse(JSON.stringify(last)) : {};

    this._loadHierarchicalData();

    if (RCEngine) this.refreshTemplateList();
    this.bindFormToState();
    this.renderTemarioHierarchy();
    this.calcAhorro();

    document.addEventListener('input', function() {
      self.calcAhorro();
    });
  },

  toggleSection: function(header) {
    var body = header.nextElementSibling;
    if (!body) return;
    header.classList.toggle('collapsed');
    body.classList.toggle('hidden');
  },

  bindFormToState: function() {
    var self = this;
    document.querySelectorAll('[data-field]').forEach(function(el) {
      var field = el.dataset.field;
      if (self.currentState[field] !== undefined && !el.value) {
        el.value = self.currentState[field];
      }
    });
  },

  calcAhorro: function() {
    var reg = parseFloat(document.getElementById('precioRegular')?.value) || 0;
    var ofe = parseFloat(document.getElementById('precioOferta')?.value) || 0;
    var ahorro = Math.max(0, Math.round(reg - ofe));
    var el = document.getElementById('ahorro');
    if (el) el.value = String(ahorro);
  },

  autoSlug: function(value) {
    var slugInput = document.getElementById('slugUrl');
    if (!slugInput || slugInput.value) return;
    slugInput.value = value.toLowerCase()
      .replace(/[^\w\s-]/g, '')
      .replace(/[\s_]+/g, '-')
      .replace(/^-+|-+$/g, '');
  },

  // ─── DYNAMIC LISTS (objetivos, participantes, profesores) ───
  addItem: function(key, defaults) {
    var container = document.getElementById(key + 'List');
    if (!container) return;
    var items = container.querySelectorAll('.dynamic-item');
    var idx = items.length;
    var div = document.createElement('div');
    div.className = 'dynamic-item';

    var html = '<button type="button" class="btn-remove" onclick="Admin.removeItem(\'' + key + '\', this)">✕</button>';

    if (key === 'objetivos') {
      html += '<div class="form-row">'
        + '<div class="form-group"><label>Título</label>'
        + '<input type="text" name="objetivos[' + idx + '][titulo]" class="field-titulo" placeholder="Ej: Excelencia en la Formación de Funcionarios:"></div>'
        + '<div class="form-group"><label>Descripción</label>'
        + '<input type="text" name="objetivos[' + idx + '][descripcion]" class="field-descripcion" placeholder="Texto del objetivo"></div>'
        + '</div>';
    } else if (key === 'participantes') {
      html += '<div class="form-row">'
        + '<div class="form-group"><label>Título</label>'
        + '<input type="text" name="participantes[' + idx + '][titulo]" class="field-titulo" placeholder="Ej: Servidores Públicos y Planeamiento:"></div>'
        + '<div class="form-group"><label>Descripción</label>'
        + '<input type="text" name="participantes[' + idx + '][descripcion]" class="field-descripcion" placeholder="Texto del perfil"></div>'
        + '</div>';
    }

    div.innerHTML = html;
    container.appendChild(div);
  },

  removeItem: function(key, btn) {
    var item = btn.closest('.dynamic-item');
    if (!item) return;
    item.remove();
  },

  // ─── TEMPLATE MANAGEMENT ───
  refreshTemplateList: function() {
    if (!RCEngine) return;
    var sel = document.getElementById('templateSelect');
    if (!sel) return;
    var names = RCEngine.listTemplates();
    sel.innerHTML = '<option value="">-- Nueva plantilla --</option>';
    names.forEach(function(name) {
      var opt = document.createElement('option');
      opt.value = name;
      opt.textContent = name;
      sel.appendChild(opt);
    });
    var last = localStorage.getItem('rc-last-template') || '';
    if (last && names.indexOf(last) !== -1) {
      sel.value = last;
      document.getElementById('templateNameInput').value = last;
    }
  },

  loadSelected: function() {
    if (!RCEngine) return;
    var sel = document.getElementById('templateSelect');
    if (!sel || !sel.value) return;
    var saved = RCEngine.loadTemplate(sel.value);
    if (saved) {
      this.currentState = JSON.parse(JSON.stringify(saved));
      this.bindFormToState();
      this.calcAhorro();
      document.getElementById('templateNameInput').value = sel.value;
      this.showToast('Plantilla "' + sel.value + '" cargada', 'success');
    }
  },

  saveCurrent: function() {
    if (!RCEngine) return;
    var name = document.getElementById('templateNameInput')?.value.trim();
    if (!name) {
      this.showToast('Ingresa un nombre para la plantilla', 'error');
      return;
    }
    var state = {};
    document.querySelectorAll('[data-field]').forEach(function(el) {
      state[el.dataset.field] = el.value;
    });
    RCEngine.saveTemplate(name, state);
    this.refreshTemplateList();
    document.getElementById('templateSelect').value = name;
    this.showToast('Plantilla "' + name + '" guardada localmente', 'success');
  },

  deleteCurrent: function() {
    if (!RCEngine) return;
    var sel = document.getElementById('templateSelect');
    if (!sel || !sel.value) {
      this.showToast('Selecciona una plantilla para eliminar', 'error');
      return;
    }
    if (!confirm('¿Eliminar la plantilla "' + sel.value + '"?')) return;
    RCEngine.deleteTemplate(sel.value);
    this.refreshTemplateList();
    this.showToast('Plantilla eliminada', 'success');
  },

  showToast: function(msg, type) {
    var toast = document.getElementById('toast');
    if (!toast) return;
    toast.textContent = msg;
    toast.className = 'toast ' + type + ' show';
    setTimeout(function() { toast.classList.remove('show'); }, 2500);
  },

  // ─── HELPER FOR HIERARCHICAL DATA ───
  _getHierarchicalData: function() {
    try {
      var input = document.getElementById('temarioHierarchicalInput');
      if (input && input.value) {
        return JSON.parse(input.value);
      }
    } catch(e) {}
    return @json($hierarchicalData);
  },

  // ─── LOAD HIERARCHICAL DATA FROM PHP ───
  _loadHierarchicalData: function() {
    var data = this._getHierarchicalData();
    if (!data || !Array.isArray(data) || data.length === 0) return;
    this.currentState.cursos = [];
    this.currentState.modulos = [];
    this.currentState.sesiones = [];
    data.forEach(function(item) {
      if (item.tipo === 'curso') {
        this.currentState.cursos.push(item);
      } else if (item.tipo === 'modulo') {
        this.currentState.modulos.push(item);
      } else if (item.tipo === 'sesion') {
        this.currentState.sesiones.push(item);
      }
    }, this);
  },

  // ─── MOVE ARRAY ITEM HELPER ───
  _moveArrayItem: function(arr, idx, dir) {
    var target = idx + dir;
    if (target < 0 || target >= arr.length) return;
    var tmp = arr[idx];
    arr[idx] = arr[target];
    arr[target] = tmp;
  },

  // ─── GET/SET SESIONES BY PATH (como admin.js) ───
  _getSesionesByPath: function(ci, mi) {
    if (ci === -2) {
      return this.currentState.sesiones || null;
    }
    if (ci === -1) {
      var modulos = this.currentState.modulos || [];
      return modulos[mi] ? modulos[mi].sesiones || [] : null;
    }
    if (mi >= 0) {
      var cursos = this.currentState.cursos || [];
      if (!cursos[ci]) return null;
      var modulos = cursos[ci].modulos || [];
      return modulos[mi] ? modulos[mi].sesiones || [] : null;
    }
    var cursos = this.currentState.cursos || [];
    return cursos[ci] ? cursos[ci].sesiones || [] : null;
  },

  _setSesionesByPath: function(ci, mi, sesiones) {
    if (ci === -2) {
      this.currentState.sesiones = sesiones;
    } else if (ci === -1) {
      var modulos = this.currentState.modulos || [];
      if (modulos[mi]) modulos[mi].sesiones = sesiones;
      this.currentState.modulos = modulos;
    } else if (mi >= 0) {
      var cursos = this.currentState.cursos || [];
      if (cursos[ci] && cursos[ci].modulos[mi]) cursos[ci].modulos[mi].sesiones = sesiones;
    } else {
      var cursos = this.currentState.cursos || [];
      if (cursos[ci]) cursos[ci].sesiones = sesiones;
    }
  },

  // ─── TEMARIO JERÁRQUICO (como cesar-plantilla/admin.js) ───
  renderTemarioHierarchy: function() {
    var container = document.getElementById('temarioHierarchy');
    if (!container) return;
    container.innerHTML = '';

    var cursos = this.currentState.cursos || [];
    var modulos = this.currentState.modulos || [];
    var sesiones = this.currentState.sesiones || [];
    var self = this;

    cursos.forEach(function(curso, ci) {
      container.appendChild(self._createCursoElement(curso, ci));
    });
    modulos.forEach(function(mod, mi) {
      container.appendChild(self._createStandaloneModuloElement(mod, mi));
    });
    sesiones.forEach(function(ses, si) {
      container.appendChild(self._createStandaloneSesionElement(ses, si));
    });
  },

  _createCursoElement: function(curso, ci) {
    var self = this;
    var div = document.createElement('div');
    div.className = 'h-level curso-level';
    div.dataset.ci = ci;

    var totalCursos = (this.currentState.cursos || []).length;

    var header = document.createElement('div');
    header.className = 'h-header curso-header';
    header.innerHTML = '<span class="h-badge curso-badge">CURSO</span>'
      + '<button type="button" class="btn-move-sm" onclick="Admin.moveCurso(' + ci + ',-1)"' + (ci === 0 ? ' disabled' : '') + ' title="Subir">▲</button>'
      + '<button type="button" class="btn-move-sm" onclick="Admin.moveCurso(' + ci + ',1)"' + (ci === totalCursos - 1 ? ' disabled' : '') + ' title="Bajar">▼</button>'
      + '<span class="h-arrow">▼</span>'
      + '<input class="h-input curso-titulo" value="' + this._escAttr(curso.titulo || '') + '" placeholder="Título del curso">'
      + '<button type="button" class="btn-remove-sm" onclick="Admin.removeCurso(' + ci + ')" title="Eliminar curso">✕</button>';
    header.onclick = function(e) {
      if (e.target.tagName === 'INPUT' || e.target.tagName === 'BUTTON' || e.target.tagName === 'TEXTAREA') return;
      var body = this.nextElementSibling;
      if (!body) return;
      this.classList.toggle('collapsed');
      body.classList.toggle('hidden');
    };
    div.appendChild(header);

    var body = document.createElement('div');
    body.className = 'h-body';

    // Lecturas
    var lectDiv = document.createElement('div');
    lectDiv.className = 'h-lecturas';
    lectDiv.innerHTML = '<label>Lecturas Previas (HTML)</label>'
      + '<textarea class="h-textarea curso-lecturas" placeholder="<p><strong>Lecturas Previas Obligatorias:</strong></p>..." style="min-height:50px;">'
      + this._escAttr(curso.lecturasPrevias || '') + '</textarea>';
    body.appendChild(lectDiv);

    // Módulos hijos
    var modulos = curso.modulos || [];
    var modWrap = document.createElement('div');
    modWrap.className = 'h-children modulos-wrap';
    modulos.forEach(function(mod, mi) {
      modWrap.appendChild(self._createModuloElement(mod, ci, mi));
    });
    var addModBtn = document.createElement('button');
    addModBtn.type = 'button';
    addModBtn.className = 'btn-add-sm';
    addModBtn.textContent = '+ Añadir Módulo';
    addModBtn.onclick = function() { Admin._addModuloToCurso(ci); };
    modWrap.appendChild(addModBtn);
    body.appendChild(modWrap);

    // Sesiones directas del curso (sin módulo)
    var sesWrap = document.createElement('div');
    sesWrap.className = 'h-children sesiones-wrap';
    if (modulos.length === 0) {
      var sesDirectas = curso.sesiones || [];
      sesDirectas.forEach(function(ses, si) {
        sesWrap.appendChild(self._createSesionElement(ses, ci, -1, si));
      });
      var addSesBtn = document.createElement('button');
      addSesBtn.type = 'button';
      addSesBtn.className = 'btn-add-sm';
      addSesBtn.textContent = '+ Añadir Sesión (directa)';
      addSesBtn.onclick = function() { Admin._addSesionToCurso(ci); };
      sesWrap.appendChild(addSesBtn);
    }
    body.appendChild(sesWrap);
    div.appendChild(body);
    return div;
  },

  _createModuloElement: function(mod, ci, mi) {
    var self = this;
    var div = document.createElement('div');
    div.className = 'h-level modulo-level';
    div.dataset.ci = ci;
    div.dataset.mi = mi;

    var totalMods = ((this.currentState.cursos || [])[ci]?.modulos || []).length;

    var header = document.createElement('div');
    header.className = 'h-header modulo-header';
    header.innerHTML = '<span class="h-badge modulo-badge">MÓDULO</span>'
      + '<button type="button" class="btn-move-sm" onclick="Admin.moveModulo(' + ci + ',' + mi + ',-1)"' + (mi === 0 ? ' disabled' : '') + ' title="Subir">▲</button>'
      + '<button type="button" class="btn-move-sm" onclick="Admin.moveModulo(' + ci + ',' + mi + ',1)"' + (mi === totalMods - 1 ? ' disabled' : '') + ' title="Bajar">▼</button>'
      + '<span class="h-arrow">▼</span>'
      + '<input class="h-input modulo-titulo" value="' + this._escAttr(mod.titulo || '') + '" placeholder="Título del módulo">'
      + '<button type="button" class="btn-remove-sm" onclick="Admin.removeModulo(' + ci + ',' + mi + ')" title="Eliminar módulo">✕</button>';
    header.onclick = function(e) {
      if (e.target.tagName === 'INPUT' || e.target.tagName === 'BUTTON' || e.target.tagName === 'TEXTAREA') return;
      var body = this.nextElementSibling;
      if (!body) return;
      this.classList.toggle('collapsed');
      body.classList.toggle('hidden');
    };
    div.appendChild(header);

    var body = document.createElement('div');
    body.className = 'h-body';

    var sesiones = mod.sesiones || [];
    var sesWrap = document.createElement('div');
    sesWrap.className = 'h-children sesiones-wrap';
    sesiones.forEach(function(ses, si) {
      sesWrap.appendChild(self._createSesionElement(ses, ci, mi, si));
    });
    var addSesBtn = document.createElement('button');
    addSesBtn.type = 'button';
    addSesBtn.className = 'btn-add-sm';
    addSesBtn.textContent = '+ Añadir Sesión';
    addSesBtn.onclick = function() { Admin._addSesionToModulo(ci, mi); };
    sesWrap.appendChild(addSesBtn);
    body.appendChild(sesWrap);
    div.appendChild(body);
    return div;
  },

  _createSesionElement: function(ses, ci, mi, si) {
    var self = this;
    var div = document.createElement('div');
    div.className = 'h-level sesion-level';

    var removeFn;
    if (ci === -2) {
      removeFn = 'Admin.removeSesionStandaloneItem(' + si + ')';
    } else if (ci === -1) {
      removeFn = 'Admin.removeSesionStandalone(' + mi + ',' + si + ')';
    } else if (mi >= 0) {
      removeFn = 'Admin.removeSesion(' + ci + ',' + mi + ',' + si + ')';
    } else {
      removeFn = 'Admin.removeSesionDirect(' + ci + ',' + si + ')';
    }

    var totalSes = (this._getSesionesByPath(ci, mi) || []).length;

    var header = document.createElement('div');
    header.className = 'h-header sesion-header';
    header.innerHTML = '<span class="h-badge sesion-badge">SESIÓN</span>'
      + '<button type="button" class="btn-move-sm" onclick="Admin.moveSesion(' + ci + ',' + mi + ',' + si + ',-1)"' + (si === 0 ? ' disabled' : '') + ' title="Subir">▲</button>'
      + '<button type="button" class="btn-move-sm" onclick="Admin.moveSesion(' + ci + ',' + mi + ',' + si + ',1)"' + (si === totalSes - 1 ? ' disabled' : '') + ' title="Bajar">▼</button>'
      + '<span class="h-arrow">▼</span>'
      + '<input class="h-input sesion-titulo" value="' + this._escAttr(ses.titulo || '') + '" placeholder="Título de la sesión">'
      + '<button type="button" class="btn-remove-sm" onclick="' + removeFn + '" title="Eliminar sesión">✕</button>';
    header.onclick = function(e) {
      if (e.target.tagName === 'INPUT' || e.target.tagName === 'BUTTON' || e.target.tagName === 'TEXTAREA') return;
      var body = this.nextElementSibling;
      if (!body) return;
      this.classList.toggle('collapsed');
      body.classList.toggle('hidden');
    };
    div.appendChild(header);

    var body = document.createElement('div');
    body.className = 'h-body';

    var contWrap = document.createElement('div');
    contWrap.className = 'h-contenido-items';
    contWrap.id = 'contenido-' + ci + '-' + mi + '-' + si;

    var raw = ses.contenido || [];
    var items = typeof raw === 'string' ? [] : raw;
    items.forEach(function(item, ii) {
      contWrap.appendChild(self._createContenidoItem(item, ci, mi, si, ii));
    });

    var addBar = document.createElement('div');
    addBar.className = 'h-add-bar';
    addBar.innerHTML = '<button type="button" class="btn-add-xs" onclick="Admin.addContenidoItem(' + ci + ',' + mi + ',' + si + ',\'subtitulo\')">+ Subtítulo</button>'
      + '<button type="button" class="btn-add-xs" onclick="Admin.addContenidoItem(' + ci + ',' + mi + ',' + si + ',\'texto\')">+ Texto</button>'
      + '<button type="button" class="btn-add-xs" onclick="Admin.addContenidoItem(' + ci + ',' + mi + ',' + si + ',\'lista\')">+ Lista</button>';
    contWrap.appendChild(addBar);

    body.appendChild(contWrap);
    div.appendChild(body);
    return div;
  },

  _createStandaloneModuloElement: function(mod, mi) {
    var self = this;
    var div = document.createElement('div');
    div.className = 'h-level curso-level standalone-modulo-level';
    div.dataset.mi = mi;

    var totalMods = (this.currentState.modulos || []).length;

    var header = document.createElement('div');
    header.className = 'h-header curso-header';
    header.innerHTML = '<span class="h-badge modulo-badge">MÓDULO</span>'
      + '<button type="button" class="btn-move-sm" onclick="Admin.moveModuloStandalone(' + mi + ',-1)"' + (mi === 0 ? ' disabled' : '') + ' title="Subir">▲</button>'
      + '<button type="button" class="btn-move-sm" onclick="Admin.moveModuloStandalone(' + mi + ',1)"' + (mi === totalMods - 1 ? ' disabled' : '') + ' title="Bajar">▼</button>'
      + '<span class="h-arrow">▼</span>'
      + '<input class="h-input modulo-titulo" value="' + this._escAttr(mod.titulo || '') + '" placeholder="Título del módulo">'
      + '<button type="button" class="btn-remove-sm" onclick="Admin.removeModuloStandalone(' + mi + ')" title="Eliminar módulo">✕</button>';
    header.onclick = function(e) {
      if (e.target.tagName === 'INPUT' || e.target.tagName === 'BUTTON' || e.target.tagName === 'TEXTAREA') return;
      var body = this.nextElementSibling;
      if (!body) return;
      this.classList.toggle('collapsed');
      body.classList.toggle('hidden');
    };
    div.appendChild(header);

    var body = document.createElement('div');
    body.className = 'h-body';
    var sesWrap = document.createElement('div');
    sesWrap.className = 'h-children sesiones-wrap';
    var sesiones = mod.sesiones || [];
    sesiones.forEach(function(ses, si) {
      sesWrap.appendChild(self._createSesionElement(ses, -1, mi, si));
    });
    var addBtn = document.createElement('button');
    addBtn.type = 'button';
    addBtn.className = 'btn-add-sm';
    addBtn.textContent = '+ Añadir Sesión';
    addBtn.onclick = function() { Admin._addSesionToModulo(-1, mi); };
    sesWrap.appendChild(addBtn);
    body.appendChild(sesWrap);
    div.appendChild(body);
    return div;
  },

  _createStandaloneSesionElement: function(ses, si) {
    var self = this;
    var div = document.createElement('div');
    div.className = 'h-level sesion-level standalone-sesion-level';
    div.dataset.ci = -2;
    div.dataset.mi = -1;
    div.dataset.si = si;

    var totalSesiones = (this._getSesionesByPath(-2, -1) || []).length;

    var header = document.createElement('div');
    header.className = 'h-header sesion-header';
    header.innerHTML = '<span class="h-badge sesion-badge">SESIÓN</span>'
      + '<button type="button" class="btn-move-sm" onclick="Admin.moveSesion(-2,-1,' + si + ',-1)"' + (si === 0 ? ' disabled' : '') + ' title="Subir">▲</button>'
      + '<button type="button" class="btn-move-sm" onclick="Admin.moveSesion(-2,-1,' + si + ',1)"' + (si === totalSesiones - 1 ? ' disabled' : '') + ' title="Bajar">▼</button>'
      + '<span class="h-arrow">▼</span>'
      + '<input class="h-input sesion-titulo" value="' + this._escAttr(ses.titulo || '') + '" placeholder="Título de la sesión">'
      + '<button type="button" class="btn-remove-sm" onclick="Admin.removeSesionStandaloneItem(' + si + ')" title="Eliminar sesión">✕</button>';
    header.onclick = function(e) {
      if (e.target.tagName === 'INPUT' || e.target.tagName === 'BUTTON' || e.target.tagName === 'TEXTAREA') return;
      var body = this.nextElementSibling;
      if (!body) return;
      this.classList.toggle('collapsed');
      body.classList.toggle('hidden');
    };
    div.appendChild(header);

    var body = document.createElement('div');
    body.className = 'h-body';

    var contWrap = document.createElement('div');
    contWrap.className = 'h-contenido-items';
    contWrap.id = 'contenido--2--1-' + si;

    var raw = ses.contenido || [];
    var items = typeof raw === 'string' ? [] : raw;
    items.forEach(function(item, ii) {
      contWrap.appendChild(self._createContenidoItem(item, -2, -1, si, ii));
    });

    var addBar = document.createElement('div');
    addBar.className = 'h-add-bar';
    addBar.innerHTML = '<button type="button" class="btn-add-xs" onclick="Admin.addContenidoItem(-2,-1,' + si + ',\'subtitulo\')">+ Subtítulo</button>'
      + '<button type="button" class="btn-add-xs" onclick="Admin.addContenidoItem(-2,-1,' + si + ',\'texto\')">+ Texto</button>'
      + '<button type="button" class="btn-add-xs" onclick="Admin.addContenidoItem(-2,-1,' + si + ',\'lista\')">+ Lista</button>';
    contWrap.appendChild(addBar);

    body.appendChild(contWrap);
    div.appendChild(body);
    return div;
  },

  _createContenidoItem: function(item, ci, mi, si, ii) {
    var self = this;
    var badgeClass = item.tipo === 'subtitulo' ? 'subtitulo-badge'
      : item.tipo === 'texto' ? 'texto-badge' : 'lista-badge';

    var totalItems = (this._getSesionesByPath(ci, mi)?.[si]?.contenido || []).length;

    var div = document.createElement('div');
    div.className = 'h-contenido-item';
    div.dataset.ii = ii;

    var headerRow = document.createElement('div');
    headerRow.className = 'h-contenido-header';
    headerRow.innerHTML = '<span class="h-badge ' + badgeClass + '">' + (item.tipo || 'lista').toUpperCase() + '</span>'
      + '<button type="button" class="btn-move-xs" onclick="Admin.moveContenidoItem(' + ci + ',' + mi + ',' + si + ',' + ii + ',-1)"' + (ii === 0 ? ' disabled' : '') + ' title="Subir">▲</button>'
      + '<button type="button" class="btn-move-xs" onclick="Admin.moveContenidoItem(' + ci + ',' + mi + ',' + si + ',' + ii + ',1)"' + (ii === totalItems - 1 ? ' disabled' : '') + ' title="Bajar">▼</button>'
      + '<input class="h-input contenido-texto" value="' + this._escAttr(item.texto || '') + '" placeholder="Texto del ' + (item.tipo || 'elemento') + '">'
      + '<button type="button" class="btn-remove-xs" onclick="Admin.removeContenidoItem(' + ci + ',' + mi + ',' + si + ',' + ii + ')" title="Eliminar">✕</button>';
    div.appendChild(headerRow);

    if (item.tipo === 'lista') {
      var elemWrap = document.createElement('div');
      elemWrap.className = 'h-elementos-wrap';
      var elementos = item.elementos || [];
      elementos.forEach(function(elem, ei) {
        var row = document.createElement('div');
        row.className = 'h-elemento-row';
        row.innerHTML = '<span class="h-elem-bullet"></span>'
          + '<input class="h-input elemento-texto" value="' + self._escAttr(elem) + '" placeholder="Elemento">'
          + '<button type="button" class="btn-remove-xs" onclick="Admin.removeListaElement(' + ci + ',' + mi + ',' + si + ',' + ii + ',' + ei + ')" title="Eliminar">✕</button>';
        elemWrap.appendChild(row);
      });
      var addBtn = document.createElement('button');
      addBtn.type = 'button';
      addBtn.className = 'btn-add-xs';
      addBtn.textContent = '+ elemento';
      addBtn.onclick = function() { Admin.addListaElement(ci, mi, si, ii); };
      elemWrap.appendChild(addBtn);
      div.appendChild(elemWrap);
    }

    return div;
  },

  // ─── ADD ITEMS TO HIERARCHY ───
  addCurso: function() {
    this.syncStateFromForm();
    var cursos = this.currentState.cursos || [];
    cursos.push({ tipo: 'curso', titulo: 'CURSO ' + (cursos.length + 1) + ': NUEVO CURSO', lecturasPrevias: '', modulos: [], sesiones: [] });
    this.currentState.cursos = cursos;
    this.renderTemarioHierarchy();
  },

  addModuloGlobal: function() {
    this.syncStateFromForm();
    var modulos = this.currentState.modulos || [];
    modulos.push({ tipo: 'modulo', titulo: 'MÓDULO ' + (modulos.length + 1) + ': NUEVO MÓDULO', sesiones: [] });
    this.currentState.modulos = modulos;
    this.renderTemarioHierarchy();
  },

  addSesionGlobal: function() {
    this.syncStateFromForm();
    var modulos = this.currentState.modulos || [];

    if (modulos.length > 0) {
      // Add to last standalone módulo
      var mi = modulos.length - 1;
      var sesiones = modulos[mi].sesiones || [];
      sesiones.push({ tipo: 'sesion', titulo: 'SESIÓN ' + (sesiones.length + 1) + ': NUEVA SESIÓN', contenido: [] });
      modulos[mi].sesiones = sesiones;
      this.currentState.modulos = modulos;
    } else {
      var cursos = this.currentState.cursos || [];
      if (cursos.length > 0) {
        var ci = cursos.length - 1;
        var cModulos = cursos[ci].modulos || [];
        if (cModulos.length > 0) {
          var mi = cModulos.length - 1;
          var sesiones = cModulos[mi].sesiones || [];
          sesiones.push({ tipo: 'sesion', titulo: 'SESIÓN ' + (sesiones.length + 1) + ': NUEVA SESIÓN', contenido: [] });
          cModulos[mi].sesiones = sesiones;
          cursos[ci].modulos = cModulos;
        } else {
          var sesiones = cursos[ci].sesiones || [];
          sesiones.push({ tipo: 'sesion', titulo: 'SESIÓN ' + (sesiones.length + 1) + ': NUEVA SESIÓN', contenido: [] });
          cursos[ci].sesiones = sesiones;
        }
        this.currentState.cursos = cursos;
      } else {
        // No cursos, no modulos → standalone sesion
        var sesiones = this.currentState.sesiones || [];
        sesiones.push({ tipo: 'sesion', titulo: 'SESIÓN ' + (sesiones.length + 1) + ': NUEVA SESIÓN', contenido: [] });
        this.currentState.sesiones = sesiones;
      }
    }

    this.renderTemarioHierarchy();
  },

  _addModuloToCurso: function(ci) {
    this.syncStateFromForm();
    var cursos = this.currentState.cursos || [];
    if (!cursos[ci]) return;
    var modulos = cursos[ci].modulos || [];
    modulos.push({ tipo: 'modulo', titulo: 'MÓDULO ' + (modulos.length + 1) + ': NUEVO MÓDULO', sesiones: [] });
    cursos[ci].modulos = modulos;
    // Clear direct sesiones when adding first modulo
    cursos[ci].sesiones = [];
    this.currentState.cursos = cursos;
    this.renderTemarioHierarchy();
  },

  _addSesionToCurso: function(ci) {
    this.syncStateFromForm();
    var cursos = this.currentState.cursos || [];
    if (!cursos[ci]) return;
    var sesiones = cursos[ci].sesiones || [];
    sesiones.push({ tipo: 'sesion', titulo: 'SESIÓN ' + (sesiones.length + 1) + ': NUEVA SESIÓN', contenido: [] });
    cursos[ci].sesiones = sesiones;
    this.currentState.cursos = cursos;
    this.renderTemarioHierarchy();
  },

  _addSesionToModulo: function(ci, mi) {
    this.syncStateFromForm();
    var sesiones = this._getSesionesByPath(ci, mi);
    if (!sesiones) return;
    sesiones.push({ tipo: 'sesion', titulo: 'SESIÓN ' + (sesiones.length + 1) + ': NUEVA SESIÓN', contenido: [] });
    this._setSesionesByPath(ci, mi, sesiones);
    this.renderTemarioHierarchy();
  },

  addContenidoItem: function(ci, mi, si, tipo) {
    this.syncStateFromForm();
    var sesiones = this._getSesionesByPath(ci, mi);
    if (!sesiones || !sesiones[si]) return;
    var contenido = sesiones[si].contenido || [];
    contenido.push({ tipo: tipo, texto: '' });
    sesiones[si].contenido = contenido;
    this._setSesionesByPath(ci, mi, sesiones);
    this.renderTemarioHierarchy();
  },

  // ─── CRUD: CURSOS ───
  moveCurso: function(ci, dir) {
    this.syncStateFromForm();
    var cursos = this.currentState.cursos || [];
    this._moveArrayItem(cursos, ci, dir);
    this.currentState.cursos = cursos;
    this.renderTemarioHierarchy();
  },

  removeCurso: function(ci) {
    if (!confirm('¿Eliminar este curso y todo su contenido?')) return;
    this.syncStateFromForm();
    var cursos = this.currentState.cursos || [];
    cursos.splice(ci, 1);
    this.currentState.cursos = cursos;
    this.renderTemarioHierarchy();
  },

  // ─── CRUD: MÓDULOS ───
  moveModulo: function(ci, mi, dir) {
    this.syncStateFromForm();
    var cursos = this.currentState.cursos || [];
    if (!cursos[ci]) return;
    var modulos = cursos[ci].modulos || [];
    this._moveArrayItem(modulos, mi, dir);
    cursos[ci].modulos = modulos;
    this.currentState.cursos = cursos;
    this.renderTemarioHierarchy();
  },

  removeModulo: function(ci, mi) {
    if (!confirm('¿Eliminar este módulo y todas sus sesiones?')) return;
    this.syncStateFromForm();
    var cursos = this.currentState.cursos || [];
    if (!cursos[ci]) return;
    var modulos = cursos[ci].modulos || [];
    modulos.splice(mi, 1);
    cursos[ci].modulos = modulos;
    this.currentState.cursos = cursos;
    this.renderTemarioHierarchy();
  },

  // ─── CRUD: SESIONES ───
  moveSesion: function(ci, mi, si, dir) {
    this.syncStateFromForm();
    var sesiones = this._getSesionesByPath(ci, mi);
    if (!sesiones) return;
    this._moveArrayItem(sesiones, si, dir);
    this._setSesionesByPath(ci, mi, sesiones);
    this.renderTemarioHierarchy();
  },

  removeSesion: function(ci, mi, si) {
    if (!confirm('¿Eliminar esta sesión?')) return;
    this.syncStateFromForm();
    var sesiones = this._getSesionesByPath(ci, mi);
    if (!sesiones || !sesiones[si]) return;
    sesiones.splice(si, 1);
    this._setSesionesByPath(ci, mi, sesiones);
    this.renderTemarioHierarchy();
  },

  removeSesionDirect: function(ci, si) {
    if (!confirm('¿Eliminar esta sesión?')) return;
    this.syncStateFromForm();
    var cursos = this.currentState.cursos || [];
    if (!cursos[ci]) return;
    var sesiones = cursos[ci].sesiones || [];
    sesiones.splice(si, 1);
    cursos[ci].sesiones = sesiones;
    this.currentState.cursos = cursos;
    this.renderTemarioHierarchy();
  },

  // ─── STANDALONE CRUD ───
  moveModuloStandalone: function(mi, dir) {
    this.syncStateFromForm();
    var modulos = this.currentState.modulos || [];
    this._moveArrayItem(modulos, mi, dir);
    this.currentState.modulos = modulos;
    this.renderTemarioHierarchy();
  },

  removeModuloStandalone: function(mi) {
    if (!confirm('¿Eliminar este módulo y todas sus sesiones?')) return;
    this.syncStateFromForm();
    var modulos = this.currentState.modulos || [];
    modulos.splice(mi, 1);
    this.currentState.modulos = modulos;
    this.renderTemarioHierarchy();
  },

  removeSesionStandalone: function(mi, si) {
    if (!confirm('¿Eliminar esta sesión?')) return;
    this.syncStateFromForm();
    var modulos = this.currentState.modulos || [];
    if (!modulos[mi]) return;
    var sesiones = modulos[mi].sesiones || [];
    sesiones.splice(si, 1);
    modulos[mi].sesiones = sesiones;
    this.currentState.modulos = modulos;
    this.renderTemarioHierarchy();
  },

  removeSesionStandaloneItem: function(si) {
    if (!confirm('¿Eliminar esta sesión?')) return;
    this.syncStateFromForm();
    var sesiones = this.currentState.sesiones || [];
    sesiones.splice(si, 1);
    this.currentState.sesiones = sesiones;
    this.renderTemarioHierarchy();
  },

  // ─── CRUD: CONTENIDO ITEMS ───
  moveContenidoItem: function(ci, mi, si, ii, dir) {
    this.syncStateFromForm();
    var sesiones = this._getSesionesByPath(ci, mi);
    if (!sesiones || !sesiones[si]) return;
    var contenido = sesiones[si].contenido || [];
    this._moveArrayItem(contenido, ii, dir);
    sesiones[si].contenido = contenido;
    this._setSesionesByPath(ci, mi, sesiones);
    this.renderTemarioHierarchy();
  },

  removeContenidoItem: function(ci, mi, si, ii) {
    this.syncStateFromForm();
    var sesiones = this._getSesionesByPath(ci, mi);
    if (!sesiones || !sesiones[si]) return;
    var contenido = sesiones[si].contenido || [];
    contenido.splice(ii, 1);
    sesiones[si].contenido = contenido;
    this._setSesionesByPath(ci, mi, sesiones);
    this.renderTemarioHierarchy();
  },

  // ─── CRUD: ELEMENTOS DE LISTA ───
  addListaElement: function(ci, mi, si, ii) {
    this.syncStateFromForm();
    var sesiones = this._getSesionesByPath(ci, mi);
    if (!sesiones || !sesiones[si]) return;
    var contenido = sesiones[si].contenido || [];
    if (!contenido[ii]) return;
    var elementos = contenido[ii].elementos || [];
    elementos.push('');
    contenido[ii].elementos = elementos;
    sesiones[si].contenido = contenido;
    this._setSesionesByPath(ci, mi, sesiones);
    this.renderTemarioHierarchy();
  },

  removeListaElement: function(ci, mi, si, ii, ei) {
    this.syncStateFromForm();
    var sesiones = this._getSesionesByPath(ci, mi);
    if (!sesiones || !sesiones[si]) return;
    var contenido = sesiones[si].contenido || [];
    if (!contenido[ii]) return;
    var elementos = contenido[ii].elementos || [];
    elementos.splice(ei, 1);
    contenido[ii].elementos = elementos;
    sesiones[si].contenido = contenido;
    this._setSesionesByPath(ci, mi, sesiones);
    this.renderTemarioHierarchy();
  },

  // ─── SYNC HIERARCHY FROM DOM ───
  syncStateFromForm: function() {
    var container = document.getElementById('temarioHierarchy');
    if (!container) return;
    var cursos = [];
    var modulos = [];
    var standaloneSesiones = [];

    container.querySelectorAll(':scope > .curso-level').forEach(function(cursoEl) {
      // Skip standalone modulos
      if (cursoEl.classList.contains('standalone-modulo-level')) return;

      var titulo = cursoEl.querySelector('.curso-titulo')?.value || '';
      var lecturas = cursoEl.querySelector('.curso-lecturas')?.value || '';
      var modulosCurso = [];
      var sesiones = [];

      var modEls = cursoEl.querySelectorAll('.modulos-wrap > .modulo-level');
      if (modEls.length > 0) {
        modEls.forEach(function(modEl) {
          var modTitulo = modEl.querySelector('.modulo-titulo')?.value || '';
          var modSesiones = [];
          modEl.querySelectorAll('.sesiones-wrap > .sesion-level').forEach(function(sesEl) {
            modSesiones.push(Admin._readSesionFromDOM(sesEl));
          });
          modulosCurso.push({ tipo: 'modulo', titulo: modTitulo, sesiones: modSesiones });
        });
      }

      if (modulosCurso.length === 0) {
        cursoEl.querySelectorAll('.sesiones-wrap > .sesion-level').forEach(function(sesEl) {
          sesiones.push(Admin._readSesionFromDOM(sesEl));
        });
      }

      cursos.push({ tipo: 'curso', titulo: titulo, lecturasPrevias: lecturas, modulos: modulosCurso, sesiones: sesiones });
    });

    // Standalone módulos
    container.querySelectorAll(':scope > .standalone-modulo-level').forEach(function(modEl) {
      var titulo = modEl.querySelector('.modulo-titulo')?.value || '';
      var sesiones = [];
      modEl.querySelectorAll('.sesiones-wrap > .sesion-level').forEach(function(sesEl) {
        sesiones.push(Admin._readSesionFromDOM(sesEl));
      });
      modulos.push({ tipo: 'modulo', titulo: titulo, sesiones: sesiones });
    });

    // Standalone sesiones
    container.querySelectorAll(':scope > .standalone-sesion-level').forEach(function(sesEl) {
      standaloneSesiones.push(Admin._readSesionFromDOM(sesEl));
    });

    this.currentState.cursos = cursos;
    this.currentState.modulos = modulos;
    this.currentState.sesiones = standaloneSesiones;
  },

  _readSesionFromDOM: function(sesEl) {
    var titulo = sesEl.querySelector('.sesion-titulo')?.value || '';
    var contenido = [];
    var contWrap = sesEl.querySelector('.h-contenido-items');
    if (contWrap) {
      contWrap.querySelectorAll('.h-contenido-item').forEach(function(itemEl) {
        var badge = itemEl.querySelector('.h-badge');
        var tipo = badge ? badge.textContent.toLowerCase() : 'lista';
        var texto = itemEl.querySelector('.contenido-texto')?.value || '';
        var item = { tipo: tipo, texto: texto };
        if (tipo === 'lista') {
          var elementos = [];
          itemEl.querySelectorAll('.elemento-texto').forEach(function(el) {
            elementos.push(el.value);
          });
          item.elementos = elementos;
        }
        contenido.push(item);
      });
    }
    return { titulo: titulo, contenido: contenido };
  },

  _syncHierarchyInput: function() {
    this.syncStateFromForm();
    var input = document.getElementById('temarioHierarchicalInput');
    if (!input) return;

    var data = [];
    var self = this;

    (this.currentState.cursos || []).forEach(function(curso) {
      data.push({
        tipo: 'curso',
        titulo: curso.titulo,
        lecturasPrevias: curso.lecturasPrevias || '',
        modulos: (curso.modulos || []).map(function(m) {
          return {
            tipo: 'modulo',
            titulo: m.titulo,
            sesiones: (m.sesiones || []).map(function(s) {
              return { titulo: s.titulo, contenido: s.contenido || [] };
            })
          };
        }),
        sesiones: (curso.sesiones || []).map(function(s) {
          return { titulo: s.titulo, contenido: s.contenido || [] };
        })
      });
    });

    (this.currentState.modulos || []).forEach(function(mod) {
      var item = {
        tipo: 'modulo',
        titulo: mod.titulo,
        sesiones: (mod.sesiones || []).map(function(s) {
          return { titulo: s.titulo, contenido: s.contenido || [] };
        })
      };
      data.push(item);
    });

    (this.currentState.sesiones || []).forEach(function(ses) {
      data.push({
        tipo: 'sesion',
        titulo: ses.titulo,
        contenido: ses.contenido || []
      });
    });

    input.value = JSON.stringify(data);
  },

  _escAttr: function(str) {
    return String(str).replace(/&/g, '&amp;').replace(/\"/g, '&quot;')
      .replace(/'/g, '&#39;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
  }
};

// ─── TYPE / MODE SELECTORS ───
function selectType(type) {
  document.getElementById('typeInput').value = type;
  document.querySelectorAll('.type-tab').forEach(function(t) { t.classList.remove('active'); });
  var tab = document.querySelector('.type-tab[data-type="' + type + '"]');
  if (tab) tab.classList.add('active');
  var tipoProg = document.getElementById('tipoPrograma');
  if (tipoProg) {
    tipoProg.value = type.charAt(0).toUpperCase() + type.slice(1);
  }
  var lbl = document.getElementById('headerTypeLabel');
  if (lbl) lbl.textContent = type === 'diplomado' ? 'Diplomado' : 'Curso';
}

function selectMode(mode) {
  document.getElementById('modeInput').value = mode;
  document.querySelectorAll('.mode-tab').forEach(function(t) { t.classList.remove('active'); });
  var tab = document.querySelector('.mode-tab[data-mode="' + mode + '"]');
  if (tab) tab.classList.add('active');
  var modalidad = document.getElementById('modalidadSelect');
  if (modalidad) {
    modalidad.value = mode === 'grabado' ? 'Online' : 'En Vivo';
  }
}

function syncTypeSelect() {
  var val = document.getElementById('tipoPrograma')?.value || 'Curso';
  selectType(val.toLowerCase());
}

function syncModeSelect() {
  var val = document.getElementById('modalidadSelect')?.value || 'Online';
  selectMode(val === 'Online' ? 'grabado' : 'en_vivo');
}

// ─── FILE PREVIEW ───
function previewFile(input, imgId) {
  var img = document.getElementById(imgId);
  if (!img) return;
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e) {
      img.src = e.target.result;
      img.style.display = 'block';
    };
    reader.readAsDataURL(input.files[0]);
  }
}

// ─── INIT ───
document.addEventListener('DOMContentLoaded', function() {
  // Cargar app-core.js si no está
  if (typeof RCEngine === 'undefined') {
    var script = document.createElement('script');
    script.src = '{{ asset("js/app-core.js") }}';
    document.body.appendChild(script);
    script.onload = function() { Admin.init(); };
  } else {
    Admin.init();
  }

  // Sincronizar jerarquía al hacer submit
  document.getElementById('cursoForm')?.addEventListener('submit', function() {
    Admin._syncHierarchyInput();
  });
});
</script>
@endsection