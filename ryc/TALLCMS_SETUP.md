# 🚀 TallCMS - Guía de Instalación

## 📋 ¿Por qué TallCMS?

- **⭐ Estrellas**: 3 en GitHub (proyecto nuevo, muy activo en 2026)
- **🛠️ Tech Stack**: Laravel 11/12 + Filament 5 + TALL Stack (Tailwind, Alpine, Livewire, Laravel)
- **🔍 SEO Completo**: Meta descriptions, canonical URLs, structured data, XML sitemaps, robots.txt
- **📝 Editor**: Block-based con 16+ bloques integrados
- **🎨 Filament 5**: Panel admin moderno y potente
- **📱 Responsive**: Tailwind CSS incluido
- **🔗 GitHub**: https://github.com/tallcms/cms
- **🌐 Web**: https://tallcms.com/

---

## ⚙️ Requisitos

- **PHP**: 8.2+ con OpenSSL, PDO, Mbstring, GD
- **Laravel**: 11.0 o 12.0
- **Filament**: 5.0
- **Base de datos**: MySQL 8.0+, MariaDB 10.3+, o SQLite
- **Node.js**: Para compilar assets (opcional si usas precompilados)

---

## 🚀 Instalación (Cuando tengas PHP disponible)

### Opción A: Instalación en proyecto existente (Recomendado)

```bash
# 1. Instalar TallCMS via Composer
composer require tallcms/cms

# 2. Publicar configuración y assets
php artisan vendor:publish --provider="Tallcms\Cms\CmsServiceProvider"

# 3. Ejecutar migraciones
php artisan migrate

# 4. Instalar Filament (si no lo tienes)
composer require filament/filament:"^5.0"
php artisan filament:install

# 5. Crear usuario admin
php artisan make:filament-user
```

### Opción B: Nuevo proyecto desde cero

```bash
# 1. Crear nuevo proyecto Laravel
composer create-project laravel/laravel mi-blog
cd mi-blog

# 2. Instalar Filament 5
composer require filament/filament:"^5.0"
php artisan filament:install

# 3. Instalar TallCMS
composer require tallcms/cms
php artisan vendor:publish --provider="Tallcms\Cms\CmsServiceProvider"
php artisan migrate

# 4. Crear usuario admin
php artisan make:filament-user
```

---

## 🔧 Configuración Inicial

### 1. Configurar Site Settings
Accede a tu panel de Filament:
```
http://tu-sitio.com/admin
```

Ve a **Site Settings** y configura:
- Nombre del sitio
- Información de contacto
- Enlaces de redes sociales
- Logo y favicon

### 2. Configurar SEO Global
En el archivo `config/tallcms.php`:
```php
'seo' => [
    'site_name' => 'R&C Consulting',
    'default_description' => 'Especialistas en gestión pública y capacitación',
    'default_keywords' => ['gestión pública', 'capacitación', 'cursos'],
    'og_image' => asset('img/og-default.jpg'),
],
```

### 3. Crear Páginas Estáticas
Desde el panel admin:
- **Pages** → New Page
- Tipos: Home, About, Contact, etc.
- Usa el block editor para contenido rico

### 4. Crear Posts del Blog
- **Posts** → New Post
- Categorías y tags
- Meta description para SEO
- Programar publicación (opcional)

---

## 🔍 Características SEO de TallCMS

### Automático:
- ✅ Meta descriptions personalizadas por post/página
- ✅ Canonical URLs para evitar contenido duplicado
- ✅ Open Graph (Facebook) y Twitter Cards
- ✅ JSON-LD structured data (Schema.org)
- ✅ XML Sitemap automático (`/sitemap.xml`)
- ✅ Robots.txt configurable
- ✅ URLs amigables (slugs automáticos)

### Para configurar:
```php
// config/tallcms.php
'seo' => [
    'canonical' => true,
    'og_tags' => true,
    'twitter_cards' => true,
    'schema_org' => true,
    'sitemap' => true,
],
```

---

## 📝 Uso del Block Editor

TallCMS incluye 16+ bloques:
- Texto rico
- Imágenes
- Videos embebidos
- Testimonios
- Tarjetas (cards)
- Acordeones
- Pestañas
- Carruseles
- Formularios de contacto
- Y más...

---

## 🔄 Gestión de Medios

- **Media Library**: Organización por colecciones
- **Metadata**: Alt text, captions, descriptions
- **Redimensionamiento**: Automático al subir
- **Optimización**: Compresión para web

---

## 👥 Roles y Permisos

| Rol | Permisos |
|-----|-----------|
| Super Admin | Acceso total |
| Administrator | Gestionar todo excepto configuración global |
| Editor | Editar/Publicar contenido propio y de otros |
| Author | Editar/Publicar solo contenido propio |

---

## 🚀 Comandos Útiles

```bash
# Limpiar caché
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Ver rutas registradas
php artisan route:list | grep tallcms

# Reindexar búsqueda (si aplica)
php artisan tallcms:reindex
```

---

## 🔗 Integración con R&C Consulting

Una vez instalado, puedes:

1. **Crear blog de contenidos educativos** relacionados a gestión pública
2. **SEO para cursos**: Cada curso puede tener un post de blog asociado
3. **Landing pages**: Crear páginas de aterrizaje para campañas específicas
4. **FAQ/Documentación**: Usar el block editor para documentación técnica

---

## 📚 Recursos

- **Documentación**: https://tallcms.com/docs
- **GitHub Issues**: https://github.com/tallcms/cms/issues
- **Demostración**: https://demo.tallcms.com (si está disponible)
- **Filament Docs**: https://filamentphp.com/docs

---

## ⚠️ Notas Importantes

1. **Backup**: Haz backup de tu BD antes de instalar
2. **Compatibilidad**: Verifica que tu versión de Laravel sea 11+ o 12+
3. **Filament**: TallCMS requiere Filament 5, no versiones anteriores
4. **Node.js**: Solo necesitas npm si vas a modificar los assets de TALL stack

---

## 🎯 Siguientes Pasos (Cuando esté instalado)

- [ ] Configurar categorías del blog (Gestión Pública, Cursos, Noticias)
- [ ] Crear primer post de blog
- [ ] Configurar página "Acerca de" con el contenido de `/nosotros`
- [ ] Integrar formulario de contacto en el blog
- [ ] Configurar Google Analytics en el panel admin
- [ ] Optimizar meta tags para palabras clave de R&C
