<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->string('google_site_verification')->nullable();
        });

        DB::table('site_settings')
            ->whereNull('google_site_verification')
            ->update(['google_site_verification' => 'fl-YC0QLNU1SitF76E_ENvSr54ZCG9tHJH1p9GCe4Yo']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn('google_site_verification');
        });
    }
};
