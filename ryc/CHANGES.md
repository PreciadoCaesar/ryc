# Cambios Realizados - Abril 8, 2026

## Sistema de Cursos (CRUD Completo)

### Archivos creados:

1. **Modelos:**
   - `app/Models/Course.php` - Modelo principal del curso
   - `app/Models/Advisor.php` - Modelo de asesores
   - `app/Models/Professor.php` - Modelo de profesores
   - `app/Models/CourseSesion.php` - Sesiones del temario
   - `app/Models/CourseObjetivo.php` - Objetivos del curso
   - `app/Models/CourseParticipante.php` - Público objetivo

2. **Controlador:**
   - `app/Http/Controllers/CursoController.php` - CRUD completo de cursos

3. **Migraciones:**
   - `2026_04_08_170722_add_fields_to_courses_table.php` - Campos adicionales
   - `2026_04_08_170936_create_course_related_tables.php` - Tablas relacionadas
   - `2026_04_08_171431_add_cargo_to_advisors_table.php` - Campo cargo
   - `2026_04_08_171538_add_formacion_experiencia_to_professors_table.php` - Formación y experiencia
   - `2026_04_08_171807_fix_courses_type_column.php` - Fix tipo de curso
   - `2026_04_08_171930_drop_and_recreate_courses_type.php` - Recreate tipo

4. **Vistas:**
   - `resources/views/cursos/index.blade.php` - Listado de cursos (admin)
   - `resources/views/cursos/crear.blade.php` - Formulario crear curso
   - `resources/views/cursos/editar.blade.php` - Formulario editar curso
   - `resources/views/cursos/mostrar.blade.php` - Vista pública del curso (usa layout app)

5. **Rutas en `routes/web.php`:**
   ```
   GET/POST /admin/cursos → CursoController@index/store
   GET /admin/cursos/create → CursoController@create
   GET /admin/cursos/{curso}/editar → CursoController@edit
   PUT /admin/cursos/{curso} → CursoController@update
   DELETE /admin/cursos/{curso} → CursoController@destroy
   GET /curso/{slug} → CursoController@show
   ```

### Recursos copiados:

1. **CSS:** `public/css/curso/` (styles.css, header.css, main.css, etc.)
2. **Imágenes:** `public/img/SVG/`, `public/img/icons/bancos/`, `public/img/added/`
3. **Js:** `public/js/jquery-3.2.1.min.js`

---

## Página de Cursos - mostrar.blade.php

### Estructura:
- Usa `@extends('layouts.app')` para header/footer de Laravel
- CSS del curso se carga via `@section('styles')` para no afectar header/footer
- Vista completa con: hero, quick bar, temario, certificación, profesores, valores diferenciales, formas de pago, inversión

### Layout actualizado:
- `resources/views/layouts/app.blade.php` - Estilos de header/footer al final para mayor precedencia

---

## Suscripciones (Marzo 31, 2026)

### Archivos creados anteriormente:
- `resources/views/suscripciones/index.blade.php`
- `app/Http/Controllers/SuscripcionController.php`

---

## Estado Actual

| URL | Estado |
|-----|--------|
| `/` | ✅ Home |
| `/suscripciones` | ✅ Membresía Premium |
| `/admin/cursos` | ✅ Panel admin cursos |
| `/admin/cursos/create` | ✅ Crear curso |
| `/curso/{slug}` | ✅ Vista pública curso |