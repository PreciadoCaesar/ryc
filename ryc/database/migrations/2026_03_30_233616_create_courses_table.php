<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('image');
            $table->integer('hours')->default(90);
            $table->string('link');
            $table->string('color')->default('#9e183a');
            $table->enum('type', ['curso', 'diplomado'])->default('curso');
            $table->enum('mode', ['en_vivo', 'grabado'])->default('grabado');
            $table->boolean('featured')->default(false);
            $table->text('overlay_html')->nullable();
            $table->integer('sesiones')->nullable();
            $table->string('fecha_inicio')->nullable();
            $table->foreignId('professor_id')->nullable()->constrained('professors')->nullOnDelete();
            $table->foreignId('advisor_id')->nullable()->constrained('advisors')->nullOnDelete();
            $table->string('slug')->unique();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
