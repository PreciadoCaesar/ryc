<?php

namespace Database\Seeders;

use App\Models\Advisor;
use Illuminate\Database\Seeder;

class AdvisorSeeder extends Seeder
{
    public function run(): void
    {
        $asesoras = [
            [
                'name' => 'María Elena Rodríguez',
                'whatsapp' => '51999888777',
                'email' => 'maria@rc-consulting.org',
                'cargo' => 'Asesora Senior',
                'photo' => 'img/asesoras/maria.jpg',
            ],
            [
                'name' => 'Carlos Mendoza López',
                'whatsapp' => '51988777666',
                'email' => 'carlos@rc-consulting.org',
                'cargo' => 'Asesor Especializado',
                'photo' => 'img/asesoras/carlos.jpg',
            ],
            [
                'name' => 'Ana Patricia Vargas',
                'whatsapp' => '51977666555',
                'email' => 'ana@rc-consulting.org',
                'cargo' => 'Asesora Administrativa',
                'photo' => 'img/asesoras/ana.jpg',
            ],
        ];

        foreach ($asesoras as $asesora) {
            Advisor::create($asesora);
        }
    }
}
