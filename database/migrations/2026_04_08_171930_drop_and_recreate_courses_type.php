<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->string('type_old')->nullable();
        });
        
        DB::statement("UPDATE courses SET type_old = type");
        
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn('type');
        });
        
        Schema::table('courses', function (Blueprint $table) {
            $table->string('type')->default('Curso de Especialización Virtual')->after('title');
        });
        
        DB::statement("UPDATE courses SET type = 'Curso de Especialización Virtual' WHERE type_old IS NOT NULL");
        
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn('type_old');
        });
    }

    public function down(): void
    {
        // No hay forma de volver atrás fácilmente
    }
};
