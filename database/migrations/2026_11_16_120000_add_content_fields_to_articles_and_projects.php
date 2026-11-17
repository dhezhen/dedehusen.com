<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table): void {
            $table->string('thumbnail_alt')->nullable();
        });

        Schema::table('projects', function (Blueprint $table): void {
            $table->longText('details')->nullable();
            $table->string('thumbnail_alt')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table): void {
            $table->dropColumn('thumbnail_alt');
        });

        Schema::table('projects', function (Blueprint $table): void {
            $table->dropColumn(['details', 'thumbnail_alt']);
        });
    }
};
