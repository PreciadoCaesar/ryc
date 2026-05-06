<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('celular');
            $table->string('correo')->nullable();
            $table->text('consulta')->nullable();
            $table->string('curso');
            $table->enum('status', ['ingreso', 'contacto', 'venta cerrada', 'no interesado'])->default('ingreso');
            $table->boolean('is_whatsapp')->default(false);
            $table->foreignId('advisor_id')->nullable()->constrained('advisors')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
