<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('scholar_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('scholar_id')->unique();
            $table->string('author_name')->nullable();
            $table->string('affiliation')->nullable();
            $table->unsignedInteger('citations_all')->default(0);
            $table->unsignedInteger('citations_since')->default(0);
            $table->unsignedInteger('h_index_all')->default(0);
            $table->unsignedInteger('h_index_since')->default(0);
            $table->unsignedInteger('i10_index_all')->default(0);
            $table->unsignedInteger('i10_index_since')->default(0);
            $table->json('citation_history')->nullable();
            $table->timestamp('last_synced_at')->nullable();
            $table->timestamps();
        });

        Schema::create('scholar_publications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('scholar_profile_id')->nullable()->constrained('scholar_profiles')->cascadeOnDelete();
            $table->string('title');
            $table->text('authors')->nullable();
            $table->text('venue')->nullable();
            $table->string('year', 10)->nullable()->index();
            $table->unsignedInteger('citations')->default(0)->index();
            $table->text('scholar_citation_url')->nullable();
            $table->boolean('is_visible')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('scholar_publications');
        Schema::dropIfExists('scholar_profiles');
    }
};
