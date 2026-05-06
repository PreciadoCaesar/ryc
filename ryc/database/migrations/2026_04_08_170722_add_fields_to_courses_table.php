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
            $table->string('subtitle')->nullable()->after('title');
            $table->text('phrase')->nullable()->after('subtitle');
            $table->text('description')->nullable()->after('phrase');
            $table->string('image_promotion')->nullable()->after('description');
            $table->string('link_brochure')->nullable()->after('image_promotion');
            $table->string('link_niubiz')->nullable()->after('link_brochure');
            $table->string('specialization_name')->nullable()->after('link_niubiz');
            $table->string('start_date')->nullable()->after('specialization_name');
            $table->integer('sessions')->nullable()->after('start_date');
            $table->string('inhouse_web')->nullable()->after('sessions');
            $table->string('inhouse_mobile')->nullable()->after('inhouse_web');
            $table->string('precio_flash_fecha')->nullable()->after('inhouse_mobile');
            $table->decimal('precio_flash', 10, 2)->nullable()->after('precio_flash_fecha');
            $table->decimal('precio_regular', 10, 2)->nullable()->after('precio_flash');
            $table->string('precio_pronto_fecha')->nullable()->after('precio_regular');
            $table->decimal('precio_pronto', 10, 2)->nullable()->after('precio_pronto_fecha');
            $table->text('seo_title')->nullable()->after('precio_pronto');
            $table->text('seo_description')->nullable()->after('seo_title');
            $table->string('seo_keywords')->nullable()->after('seo_description');
            $table->enum('status', ['activo', 'inactivo'])->default('activo')->after('seo_keywords');
            
            // Eliminar campos antigos que no usaremos
            $table->dropColumn(['image', 'link', 'color', 'mode', 'overlay_html', 'sesiones', 'fecha_inicio']);
        });
    }

    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn([
                'subtitle', 'phrase', 'description', 'image_promotion', 'link_brochure', 
                'link_niubiz', 'specialization_name', 'start_date', 'sessions', 
                'inhouse_web', 'inhouse_mobile', 'precio_flash_fecha', 'precio_flash', 
                'precio_regular', 'precio_pronto_fecha', 'precio_pronto', 'seo_title', 
                'seo_description', 'seo_keywords', 'status'
            ]);
            
            // Restaurar campos antiguos
            $table->string('image')->nullable();
            $table->string('link')->nullable();
            $table->string('color')->default('#9e183a');
            $table->enum('mode', ['en_vivo', 'grabado'])->default('grabado');
            $table->text('overlay_html')->nullable();
            $table->integer('sesiones')->nullable();
            $table->string('fecha_inicio')->nullable();
        });
    }
};
