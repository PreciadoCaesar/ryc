<?php

namespace Database\Seeders;

use App\Models\Lead;
use App\Models\Advisor;
use Illuminate\Database\Seeder;

class LeadSeeder extends Seeder
{
    public function run(): void
    {
        $asesora1 = Advisor::where('name', 'María Elena Rodríguez')->first();
        $asesora2 = Advisor::where('name', 'Carlos Mendoza López')->first();

        $leads = [
            [
                'nombre' => 'Juan Pérez García',
                'celular' => '51912345678',
                'correo' => 'juan.perez@ejemplo.com',
                'consulta' => 'Interesado en el curso de SIAF',
                'curso' => 'SIAF Básico',
                'status' => 'ingreso',
                'is_whatsapp' => true,
                'advisor_id' => $asesora1?->id,
            ],
            [
                'nombre' => 'Lucía Ramírez Torres',
                'celular' => '51987654321',
                'correo' => 'lucia.ramirez@ejemplo.com',
                'consulta' => 'Necesito información sobre diplomados',
                'curso' => 'Diplomado en Contrataciones',
                'status' => 'contacto',
                'is_whatsapp' => true,
                'advisor_id' => $asesora1?->id,
            ],
            [
                'nombre' => 'Roberto Sánchez Díaz',
                'celular' => '51876543210',
                'correo' => 'roberto.sanchez@ejemplo.com',
                'consulta' => 'Quiero inscribirme en SIGA',
                'curso' => 'SIGA Avanzado',
                'status' => 'venta cerrada',
                'is_whatsapp' => false,
                'advisor_id' => $asesora2?->id,
            ],
            [
                'nombre' => 'Carmen Herrera Luna',
                'celular' => '51901234567',
                'correo' => 'carmen.herrera@ejemplo.com',
                'consulta' => 'No me interesa por ahora',
                'curso' => 'SEACE Especializado',
                'status' => 'no interesado',
                'is_whatsapp' => true,
                'advisor_id' => $asesora2?->id,
            ],
        ];

        foreach ($leads as $lead) {
            Lead::create($lead);
        }
    }
}
