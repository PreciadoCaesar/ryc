# INSTRUCCIONES PARA OPENCODE — Crear `/formulario` (Gestor de Cursos y Diplomados)

## Contexto del proyecto

Este proyecto es un sistema de landing pages para **R&C Consulting**. El archivo principal es `index.html` (plantilla de curso) que ya tiene implementado un sistema de "data-bind" y un motor `RCEngine` que hidrata la página con datos dinámicos.

Ya existe un `admin.html` (gestor de plantillas) que **NO se debe tocar**. Lo que se necesita es crear una ruta/página nueva llamada `/formulario` que sea la **interfaz pública de registro de leads** — es decir, un formulario standalone que cualquier usuario pueda llenar para inscribirse o solicitar información sobre un curso/diplomado específico.

---

## ¿Qué es `/formulario`?

Es una página HTML independiente (`/formulario/index.html` o `/formulario.html`) que muestra:

1. Un **formulario de captación de leads** con los mismos campos que el panel amarillo del `index.html` (nombre, correo, celular, checkbox de privacidad, botón de envío).
2. El **nombre del curso/diplomado** al que corresponde (pasado por parámetro URL, ej: `?curso=siaf-web-2026`).
3. El **precio de oferta** y fecha límite si aplica (también via parámetro o cargado desde un JSON).
4. Envío al mismo **Google Apps Script** (`ver.js`) que ya existe.

---

## Diseño: ESTRICTAMENTE igual al panel amarillo de `index.html`

No crear diseño nuevo. Reutilizar **exactamente** los mismos estilos del panel amarillo que ya existe en `styles.css`. Las clases a usar son:

```
.panel-amarillo
.panel-oferta-tag
.panel-price-box
.panel-price-label
.panel-price-main
.panel-price-regular
.precio-tachado
.contain-btn-pago
.btn-pago-tarjeta
.panel-registro-box
.panel-registro-text
.panel-check
.btn-panel-submit1
.btn-submit-icon
.panel-logos
```

El formulario debe verse **idéntico** al panel lateral derecho que aparece en `index.html`. Solo cambia que ahora está centrado en pantalla completa sin el `content-wrapper` a la izquierda.

---

## Estructura HTML de `/formulario`

```html
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Solicitar Información | R&C Consulting</title>
  <!-- Mismos CDN que index.html -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link href="../styles.css" rel="stylesheet"> <!-- Mismo CSS, sin tocar -->
</head>
<body style="background: #f0f0f0; min-height: 100vh; display: flex; align-items: center; justify-content: center;">

  <div class="panel-amarillo" style="max-width: 420px; width: 100%; margin: 30px auto;">

    <!-- Tag de oferta — se llena dinámicamente con JS -->
    <div class="panel-oferta-tag">
      🔥 OFERTA FLASH <br>CONSULTA CON TU ASESORA
    </div>

    <!-- Precio — se llena dinámicamente -->
    <div class="panel-price-box">
      <div class="panel-price-label" style="display:flex; justify-content:center; align-items:center; padding-bottom:10px; font-size:15px;">
        Oferta hasta el <span id="fechaLimiteOferta" style="margin-left:4px;">—</span>
      </div>
      <div class="panel-price-main">
        <span>S/. </span><span id="precioOferta">—</span>
        <div class="panel-price-regular">
          Precio regular:<br>
          <span class="precio-tachado">s/. <span id="precioRegular">—</span></span>
        </div>
      </div>
      <div class="contain-btn-pago" style="width:100%; margin:25px 0 15px 0; background:white; border-radius:12px;">
        <a href="#" id="btnPago" class="btn btn-pago-tarjeta">
          <i class="fas fa-credit-card"></i>
          <span>Pagar con tarjeta</span>
        </a>
      </div>
      <div class="panel-logos">
        <img src="../img/added/payment.webp" alt="Métodos de pago">
      </div>
    </div>

    <!-- Formulario de registro — idéntico al del panel -->
    <div class="panel-registro-box">
      <p class="panel-registro-text">Registra tus datos y un asesor especializado te contactará para ayudarte</p>
      <form onsubmit="return handleLead(event)" id="formRegistroPanel">
        <input type="text"  name="nombre"  placeholder="Ingresa nombre completo"   required>
        <input type="email" name="correo"  placeholder="Ingresa correo electrónico" required>
        <input type="tel"   name="celular" placeholder="Ingresa celular/WhatsApp"   required>
        <label class="panel-check">
          <input type="checkbox" required checked>
          <span>Acepto las políticas de privacidad de datos</span>
        </label>
        <button type="submit" class="btn-panel-submit1" style="display:flex; align-items:center; justify-content:center; gap:8px;">
          <img src="../img/added/flecha.webp" alt="Icono" class="btn-submit-icon">
          <span>Solicitar información</span>
        </button>
      </form>
    </div>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="./formulario.js"></script>
</body>
</html>
```

---

## Lógica JS — `formulario.js`

### 1. Leer parámetros de la URL

La URL tendrá la forma:
```
/formulario?curso=siaf-web-2026&origen=facebook
```

Parámetros posibles:
| Parámetro | Descripción | Ejemplo |
|-----------|-------------|---------|
| `curso` | Slug del curso (para buscar datos) | `siaf-web-2026` |
| `origen` | Origen del lead (para Sheets) | `facebook`, `google`, `organico` |

### 2. Cargar datos del curso

Los datos del curso vienen del mismo sistema de plantillas que usa `admin.html` / `app-core.js`. El estado del curso se guarda en `localStorage` con la clave `rc_templates` (array de objetos) y la plantilla activa con `rc_active_template`.

Para el formulario, buscar la plantilla cuyo `slugUrl` coincida con el parámetro `curso` de la URL:

```js
// Pseudocódigo
const params  = new URLSearchParams(window.location.search);
const slugURL = params.get('curso');
const origen  = params.get('origen') || 'directo';

const templates = JSON.parse(localStorage.getItem('rc_templates') || '[]');
const plantilla = templates.find(t => t.slugUrl === slugURL) || {};

// Poblar UI
document.getElementById('fechaLimiteOferta').textContent = plantilla.fechaLimiteOferta || '—';
document.getElementById('precioOferta').textContent      = plantilla.precioOferta      || '—';
document.getElementById('precioRegular').textContent     = plantilla.precioRegular     || '—';
document.getElementById('btnPago').href                  = plantilla.urlCarritoPago    || '#';
document.title = (plantilla.tituloCursoCorto || 'Solicitar Información') + ' | R&C Consulting';
```

### 3. Envío al Google Apps Script (exactamente igual que `index.html`)

El endpoint del Apps Script es:
```
https://script.google.com/macros/s/AKfycbw1yJHtY22cXwnW4XDZo9w2eNckcBMIen9MdcaAEyAHA-0WsOGRJQ_4ClkE_SPoWQgMKg/exec
```

Los parámetros que espera el script (`ver.js`) son:

| Campo GAS | Descripción | Valor a enviar |
|-----------|-------------|----------------|
| `origen` | Canal de captación | Parámetro URL `origen` |
| `nombres` | Nombre completo | Input nombre del form |
| `correo` | Email | Input correo |
| `telefono` | Celular/WhatsApp | Input celular |
| `institucion` | Institución (opcional) | Vacío o campo adicional |
| `cantidadAlumnos` | Cantidad alumnos | Vacío (es lead individual) |
| `nivelCurso` | Nivel del curso | Vacío |
| `curso` | Nombre del curso | `plantilla.nombreCursoSheets` |
| `urlWha` | URL WhatsApp de asesora | Construir desde `plantilla.asesoraTelefono` |

La función `handleLead` debe ser idéntica a la ya existente en `js/added.js` o `js/funcionamiento.js`. **No reimplementar** — importar o copiar directamente esa función.

Formato URL de envío (GET):
```
SCRIPT_URL?origen=...&nombres=...&correo=...&telefono=...&curso=...&urlWha=...
```

Tras éxito, mostrar un mensaje de confirmación simple (puede ser un `alert` o un div de éxito inline, **sin SweetAlert** para no añadir dependencias).

---

## Archivos a crear

```
/formulario/
  index.html     ← HTML del formulario (estructura arriba)
  formulario.js  ← Lógica: leer URL params, cargar plantilla, enviar a GAS
```

**No tocar:**
- `index.html` (raíz)
- `admin.html`
- `styles.css`
- `js/app-core.js`
- `js/admin.js`
- `js/funcionamiento.js`
- `js/added.js`
- `ver.js`

---

## Resumen del flujo completo

```
Usuario llega a /formulario?curso=siaf-web-2026&origen=facebook
       ↓
formulario.js lee params de URL
       ↓
Busca en localStorage la plantilla con slugUrl === "siaf-web-2026"
       ↓
Hidrata el panel: precio, fecha, botón de pago
       ↓
Usuario llena nombre + correo + celular → submit
       ↓
GET al Apps Script con todos los campos mapeados
       ↓
Confirmación de envío inline (sin recargar la página)
```

---

## Notas importantes

- **No cambiar `styles.css`** bajo ningún concepto. Si algún estilo falta, añadirlo inline en el propio HTML del formulario.
- El panel amarillo en mobile ya es responsive por los estilos existentes. No añadir media queries nuevas.
- Si `localStorage` no tiene la plantilla (ej. primer acceso sin admin), mostrar el formulario igual pero con precios en "—" y el botón de pago deshabilitado.
- El `panel-amarillo` tiene `position: sticky` en desktop dentro del layout de dos columnas de `index.html`. Aquí, al estar solo, no necesita sticky — usar `margin: auto` para centrarlo.
- Mantener la misma estructura de carpetas del proyecto. Si el proyecto tiene `/js/`, `/img/`, etc., las rutas relativas de `/formulario/index.html` deben ajustarse con `../`.