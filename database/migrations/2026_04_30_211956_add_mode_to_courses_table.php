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
            $table->string('mode')->default('en_vivo')->after('type');
            $table->string('link')->nullable()->after('description');
            $table->string('color')->nullable()->after('link');
            $table->text('overlay_html')->nullable()->after('color');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn(['mode', 'link', 'color', 'overlay_html']);
        });
    }
};
