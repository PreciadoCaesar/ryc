<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Curso | R&C Consulting</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background: #f5f7fa; font-family: 'Poppins', sans-serif; }
        .form-container { max-width: 900px; margin: 40px auto; background: #fff; border-radius: 12px; padding: 30px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
        .section-title { font-size: 18px; font-weight: 600; color: #0A1F5C; margin: 25px 0 15px; padding-bottom: 8px; border-bottom: 2px solid #FF044D; }
        .form-label { font-weight: 500; color: #4A5568; font-size: 14px; }
        .form-control, .form-select { border: 1.5px solid #E8ECF0; border-radius: 8px; padding: 10px 14px; font-size: 14px; }
        .form-control:focus, .form-select:focus { border-color: #0A1F5C; box-shadow: 0 0 0 3px rgba(10, 31, 92, 0.1); }
        .btn-agregar { background: #10B981; color: #fff; border: none; padding: 8px 16px; border-radius: 6px; font-size: 13px; font-weight: 600; cursor: pointer; }
        .btn-agregar:hover { background: #059669; }
        .btn-eliminar { background: #EF4444; color: #fff; border: none; padding: 6px 12px; border-radius: 6px; font-size: 12px; }
        .btn-enviar { background: #FF044D; color: #fff; border: none; padding: 14px 30px; border-radius: 8px; font-size: 16px; font-weight: 700; width: 100%; }
        .btn-enviar:hover { background: #C40032; }
        .item-card { background: #F9FAFB; border: 1px solid #E5E7EB; border-radius: 8px; padding: 15px; margin-bottom: 12px; }
        .dynamic-section { border: 1px solid #E5E7EB; border-radius: 8px; padding: 20px; margin-bottom: 20px; background: #FAFAFA; }
        .img-preview { max-width: 150px; max-height: 100px; border-radius: 8px; margin-top: 5px; }
    </style>
</head>
<body>

<div class="container">
    <div class="form-container">
        <h2 style="text-align: center; margin-bottom: 30px; color: #0A1F5C;">
            <i class="fas fa-edit"></i> Editar Curso: {{ $curso->title }}
        </h2>

        <form action="{{ route('cursos.update', $curso->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- DATOS BÁSICOS -->
            <div class="section-title">📋 Datos Básicos</div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Título del Curso *</label>
                    <input type="text" name="title" class="form-control" value="{{ $curso->title }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Subtítulo (resaltado amarillo)</label>
                    <input type="text" name="subtitle" class="form-control" value="{{ $curso->subtitle }}">
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Tipo de Programa *</label>
                    <select name="type" class="form-select" required>
                        <option value="Curso de Especialización Virtual" {{ $curso->type == 'Curso de Especialización Virtual' ? 'selected' : '' }}>Curso de Especialización Virtual</option>
                        <option value="Diplomado de Especialización Virtual" {{ $curso->type == 'Diplomado de Especialización Virtual' ? 'selected' : '' }}>Diplomado de Especialización Virtual</option>
                        <option value="Curso Online" {{ $curso->type == 'Curso Online' ? 'selected' : '' }}>Curso Online</option>
                        <option value="Diplomado Online" {{ $curso->type == 'Diplomado Online' ? 'selected' : '' }}>Diplomado Online</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Modalidad *</label>
                    <select name="mode" class="form-select" required>
                        <option value="en_vivo" {{ ($curso->mode ?? 'en_vivo') == 'en_vivo' ? 'selected' : '' }}>En Vivo (clases en tiempo real)</option>
                        <option value="grabado" {{ ($curso->mode ?? '') == 'grabado' ? 'selected' : '' }}>Online Grabado (acceso inmediato)</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Frase del Curso</label>
                    <input type="text" name="phrase" class="form-control" value="{{ $curso->phrase }}">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Descripción</label>
                <textarea name="description" class="form-control" rows="3">{{ $curso->description }}</textarea>
            </div>

            <div class="row">
                <div class="col-md-3 mb-3">
                    <label class="form-label">Fecha de Inicio</label>
                    <input type="text" name="start_date" class="form-control" value="{{ $curso->start_date }}">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Número de Sesiones</label>
                    <input type="number" name="sessions" class="form-control" value="{{ $curso->sessions }}">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Horas Certificadas</label>
                    <input type="number" name="hours" class="form-control" value="{{ $curso->hours }}">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Nombre Especialización</label>
                    <input type="text" name="specialization_name" class="form-control" value="{{ $curso->specialization_name }}">
                </div>
            </div>

            <!-- IMÁGENES -->
            <div class="section-title">🖼️ Imágenes del Curso</div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Imagen de Promoción</label>
                    <input type="file" name="image_promotion" class="form-control" accept="image/*">
                    @if($curso->image_promotion)
                        <img src="{{ asset($curso->image_promotion) }}" class="img-preview" alt="Preview">
                        <small class="text-muted d-block">Actual: {{ $curso->image_promotion }}</small>
                    @endif
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Imagen In House Web</label>
                    <input type="file" name="inhouse_web" class="form-control mb-2" accept="image/*">
                    @if($curso->inhouse_web)
                        <img src="{{ asset($curso->inhouse_web) }}" class="img-preview" alt="Preview">
                    @endif
                    <label class="form-label mt-2">Imagen In House Móvil</label>
                    <input type="file" name="inhouse_mobile" class="form-control" accept="image/*">
                    @if($curso->inhouse_mobile)
                        <img src="{{ asset($curso->inhouse_mobile) }}" class="img-preview" alt="Preview">
                    @endif
                </div>
            </div>

            <!-- LINKS -->
            <div class="section-title">🔗 Links Externos</div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Link del Brochure (Google Drive/PDF)</label>
                    <input type="url" name="link_brochure" class="form-control" value="{{ $curso->link_brochure }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Link de Pago Niubiz</label>
                    <input type="url" name="link_niubiz" class="form-control" value="{{ $curso->link_niubiz }}">
                </div>
            </div>

            <!-- ASESORA -->
            <div class="section-title">👩‍💼 Asesora</div>

            <div class="mb-3">
                <label class="form-label">Seleccionar Asesora</label>
                <select name="advisor_id" class="form-select">
                    <option value="">Seleccionar asesora...</option>
                    @foreach($asesoras as $asesora)
                        <option value="{{ $asesora->id }}" {{ $curso->advisor_id == $asesora->id ? 'selected' : '' }}>
                            {{ $asesora->name }} - WhatsApp: {{ $asesora->whatsapp }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- PROFESORES -->
            <div class="section-title">👨‍🏫 Profesores</div>

            <div class="mb-3">
                <label class="form-label">Seleccionar Profesores</label>
                <select name="profesores[]" class="form-select" multiple size="4">
                    @foreach($profesores as $profesor)
                        <option value="{{ $profesor->id }}" {{ $curso->profesores->contains($profesor->id) ? 'selected' : '' }}>
                            {{ $profesor->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- PRECIOS -->
            <div class="section-title">💰 Precios</div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Precio Flash</label>
                    <input type="number" name="precio_flash" class="form-control" value="{{ $curso->precio_flash }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Fecha Límite Flash</label>
                    <input type="text" name="precio_flash_fecha" class="form-control" value="{{ $curso->precio_flash_fecha }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Precio Regular</label>
                    <input type="number" name="precio_regular" class="form-control" value="{{ $curso->precio_regular }}">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Precio Pronto Pago</label>
                    <input type="number" name="precio_pronto" class="form-control" value="{{ $curso->precio_pronto }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Fecha/Descripción Pronto Pago</label>
                    <input type="text" name="precio_pronto_fecha" class="form-control" value="{{ $curso->precio_pronto_fecha }}">
                </div>
            </div>

            @php $pc = $curso->page?->content ?? []; @endphp

            <!-- VIDEO (para online) -->
            <div class="section-title">📺 Video del Curso (Online)</div>
            <div class="mb-3">
                <label class="form-label">Código Embed del Video</label>
                <textarea name="video_url" class="form-control" rows="3" placeholder="&lt;iframe src=&quot;https://www.youtube.com/embed/...&quot;&gt;&lt;/iframe&gt;">{{ $pc['video_url'] ?? '' }}</textarea>
                <small class="text-muted">Pega el código iframe de YouTube o Vimeo</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Horario / Schedule</label>
                <input type="text" name="schedule" class="form-control" value="{{ $pc['schedule'] ?? 'Disponible 24/7' }}" placeholder="Ej: Disponible 24/7">
            </div>

            <!-- TESTIMONIOS -->
            <div class="section-title">⭐ Testimonios</div>
            <div id="testimonios-container">
                @foreach(($pc['testimonios'] ?? []) as $i => $t)
                <div class="item-card">
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <input type="text" name="testimonios[{{ $i }}][nombre]" class="form-control" value="{{ $t['nombre'] ?? '' }}" placeholder="Nombre del alumno">
                        </div>
                        <div class="col-md-3 mb-2">
                            <input type="text" name="testimonios[{{ $i }}][cargo]" class="form-control" value="{{ $t['cargo'] ?? '' }}" placeholder="Cargo / Empresa">
                        </div>
                        <div class="col-md-5 mb-2">
                            <input type="text" name="testimonios[{{ $i }}][texto]" class="form-control" value="{{ $t['texto'] ?? '' }}" placeholder="Texto del testimonio">
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn-eliminar" onclick="this.closest('.item-card').remove()">X</button>
                        </div>
                    </div>
                    <div class="mb-2">
                        <input type="text" name="testimonios[{{ $i }}][foto]" class="form-control" value="{{ $t['foto'] ?? '' }}" placeholder="URL de la foto (opcional)">
                    </div>
                </div>
                @endforeach
            </div>
            <button type="button" class="btn-agregar" onclick="agregarTestimonio()">
                <i class="fas fa-plus"></i> Agregar Testimonio
            </button>

            <!-- FAQ -->
            <div class="section-title">❓ Preguntas Frecuentes</div>
            <div id="faq-container">
                @foreach(($pc['faq'] ?? []) as $i => $f)
                <div class="item-card">
                    <div class="row">
                        <div class="col-md-5 mb-2">
                            <input type="text" name="faq[{{ $i }}][pregunta]" class="form-control" value="{{ $f['pregunta'] ?? '' }}" placeholder="Pregunta">
                        </div>
                        <div class="col-md-6 mb-2">
                            <input type="text" name="faq[{{ $i }}][respuesta]" class="form-control" value="{{ $f['respuesta'] ?? '' }}" placeholder="Respuesta">
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn-eliminar" onclick="this.closest('.item-card').remove()">X</button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <button type="button" class="btn-agregar" onclick="agregarFaq()">
                <i class="fas fa-plus"></i> Agregar FAQ
            </button>

            <!-- DIFERENCIADORES -->
            <div class="section-title">🏆 Valor Diferencial</div>
            <div id="diferenciadores-container">
                @foreach(($pc['diferenciadores'] ?? []) as $i => $d)
                <div class="item-card">
                    <div class="row">
                        <div class="col-md-5 mb-2">
                            <input type="text" name="diferenciadores[{{ $i }}][titulo]" class="form-control" value="{{ $d['titulo'] ?? '' }}" placeholder="Título">
                        </div>
                        <div class="col-md-6 mb-2">
                            <input type="text" name="diferenciadores[{{ $i }}][texto]" class="form-control" value="{{ $d['texto'] ?? '' }}" placeholder="Descripción">
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn-eliminar" onclick="this.closest('.item-card').remove()">X</button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <button type="button" class="btn-agregar" onclick="agregarDiferenciador()">
                <i class="fas fa-plus"></i> Agregar Valor Diferencial
            </button>

            <!-- SEO -->
            <div class="section-title">🔍 SEO</div>

            <div class="mb-3">
                <label class="form-label">Título SEO</label>
                <input type="text" name="seo_title" class="form-control" value="{{ $curso->seo_title }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Descripción SEO</label>
                <textarea name="seo_description" class="form-control" rows="2">{{ $curso->seo_description }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Palabras Clave</label>
                <input type="text" name="seo_keywords" class="form-control" value="{{ $curso->seo_keywords }}">
            </div>

            <!-- OBJETIVOS -->
            <div class="section-title">🎯 Objetivos de Aprendizaje</div>
            
            <div id="objetivos-container">
                @foreach($curso->objetivos as $index => $obj)
                <div class="item-card">
                    <div class="row">
                        <div class="col-md-5 mb-2">
                            <input type="text" name="objetivos[{{ $index }}][titulo]" class="form-control" value="{{ $obj->titulo }}">
                        </div>
                        <div class="col-md-6 mb-2">
                            <input type="text" name="objetivos[{{ $index }}][descripcion]" class="form-control" value="{{ $obj->descripcion }}">
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn-eliminar" onclick="this.closest('.item-card').remove()">X</button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <button type="button" class="btn-agregar" onclick="agregarObjetivo()">
                <i class="fas fa-plus"></i> Agregar Objetivo
            </button>

            <!-- PARTICIPANTES -->
            <div class="section-title">👥 ¿Quiénes Deben Participar?</div>
            
            <div id="participantes-container">
                @foreach($curso->participantes as $index => $par)
                <div class="item-card">
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <select name="participantes[{{ $index }}][icono]" class="form-select">
                                <option value="fa-user-tie" {{ $par->icono == 'fa-user-tie' ? 'selected' : '' }}>👔 Profesional</option>
                                <option value="fa-hard-hat" {{ $par->icono == 'fa-hard-hat' ? 'selected' : '' }}>⛑️ Constructor</option>
                                <option value="fa-chart-line" {{ $par->icono == 'fa-chart-line' ? 'selected' : '' }}>📈 Analista</option>
                                <option value="fa-building" {{ $par->icono == 'fa-building' ? 'selected' : '' }}>🏢 Empresa</option>
                                <option value="fa-graduation-cap" {{ $par->icono == 'fa-graduation-cap' ? 'selected' : '' }}>🎓 Estudiante</option>
                                <option value="fa-briefcase" {{ $par->icono == 'fa-briefcase' ? 'selected' : '' }}>💼 Funcionario</option>
                            </select>
                        </div>
                        <div class="col-md-8 mb-2">
                            <input type="text" name="participantes[{{ $index }}][descripcion]" class="form-control" value="{{ $par->descripcion }}">
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn-eliminar" onclick="this.closest('.item-card').remove()">X</button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <button type="button" class="btn-agregar" onclick="agregarParticipante()">
                <i class="fas fa-plus"></i> Agregar Perfil
            </button>

            <!-- TEMARIO -->
            <div class="section-title">📚 Temario del Curso</div>
            
            <div id="temario-container">
                @foreach($curso->temario as $index => $ses)
                <div class="dynamic-section">
                    <div class="item-card">
                        <div class="row">
                            <div class="col-md-2 mb-2">
                                <input type="number" name="temario[{{ $index }}][numero]" class="form-control" value="{{ $ses->numero }}">
                            </div>
                            <div class="col-md-9 mb-2">
                                <input type="text" name="temario[{{ $index }}][titulo]" class="form-control" value="{{ $ses->titulo }}">
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn-eliminar" onclick="this.closest('.dynamic-section').remove()">X</button>
                            </div>
                        </div>
                        <div class="mb-2">
                            <label class="form-label" style="font-size: 12px;">Temas (separados por coma)</label>
                            <input type="text" name="temario[{{ $index }}][temas_text]" class="form-control" value="{{ is_array($ses->temas) ? implode(', ', $ses->temas) : '' }}">
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <button type="button" class="btn-agregar" onclick="agregarSesion()">
                <i class="fas fa-plus"></i> Agregar Sesión
            </button>

            <hr style="margin: 40px 0;">

            <button type="submit" class="btn-enviar">
                <i class="fas fa-save"></i> Actualizar Curso
            </button>
        </form>
    </div>
</div>

<script>
    let objetivoCount = {{ $curso->objetivos->count() }};
    let participanteCount = {{ $curso->participantes->count() }};
    let sesionCount = {{ $curso->temario->count() }};
    let testimonioCount = {{ count($pc['testimonios'] ?? []) }};
    let faqCount = {{ count($pc['faq'] ?? []) }};
    let diferenciadorCount = {{ count($pc['diferenciadores'] ?? []) }};

    function agregarObjetivo() {
        const container = document.getElementById('objetivos-container');
        const html = `
            <div class="item-card">
                <div class="row">
                    <div class="col-md-5 mb-2">
                        <input type="text" name="objetivos[${objetivoCount}][titulo]" class="form-control" placeholder="Título del objetivo">
                    </div>
                    <div class="col-md-6 mb-2">
                        <input type="text" name="objetivos[${objetivoCount}][descripcion]" class="form-control" placeholder="Descripción del objetivo">
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn-eliminar" onclick="this.closest('.item-card').remove()">X</button>
                    </div>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', html);
        objetivoCount++;
    }

    function agregarParticipante() {
        const container = document.getElementById('participantes-container');
        const html = `
            <div class="item-card">
                <div class="row">
                    <div class="col-md-3 mb-2">
                        <select name="participantes[${participanteCount}][icono]" class="form-select">
                            <option value="fa-user-tie">👔 Profesional</option>
                            <option value="fa-hard-hat">⛑️ Constructor</option>
                            <option value="fa-chart-line">📈 Analista</option>
                            <option value="fa-building">🏢 Empresa</option>
                            <option value="fa-graduation-cap">🎓 Estudiante</option>
                            <option value="fa-briefcase">💼 Funcionario</option>
                        </select>
                    </div>
                    <div class="col-md-8 mb-2">
                        <input type="text" name="participantes[${participanteCount}][descripcion]" class="form-control" placeholder="Descripción del perfil">
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn-eliminar" onclick="this.closest('.item-card').remove()">X</button>
                    </div>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', html);
        participanteCount++;
    }

    function agregarSesion() {
        const container = document.getElementById('temario-container');
        const html = `
            <div class="dynamic-section">
                <div class="item-card">
                    <div class="row">
                        <div class="col-md-2 mb-2">
                            <input type="number" name="temario[${sesionCount}][numero]" class="form-control" placeholder="N°" value="${sesionCount + 1}">
                        </div>
                        <div class="col-md-9 mb-2">
                            <input type="text" name="temario[${sesionCount}][titulo]" class="form-control" placeholder="Título de la sesión">
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn-eliminar" onclick="this.closest('.dynamic-section').remove()">X</button>
                        </div>
                    </div>
                    <div class="mb-2">
                        <label class="form-label" style="font-size: 12px;">Temas (separados por coma)</label>
                        <input type="text" name="temario[${sesionCount}][temas_text]" class="form-control" placeholder="Tema 1, Tema 2, Tema 3">
                    </div>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', html);
        sesionCount++;
    }

    function agregarTestimonio() {
        const container = document.getElementById('testimonios-container');
        const html = `
            <div class="item-card">
                <div class="row">
                    <div class="col-md-3 mb-2">
                        <input type="text" name="testimonios[\${testimonioCount}][nombre]" class="form-control" placeholder="Nombre del alumno">
                    </div>
                    <div class="col-md-3 mb-2">
                        <input type="text" name="testimonios[\${testimonioCount}][cargo]" class="form-control" placeholder="Cargo / Empresa">
                    </div>
                    <div class="col-md-5 mb-2">
                        <input type="text" name="testimonios[\${testimonioCount}][texto]" class="form-control" placeholder="Texto del testimonio">
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn-eliminar" onclick="this.closest('.item-card').remove()">X</button>
                    </div>
                </div>
                <div class="mb-2">
                    <input type="text" name="testimonios[\${testimonioCount}][foto]" class="form-control" placeholder="URL de la foto (opcional)">
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', html);
        testimonioCount++;
    }

    function agregarFaq() {
        const container = document.getElementById('faq-container');
        const html = `
            <div class="item-card">
                <div class="row">
                    <div class="col-md-5 mb-2">
                        <input type="text" name="faq[\${faqCount}][pregunta]" class="form-control" placeholder="Pregunta">
                    </div>
                    <div class="col-md-6 mb-2">
                        <input type="text" name="faq[\${faqCount}][respuesta]" class="form-control" placeholder="Respuesta">
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn-eliminar" onclick="this.closest('.item-card').remove()">X</button>
                    </div>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', html);
        faqCount++;
    }

    function agregarDiferenciador() {
        const container = document.getElementById('diferenciadores-container');
        const html = `
            <div class="item-card">
                <div class="row">
                    <div class="col-md-5 mb-2">
                        <input type="text" name="diferenciadores[\${diferenciadorCount}][titulo]" class="form-control" placeholder="Título">
                    </div>
                    <div class="col-md-6 mb-2">
                        <input type="text" name="diferenciadores[\${diferenciadorCount}][texto]" class="form-control" placeholder="Descripción">
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn-eliminar" onclick="this.closest('.item-card').remove()">X</button>
                    </div>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', html);
        diferenciadorCount++;
    }
</script>

</body>
</html>