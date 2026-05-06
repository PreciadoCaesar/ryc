<?php

namespace Database\Seeders;

use App\Models\Advisor;
use App\Models\Course;
use App\Models\Professor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        $professor = Professor::create([
            'name' => 'Docente Principal',
            'bio' => 'Especialista en gestión pública',
            'photo' => null,
        ]);

        $advisor = Advisor::create([
            'name' => 'Asesora R&C',
            'whatsapp' => '51950883155',
            'photo' => null,
            'email' => 'informes@rc-consulting.org',
        ]);

        $cursosGrabados = [
            ['title' => 'Nueva Ley General de Contrataciones Públicas', 'image' => 'ley-general-contratacion-publicas.webp', 'hours' => 90, 'link' => 'https://rc-consulting.org/online/curso-nueva-ley-general-de-contrataciones-publicas/', 'color' => '#9e183a', 'type' => 'curso', 'mode' => 'grabado', 'featured' => true],
            ['title' => 'SEACE 3.0 y PLADICOP', 'image' => 'portada-pladicop-seace-online.webp', 'hours' => 90, 'link' => 'https://rc-consulting.org/online/curso-pladicop-y-seace-3/', 'color' => '#9e183a', 'type' => 'curso', 'mode' => 'grabado', 'featured' => true, 'overlay_html' => 'Sistema Electrónico de Contrataciones del Estado<br><span style="color:#ffbb00;">SEACE 3.0 y PLADICOP</span>'],
            ['title' => 'SIGA MEF – (Nivel Básico)', 'image' => 'PortadaAAnline.jpg', 'hours' => 90, 'link' => 'https://rc-consulting.org/online/curso-siga-mef/', 'color' => '#9e183a', 'type' => 'curso', 'mode' => 'grabado', 'featured' => false],
            ['title' => 'SIGA MEF Módulo Patrimonio', 'image' => 'portada-curso-siga-mef-gestion-patrimonial.webp', 'hours' => 90, 'link' => 'https://rc-consulting.org/siga-mef-bienes-patrimoniales/', 'color' => '#9e183a', 'type' => 'curso', 'mode' => 'grabado', 'featured' => false, 'overlay_html' => 'Aplicaciones en la Gestión Patrimonial<br><span style="color:#ffbb00;">SIGA MEF MODULO PATRIMONIO</span>'],
            ['title' => 'Soporte Técnico SIAF y SIGA', 'image' => 'portada-curso-soporte-tecnico-siaf-siga.webp', 'hours' => 90, 'link' => 'https://rc-consulting.org/soporte-tecnico-siaf-sp-y-siga-mef-online/', 'color' => '#9e183a', 'type' => 'curso', 'mode' => 'grabado', 'featured' => false],
            ['title' => 'Proyectos de Inversión Pública - INVIERTE.PE', 'image' => 'portada-curso-gestion-proyectos-inversion-invierte-pe.webp', 'hours' => 90, 'link' => 'https://rc-consulting.org/curso-proyectos-de-inversion-publica-invierte-pe-online/', 'color' => '#9e183a', 'type' => 'curso', 'mode' => 'grabado', 'featured' => false],
            ['title' => 'Elaboración de Fichas Técnicas según Invierte.pe', 'image' => 'portada-elaboracion-fichas-tecnicas-basado-invierte-pe.webp', 'hours' => 90, 'link' => 'https://rc-consulting.org/curso-invierte-peru-llenado-de-fichas-tecnicas-en-dvd-online/', 'color' => '#9e183a', 'type' => 'curso', 'mode' => 'grabado', 'featured' => false],
            ['title' => 'Planeamiento Estratégico en las Entidades Públicas', 'image' => 'portada-curso-planeamiento-estrategico.webp', 'hours' => 90, 'link' => 'https://rc-consulting.org/planeamiento-estrategico-en-el-sector-publico-modalidad-online/', 'color' => '#9e183a', 'type' => 'curso', 'mode' => 'grabado', 'featured' => false],
            ['title' => 'Sistemas de Control Gubernamental', 'image' => 'portada-curso-sistema-control-gubernamental.webp', 'hours' => 90, 'link' => 'https://rc-consulting.org/contabilidad-gubernamental-online/', 'color' => '#9e183a', 'type' => 'curso', 'mode' => 'grabado', 'featured' => false],
            ['title' => 'Gestión de las Obras Públicas', 'image' => 'portada-curso-gestion-obras-publicas.webp', 'hours' => 90, 'link' => 'https://rc-consulting.org/gestion-de-obras-publicas-online/', 'color' => '#9e183a', 'type' => 'curso', 'mode' => 'grabado', 'featured' => false],
            ['title' => 'Gestión y Administración Pública', 'image' => 'portada-curso-gestion-administracion-publica.webp', 'hours' => 90, 'link' => 'https://rc-consulting.org/curso-de-gestion-y-administracion-publica/', 'color' => '#9e183a', 'type' => 'curso', 'mode' => 'grabado', 'featured' => false],
            ['title' => 'Presupuesto Público', 'image' => 'portada-curso-gestion-presupuesto-publico.webp', 'hours' => 90, 'link' => 'https://rc-consulting.org/online/gestion-de-presupuesto-publico/', 'color' => '#9e183a', 'type' => 'curso', 'mode' => 'grabado', 'featured' => false],
            ['title' => 'Régimen Laboral en el Sector Público', 'image' => 'portada-curso-regimen-laboral.webp', 'hours' => 90, 'link' => 'https://rc-consulting.org/curso-regimen-laboral-en-el-sector-publico/', 'color' => '#9e183a', 'type' => 'curso', 'mode' => 'grabado', 'featured' => false],
            ['title' => 'Presupuesto por Resultados – PPR', 'image' => 'portada-curso-presupuesto-por-resultados.webp', 'hours' => 90, 'link' => 'https://rc-consulting.org/presupuesto-por-resultados-ppr-mef-online/', 'color' => '#9e183a', 'type' => 'curso', 'mode' => 'grabado', 'featured' => false],
            ['title' => 'Control Previo y Concurrente', 'image' => 'portada-curso-control-previo-recurrente.webp', 'hours' => 90, 'link' => 'https://rc-consulting.org/control-previo-concurrente-online/', 'color' => '#9e183a', 'type' => 'curso', 'mode' => 'grabado', 'featured' => false],
            ['title' => 'Sistema de Control Interno en las Entidades Públicas', 'image' => 'portada-curso-sistema-control-interno-entidades-publicas.webp', 'hours' => 90, 'link' => 'https://rc-consulting.org/implementacion-de-control-interno-online/', 'color' => '#9e183a', 'type' => 'curso', 'mode' => 'grabado', 'featured' => false],
            ['title' => 'Gestión por Procesos en la Administración Pública', 'image' => 'portada-curso-gestion-por-procesos-administracion.webp', 'hours' => 90, 'link' => 'https://rc-consulting.org/gestion-por-procesos-en-las-entidades-publicas/', 'color' => '#9e183a', 'type' => 'curso', 'mode' => 'grabado', 'featured' => false],
            ['title' => 'Gestión de Bienes Muebles (SNA)', 'image' => 'portada-curso-gestion-bienes-muebles.webp', 'hours' => 90, 'link' => 'https://rc-consulting.org/bienes-patrimoniales-sna-mef-online/', 'color' => '#9e183a', 'type' => 'curso', 'mode' => 'grabado', 'featured' => false],
            ['title' => 'Contabilidad Gubernamental', 'image' => 'portada-curso-contabilidad-gubernamental.webp', 'hours' => 90, 'link' => 'https://rc-consulting.org/contabilidad-gubernamental-online/', 'color' => '#9e183a', 'type' => 'curso', 'mode' => 'grabado', 'featured' => false],
            ['title' => 'Sistema Nacional de Tesorería', 'image' => 'portada-curso-sistema-nacional-tesoreria.webp', 'hours' => 90, 'link' => 'https://rc-consulting.org/contabilidad-gubernamental-online/', 'color' => '#9e183a', 'type' => 'curso', 'mode' => 'grabado', 'featured' => false],
            ['title' => 'Procedimiento Administrativo General (Ley 27444)', 'image' => 'portada-curso-procedimiento-administrativo-disciplinario-pad.webp', 'hours' => 90, 'link' => 'https://rc-consulting.org/procedimiento-administrativo-general-lpag-27444/', 'color' => '#9e183a', 'type' => 'curso', 'mode' => 'grabado', 'featured' => false],
            ['title' => 'Procedimiento Administrativo Disciplinario y Sancionador', 'image' => 'portada-curso-pad-pas-procedimiento-administrativo.webp', 'hours' => 90, 'link' => 'https://rc-consulting.org/curso-procedimiento-administrativo-disciplinario-pad/', 'color' => '#9e183a', 'type' => 'curso', 'mode' => 'grabado', 'featured' => false],
            ['title' => 'Gestión de Recursos Humanos (Ley Servir)', 'image' => 'portada-curso-gestion-recursos-humanos.webp', 'hours' => 90, 'link' => 'https://rc-consulting.org/curso-gestion-recursos-humanos/', 'color' => '#9e183a', 'type' => 'curso', 'mode' => 'grabado', 'featured' => false],
            ['title' => 'Calidad de Servicio al Ciudadano', 'image' => 'portada-curso-calidad-servicio-ciudadano.webp', 'hours' => 90, 'link' => 'https://rc-consulting.org/curso-calidad-de-servicio-al-ciudadano-online/', 'color' => '#9e183a', 'type' => 'curso', 'mode' => 'grabado', 'featured' => false],
            ['title' => 'Gestión de Riesgos de Corrupción', 'image' => 'portada-curso-gestion-riesgos-corrupcion-administracion-publica.webp', 'hours' => 90, 'link' => 'https://rc-consulting.org/curso-de-gestion-y-administracion-publica/', 'color' => '#9e183a', 'type' => 'curso', 'mode' => 'grabado', 'featured' => false],
            ['title' => 'Gobierno Digital, Trámite Documentario y de Archivos', 'image' => 'portada-curso-gobierno-digital-tramite-documentario.webp', 'hours' => 90, 'link' => 'https://rc-consulting.org/gestion-documentaria-y-manejo-de-archivos-online/', 'color' => '#9e183a', 'type' => 'curso', 'mode' => 'grabado', 'featured' => false],
            ['title' => 'Gestión de Fedatarios', 'image' => 'portada-curso-gestion-de-fedatarios.webp', 'hours' => 90, 'link' => 'https://rc-consulting.org/gestion-de-fedatarios-online/', 'color' => '#9e183a', 'type' => 'curso', 'mode' => 'grabado', 'featured' => false],
            ['title' => 'Gestión Pública para Secretarias y Asistentes', 'image' => 'portada-curso-gestion-publica-para-secretarias-y-asistentes-administrativos.webp', 'hours' => 90, 'link' => 'https://rc-consulting.org/curso-para-secretarias-y-asistentes-administrativas-online/', 'color' => '#9e183a', 'type' => 'curso', 'mode' => 'grabado', 'featured' => false],
            ['title' => 'Redacción Administrativa y de Documentos Oficiales', 'image' => 'portada-curso-redaccion-administrativa-documentos-oficiales.webp', 'hours' => 90, 'link' => 'https://rc-consulting.org/curso-gestion-recursos-humanos/', 'color' => '#9e183a', 'type' => 'curso', 'mode' => 'grabado', 'featured' => false],
            ['title' => 'Planeamiento Estratégico en Gestión del Riesgo de Desastres', 'image' => 'portada-curso-planeamiento-estrategico-desastres.webp', 'hours' => 90, 'link' => 'https://rc-consulting.org/planeamiento-estrategico-en-gestion-de-riesgos-de-desastres/', 'color' => '#9e183a', 'type' => 'curso', 'mode' => 'grabado', 'featured' => false],
        ];

        $diplomadosGrabados = [
            ['title' => 'Diplomado Sistemas Administrativos SIAF SIGA SEACE PLADICOP', 'image' => 'portada-diplomado-sistemas-administrativos.jpg', 'hours' => 384, 'link' => 'https://rc-consulting.org/diplomado-sistemas-administrativos-siaf-siga-seace-pladicop', 'color' => '#9e183a', 'type' => 'diplomado', 'mode' => 'grabado', 'featured' => true],
            ['title' => 'Diplomado Presupuesto Público y SIAF', 'image' => '22PortadaddOnline.jpg', 'hours' => 180, 'link' => 'https://rc-consulting.org/diplomado-presupuesto-publico-siaf-mef-ley-32513', 'color' => '#9e183a', 'type' => 'diplomado', 'mode' => 'grabado', 'featured' => true],
            ['title' => 'Diplomado Contrataciones Públicas', 'image' => 'PortadacontrOnline.jpg', 'hours' => 270, 'link' => 'https://rc-consulting.org/diplomado-contrataciones-publicas', 'color' => '#9e183a', 'type' => 'diplomado', 'mode' => 'grabado', 'featured' => true],
            ['title' => 'SIAF SP y RP, SIGA MEF y SEACE 3.0 y PLADICOP', 'image' => 'diplomado-sistemas-gubernamentales.webp', 'hours' => 270, 'link' => 'https://rc-consulting.org/online/diplomado-sistemas-informaticos-gestion-publica-siaf-siga-seace/', 'color' => '#9e183a', 'type' => 'diplomado', 'mode' => 'grabado', 'featured' => true, 'overlay_html' => '<div class="fs-6">SISTEMAS INFORMÁTICOS EN LA GESTIÓN PÚBLICA<br><span style="color:#ffbb00;">SIAF SP y RP, SIGA MEF y SEACE 3.0 y PLADICOP</span></div>'],
            ['title' => 'Especialización en Gestión Pública', 'image' => 'gestion-publica.png', 'hours' => 384, 'link' => 'https://rc-consulting.org/online/diplomado-especializacion-gestion-publica/', 'color' => '#9e183a', 'type' => 'diplomado', 'mode' => 'grabado', 'featured' => true],
            ['title' => 'Gestión de las Contrataciones bajo la Nueva Ley', 'image' => 'diplomado-contrataciones-publicas.webp', 'hours' => 270, 'link' => 'https://rc-consulting.org/online/diplomado-gestion-contrataciones-publicas/', 'color' => '#9e183a', 'type' => 'diplomado', 'mode' => 'grabado', 'featured' => true, 'overlay_html' => '<div class="fs-6">Gestión de las Contrataciones bajo la Nueva Ley Contrataciones Públicas Ley N° 30269<br><span style="color:#ffbb00;">OECE, PLADICOP y SEACE 3.0</span></div>'],
            ['title' => 'Presupuesto y Finanzas Públicas', 'image' => 'diplomado-presupuesto-finanzas.webp', 'hours' => 180, 'link' => 'https://rc-consulting.org/gestion-del-presupuesto-y-finanzas-publicas/', 'color' => '#9e183a', 'type' => 'diplomado', 'mode' => 'grabado', 'featured' => false],
            ['title' => 'SIAF SP y RP (Nivel Básico y Soporte Técnico)', 'image' => 'diplomado-administracion-financiera-siaf-sp-rp.webp', 'hours' => 180, 'link' => 'https://rc-consulting.org/online/diplomado-siaf-sp-rp/', 'color' => '#9e183a', 'type' => 'diplomado', 'mode' => 'grabado', 'featured' => false, 'overlay_html' => '<div class="fs-6">Sistema Integrado de Administración Financiera – (Nivel Básico y Soporte Técnico)<br><span style="color:#ffbb00;">SIAF SP y RP</span></div>'],
            ['title' => 'SIGA MEF (Nivel Básico y Soporte Técnico)', 'image' => 'diplomado-gestion-administracion-siga-mef.webp', 'hours' => 180, 'link' => 'https://rc-consulting.org/diplomado-de-siga-mef/', 'color' => '#9e183a', 'type' => 'diplomado', 'mode' => 'grabado', 'featured' => false, 'overlay_html' => '<div class="fs-6">Sistema Integrado de Gestión Administrativa – (Nivel Básico y Soporte Técnico)<br><span style="color:#ffbb00;">SIGA MEF</span></div>'],
            ['title' => 'Ofimática Aplicada a la Gestión Pública', 'image' => 'diplomado-ofimatica-aplicada.webp', 'hours' => 120, 'link' => 'https://rc-consulting.org/diploma-ofimatica-word-excel-powerpoint-online/', 'color' => '#9e183a', 'type' => 'diplomado', 'mode' => 'grabado', 'featured' => false],
            ['title' => 'Seguridad y Salud en el Trabajo', 'image' => 'diplomado-seguridad-salud.webp', 'hours' => 180, 'link' => 'https://rc-consulting.org/online/diplomado-seguridad-y-salud-en-el-trabajo/', 'color' => '#9e183a', 'type' => 'diplomado', 'mode' => 'grabado', 'featured' => false],
        ];

        $cursosEnVivo = [
            ['title' => 'Preparación intensiva para Certificación OECE 2026', 'image' => 'PortadasdsWeb.jpg', 'hours' => 90, 'link' => 'https://rc-consulting.org/online/Preparacion intensiva para el examen de Certificacion OECE 2026, incluye simulador del Examen OECE/', 'color' => '#9e183a', 'type' => 'curso', 'mode' => 'en_vivo', 'sesiones' => 6, 'fecha_inicio' => '29 ABR'],
            ['title' => 'Planeamiento Estratégico en el Sector Público CEPLAN', 'image' => 'PortadaPW2Web.jpg', 'hours' => 90, 'link' => 'https://rc-consulting.org/planeamiento-estrategico-en-el-sector-publico-ceplan', 'color' => '#9e183a', 'type' => 'curso', 'mode' => 'en_vivo', 'sesiones' => 6, 'fecha_inicio' => '6 MAY'],
            ['title' => 'BIM - Building Information Modeling', 'image' => 'curso-bim-building-information-modeling.jpg', 'hours' => 90, 'link' => 'https://rc-consulting.org/bim-building-information-modeling', 'color' => '#9e183a', 'type' => 'curso', 'mode' => 'en_vivo', 'fecha_inicio' => '24 MAR'],
            ['title' => 'SIAF-WEB Práctica en Administrativo', 'image' => 'Portadasiaf26Web.jpg', 'hours' => 90, 'link' => 'https://rc-consulting.org/practica-siaf-web-administrativo-contable-tesoreria', 'color' => '#9e183a', 'type' => 'curso', 'mode' => 'en_vivo', 'sesiones' => 6, 'fecha_inicio' => '22 ABRIL'],
            ['title' => 'SIGA-MEF 2026', 'image' => '1curso-sistema-integrado-de-gestion-administrativa-siga-mef-2026.jpg', 'hours' => 90, 'link' => 'https://rc-consulting.org/curso-sistema-integrado-de-gestion-administrativa-siga-mef-2026', 'color' => '#9e183a', 'type' => 'curso', 'mode' => 'en_vivo', 'sesiones' => 6, 'fecha_inicio' => '06 ABRIL'],
            ['title' => 'Presupuesto Público 2026', 'image' => 'presupuesto-publico-2026.jpg', 'hours' => 90, 'link' => 'https://rc-consulting.org/curso-presupuesto-publico-2026', 'color' => '#9e183a', 'type' => 'curso', 'mode' => 'en_vivo', 'sesiones' => 6, 'fecha_inicio' => '08 ABRIL'],
            ['title' => 'Gestión de Tesorería y el SIAF 2026', 'image' => 'Tesoreria-portada.jpg', 'hours' => 90, 'link' => 'https://rc-consulting.org/curso-en-vivo-gestion-tesoreria-siaf-20261', 'color' => '#9e183a', 'type' => 'curso', 'mode' => 'en_vivo', 'fecha_inicio' => '23 MAR'],
            ['title' => 'Inteligencia Artificial Generativa - Prompt Engineering', 'image' => 'propmtPortada.jpg', 'hours' => 90, 'link' => 'https://rc-consulting.org/online/curso-generacion-ia-prompts', 'color' => '#9e183a', 'type' => 'curso', 'mode' => 'en_vivo', 'sesiones' => 6, 'fecha_inicio' => '30 MAR'],
            ['title' => 'Proyectos de Inversión Pública - INVIERTE.PE', 'image' => 'inversiones-publica-invierte-pe.jpg', 'hours' => 90, 'link' => 'https://rc-consulting.org/online/curso-inversiones-publicas-invierte-pe', 'color' => '#9e183a', 'type' => 'curso', 'mode' => 'en_vivo', 'sesiones' => 6, 'fecha_inicio' => '15 ABRIL'],
            ['title' => 'SIGA MEF Gestión Patrimonial', 'image' => 'SIGA.jpg', 'hours' => 90, 'link' => 'https://rc-consulting.org/online/curso-gestion-bienes-muebles-sna-siga-mef/', 'color' => '#9e183a', 'type' => 'curso', 'mode' => 'en_vivo', 'fecha_inicio' => '18 MAR'],
            ['title' => 'Excel IA Profesional', 'image' => 'excel-iaprofesional.jpg', 'hours' => 90, 'link' => 'https://rc-consulting.org/online/curso-excel-ia-profesional', 'color' => '#9e183a', 'type' => 'curso', 'mode' => 'en_vivo', 'fecha_inicio' => '16 MAR'],
            ['title' => 'Contabilidad Gubernamental', 'image' => 'contabilidad-gubernamentalv1.jpg', 'hours' => 90, 'link' => 'https://rc-consulting.org/curso-contabilidad-gubernamential-siaf-mef/', 'color' => '#9e183a', 'type' => 'curso', 'mode' => 'en_vivo', 'sesiones' => 6, 'fecha_inicio' => '22 ABR'],
            ['title' => 'Nueva Ley General de Contrataciones Públicas', 'image' => 'portada-curso-contrataciones-publicas-2026.jpg', 'hours' => 90, 'link' => 'https://rc-consulting.org/online/ley-general-contrataciones-publicas/', 'color' => '#9e183a', 'type' => 'curso', 'mode' => 'en_vivo', 'sesiones' => 6, 'fecha_inicio' => '22 ABRIL'],
            ['title' => 'SEACE 3.0 y PLADICOP', 'image' => 'seace-pladicop.jpg', 'hours' => 90, 'link' => 'https://rc-consulting.org/online/curso-seace-pladiccop/', 'color' => '#9e183a', 'type' => 'curso', 'mode' => 'en_vivo', 'fecha_inicio' => '24 MAR'],
        ];

        $diplomadosEnVivo = [
            ['title' => 'Diplomado Gestión Pública', 'image' => 'diplomado-gestion-publica.jpg', 'hours' => 384, 'link' => 'https://rc-consulting.org/diplomado-gestion-publica', 'color' => '#9e183a', 'type' => 'diplomado', 'mode' => 'en_vivo', 'sesiones' => 18, 'fecha_inicio' => '08 ABRIL'],
            ['title' => 'Diplomado Gestión de Bienes Patrimoniales SIGA-MEF', 'image' => 'diplomado-gestion-bienes-patrimoniales-siga-mef.png', 'hours' => 180, 'link' => 'https://rc-consulting.org/diplomado-de-bienes-patrimoniales-siga-mef', 'color' => '#9e183a', 'type' => 'diplomado', 'mode' => 'en_vivo', 'fecha_inicio' => '18 MAR'],
            ['title' => 'Diplomado Presupuesto Público y SIAF', 'image' => 'DpPresupuesto.jpg', 'hours' => 180, 'link' => 'https://rc-consulting.org/diplomado-presupuesto-publico-siaf-mef', 'color' => '#9e183a', 'type' => 'diplomado', 'mode' => 'en_vivo', 'sesiones' => 12, 'fecha_inicio' => '08 ABRIL'],
            ['title' => 'Diplomado MS Excel e Inteligencia Artificial Generativa', 'image' => 'diplomado-ms-excel-inteligencia-artifical-generativa.png', 'hours' => 180, 'link' => 'https://rc-consulting.org/online/diplomado-excel-inteligencia-artificial-generativa', 'color' => '#9e183a', 'type' => 'diplomado', 'mode' => 'en_vivo', 'fecha_inicio' => '16 MAR'],
            ['title' => 'Diplomado Gestión de Finanzas Públicas', 'image' => 'cesar-diplomado-gestion-finanzas.jpg', 'hours' => 270, 'link' => 'https://rc-consulting.org/online/diplomado-gestion-de-finanzas-publicas/', 'color' => '#9e183a', 'type' => 'diplomado', 'mode' => 'en_vivo', 'fecha_inicio' => '23 MAR'],
            ['title' => 'Diplomado Sistemas Gubernamentales SIAF SIGA SEACE PLADICOP', 'image' => 'diplomado-sistemas-gubernamentales.jpg', 'hours' => 270, 'link' => 'https://rc-consulting.org/online/diplomado-sistemas-gubernamentales-siaf-siga-seace-pladicop', 'color' => '#9e183a', 'type' => 'diplomado', 'mode' => 'en_vivo', 'fecha_inicio' => '25 MAR'],
        ];

        $allCourses = array_merge($cursosGrabados, $diplomadosGrabados, $cursosEnVivo, $diplomadosEnVivo);

        foreach ($allCourses as $courseData) {
            $courseData['slug'] = Str::slug($courseData['title']) . '-' . Str::random(6);
            $courseData['professor_id'] = $professor->id;
            $courseData['advisor_id'] = $advisor->id;

            Course::create($courseData);
        }

        $this->command->info(count($allCourses) . ' cursos creados exitosamente!');
    }
}
