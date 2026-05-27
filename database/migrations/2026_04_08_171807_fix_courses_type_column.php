<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->enum('type', [
                'Curso de Especialización Virtual',
                'Diplomado de Especialización Virtual',
                'Curso Online',
                'Diplomado Online'
            ])->default('Curso de Especialización Virtual')->change();
        });
    }

    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->enum('type', ['curso', 'diplomado'])->default('curso')->change();
        });
    }
};
