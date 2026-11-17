<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Seeder;

class ArticleDemoSeeder extends Seeder
{
    public function run(): void
    {
        $examples = [
            'pendidikan' => [
                ['Menyusun tujuan belajar yang terukur', 'Contoh materi demonstrasi tentang cara menulis tujuan belajar yang mudah dipahami dan diperiksa.', '<p>Tujuan belajar membantu dosen dan mahasiswa memahami hasil yang hendak dicapai. Dalam contoh ini, tujuan ditulis dengan kata kerja yang dapat diamati.</p><h2>Mulai dari hasil</h2><p>Sebutkan kemampuan yang perlu ditunjukkan mahasiswa setelah kegiatan. Hindari tujuan yang hanya menyebut aktivitas seperti membaca atau mendengarkan.</p><ul><li>Gunakan satu kemampuan utama untuk setiap tujuan.</li><li>Tentukan bukti yang menunjukkan kemampuan tersebut.</li><li>Sesuaikan tingkat kesulitan dengan materi.</li></ul><p>Contoh ini disediakan sebagai materi demonstrasi dan dapat disesuaikan dengan konteks mata kuliah.</p>'],
                ['Merancang proyek kecil untuk kelas pemrograman', 'Contoh rancangan tugas proyek sederhana agar mahasiswa berlatih membuat program dari kebutuhan yang jelas.', '<p>Proyek kecil dapat menghubungkan konsep pemrograman dengan masalah yang dekat dengan keseharian mahasiswa. Ruang lingkup yang terbatas membuat proses pengerjaan lebih terarah.</p><h2>Tahapan tugas</h2><ol><li>Jelaskan masalah dan siapa penggunanya.</li><li>Tentukan masukan, proses, dan keluaran program.</li><li>Minta mahasiswa menguji beberapa kondisi.</li></ol><p>Penilaian dapat melihat ketepatan fungsi, keterbacaan kode, dan alasan di balik keputusan desain. Contoh ini merupakan materi demonstrasi, bukan laporan kegiatan kelas.</p>'],
                ['Memberi umpan balik formatif pada praktikum', 'Contoh pendekatan umpan balik yang membantu mahasiswa mengetahui langkah perbaikan berikutnya.', '<p>Umpan balik formatif memberi petunjuk saat mahasiswa masih dapat memperbaiki pekerjaannya. Catatan yang spesifik lebih mudah ditindaklanjuti daripada komentar umum.</p><h2>Fokus pada langkah berikutnya</h2><p>Tunjukkan bagian yang sudah sesuai, jelaskan bagian yang perlu diperiksa, lalu berikan satu saran konkret. Hindari menilai pribadi mahasiswa.</p><ul><li>Rujuk kriteria tugas yang telah dibagikan.</li><li>Gunakan contoh atau pertanyaan pemandu.</li><li>Sediakan kesempatan untuk mencoba kembali.</li></ul><p>Materi ini adalah contoh demonstrasi yang dapat diadaptasi untuk kegiatan praktikum.</p>'],
            ],
            'penelitian' => [
                ['Merumuskan pertanyaan penelitian terapan', 'Contoh langkah awal untuk mempersempit topik menjadi pertanyaan penelitian yang dapat ditelaah.', '<p>Topik yang luas perlu dibatasi sebelum metode dan data dipilih. Pertanyaan penelitian yang jelas membantu menjaga hubungan antara tujuan, pengumpulan data, dan analisis.</p><h2>Batasi ruang lingkup</h2><ul><li>Tentukan konteks atau kelompok yang dikaji.</li><li>Jelaskan fenomena yang ingin dipahami.</li><li>Pastikan data yang dibutuhkan dapat diperoleh.</li></ul><p>Setelah pertanyaan dirumuskan, periksa kembali apakah jawaban yang dicari sesuai dengan tujuan studi. Ini adalah contoh materi demonstrasi, bukan hasil penelitian tertentu.</p>'],
                ['Menyiapkan data sebelum analisis', 'Contoh daftar pemeriksaan untuk memastikan data penelitian terdokumentasi dan siap dianalisis.', '<p>Persiapan data merupakan bagian dari proses penelitian. Catatan yang rapi memudahkan peneliti menelusuri asal data dan keputusan pengolahannya.</p><h2>Pemeriksaan dasar</h2><ol><li>Simpan salinan data mentah secara terpisah.</li><li>Catat arti setiap kolom dan satuannya.</li><li>Periksa nilai kosong, duplikat, dan format yang tidak konsisten.</li><li>Dokumentasikan setiap perubahan yang dilakukan.</li></ol><p>Langkah ini tidak menggantikan pemeriksaan metodologis. Contoh ini hanya materi demonstrasi untuk alur kerja penelitian.</p>'],
                ['Membaca hasil evaluasi model secara cermat', 'Contoh cara menjelaskan metrik evaluasi dengan memperhatikan tujuan dan keterbatasan data.', '<p>Angka evaluasi model perlu dibaca sesuai konteks penggunaannya. Satu metrik saja belum tentu menggambarkan seluruh jenis kesalahan yang mungkin terjadi.</p><h2>Letakkan angka dalam konteks</h2><p>Jelaskan data yang digunakan, cara pembagian data, dan ukuran evaluasi yang dipilih. Bila kelas tidak seimbang, tampilkan metrik tambahan yang relevan.</p><ul><li>Bandingkan dengan pendekatan dasar.</li><li>Periksa kesalahan pada tiap kelompok.</li><li>Sebutkan batas penggunaan hasil.</li></ul><p>Artikel demonstrasi ini tidak menyajikan hasil eksperimen tertentu.</p>'],
            ],
            'pengabdian' => [
                ['Memetakan kebutuhan mitra sebelum pelatihan', 'Contoh cara menyusun percakapan awal dengan mitra agar materi kegiatan sesuai kebutuhan.', '<p>Kegiatan bersama masyarakat sebaiknya dimulai dengan memahami kondisi dan prioritas mitra. Percakapan awal membantu tim menghindari asumsi tentang kebutuhan peserta.</p><h2>Hal yang perlu digali</h2><ul><li>Tujuan yang ingin dicapai mitra.</li><li>Pengalaman dan perangkat yang tersedia.</li><li>Kendala waktu, akses, atau pendampingan.</li></ul><p>Ringkas hasil diskusi dan minta mitra memeriksa kembali rangkumannya. Materi ini adalah contoh demonstrasi, bukan dokumentasi kegiatan nyata.</p>'],
                ['Merancang pelatihan digital yang praktis', 'Contoh struktur sesi pelatihan yang menyediakan waktu untuk mencoba, bertanya, dan mengulang langkah.', '<p>Pelatihan digital akan lebih mudah diikuti jika materi dibagi menjadi tugas kecil. Peserta dapat melihat hasil dari setiap langkah dan meminta bantuan saat menemui kendala.</p><h2>Susunan sesi</h2><ol><li>Kenalkan tujuan dan alat yang digunakan.</li><li>Demonstrasikan satu alur kerja.</li><li>Ajak peserta mencoba dengan pendampingan.</li><li>Sisihkan waktu untuk mengulang bagian yang sulit.</li></ol><p>Rancangan ini merupakan contoh demonstrasi yang perlu disesuaikan bersama mitra.</p>'],
                ['Mengevaluasi kegiatan bersama mitra', 'Contoh pertanyaan refleksi untuk menilai proses kegiatan dan merencanakan tindak lanjut.', '<p>Evaluasi kegiatan dapat menggabungkan catatan proses, masukan peserta, dan hasil yang disepakati bersama. Tujuannya adalah memahami apa yang berjalan baik dan bagian yang perlu diperbaiki.</p><h2>Pertanyaan refleksi</h2><ul><li>Apakah kegiatan menjawab kebutuhan yang disepakati?</li><li>Bagian mana yang paling membantu peserta?</li><li>Dukungan apa yang masih diperlukan setelah kegiatan?</li></ul><p>Bahas hasil evaluasi bersama mitra sebelum menentukan tindak lanjut. Contoh ini bukan laporan pengabdian yang telah dilaksanakan.</p>'],
            ],
            'teknologi' => [
                ['Memilih struktur data berdasarkan kebutuhan', 'Contoh pertimbangan sederhana untuk menentukan struktur data yang sesuai dengan operasi program.', '<p>Pemilihan struktur data memengaruhi cara program menyimpan dan mencari informasi. Mulailah dari operasi yang paling sering dilakukan, bukan dari pilihan yang sedang populer.</p><h2>Bandingkan pola penggunaan</h2><p>Daftar berurutan cocok untuk menjaga urutan. Himpunan membantu memeriksa keanggotaan. Pemetaan pasangan kunci dan nilai memudahkan pencarian berdasarkan identitas.</p><ul><li>Tuliskan kebutuhan akses dan perubahan data.</li><li>Perkirakan ukuran data.</li><li>Uji pilihan pada contoh yang mewakili penggunaan.</li></ul><p>Ini adalah materi demonstrasi; pilihan akhir tetap bergantung pada konteks program.</p>'],
                ['Merancang API yang mudah dirawat', 'Contoh prinsip dasar agar endpoint dan respons API lebih konsisten bagi pengembang.', '<p>API yang konsisten membantu klien memahami cara meminta dan menerima data. Penamaan, validasi, dan format respons sebaiknya mengikuti pola yang sama.</p><h2>Prinsip yang dapat diterapkan</h2><ul><li>Gunakan nama sumber daya yang jelas.</li><li>Validasi masukan pada batas sistem.</li><li>Kembalikan status dan pesan kesalahan yang dapat ditindaklanjuti.</li><li>Dokumentasikan perubahan kontrak.</li></ul><p>Materi ini merupakan contoh demonstrasi, bukan panduan untuk satu API tertentu.</p>'],
                ['Mengamankan formulir publik dari penyalahgunaan', 'Contoh lapisan perlindungan untuk formulir kontak yang menerima kiriman dari pengunjung.', '<p>Formulir publik perlu menerima pesan yang sah tanpa membiarkan satu pengirim membebani layanan. Validasi masukan dan pembatasan frekuensi membantu menjaga jalur tersebut.</p><h2>Lapisan pemeriksaan</h2><ul><li>Validasi panjang dan format setiap masukan.</li><li>Batasi frekuensi pengiriman secara wajar.</li><li>Berikan konfirmasi yang jelas setelah berhasil.</li><li>Simpan kegagalan teknis untuk ditinjau tanpa membuka data sensitif.</li></ul><p>Contoh demonstrasi ini perlu disesuaikan dengan risiko dan kebutuhan situs.</p>'],
            ],
        ];

        foreach ($examples as $category => $posts) {
            $count = Article::query()->where('category', $category)->where('is_published', true)->count();

            foreach ($posts as $index => [$title, $excerpt, $body]) {
                if ($count >= 3) {
                    break;
                }

                $slug = str($title)->slug()->prepend('contoh-')->toString();

                if (Article::query()->where('slug', $slug)->exists()) {
                    continue;
                }

                Article::query()->create([
                    'title' => 'Contoh: '.$title,
                    'slug' => $slug,
                    'category' => $category,
                    'excerpt' => $excerpt,
                    'body' => '<p><strong>Artikel demonstrasi.</strong> Konten berikut disiapkan sebagai data contoh dan bukan laporan kegiatan atau hasil penelitian nyata.</p>'.$body,
                    'thumbnail' => 'assets/blog/thumbnail-placeholder.svg',
                    'thumbnail_alt' => 'Ilustrasi untuk artikel contoh: '.$title,
                    'published_at' => today()->subDays(($index + 1) * 3)->toDateString(),
                    'is_published' => true,
                ]);

                $count++;
            }
        }
    }
}
