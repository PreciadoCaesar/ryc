<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            // Section 1: Info adicional
            if (!Schema::hasColumn('courses', 'fecha_limite_oferta')) {
                $table->string('fecha_limite_oferta')->nullable()->after('start_date');
            }
            if (!Schema::hasColumn('courses', 'fecha_inicio_iso')) {
                $table->string('fecha_inicio_iso')->nullable()->after('start_date');
            }

            // Section 2: Precios - ahorro es calculado, no se guarda

            // Section 3: Sesiones y Contenido
            if (!Schema::hasColumn('courses', 'tipo_certificado')) {
                $table->string('tipo_certificado')->nullable()->after('hours');
            }
            if (!Schema::hasColumn('courses', 'temario_titulo')) {
                $table->string('temario_titulo')->nullable()->after('link_brochure');
            }
            if (!Schema::hasColumn('courses', 'temario_tipo')) {
                $table->string('temario_tipo')->default('jerarquico')->after('temario_titulo');
            }

            // Section 4: Multimedia
            if (!Schema::hasColumn('courses', 'url_video_vimeo')) {
                $table->string('url_video_vimeo')->nullable()->after('image_promotion');
            }
            if (!Schema::hasColumn('courses', 'og_image_url')) {
                $table->string('og_image_url')->nullable()->after('url_video_vimeo');
            }
            if (!Schema::hasColumn('courses', 'descripcion_inhouse')) {
                $table->text('descripcion_inhouse')->nullable()->after('inhouse_mobile');
            }

            // Section 5: Asesora (separada del Asesor InHouse)
            if (!Schema::hasColumn('courses', 'asesora_nombre')) {
                $table->string('asesora_nombre')->nullable()->after('asesor_foto');
            }
            if (!Schema::hasColumn('courses', 'asesora_telefono')) {
                $table->string('asesora_telefono')->nullable()->after('asesora_nombre');
            }
            if (!Schema::hasColumn('courses', 'asesora_foto')) {
                $table->string('asesora_foto')->nullable()->after('asesora_telefono');
            }

            // Temario jerárquico como JSON
            if (!Schema::hasColumn('courses', 'temario_hierarchical')) {
                $table->json('temario_hierarchical')->nullable()->after('temario_tipo');
            }
        });
    }

    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $columns = [
                'fecha_limite_oferta', 'fecha_inicio_iso',
                'tipo_certificado', 'temario_titulo', 'temario_tipo',
                'url_video_vimeo', 'og_image_url', 'descripcion_inhouse',
                'asesora_nombre', 'asesora_telefono', 'asesora_foto',
                'temario_hierarchical',
            ];
            foreach ($columns as $col) {
                if (Schema::hasColumn('courses', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
