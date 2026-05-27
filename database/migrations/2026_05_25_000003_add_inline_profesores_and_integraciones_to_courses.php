<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->json('profesores_inline')->nullable()->after('featured');
            $table->string('asesor_nombre')->nullable()->after('profesores_inline');
            $table->string('asesor_celular')->nullable()->after('asesor_nombre');
            $table->string('asesor_email')->nullable()->after('asesor_celular');
            $table->string('asesor_foto')->nullable()->after('asesor_email');
            $table->string('hoja_destino_sheets')->nullable()->after('asesor_foto');
            $table->string('nombre_curso_sheets')->nullable()->after('hoja_destino_sheets');
            $table->string('url_carrito_pago')->nullable()->after('nombre_curso_sheets');
        });
    }

    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn([
                'profesores_inline',
                'asesor_nombre',
                'asesor_celular',
                'asesor_email',
                'asesor_foto',
                'hoja_destino_sheets',
                'nombre_curso_sheets',
                'url_carrito_pago',
            ]);
        });
    }
};
