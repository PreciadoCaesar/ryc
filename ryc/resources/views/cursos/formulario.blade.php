<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Nuevo Curso | R&C Consulting</title>
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
        .file-upload { border: 2px dashed #CBD5E0; border-radius: 8px; padding: 30px; text-align: center; cursor: pointer; transition: all 0.2s; }
        .file-upload:hover { border-color: #0A1F5C; background: #F0F4F8; }
        .file-upload.has-file { border-color: #10B981; background: #ECFDF5; }
        .dynamic-section { border: 1px solid #E5E7EB; border-radius: 8px; padding: 20px; margin-bottom: 20px; background: #FAFAFA; }
    </style>
</head>
<body>

<div class="container">
    <div class="form-container">
        <h2 style="text-align: center; margin-bottom: 30px; color: #0A1F5C;">
            <i class="fas fa-book-open"></i> Crear Nuevo Curso
        </h2>

        <form action="{{ route('cursos.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- DATOS BÁSICOS -->
            <div class="section-title">📋 Datos Básicos</div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Título del Curso *</label>
                    <input type="text" name="title" class="form-control" placeholder="Ej: Gestión Pública" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Subtítulo (resaltado amarillo)</label>
                    <input type="text" name="subtitle" class="form-control" placeholder="Ej: 2026">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tipo de Programa *</label>
                    <select name="type" class="form-select" required>
                        <option value="">Seleccionar tipo</option>
                        <option value="Curso de Especialización Virtual">Curso de Especialización Virtual</option>
                        <option value="Diplomado de Especialización Virtual">Diplomado de Especialización Virtual</option>
                        <option value="Curso Online">Curso Online</option>
                        <option value="Diplomado Online">Diplomado Online</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Frase del Curso</label>
                    <input type="text" name="phrase" class="form-control" placeholder="Ej: Domina las nuevas normativas">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Descripción</label>
                <textarea name="description" class="form-control" rows="3" placeholder="Descripción del curso..."></textarea>
            </div>

            <div class="row">
                <div class="col-md-3 mb-3">
                    <label class="form-label">Fecha de Inicio</label>
                    <input type="text" name="start_date" class="form-control" placeholder="Ej: 22 de abril">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Número de Sesiones</label>
                    <input type="number" name="sessions" class="form-control" placeholder="6">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Horas Certificadas</label>
                    <input type="number" name="hours" class="form-control" placeholder="90">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Nombre Especialización</label>
                    <input type="text" name="specialization_name" class="form-control" placeholder="Nombre que aparece en temario">
                </div>
            </div>

            <!-- IMÁGENES -->
            <div class="section-title">🖼️ Imágenes del Curso</div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Imagen de Promoción</label>
                    <input type="file" name="image_promotion" class="form-control" accept="image/*">
                    <small class="text-muted">Sube imagen para promoción (jpg, png, webp)</small>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Imagen In House Web</label>
                    <input type="file" name="inhouse_web" class="form-control mb-2" accept="image/*">
                    <label class="form-label">Imagen In House Móvil</label>
                    <input type="file" name="inhouse_mobile" class="form-control" accept="image/*">
                </div>
            </div>

            <!-- LINKS -->
            <div class="section-title">🔗 Links Externos</div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Link del Brochure (Google Drive/PDF)</label>
                    <input type="url" name="link_brochure" class="form-control" placeholder="https://drive.google.com/...">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Link de Pago Niubiz</label>
                    <input type="url" name="link_niubiz" class="form-control" placeholder="https://pagolink.niubiz.com.pe/...">
                </div>
            </div>

            <!-- ASESORA -->
            <div class="section-title">👩‍💼 Asesora</div>

            <div class="mb-3">
                <label class="form-label">Seleccionar Asesora</label>
                <select name="advisor_id" class="form-select">
                    <option value="">Seleccionar asesora...</option>
                    @foreach($asesoras as $asesora)
                        <option value="{{ $asesora->id }}">{{ $asesora->name }} - WhatsApp: {{ $asesora->whatsapp }}</option>
                    @endforeach
                </select>
                <small class="text-muted">Al seleccionar se cargará automáticamente su foto, nombre y WhatsApp</small>
            </div>

            <!-- PROFESORES -->
            <div class="section-title">👨‍🏫 Profesores</div>

            <div class="mb-3">
                <label class="form-label">Seleccionar Profesores (puede seleccionar varios)</label>
                <select name="profesores[]" class="form-select" multiple size="4">
                    @foreach($profesores as $profesor)
                        <option value="{{ $profesor->id }}">{{ $profesor->name }}</option>
                    @endforeach
                </select>
                <small class="text-muted">Mantén presionado Ctrl (Cmd en Mac) para seleccionar varios</small>
            </div>

            <!-- PRECIOS -->
            <div class="section-title">💰 Precios</div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Precio Flash</label>
                    <input type="number" name="precio_flash" class="form-control" placeholder="299">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Fecha Límite Flash</label>
                    <input type="text" name="precio_flash_fecha" class="form-control" placeholder="15 de abril">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Precio Regular</label>
                    <input type="number" name="precio_regular" class="form-control" placeholder="499">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Precio Pronto Pago</label>
                    <input type="number" name="precio_pronto" class="form-control" placeholder="399">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Fecha/Descripción Pronto Pago</label>
                    <input type="text" name="precio_pronto_fecha" class="form-control" placeholder="Hasta 20 de abril">
                </div>
            </div>

            <!-- SEO -->
            <div class="section-title">🔍 SEO</div>

            <div class="mb-3">
                <label class="form-label">Título SEO (para Google)</label>
                <input type="text" name="seo_title" class="form-control" placeholder="Curso Preparación ONA OCE 2026 | R&C Consulting">
            </div>

            <div class="mb-3">
                <label class="form-label">Descripción SEO</label>
                <textarea name="seo_description" class="form-control" rows="2" placeholder="Curso de preparación para el examen de..."></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Palabras Clave (keywords)</label>
                <input type="text" name="seo_keywords" class="form-control" placeholder="curso online, certificación, gestión pública">
            </div>

            <!-- OBJETIVOS -->
            <div class="section-title">🎯 Objetivos de Aprendizaje</div>
            
            <div id="objetivos-container">
                <div class="item-card">
                    <div class="row">
                        <div class="col-md-5 mb-2">
                            <input type="text" name="objetivos[0][titulo]" class="form-control" placeholder="Título del objetivo">
                        </div>
                        <div class="col-md-6 mb-2">
                            <input type="text" name="objetivos[0][descripcion]" class="form-control" placeholder="Descripción del objetivo">
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn-eliminar" onclick="this.closest('.item-card').remove()">X</button>
                        </div>
                    </div>
                </div>
            </div>
            <button type="button" class="btn-agregar" onclick="agregarObjetivo()">
                <i class="fas fa-plus"></i> Agregar Objetivo
            </button>

            <!-- PARTICIPANTES -->
            <div class="section-title">👥 ¿Quiénes Deben Participar?</div>
            
            <div id="participantes-container">
                <div class="item-card">
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <select name="participantes[0][icono]" class="form-select">
                                <option value="fa-user-tie">👔 Profesional</option>
                                <option value="fa-hard-hat">⛑️ Constructor</option>
                                <option value="fa-chart-line">📈 Analista</option>
                                <option value="fa-building">🏢 Empresa</option>
                                <option value="fa-graduation-cap">🎓 Estudiante</option>
                                <option value="fa-briefcase">💼 Funcionario</option>
                            </select>
                        </div>
                        <div class="col-md-8 mb-2">
                            <input type="text" name="participantes[0][descripcion]" class="form-control" placeholder="Descripción del perfil">
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn-eliminar" onclick="this.closest('.item-card').remove()">X</button>
                        </div>
                    </div>
                </div>
            </div>
            <button type="button" class="btn-agregar" onclick="agregarParticipante()">
                <i class="fas fa-plus"></i> Agregar Perfil
            </button>

            <!-- TEMARIO -->
            <div class="section-title">📚 Temario del Curso</div>
            
            <div id="temario-container">
                <div class="dynamic-section">
                    <div class="item-card">
                        <div class="row">
                            <div class="col-md-2 mb-2">
                                <input type="number" name="temario[0][numero]" class="form-control" placeholder="N°" value="1">
                            </div>
                            <div class="col-md-9 mb-2">
                                <input type="text" name="temario[0][titulo]" class="form-control" placeholder="Título de la sesión">
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn-eliminar" onclick="this.closest('.item-card').remove()">X</button>
                            </div>
                        </div>
                        <div class="mb-2">
                            <label class="form-label" style="font-size: 12px;">Temas (separados por coma)</label>
                            <input type="text" name="temario[0][temas_text]" class="form-control" placeholder="Tema 1, Tema 2, Tema 3">
                        </div>
                    </div>
                </div>
            </div>
            <button type="button" class="btn-agregar" onclick="agregarSesion()">
                <i class="fas fa-plus"></i> Agregar Sesión
            </button>

            <hr style="margin: 40px 0;">

            <button type="submit" class="btn-enviar">
                <i class="fas fa-save"></i> Guardar Curso
            </button>
        </form>
    </div>
</div>

<script>
    let objetivoCount = 1;
    let participanteCount = 1;
    let sesionCount = 1;

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
</script>

</body>
</html>