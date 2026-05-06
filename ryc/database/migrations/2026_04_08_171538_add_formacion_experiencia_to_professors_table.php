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
        Schema::table('professors', function (Blueprint $table) {
            $table->json('formacion')->nullable()->after('photo');
            $table->json('experiencia')->nullable()->after('formacion');
        });
    }

    public function down(): void
    {
        Schema::table('professors', function (Blueprint $table) {
            $table->dropColumn(['formacion', 'experiencia']);
        });
    }
};
