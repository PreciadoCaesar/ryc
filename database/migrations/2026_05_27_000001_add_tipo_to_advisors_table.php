<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('advisors', function (Blueprint $table) {
            if (!Schema::hasColumn('advisors', 'tipo')) {
                $table->string('tipo')->default('asesora')->after('cargo');
            }
        });
    }

    public function down(): void
    {
        Schema::table('advisors', function (Blueprint $table) {
            if (Schema::hasColumn('advisors', 'tipo')) {
                $table->dropColumn('tipo');
            }
        });
    }
};
