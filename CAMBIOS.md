# REGISTRO DE CAMBIOS - R&C Consulting Dashboard

## Fecha: 30 Abril 2026

### ✅ COMPLETADO

#### 1. **Base de Datos - Migraciones y Seeders**
- ✅ Migración `2026_04_30_193330_add_google_fields_to_users_table.php` completada:
  - Agregado campos: `google_id`, `avatar`, `rol`
- ✅ Migración `2026_04_30_211956_add_mode_to_courses_table.php`:
  - Agregado campo `mode` (en_vivo/grabado)
  - Agregado campo `link`, `color`, `overlay_html`
- ✅ Migración `2026_04_30_212659_add_asesora_id_to_courses_table.php`:
  - Agregado `asesora_id` como foreign key a `advisors`

#### 2. **Seeders Automáticos**
- ✅ `AdvisorSeeder.php` - Crea asesoras con WhatsApp y foto
- ✅ `CourseSeeder.php` - Crea cursos con `image_promotion` (miniaturas)
- ✅ `LeadSeeder.php` - Crea leads vinculados a asesoras
- ✅ `DatabaseSeeder.php` - Ejecuta todos los seeders automáticamente
- **Comando:** `php artisan migrate:fresh --seed`

#### 3. **Modelos Actualizados**
- ✅ `User.php` - Agregados campos fillable: `google_id`, `avatar`, `rol`
- ✅ `Course.php` - Ya tiene relación con `asesora_id` y `Advisor`

#### 4. **Rutas de Google OAuth**
- ✅ Agregadas en `routes/web.php`:
  - `GET /auth/google` → `GoogleController@redirect`
  - `GET /auth/google/callback` → `GoogleController@callback`
  - `GET /auth/logout` → `GoogleController@logout`

#### 5. **Controller de Leads Creado**
- ✅ `LeadController.php` con métodos:
  - `index()` - Lista leads (filtra por asesora autenticada)
  - `exportExcel()` - Exporta leads a CSV
  - `updateStatus()` - Actualiza status vía AJAX

#### 6. **Vistas Creadas/Actualizadas**
- ✅ `resources/views/admin/dashboard.blade.php` - Dashboard principal con estadísticas
- ✅ `resources/views/admin/cursos/create.blade.php` - Formulario con subida de miniatura `image_promotion`
- ✅ `resources/views/admin/leads/index.blade.php` - Vista de leads tipo Excel
- ✅ `resources/views/partials/header.blade.php`:
  - Agregado botón de login con Google
  - Agregado botón de Dashboard y Logout según autenticación
  - Uso de `@guest` y `@else` para mostrar según estado

#### 7. **Diseño Vercel (longcipher-design-DESIGN.md)**
- ✅ Actualizado con Sección 11: "Admin Dashboard Components (R&C Consulting)"
- ✅ Documentados: Course Cards, Excel/DataTables, Course Creation Form, Advisor-Course-Lead Relationship, Database Auto-Seed

#### 8. **Home Dinámico**
- ✅ `routes/web.php` - Home ahora carga cursos desde BD:
  ```php
  $courses = App\Models\Course::where('status', 'activo')->orWhereNull('status')->get();
  ```
- ✅ `home.blade.php` - Usa `image_promotion` en lugar de `cursos.php` estático

#### 9. **Configuración de Entorno**
- ✅ `.env` actualizado:
  ```
  GOOGLE_CLIENT_ID=965110063300-nllenpnt1h5sfhs6qifpvot7j2gbk65i.apps.googleusercontent.com
  GOOGLE_CLIENT_SECRET=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
  GOOGLE_REDIRECT_URL=http://localhost:8000/auth/google/callback
  ```

#### 10. **Laravel Socialite Instalado**
- ✅ `composer require laravel/socialite --ignore-platform-reqs`
- ✅ ServiceProvider registrado automáticamente

---

### 📊 ESTRUCTURA FINAL

#### **Relación Asesora-Curso-Leads:**
```
Advisor (asesora) ──── hasMany ────> Course (asesora_id)
Advisor (asesora) ──── hasMany ────> Lead (advisor_id)
```

#### **Cada asesora:**
- Ve su propio Excel de leads filtrado por `advisor_id`
- Tiene cursos asignados que se muestran en home con `image_promotion`

#### **Rutas principales:**
- `/` - Home con cursos dinámicos
- `/auth/google` - Inicio de sesión Google
- `/admin/dashboard` - Dashboard admin
- `/admin/cursos/crear` - Crear curso con miniatura
- `/admin/leads` - Excel de leads (filtrado por asesora)

---

### 🚀 PRÓXIMOS PASOS (Pendientes)

1. ⚠️ **Configurar Google Cloud Console** con URL:
   ```
   http://localhost:8000/auth/google/callback
   ```

2. ⚠️ **Instalar paquetes adicionales:**
   ```bash
   composer require maatwebsite/excel pusher/pusher-php-server
   ```

3. ⚠️ **Configurar WebSockets** para tiempo real en leads

4. ⚠️ **Migrar sistema "trabajo-llevar"** a módulo Laravel

---

**✅ Sistema listo para pruebas de login con Google OAuth**

## Fecha: 06 Mayo 2026

### ✅ CAMBIOS REALIZADOS HOY

#### 1. **Corrección de Header - Diseño Restaurado**
- ✅ Restaurado el diseño original del header (basado en commit 2ff4dce)
- ✅ Mantenido el botón de "Iniciar Sesión con Google" y foto de usuario
- ✅ Agregados estilos CSS para botones de login/logout en el header
- ✅ Corregido el botón de logout con ícono `fa-sign-out-alt`
- ✅ El header ahora usa `container-fluid px-4` (diseño original)
- ✅ Enlaces actualizados para usar `{{ url('/') }}` en lugar de rutas fijas

#### 2. **Archivos Modificados**
- ✅ `resources/views/partials/header.blade.php` - Diseño corregido
- ✅ `resources/css/header-footer.css` - Estilos OAuth agregados
- ✅ `public/css/header-footer.css` - Actualizado
- ✅ `resources/views/layouts/app-main.blade.php` - Limpiado de estilos inline

#### 3. **Estado del Código**
- Header restaurado al diseño original de GitHub
- Funcionalidad de Google OAuth preservada
- CSS organizado correctamente en archivos externos
