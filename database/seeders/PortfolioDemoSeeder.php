<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class PortfolioDemoSeeder extends Seeder
{
    public function run(): void
    {
        $projects = [
            [
                'title' => 'Contoh: Dashboard pemantauan layanan desa',
                'slug' => 'contoh-dashboard-layanan-desa',
                'category' => 'Sistem informasi',
                'summary' => 'Proyek demonstrasi untuk memperlihatkan ringkasan layanan, status permohonan, dan informasi yang perlu ditindaklanjuti.',
                'details' => '<p><strong>Proyek demonstrasi.</strong> Ini adalah konten contoh, bukan sistem yang telah diterapkan pada desa atau instansi tertentu.</p><h2>Ruang lingkup contoh</h2><ul><li>Menampilkan ringkasan status layanan.</li><li>Mengelompokkan permohonan berdasarkan tahap.</li><li>Menyediakan tampilan yang menyesuaikan ukuran layar.</li></ul><p>Implementasi nyata perlu disusun bersama calon pengguna dan mengikuti kebijakan pengelolaan data yang berlaku.</p>',
                'thumbnail' => 'assets/portfolio/posyandu.svg',
                'thumbnail_alt' => 'Ilustrasi untuk proyek contoh dashboard layanan desa',
                'published_at' => today()->subDays(3)->toDateString(),
                'sort_order' => 0,
            ],
            [
                'title' => 'Contoh: Ringkasan analisis capaian akademik',
                'slug' => 'contoh-analisis-capaian-akademik',
                'category' => 'Analitik data',
                'summary' => 'Proyek contoh tentang penyajian data akademik dalam bentuk ringkasan yang mudah dibaca dan ditelusuri.',
                'details' => '<p><strong>Proyek demonstrasi.</strong> Konten ini tidak menggunakan data mahasiswa dan tidak menyatakan hasil analisis nyata.</p><h2>Rancangan demonstrasi</h2><ul><li>Menjelaskan definisi setiap indikator.</li><li>Memisahkan data agregat dari identitas individu.</li><li>Memberi konteks dan batas pembacaan pada setiap grafik.</li></ul><p>Penerapan sesungguhnya memerlukan pemeriksaan kualitas data, persetujuan akses, dan perlindungan privasi.</p>',
                'thumbnail' => 'assets/portfolio/regresi-akademik.svg',
                'thumbnail_alt' => 'Ilustrasi untuk proyek contoh analisis capaian akademik',
                'published_at' => today()->subDays(6)->toDateString(),
                'sort_order' => 1,
            ],
            [
                'title' => 'Contoh: Modul latihan pemrograman interaktif',
                'slug' => 'contoh-modul-pemrograman-interaktif',
                'category' => 'Pendidikan digital',
                'summary' => 'Konsep materi latihan bertahap untuk membantu mahasiswa mencoba, menguji, dan memperbaiki potongan program.',
                'details' => '<p><strong>Proyek demonstrasi.</strong> Ini adalah konsep materi, bukan laporan penggunaan di kelas tertentu.</p><h2>Alur latihan</h2><ol><li>Pelajari satu konsep melalui contoh ringkas.</li><li>Ubah kode dan amati hasilnya.</li><li>Periksa jawaban dengan kasus uji sederhana.</li><li>Tinjau penjelasan setelah mencoba.</li></ol><p>Materi nyata perlu diselaraskan dengan capaian mata kuliah dan tingkat pengalaman peserta.</p>',
                'thumbnail' => 'assets/portfolio/dataset-gameplay.svg',
                'thumbnail_alt' => 'Ilustrasi untuk proyek contoh modul pemrograman interaktif',
                'published_at' => today()->subDays(9)->toDateString(),
                'sort_order' => 2,
            ],
        ];

        foreach ($projects as $project) {
            Project::query()->firstOrCreate(
                ['slug' => $project['slug']],
                [...$project, 'is_published' => true],
            );
        }
    }
}
