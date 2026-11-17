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
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_name')->default('Dede Husen');
            $table->string('hero_title')->default('Dede Husen, M.Kom.');
            $table->text('hero_description')->nullable();
            $table->string('font_display')->default('Space Grotesk');
            $table->string('font_body')->default('Plus Jakarta Sans');
            $table->string('color_accent', 7)->default('#0b6b74');
            $table->string('color_background', 7)->default('#edf3f7');
            $table->string('color_text', 7)->default('#101c2d');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
