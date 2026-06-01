# 🏛️ R&C Consulting - Plataforma Educativa

> **Escuela de Gobierno y Gestión Pública**  
> Plataforma web para la gestión de cursos virtuales, diplomas, programas In-House, membresías y pasarela de pagos.

---

## 📋 Índice

- [Stack Tecnológico](#stack-tecnológico)
- [Estructura del Proyecto](#estructura-del-proyecto)
- [Funcionalidades Principales](#funcionalidades-principales)
- [Cambios Recientes](#cambios-recientes)
  - [Mayo 2026 - Gestor de Plantillas y Profesores](#️-mayo-2026---gestor-de-plantillas-y-profesores)
  - [Mayo 2026 - Correcciones de Seguridad y Middleware](#-mayo-2026---correcciones-de-seguridad-y-middleware)
  - [Mayo 2026 - Pasarela Izipay](#-mayo-2026---pasarela-izipay)
  - [Abril-Mayo 2026 - Sistema de Leads y Google OAuth](#-abril-mayo-2026---sistema-de-leads-y-google-oauth)
  - [Abril 2026 - CRUD de Cursos](#-abril-2026---crud-de-cursos)
- [Instalación y Configuración](#instalación-y-configuración)
- [Rutas Principales](#rutas-principales)
- [Modelos de Datos](#modelos-de-datos)

---

## Stack Tecnológico

| Capa | Tecnología |
|------|-----------|
| **Backend** | Laravel 12 (PHP 8.x) |
| **Frontend** | Blade Templates + Bootstrap 5 + Alpine.js |
| **Base de datos** | MySQL (XAMPP) |
| **Pasarela de pago** | Izipay (Lyra Krypton SDK V4.0) |
| **Autenticación** | Google OAuth 2.0 + Laravel Socialite |
| **Assets** | Vite 7 + CSS/JS nativos |

---

## Estructura del Proyecto

```
/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   │   └── ProfessorController.php    # CRUD profesores admin
│   │   │   ├── Api/
│   │   │   │   └── ImageController.php         # Subida/lista imágenes vía API
│   │   │   ├── CursoController.php            # CRUD completo cursos
│   │   │   └── PaymentController.php          # Pasarela Izipay
│   │   └── Middleware/
│   │       └── CheckAdminAccess.php           # Middleware de acceso admin
│   ├── Models/
│   │   ├── Course.php                         # Curso (con relaciones)
│   │   ├── Professor.php                      # Profesor/docente
│   │   └── Advisor.php                        # Asesora comercial
│   └── Services/
│       └── IzipayService.php                  # Integración Izipay
├── cesar-plantilla/                           # Gestor de plantillas (admin HTML)
│   ├── admin.html                             # Panel admin plantillas
│   ├── js/admin.js                            # Admin JS
│   ├── js/app-core.js                         # Core JS
│   ├── css/admin.css                          # Estilos admin
│   ├── upload.php                             # Upload de imágenes
│   ├── listar-imagenes.php                    # Listar imágenes subidas
│   ├── profesores/                            # Fotos de profesores
│   └── imagenes-promocionales/                # Imágenes promocionales
├── alianzas/                                  # Página de alianzas/nosotros
├── recursos/                                  # Header/footer global
├── resources/views/
│   ├── admin/
│   │   ├── cursos/form.blade.php              # Formulario admin curso
│   │   └── profesores/index.blade.php         # CRUD profesores admin
│   ├── cursos/
│   │   ├── landing.blade.php                  # Landing page curso (en vivo)
│   │   ├── formulario.blade.php               # Formulario vista pública
│   │   ├── mostrar.blade.php                  # Vista pública curso
│   │   └── online.blade.php                   # Vista curso online (grabado)
│   ├── cursos-virtuales.blade.php             # Listado cursos virtuales
│   ├── diplomas-virtuales.blade.php           # Listado diplomas
│   └── home.blade.php                         # Home dinámico
├── database/migrations/
│   ├── 2026_05_29_173412_update_professors_for_plantilla.php  # Profesores: primer_nombre, secciones
│   ├── 2026_05_29_174100_add_fecha_fin_to_courses_table.php   # Cursos: fecha_fin
│   └── 2026_05_30_000001_add_image_cover_to_courses_table.php # Cursos: image_cover
├── public/
│   ├── css/curso/
│   │   ├── admin.css                          # Estilos admin curso
│   │   └── styles.css                         # Estilos landing curso
│   ├── upload/                                # Uploads de imágenes
│   └── profesores/                            # Fotos profesores
├── cursos-virtuales/                          # Página independiente cursos virtuales
├── diplomas-virtuales/                        # Página independiente diplomas
└── nosotros/                                  # Página nosotros
```

---

## Funcionalidades Principales

### ✅ Catálogo de Cursos y Diplomas
- Cursos de Especialización Virtual (clases en vivo)
- Cursos Online (grabados, acceso inmediato)
- Diplomas de Especialización
- Landing page por cada curso con:
  - Hero con estadísticas
  - Temario desplegable (acordeón)
  - Precios y promociones
  - Panel lateral con oferta flash
  - Sección de profesores
  - Certificación
  - Formas de pago
  - Testimonios dinámicos
  - Sección In-House
  - FAQ
  - Chat flotante WhatsApp

### ✅ Panel de Administración
- CRUD completo de cursos (crear, editar, listar, eliminar)
- Gestión de profesores con:
  - Foto, nombre, primer nombre
  - Secciones dinámicas (formación, experiencia, etc.)
  - Subida de fotos
- Dashboard con estadísticas
- Gestor de leads (filtrado por asesora)

### ✅ Pasarela de Pago Izipay
- Integración con Krypton SDK (formulario embebido)
- Tarjetas crédito/débito
- 3DS2 (autenticación reforzada)
- Webhook IPN (notificaciones asíncronas)
- Manejo de estados: PAID, UNPAID, ABANDONED, EXPIRED
- Confirmación por email

### ✅ Gestor de Plantillas (`cesar-plantilla/`)
- Generador de plantillas HTML para cursos
- Subida de imágenes promocionales
- Subida de fotos de profesores
- Vista previa en vivo
- Integración con API de imágenes

### ✅ Autenticación
- Google OAuth 2.0
- Roles: dios, desarrollador, gerente, asesora
- Middleware de acceso admin (`admin.access`)

### ✅ Seguridad
- Bloqueo de archivos sensibles (.env, .git, storage, vendor)
- Headers de seguridad (X-Frame-Options, X-Content-Type-Options, CSP)
- Subida de imágenes validada por MIME real
- .htaccess en directorios de upload bloqueando ejecución PHP

---

## Cambios Recientes

### 🛠️ Mayo 2026 - Gestor de Plantillas y Profesores

**Profesores - Migración a nuevo schema:**
- Agregado campo `primer_nombre` para extraer el primer nombre del profesor (saltando títulos como Dr., Mg., Lic.)
- Agregado campo `secciones` (JSON) reemplazando `formacion` y `experiencia` antiguos
- Migración que convierte datos existentes automáticamente
- `primer_nombre` se usa para mostrar solo el nombre de pila en las tarjetas

**ProfessorController - Actualización:**
- Validación ahora acepta `jpeg`, `png`, `webp` (antes solo `webp`)
- Soporte para `photo_url` (URL externa de foto)
- Manejo de `secciones` como JSON desde el formulario
- Eliminación segura de fotos (distingue archivo local vs URL)
- Extracción automática de `primer_nombre`

**Gestor de Plantillas (`cesar-plantilla/`):**
- Rediseño completo del panel admin con pestañas (Plantilla + Profesores)
- Nuevos campos: modalidad (online/virtual), subtítulo, descripción, keywords
- Upload de imágenes promocionales con preview
- Selector de imágenes subidas (modal galería)
- Gestor de profesores con subida de fotos
- Nueva paleta de colores y tipografía refinada

**Nuevas vistas de cursos:**
- `mostrar.blade.php` - Vista pública para cursos en vivo (con panel lateral, temario, certificación, precios, In-House)
- `online.blade.php` - Vista para cursos online grabados (con video, panel de oferta, testimonios, FAQ)
- `formulario.blade.php` - Formulario de registro público

**CursoController - Mejoras:**
- Imágenes se almacenan en `curso/{slug}/img/` (organizado por curso)
- Soporte para `image_cover` (imagen de portada)
- `specialization_name` acepta array y se convierte a string separado por comas
- Nuevo campo `fecha_fin`
- Creación automática de directorios `img/` y `descargables/` por curso
- Soporte para texto de imagen (URL escrita manualmente)

**Formulario Admin de Cursos:**
- Rediseñado con campos para: modalidad online/virtual, subtítulo, descripción hero
- Subida de imagen promocional y portada
- Campos de texto para URLs de imágenes
- Selector de tipo de programa (Curso/Diplomado + Online/Virtual)
- Fecha fin del curso
- Especialización por módulos

**Rutas nuevas:**
- `/cursos-virtuales` - Listado de cursos virtuales (independiente)
- `/diplomas-virtuales` - Listado de diplomas (independiente)
- API: `POST /api/images/upload`, `GET /api/images/list?carpeta=...`

### 🔒 Mayo 2026 - Correcciones de Seguridad y Middleware

- Agregado middleware `CheckAdminAccess`:
  - Verifica email corporativo (@rc-consulting.org) o rol admin
  - Redirige a login si no autenticado
  - Redirige a home si no tiene acceso
- Registrado alias `admin.access` en `bootstrap/app.php`
- `.htaccess` principal:
  - Bloqueo de archivos sensibles (.env, .git, storage, vendor, etc.)
  - Headers de seguridad (X-Frame-Options, X-Content-Type-Options, CSP, Referrer-Policy)
  - Redirección a `public/` para archivos `.html`
  - Nuevas rutas: `/cursos-virtuales`, `/diplomas-virtuales`
- `.htaccess` de `cesar-plantilla/`:
  - Excepción para `upload.php` (permitir subida)
  - Restricción de ejecución PHP en demás archivos

### 💳 Mayo 2026 - Pasarela Izipay

- Integración completa con Izipay (Lyra Krypton SDK V4.0)
- `PaymentController`:
  - `index()`: genera formToken y renderiza vista de pago
  - `success()`: valida hash HMAC, orderStatus, actualiza compras y envía email
  - `cancel()`: maneja rechazo 3DS2 y cancelación manual
  - `ipn()`: webhook para notificaciones asíncronas
- `IzipayService`: generateFormToken() y verifyHash()
- Vistas: `payment.blade.php`, `confirmacion.blade.php`
- Email de confirmación: `PurchaseConfirmation` mailable
- Modelo `Purchase` actualizado con campos de pago
- Rutas CSRF-excluidas para Krypton/IPN
- Manejo completo de estados de pago
- Tarjetas de prueba documentadas

### 🔑 Abril-Mayo 2026 - Sistema de Leads y Google OAuth

- Google OAuth 2.0 con Laravel Socialite
- `LeadController` con index, exportExcel, updateStatus
- Dashboard admin con estadísticas
- Header con botón de login Google y foto de perfil
- Leads vinculados a asesoras (advisor_id)
- Home dinámico cargando cursos desde BD
- Seeders automáticos: AdvisorSeeder, CourseSeeder, LeadSeeder
- Migraciones: google_fields, mode, asesora_id, leads, purchases

### 📚 Abril 2026 - CRUD de Cursos

- Modelos: Course, Advisor, Professor, CourseSesion, CourseObjetivo, CourseParticipante
- CursoController completo (CRUD + relaciones)
- Vistas admin: index, crear, editar
- Migraciones iniciales de cursos
- Relaciones: Curso → Asesora, Curso → Profesores (many-to-many)
- Subida de image_promotion

---

## Instalación y Configuración

```bash
# Clonar repositorio
git clone https://github.com/PreciadoCaesar/ryc.git
cd ryc

# Instalar dependencias PHP
composer install --ignore-platform-reqs

# Instalar dependencias Node
npm install

# Copiar archivo de entorno
cp .env.example .env
# Editar .env con tus credenciales de BD, Google OAuth, Izipay

# Generar key
php artisan key:generate

# Ejecutar migraciones
php artisan migrate

# (Opcional) Poblar datos de prueba
php artisan db:seed

# Compilar assets
npm run build

# Iniciar servidor
php artisan serve
```

### Variables de entorno requeridas

```env
# Base de datos
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ryc
DB_USERNAME=root
DB_PASSWORD=

# Google OAuth
GOOGLE_CLIENT_ID=
GOOGLE_CLIENT_SECRET=
GOOGLE_REDIRECT_URL=http://localhost:8000/auth/google/callback

# Izipay
IZIPAY_ENDPOINT=https://api.micuentaweb.pe
IZIPAY_USERNAME=
IZIPAY_PASSWORD=
IZIPAY_PUBLIC_KEY=
IZIPAY_SHA256_KEY=

# Mail (para confirmaciones de compra)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=noreply@rc-consulting.org
MAIL_PASSWORD=
MAIL_ENCRYPTION=tls
```

---

## Rutas Principales

| URL | Descripción |
|-----|-------------|
| `/` | Home con cursos dinámicos |
| `/cursos-virtuales` | Catálogo de cursos virtuales |
| `/diplomas-virtuales` | Catálogo de diplomas virtuales |
| `/curso/{slug}` | Landing page del curso |
| `/nosotros` | Sobre nosotros |
| `/experiencia` | Experiencia y alianzas |
| `/auth/google` | Inicio de sesión Google |
| `/admin/dashboard` | Dashboard admin |
| `/admin/cursos` | CRUD de cursos |
| `/admin/profesores` | CRUD de profesores |
| `/admin/leads` | Gestión de leads |
| `/checkout/pagar` | Pasarela de pago Izipay |
| `/checkout/exito` | Confirmación de pago |
| `/izipay/ipn` | Webhook Izipay |

---

## Modelos de Datos

### Course
- `title`, `subtitle`, `slug`, `type`, `mode` (en_vivo/grabado)
- `description`, `phrase`
- `image_promotion`, `image_cover`
- `inhouse_web`, `inhouse_mobile`
- `precio_regular`, `precio_flash`, `precio_pronto`
- `fecha_inicio_iso`, `fecha_fin`, `fecha_limite_oferta`
- `sessions`, `hours`
- `specialization_name`
- `asesora_id` (FK → advisors)
- `temario_hierarchical` (JSON)
- Relaciones: `objetivos()`, `participantes()`, `temario()`, `profesores()`, `asesora()`

### Professor
- `name`, `primer_nombre`, `photo`
- `secciones` (JSON): array de {titulo, elementos[]}
- Relación: `courses()` (many-to-many)

### Advisor
- `name`, `photo`, `whatsapp`, `cargo`, `tipo` (asesora/inhouse)
- Relaciones: `courses()`, `leads()`

---

## Licencia

Proyecto privado - R&C Consulting E.I.R.L. Todos los derechos reservados.
