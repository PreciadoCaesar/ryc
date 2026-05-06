<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Advisor;
use App\Models\Professor;
use App\Models\Course;
use App\Models\CourseObjetivo;
use App\Models\CourseParticipante;
use App\Models\CourseSesion;

class CursoSeeder extends Seeder
{
    public function run(): void
    {
        // Crear asesora
        $asesora = Advisor::create([
            'name' => 'Estefany Espejo',
            'whatsapp' => '987654321',
            'photo' => 'img/asesora/estefany.png',
            'email' => 'estefany@rcconsulting.pe',
            'cargo' => 'Asesora Comercial'
        ]);

        // Crear profesores
        $profesor1 = Professor::create([
            'name' => 'Mg. Carlos Mendoza',
            'photo' => 'img/profes/profesor-01.png',
            'formacion' => [
                'Maestría en Gestión Pública - Universidad Nacional Mayor de San Marcos',
                'Especialización en Presupuesto Público - ESAN',
                'Licenciado en Economía - Universidad de Lima'
            ],
            'experiencia' => [
                'Ex Director de Presupuesto del Ministerio de Economía y Finanzas',
                '20 años de experiencia en gestión pública',
                'Consultor de proyectos de fortalecimiento institucional'
            ]
        ]);

        $profesor2 = Professor::create([
            'name' => 'Dr. Juan Pérez',
            'photo' => 'img/profes/profesor-02.png',
            'formacion' => [
                'Doctorado en Administración - Universidad Nacional de Ingeniería',
                'Maestría en Gestión de Proyectos - PUCP',
                'Ingeniero Civil - Universidad Nacional de Ingeniería'
            ],
            'experiencia' => [
                'Ex Coordinador de inversiones de OSCE',
                '15 años en contrataciones públicas',
                'Expositor en diplomados de gestión pública'
            ]
        ]);

        // Crear curso ejemplo
        $curso = Course::create([
            'title' => 'Preparación ONA-OCE',
            'subtitle' => 'para OCE',
            'type' => 'Curso de Especialización Virtual',
            'phrase' => 'Domina las nuevas normativas y certifícate',
            'description' => 'Curso integral de preparación para el examen de Nombramiento y Ascenso (ONA) y certificaciones (OCE) en el sector público. Aprende con expertos del MEF y obtén tu certificación con validez profesional.',
            'start_date' => '22 de abril',
            'sessions' => 6,
            'hours' => 90,
            'specialization_name' => 'Preparación ONA OCE',
            'advisor_id' => $asesora->id,
            'image_promotion' => 'img/promocion/promocion.jpg',
            'link_brochure' => 'https://drive.google.com/file/d/12345/view',
            'link_niubiz' => 'https://pagolink.niubiz.com.pe/pagoseguro/RYCCONSULTING/12345/info',
            'inhouse_web' => 'img/inhouse/inhouse-01.jpg',
            'inhouse_mobile' => 'img/inhouse/inhouse-02.jpg',
            'precio_flash_fecha' => '15 de abril',
            'precio_flash' => 299,
            'precio_regular' => 499,
            'precio_pronto_fecha' => 'Hasta 20 de abril',
            'precio_pronto' => 399,
            'seo_title' => 'Curso Preparación ONA OCE 2026 | R&C Consulting',
            'seo_description' => 'Curso de preparación para el examen de Nombramiento y Ascenso (ONA) y certificaciones OCE. Certificación con validez profesional. ¡Inscríbete ya!',
            'seo_keywords' => 'curso on line, preparación ona, certificación gestión pública, curso virtual perú',
            'status' => 'activo'
        ]);

        // Agregar objetivos
        $objetivos = [
            ['titulo' => 'Conocer el marco normativo vigente', 'descripcion' => 'Aprende las principales leyes y reglamentos de gestión pública actualizados.'],
            ['titulo' => 'Dominio de herramientas de gestión', 'descripcion' => 'Maneja con fluidez los principales aplicativos del Estado como SIAF, SIGA, SEACE y others.'],
            ['titulo' => 'Preparación para exámenes de certificación', 'descripcion' => 'Simula pruebas reales de ONA y OCE conMaterial de estudio actualizado.'],
            ['titulo' => 'Aplicación práctica de conocimientos', 'descripcion' => 'Casos prácticos y talleres que podrás aplicar directamente en tu trabajo.'],
        ];

        foreach ($objetivos as $index => $obj) {
            CourseObjetivo::create([
                'course_id' => $curso->id,
                'titulo' => $obj['titulo'],
                'descripcion' => $obj['descripcion'],
                'orden' => $index + 1
            ]);
        }

        // Agregar participantes
        $participantes = [
            ['icono' => 'fa-user-tie', 'descripcion' => 'Funcionarios públicos que buscan ascender o certificarse'],
            ['icono' => 'fa-building', 'descripcion' => 'Personal administrativo de entidades públicas'],
            ['icono' => 'fa-chart-line', 'descripcion' => 'Profesionales interesados en trabajar en el sector público'],
            ['icono' => 'fa-graduation-cap', 'descripcion' => 'Egresados que desean incorporarse al Estado'],
        ];

        foreach ($participantes as $index => $par) {
            CourseParticipante::create([
                'course_id' => $curso->id,
                'icono' => $par['icono'],
                'descripcion' => $par['descripcion'],
                'orden' => $index + 1
            ]);
        }

        // Agregar temario
        $sesiones = [
            ['numero' => 1, 'titulo' => 'Marco Normativo de la Gestión Pública', 'temas' => ['Ley de Gestión Presupuestaria', 'Ley de Contrataciones del Estado', 'Ley del Servicio Civil'] ],
            ['numero' => 2, 'titulo' => 'Sistema Integrado de Gestión Administrativa', 'temas' => ['Módulos de SIAF', 'Cadena de gasto', 'Certificación presupuestaria'] ],
            ['numero' => 3, 'titulo' => 'Contrataciones Públicas con SEACE', 'temas' => ['Plan Anual de Contrataciones', 'Procesos de selección', 'Contratos y ejecutorcontractual'] ],
            ['numero' => 4, 'titulo' => 'Planeamiento y Presupuesto', 'temas' => ['Presupuesto por resultados', 'Programación multianual', ' Seguimiento y evaluación'] ],
            ['numero' => 5, 'titulo' => 'Gestión de Recursos Humanos', 'temas' => ['Ley SERVIR', 'Ratios de personal', 'Gestión de personal'] ],
            ['numero' => 6, 'titulo' => 'Simulacro y Tips de Examen', 'temas' => ['Práctica de preguntas', 'Errores frecuentes', 'Estrategias de presentación'] ],
        ];

        foreach ($sesiones as $ses) {
            CourseSesion::create([
                'course_id' => $curso->id,
                'numero' => $ses['numero'],
                'titulo' => $ses['titulo'],
                'temas' => $ses['temas']
            ]);
        }

        // Adjuntar profesores
        $curso->profesores()->attach([$profesor1->id, $profesor2->id]);

        echo "✅ Curso de ejemplo creado: /curso/preparacion-ona-oce\n";
    }
}
