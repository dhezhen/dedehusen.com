<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('site_settings')
            ->whereNull('google_tag_manager_id')
            ->update(['google_tag_manager_id' => 'GTM-5SR46W97']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('site_settings')
            ->where('google_tag_manager_id', 'GTM-5SR46W97')
            ->update(['google_tag_manager_id' => null]);
    }
};
