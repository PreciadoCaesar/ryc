<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            if (!Schema::hasColumn('courses', 'asesor_inhouse_id')) {
                $table->foreignId('asesor_inhouse_id')->nullable()->after('asesora_id')
                    ->constrained('advisors')->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            if (Schema::hasColumn('courses', 'asesor_inhouse_id')) {
                $table->dropForeign(['asesor_inhouse_id']);
                $table->dropColumn('asesor_inhouse_id');
            }
        });
    }
};
