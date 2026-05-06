# 🚀 Avances del Proyecto R&C Consulting

## 📅 Fecha: 15/04/2026

---

## ✅ Lo que se hizo

### 1. **Página de Nosotros** (`/nosotros`)
- ✅ Convertida de HTML estático a **Laravel Blade**
- ✅ Diseño idéntico al original (`nosotros/home.php`)
- ✅ Header y footer reutilizados desde `layouts.app`
- ✅ CSS copiado a `public/css/nosotros/styles.css`
- ✅ Imágenes migradas a `public/img/`
- ✅ Ruta configurada en `routes/web.php`
- ✅ Regla `.htaccess` para redirigir a Laravel

**Secciones incluidas:**
- Hero con estadísticas (+23 años, +30,000 certificados)
- Acerca de nosotros (Historia, Misión, Visión)
- Nuestros logros
- Aportes a la Gestión Pública
- Formulario de cotización con envío a Google Sheets + WhatsApp

---

### 2. **Página de Experiencia y Alianzas** (`/experiencia`)
- ✅ Clonada idéntica de `alianzas/index.html`
- ✅ CSS inline completo extraído del HTML
- ✅ Header y footer desde `layouts.app`
- ✅ Imágenes copiadas a `public/img/alianzas/` y `public/img/equipo/`

**Secciones incluidas:**
- Hero de Garantía Institucional
- Carrusel de Entidades (10 logos con scroll infinito)
- Estructura Organizacional (con Fancybox zoom)
- Equipo Académico (grid de profesores con "Ver todos")
- Equipo Consulting (Equipo Directivo, Comercial, Marketing, Inhouse, Gestión y Soporte)

---

### 3. **Página de Suscripciones** (`/suscripciones`)
- ✅ Nuevo diseño移植ado desde `guia-suscripciones/`
- ✅ Planes: Personal, Premium, Dual, Institucional
- ✅ Sección de Financiamiento
- ✅ FAQ con acordeón
- ✅ Modales de registro
- ✅ CSS en `public/css/suscripciones/styles.css`

---

### 4. **Mejoras del Header**
- ✅ Rutas absolutas con `asset()` corregidas para imágenes
- ✅ `img/icons/casa.svg` → `{{ asset('img/icons/casa.svg') }}`
- ✅ `img/icons/merito.svg` → `{{ asset('img/icons/merito.svg') }}`
- ✅ `img/logo-rc-consulting-sin-fondo.webp` → `{{ asset('img/logo-rc-consulting-sin-fondo.webp') }}`

---

### 5. **Imágenes Migradas**

| Carpeta | Contenido |
|---------|-----------|
| `public/img/alianzas/` | Todas las imágenes de alianzas (logos, organigramas, etc.) |
| `public/img/alianzas/4x/1.5x/` | Iconos del hero |
| `public/img/alianzas/Logo de entidades/` | 10 logos de entidades |
| `public/img/alianzas/Profesores/` | 26 fotos de profesores |
| `public/img/equipo/` | Fotos del equipo R&C |

---

### 6. **Estructura de Archivos**

#### Archivos modificados/creados:
| Archivo | Acción |
|---------|--------|
| `resources/views/experiencia.blade.php` | Actualizado con diseño completo |
| `resources/views/suscripciones/index.blade.php` | Nuevo diseño移植ado |
| `resources/views/partials/header.blade.php` | Rutas corregidas |
| `public/css/experiencia/styles.css` | Copiado de alianzas |

---

### 7. **Rutas de Imágenes Corregidas**

| Original (alianzas) | Nuevo (Laravel) |
|--------------------|-----------------|
| `img/4x/1.5x/Recurso 52@1.5x.webp` | `{{ asset('img/alianzas/4x/1.5x/Recurso 52@1.5x.webp') }}` |
| `./Personal/Estefani.jpg` | `{{ asset('img/equipo/Estefani.jpg') }}` |
| `./Profesores/Ing. Howard.jpg` | `{{ asset('img/alianzas/Profesores/Ing. Howard.jpg') }}` |

---

## 🔧 Problemas resueltos

### ✅ Rutas de imágenes rotas
- ❌ `./img/icons/casa.svg` funcionaba solo en home
- ✅ Cambiado a `{{ asset('img/icons/casa.svg') }}` para rutas absolutas

### ✅ CSS faltante en experiencia
- ❌ Diseño roto, sin estilos
- ✅ CSS inline completo extraído del HTML de alianzas

### ✅ Imágenes de profesores rotas
- ❌ No aparecían las fotos
- ✅ Copiadas a `public/img/alianzas/Profesores/`

---

## 📅 Fecha: 30/04/2026

---

## ✅ Lo que se hizo

### 1. **Sistema de Leads para Asesoras** (Excel en Tiempo Real)
- ✅ Migración `create_leads_table` (nombre, celular, correo, curso, consulta, status, is_whatsapp, advisor_id)
- ✅ Modelo `Lead` con relación a `Advisor`
- ✅ Evento `LeadUpdated` para broadcast en tiempo real
- ✅ API `LeadController` (GET/POST/PUT/DELETE `/api/leads`)
- ✅ Vista `asesora/leads.blade.php` con **Handsontable** (Excel visual)
- ✅ CSS `public/css/asesora/leads.css` para interfaz
- ✅ JS `resources/js/asesora-spreadsheet.js` con:
  - Polling cada 5s para actualizaciones
  - Soporte WebSocket opcional (Laravel Echo)
  - Solo editable: columna de estado (ingreso/contacto/venta cerrada/no interesado)
  - Clientes WhatsApp marcados en **verde**
  - Auto-guardado al cambiar estado
- ✅ Actualización de `mostrar.blade.php` para guardar leads localmente + Google Apps Script
- ✅ CSRF token meta tag agregado en `layouts/app.blade.php`
- ✅ Nueva ruta `/asesora/leads` en `web.php`

### 2. **Limpieza de Proyecto**
- ✅ Eliminado directorio `paginaPrincipal - copia` (ya no necesario)

### 3. **Preparación para Blog CMS**
- ✅ Investigación de opciones: Prezet, TallCMS, Blogr, Valero, Filament Blog
- ✅ Seleccionado **TallCMS** como mejor opción para SEO + Filament 5
- ✅ Creado `TALLCMS_SETUP.md` con instrucciones de instalación

---

## 📅 Fecha: 15/04/2026

---

## ✅ Lo que se hizo

### 1. **Página de Nosotros** (`/nosotros`)
- ✅ Convertida de HTML estático a **Laravel Blade**
- ✅ Diseño idéntico al original (`nosotros/home.php`)
- ✅ Header y footer reutilizados desde `layouts.app`
- ✅ CSS copiado a `public/css/nosotros/styles.css`
- ✅ Imágenes migradas a `public/img/`
- ✅ Ruta configurada en `routes/web.php`
- ✅ Regla `.htaccess` para redirigir a Laravel

**Secciones incluidas:**
- Hero con estadísticas (+23 años, +30,000 certificados)
- Acerca de nosotros (Historia, Misión, Visión)
- Nuestros logros
- Aportes a la Gestión Pública
- Formulario de cotización con envío a Google Sheets + WhatsApp

---

### 2. **Página de Experiencia y Alianzas** (`/experiencia`)
- ✅ Clonada idéntica de `alianzas/index.html`
- ✅ CSS inline completo extraído del HTML
- ✅ Header y footer desde `layouts.app`
- ✅ Imágenes copiadas a `public/img/alianzas/` y `public/img/equipo/`

**Secciones incluidas:**
- Hero de Garantía Institucional
- Carrusel de Entidades (10 logos con scroll infinito)
- Estructura Organizacional (con Fancybox zoom)
- Equipo Académico (grid de profesores con "Ver todos")
- Equipo Consulting (Equipo Directivo, Comercial, Marketing, Inhouse, Gestión y Soporte)

---

### 3. **Página de Suscripciones** (`/suscripciones`)
- ✅ Nuevo diseño移植ado desde `guia-suscripciones/`
- ✅ Planes: Personal, Premium, Dual, Institucional
- ✅ Sección de Financiamiento
- ✅ FAQ con acordeón
- ✅ Modales de registro
- ✅ CSS en `public/css/suscripciones/styles.css`

---

### 4. **Mejoras del Header**
- ✅ Rutas absolutas con `asset()` corregidas para imágenes
- ✅ `img/icons/casa.svg` → `{{ asset('img/icons/casa.svg') }}`
- ✅ `img/icons/merito.svg` → `{{ asset('img/icons/merito.svg') }}`
- ✅ `img/logo-rc-consulting-sin-fondo.webp` → `{{ asset('img/logo-rc-consulting-sin-fondo.webp') }}`

---

### 5. **Imágenes Migradas**

| Carpeta | Contenido |
|---------|-----------|
| `public/img/alianzas/` | Todas las imágenes de alianzas (logos, organigramas, etc.) |
| `public/img/alianzas/4x/1.5x/` | Iconos del hero |
| `public/img/alianzas/Logo de entidades/` | 10 logos de entidades |
| `public/img/alianzas/Profesores/` | 26 fotos de profesores |
| `public/img/equipo/` | Fotos del equipo R&C |

---

### 6. **Estructura de Archivos**

#### Archivos modificados/creados:
| Archivo | Acción |
|---------|--------|
| `resources/views/experiencia.blade.php` | Actualizado con diseño completo |
| `resources/views/suscripciones/index.blade.php` | Nuevo diseño移植ado |
| `resources/views/partials/header.blade.php` | Rutas corregidas |
| `public/css/experiencia/styles.css` | Copiado de alianzas |

---

### 7. **Rutas de Imágenes Corregidas**

| Original (alianzas) | Nuevo (Laravel) |
|--------------------|-----------------|
| `img/4x/1.5x/Recurso 52@1.5x.webp` | `{{ asset('img/alianzas/4x/1.5x/Recurso 52@1.5x.webp') }}` |
| `./Personal/Estefani.jpg` | `{{ asset('img/equipo/Estefani.jpg') }}` |
| `./Profesores/Ing. Howard.jpg` | `{{ asset('img/alianzas/Profesores/Ing. Howard.jpg') }}` |

---

## 🔧 Problemas resueltos

### ✅ Rutas de imágenes rotas
- ❌ `./img/icons/casa.svg` funcionaba solo en home
- ✅ Cambiado a `{{ asset('img/icons/casa.svg') }}` para rutas absolutas

### ✅ CSS faltante en experiencia
- ❌ Diseño roto, sin estilos
- ✅ CSS inline completo extraído del HTML de alianzas

### ✅ Imágenes de profesores rotas
- ❌ No aparecían las fotos
- ✅ Copiadas a `public/img/alianzas/Profesores/`

---

## 📋 Pendiente

- [ ] Eliminar carpeta `alianzas/` después de verificar todo funciona
- [ ] Configurar VirtualHost en XAMPP para que DocumentRoot sea `public/`
- [ ] Agregar validación al formulario de nosotros
- [ ] Optimizar imágenes del carrusel de entidades
- [ ] **Instalar TallCMS** para blog (ver `TALLCMS_SETUP.md`)
- [ ] Configurar SEO del blog (meta tags, sitemaps, Open Graph)

---

## 🌐 URLs

| Página | URL |
|--------|-----|
| Home | `http://localhost/ryc/` |
| Nosotros | `http://localhost/ryc/nosotros` |
| Experiencia | `http://localhost/ryc/experiencia` |
| Suscripciones | `http://localhost/ryc/suscripciones` |
| **Gestión Leads (Asesora)** | `http://localhost/ryc/asesora/leads` |

---

## 🛠️ Tecnologías

- **Laravel 12**
- **Blade Templates**
- **Bootstrap 5.3.2**
- **Font Awesome 6.5.0**
- **Google Fonts (Poppins, Montserrat)**
- **Fancybox 5.0** (zoom de imágenes)
- **Handsontable** (Excel visual para asesoras)
- **Apache/XAMPP**

---

## 📝 Nota sobre carpetas

- `alianzas/` - Solo guías, se eliminará después
- `guia-suscripciones/` - Solo guías, se eliminará después
- `nueva-Personal/` - Fotos sin usar, se eliminará
- `alianzas/Personal/` → `public/img/equipo/`
- `alianzas/Profesores/` → `public/img/alianzas/Profesores/`