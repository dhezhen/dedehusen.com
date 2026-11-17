<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $projects = [
            ['title' => 'Literasi digital dan kecerdasan buatan untuk siswa SMK', 'slug' => 'literasi-ai-smk', 'category' => 'Pendidikan & AI', 'summary' => 'Program pengabdian tentang literasi digital dan keterampilan AI untuk mendukung pembelajaran berbasis teknologi.', 'thumbnail' => 'assets/portfolio/literasi-ai.svg', 'source_url' => 'https://doi.org/10.32877/nr.v6i1.4255', 'published_at' => '2026-11-10'],
            ['title' => 'Dataset gameplay untuk pembelajaran matematika adaptif', 'slug' => 'dataset-gameplay', 'category' => 'Data Science', 'summary' => 'Dataset log permainan edukasi yang disiapkan untuk analitik pembelajaran adaptif. Dede Husen tercatat sebagai pengumpul data.', 'thumbnail' => 'assets/portfolio/dataset-gameplay.svg', 'source_url' => 'https://doi.org/10.5281/zenodo.20576432', 'published_at' => '2026-06-01'],
            ['title' => 'Pemodelan performa akademik mahasiswa dengan regresi', 'slug' => 'prediksi-akademik', 'category' => 'Data Science', 'summary' => 'Studi pemodelan prediktif performa akademik mahasiswa menggunakan metode regresi.', 'thumbnail' => 'assets/portfolio/regresi-akademik.svg', 'source_url' => 'https://doi.org/10.32877/bt.v8i3.3391', 'published_at' => '2026-04-10'],
            ['title' => 'Pelatihan komputer untuk kader PKK Kaduagung', 'slug' => 'pelatihan-pkk', 'category' => 'Literasi digital', 'summary' => 'Pelatihan Microsoft Word dan Excel untuk membantu kader mengelola administrasi dan dokumentasi.', 'thumbnail' => 'assets/portfolio/pelatihan-komputer.svg', 'source_url' => 'https://doi.org/10.59837/jpmba.v3i10.3465', 'published_at' => '2025-12-02'],
            ['title' => 'Sistem informasi Posyandu Desa Muncangela', 'slug' => 'siposyandu', 'category' => 'Sistem informasi', 'summary' => 'Sistem berbasis web untuk pencatatan, pelaporan, jadwal layanan, dan edukasi kesehatan. Dede Husen tercatat sebagai ketua pelaksana.', 'thumbnail' => 'assets/portfolio/posyandu.svg', 'source_url' => 'https://doi.org/10.29303/abdiinsani.v12i10.2982', 'published_at' => '2025-10-01'],
            ['title' => 'Pendampingan sistem informasi kepesantrenan', 'slug' => 'sistem-pesantren', 'category' => 'Sistem informasi', 'summary' => 'Pendampingan perancangan dan prototipe sistem untuk mengelola data peserta, alumni, mitra, dan administrasi pendidikan.', 'thumbnail' => 'assets/portfolio/sistem-pesantren.svg', 'source_url' => 'https://doi.org/10.59837/jpmba.v2i9.1627', 'published_at' => '2024-11-01'],
        ];

        foreach ($projects as $project) {
            Project::updateOrCreate(['slug' => $project['slug']], [...$project, 'is_published' => true]);
        }

        SiteSetting::firstOrCreate(['id' => 1], [
            'site_name' => 'Dede Husen',
            'hero_title' => 'Halo, saya Dede Husen.',
            'hero_description' => 'Saya dosen Teknik Informatika di Fakultas Ilmu Komputer, Universitas Kuningan. Melalui situs ini, saya berbagi informasi tentang kegiatan mengajar, riset, publikasi, karya, dan bahan kuliah.',
            'google_site_verification' => 'fl-YC0QLNU1SitF76E_ENvSr54ZCG9tHJH1p9GCe4Yo',
            'google_tag_manager_id' => 'GTM-5SR46W97',
        ]);
    }
}
