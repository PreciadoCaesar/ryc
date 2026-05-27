<?php

namespace Database\Seeders;

use App\Models\Advisor;
use App\Models\Course;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        $asesora1 = Advisor::where('name', 'María Elena Rodríguez')->first();
        $asesora2 = Advisor::where('name', 'Carlos Mendoza López')->first();

        $courses = [
            [
                'title' => 'SIAF Básico - Del 01 al 05 de Mayo',
                'subtitle' => 'Sistema Integrado de Administración Financiera',
                'type' => 'curso',
                'mode' => 'en_vivo',
                'slug' => 'siaf-basico-' . Str::random(6),
                'phrase' => 'Domina el sistema financiero del Estado',
                'description' => 'Curso intensivo de SIAF para principiantes',
                'image_promotion' => 'img/promocion/siaf-basico.jpg',
                'start_date' => '2026-05-01',
                'sessions' => 6,
                'hours' => 20,
                'asesora_id' => $asesora1?->id,
                'precio_regular' => 1200.00,
                'precio_pronto' => 990.00,
                'featured' => true,
                'status' => 'activo',
            ],
            [
                'title' => 'Diplomado en Contrataciones Públicas',
                'subtitle' => 'Especialización en procesos de selección',
                'type' => 'diplomado',
                'mode' => 'en_vivo',
                'slug' => 'diplomado-contrataciones-' . Str::random(6),
                'phrase' => 'Certifícate en contrataciones',
                'description' => 'Diplomado completo en contrataciones públicas',
                'image_promotion' => 'img/promocion/diplomado-contrataciones.jpg',
                'start_date' => '2026-05-15',
                'sessions' => 12,
                'hours' => 96,
                'asesora_id' => $asesora1?->id,
                'precio_regular' => 3500.00,
                'precio_pronto' => 2990.00,
                'featured' => true,
                'status' => 'activo',
            ],
            [
                'title' => 'SEACE Especializado',
                'subtitle' => 'Sistema Electrónico de Contrataciones del Estado',
                'type' => 'curso',
                'mode' => 'grabado',
                'slug' => 'seace-especializado-' . Str::random(6),
                'phrase' => 'Aprende a tu ritmo',
                'description' => 'Curso grabado de SEACE',
                'image_promotion' => 'img/promocion/seace.jpg',
                'sessions' => 8,
                'hours' => 40,
                'asesora_id' => $asesora2?->id,
                'precio_regular' => 800.00,
                'precio_flash' => 590.00,
                'featured' => false,
                'status' => 'activo',
            ],
            [
                'title' => 'SIGA MEF – Nivel Básico',
                'subtitle' => 'Sistema Integrado de Gestión Administrativa',
                'type' => 'curso',
                'mode' => 'grabado',
                'slug' => 'siga-mef-' . Str::random(6),
                'phrase' => 'Gestiona con eficiencia',
                'description' => 'Curso completo de SIGA MEF',
                'image_promotion' => 'img/promocion/siga-mef.jpg',
                'sessions' => 10,
                'hours' => 50,
                'asesora_id' => $asesora2?->id,
                'precio_regular' => 900.00,
                'precio_pronto' => 750.00,
                'featured' => true,
                'status' => 'activo',
            ],
        ];

        foreach ($courses as $course) {
            Course::create($course);
        }

        $this->command->info('Cursos creados exitosamente con image_promotion!');
    }
}
