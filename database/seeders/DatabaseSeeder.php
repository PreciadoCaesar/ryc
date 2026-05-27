<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdvisorSeeder::class,
            CourseSeeder::class,
            LeadSeeder::class,
        ]);

        // Crear usuario admin con Google OAuth
        \App\Models\User::create([
            'name' => 'Administrador',
            'email' => 'admin@rc-consulting.org',
            'password' => bcrypt('password'),
            'rol' => 'dios',
        ]);

        // Crear usuario de prueba para cliente
        \App\Models\User::firstOrCreate(
            ['email' => 'cliente@demo.com'],
            [
                'name' => 'Cliente Demo',
                'password' => bcrypt('password'),
                'rol' => 'usuario',
            ]
        );
    }
}
