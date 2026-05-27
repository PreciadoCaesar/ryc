<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->string('origen')->nullable()->after('curso');
            $table->string('institucion')->nullable()->after('origen');
            $table->string('cantidad_alumnos')->nullable()->after('institucion');
            $table->string('nivel_curso')->nullable()->after('cantidad_alumnos');
        });
    }

    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropColumn(['origen', 'institucion', 'cantidad_alumnos', 'nivel_curso']);
        });
    }
};
