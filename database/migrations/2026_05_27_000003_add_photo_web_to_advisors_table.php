<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('advisors', function (Blueprint $table) {
            if (!Schema::hasColumn('advisors', 'photo_web')) {
                $table->string('photo_web')->nullable()->after('photo');
            }
        });
    }

    public function down(): void
    {
        Schema::table('advisors', function (Blueprint $table) {
            if (Schema::hasColumn('advisors', 'photo_web')) {
                $table->dropColumn('photo_web');
            }
        });
    }
};
