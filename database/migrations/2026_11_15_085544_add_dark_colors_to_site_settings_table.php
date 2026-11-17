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
        Schema::table('site_settings', function (Blueprint $table) {
            $table->string('color_dark_background', 7)->default('#0a111e');
            $table->string('color_dark_text', 7)->default('#e5edf5');
            $table->string('color_dark_accent', 7)->default('#43c0c8');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn(['color_dark_background', 'color_dark_text', 'color_dark_accent']);
        });
    }
};
