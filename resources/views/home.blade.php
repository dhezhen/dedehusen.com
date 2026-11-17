@extends('layouts.site')

@section('content')
  <main id="main">
    <section class="wrap hero" id="home" aria-labelledby="hero-title">
      <div class="hero-layout">
        <div>
          <p class="eyebrow">Dosen Teknik Informatika &middot; Universitas Kuningan</p>
          <h1 id="hero-title">{{ $settings->hero_title ?? 'Halo, saya Dede Husen.' }}</h1>
          <p class="hero-desc">{{ $settings->hero_description ?? 'Saya dosen Teknik Informatika di Fakultas Ilmu Komputer, Universitas Kuningan. Melalui situs ini, saya berbagi informasi tentang kegiatan mengajar, riset, publikasi, karya, dan bahan kuliah.' }}</p>
          <div class="hero-cta"><a class="button button-primary" href="#tridarma">Lihat kegiatan saya</a><a
              class="button button-glass" href="#kolaborasi">Info bimbingan & kolaborasi</a></div>
          <div class="hero-highlights" aria-label="Bidang aktivitas">
            <a class="highlight" href="/education"><strong>Pendidikan</strong><span>Mengajar dan berbagi bahan kuliah</span></a>
            <a class="highlight" href="/research"><strong>Penelitian</strong><span>Riset dan publikasi</span></a>
            <a class="highlight" href="/community-service"><strong>Pengabdian</strong><span>Menerapkan teknologi bersama masyarakat</span></a>
          </div>
        </div>
        <aside class="profile-card glass" aria-label="Profil singkat Dede Husen">
          <div class="portrait"><img class="portrait-image" src="foto.webp" alt="Foto profil Dede Husen" width="1000"
              height="1099" decoding="async" fetchpriority="high">
            <div class="profile-caption">
              <div><strong>Dede Husen, M.Kom.</strong><span>Universitas Kuningan -  Indonesia</span></div>
              <!-- <span
                class="caption-mark" aria-hidden="true"></span> -->
            </div>
          </div>
          <!-- <div class="profile-tags" aria-label="Identitas akademik"><span class="chip">Teknik Informatika</span><span
              class="chip">Fakultas Ilmu Komputer</span><span class="chip">Universitas Kuningan</span></div>
        </aside>
      </div> -->
    </section>

    <div class="wrap">
      <div class="affiliation glass" aria-label="Afiliasi akademik">
        <span class="affiliation-label">Afiliasi akademik</span>
        <div class="affiliation-detail"><span>Dosen Program Studi Teknik Informatika</span><span>Fakultas Ilmu
            Komputer</span><span>Universitas Kuningan</span></div>
      </div>
    </div>

    <section class="wrap academic-profiles" aria-labelledby="academic-profiles-title">
      <div class="academic-profiles-heading">
        <p class="eyebrow">Profil akademik</p>
        <h2 id="academic-profiles-title">Publikasi & jejaring</h2>
      </div>
      <div class="profile-links">
        <a class="profile-link" href="https://sinta.kemdiktisaintek.go.id/authors/profile/6856149/" target="_blank"
          rel="noopener noreferrer" aria-label="Buka profil SINTA Dede Husen, ID 6856149">
          <span class="profile-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
              stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
              <path d="M6 4.5h12a2 2 0 0 1 2 2v13H8a2 2 0 0 1-2-2z" />
              <path d="M6 6.5H5a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h3M10 9h6M10 13h6" />
            </svg></span>
          <span class="profile-link-copy"><strong>SINTA</strong><small>ID 6856149</small></span>
        </a>
        <a class="profile-link" href="https://scholar.google.com/citations?hl=id&amp;user=euC8dCYAAAAJ" target="_blank"
          rel="noopener noreferrer" aria-label="Buka profil Google Scholar Dede Husen">
          <span class="profile-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
              stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
              <path d="m2.5 9 9.5-5 9.5 5-9.5 5-9.5-5Z" />
              <path d="M6.5 11.2v4.3c3.4 2.9 7.6 2.9 11 0v-4.3M21.5 9v6" />
            </svg></span>
          <span class="profile-link-copy"><strong>Google Scholar</strong><small>Publikasi & sitasi</small></span>
        </a>
        <a class="profile-link" href="https://www.researchgate.net/profile/Dede-Husen-2" target="_blank"
          rel="noopener noreferrer" aria-label="Buka profil ResearchGate Dede Husen">
          <span class="profile-icon profile-icon-letters" aria-hidden="true">RG</span>
          <span class="profile-link-copy"><strong>ResearchGate</strong><small>Profil penelitian</small></span>
        </a>
        <a class="profile-link" href="https://www.scopus.com/authid/detail.uri?authorId=57223431544" target="_blank"
          rel="noopener noreferrer" aria-label="Buka profil Scopus Dede Husen, Author ID 57223431544">
          <span class="profile-icon profile-icon-letters" aria-hidden="true">Sc</span>
          <span class="profile-link-copy"><strong>Scopus</strong><small>Author ID 57223431544</small></span>
        </a>
        <a class="profile-link" href="https://orcid.org/0009-0005-0441-6681" target="_blank" rel="noopener noreferrer"
          aria-label="Buka profil ORCID Dede Husen, iD 0009-0005-0441-6681">
          <span class="profile-icon profile-icon-letters" aria-hidden="true">iD</span>
          <span class="profile-link-copy"><strong>ORCID</strong><small>0009-0005-0441-6681</small></span>
        </a>
        <a class="profile-link" href="https://uniku.ac.id/struktural-fakultas-ilmu-komputer/" target="_blank"
          rel="noopener noreferrer" aria-label="Buka direktori Fakultas Ilmu Komputer Universitas Kuningan">
          <span class="profile-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
              stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
              <path d="m3 9 9-5 9 5M5 10v9m4-9v9m6-9v9m4-9v9M3 20h18M2 9h20" />
            </svg></span>
          <span class="profile-link-copy"><strong>FKOM Uniku</strong><small>Direktori fakultas</small></span>
        </a>
      </div>
    </section>

    <section class="wrap section" id="tridarma" aria-labelledby="tridarma-title">
      <div class="section-heading">
        <p class="eyebrow">Tridarma perguruan tinggi</p>
        <h2 id="tridarma-title">Kegiatan akademik</h2>
        <p>Di Universitas Kuningan, saya mengajar, melakukan penelitian, dan menjalankan pengabdian kepada masyarakat.</p>
      </div>
      <div class="pillar-grid">
        <a class="pillar-card glass" href="/education">
          <div><span class="card-number">01</span>
            <h3>Mengajar</h3>
            <p>RPS, materi kuliah, dan sumber belajar untuk mahasiswa.</p>
          </div>
          <div class="pillar-foot">Mata kuliah dan bahan ajar</div>
        </a>
        <a class="pillar-card glass" href="/research">
          <div><span class="card-number">02</span>
            <h3>Meneliti</h3>
            <p>Minat riset saya meliputi kecerdasan buatan (AI) dan Data Science.</p>
          </div>
          <div class="pillar-foot">Hasil penelitian</div>
        </a>
        <a class="pillar-card glass" href="/community-service">
          <div><span class="card-number">03</span>
            <h3>Pengabdian masyarakat</h3>
            <p>Menerapkan teknologi bersama mitra dan komunitas.</p>
          </div>
          <div class="pillar-foot">Kegiatan bersama mitra</div>
        </a>
      </div>
    </section>

    <section class="wrap section" id="karya" aria-labelledby="karya-title">
      <div class="showcase glass">
        <div class="showcase-head">
          <div class="section-heading">
            <p class="eyebrow">Karya & pengetahuan</p>
            <h2 id="karya-title">Riset, karya, dan bahan kuliah</h2>
            <p>Publikasi, proyek, dan bahan kuliah akan saya tambahkan di sini.</p>
          </div>
          <nav class="category-list" aria-label="Lihat koleksi">
            <a class="category" href="/publications">Publikasi</a>
            <a class="category" href="/portfolio">Portofolio</a>
            <a class="category" href="/courses">Bahan kuliah</a>
          </nav>
        </div>
        <div class="topic-grid">
          <a class="topic-card" href="/publications">
            <div><span class="topic-kicker">Riset</span>
              <h3>Publikasi ilmiah</h3>
              <p>Artikel jurnal, prosiding, buku ajar, dan HKI.</p>
            </div><span class="topic-foot">Publikasi</span>
          </a>
          <a class="topic-card" href="/portfolio">
            <div><span class="topic-kicker">Karya terapan</span>
              <h3>Portofolio & PkM</h3>
              <p>Aplikasi, purwarupa riset, dan kegiatan bersama masyarakat.</p>
            </div><span class="topic-foot">Portofolio dan pengabdian</span>
          </a>
          <a class="topic-card" href="/courses" id="kuliah">
            <div><span class="topic-kicker">Untuk mahasiswa</span>
              <h3>Mata kuliah & bahan ajar</h3>
              <p>RPS, slide, modul praktikum, dan sumber belajar.</p>
            </div><span class="topic-foot">Bahan kuliah</span>
          </a>
        </div>
      </div>
    </section>

    <section class="wrap section" id="portofolio-proyek" aria-labelledby="project-title">
      <div class="project-heading">
        <div class="section-heading">
          <p class="eyebrow">Portofolio proyek</p>
          <h2 id="project-title">Tiga proyek terbaru</h2>
          <p>Beberapa karya dan kegiatan yang terdokumentasi di sumber publik.</p>
        </div>
        <a class="button button-glass project-more" href="{{ route('portfolio.index') }}">Lihat semua portofolio</a>
      </div>
      <div class="project-list" aria-label="Tiga proyek terbaru">
        @forelse ($projects as $project)
          <article class="project-list-card glass">
            <a href="{{ route('portfolio.show', $project->slug) }}" class="project-card-media" aria-label="{{ $project->title }}"><img src="{{ $project->thumbnail_url ?? asset('assets/blog/thumbnail-placeholder.svg') }}" alt="{{ $project->title }}" width="720" height="420" loading="lazy"></a>
            <div class="project-list-meta"><span class="project-year">{{ $project->published_at->format('Y') }}</span><span class="topic-kicker">{{ $project->category }}</span></div>
            <div class="project-list-copy">
              <h3><a href="{{ route('portfolio.show', $project->slug) }}">{{ $project->title }}</a></h3>
              <p>{{ $project->summary }}</p>
            </div>
          </article>
        @empty
          <p>Proyek akan ditampilkan setelah ditambahkan melalui pengelolaan konten.</p>
        @endforelse
      </div>
    </section>

    <section class="wrap section blog-section" id="artikel" aria-labelledby="blog-title">
      <div class="blog-heading">
        <div class="section-heading">
          <p class="eyebrow">Artikel &amp; blog</p>
          <h2 id="blog-title">Catatan dan tulisan</h2>
          <p>Gagasan seputar teknologi, kegiatan akademik, dan proses belajar akan saya bagikan di sini.</p>
        </div>
        <a class="button button-glass blog-more" href="{{ route('articles.index') }}">Lihat semua tulisan</a>
      </div>
      @if ($articles->isNotEmpty())
        <div class="blog-filters" role="group" aria-label="Filter artikel berdasarkan kategori">
          <button class="blog-filter is-active" type="button" data-blog-filter="all" aria-pressed="true">Semua</button>
          <button class="blog-filter" type="button" data-blog-filter="pendidikan" aria-pressed="false">Pendidikan</button>
          <button class="blog-filter" type="button" data-blog-filter="penelitian" aria-pressed="false">Penelitian</button>
          <button class="blog-filter" type="button" data-blog-filter="pengabdian" aria-pressed="false">Pengabdian</button>
          <button class="blog-filter" type="button" data-blog-filter="teknologi" aria-pressed="false">Teknologi</button>
        </div>
      @endif
      <div class="blog-post-grid" aria-label="Daftar artikel terbaru">
        @forelse ($articles as $article)
          <article class="blog-post-card glass" data-blog-card data-category="{{ $article->category }}">
            @if ($article->thumbnail)<a href="{{ route('articles.show', $article->slug) }}" class="blog-post-media" aria-label="{{ $article->title }}"><img src="{{ $article->thumbnail_url }}" alt="{{ $article->thumbnail_alt ?: $article->title }}" width="720" height="420" loading="lazy"></a>@endif
            <div class="blog-post-meta"><span class="topic-kicker">{{ ucfirst($article->category) }}</span><time datetime="{{ $article->published_at->toDateString() }}">{{ $article->published_at->format('d M Y') }}</time></div>
            <div class="blog-post-copy"><h3><a href="{{ route('articles.show', $article->slug) }}">{{ $article->title }}</a></h3><p>{{ $article->excerpt }}</p><a class="blog-post-link" href="{{ route('articles.show', $article->slug) }}">Baca artikel <span aria-hidden="true">&rarr;</span></a></div>
          </article>
        @empty
          <article class="blog-empty-card glass">
            <div class="blog-card-mark" aria-hidden="true">Aa</div>
            <div class="blog-empty-copy">
              <span class="topic-kicker">Artikel &amp; blog</span>
              <h3>Belum ada tulisan terbit</h3>
              <p>Artikel yang diterbitkan melalui dashboard akan tampil di sini.</p>
            </div>
          </article>
        @endforelse
        @if ($articles->isNotEmpty())
          <article class="blog-empty-card glass" hidden>
            <div class="blog-card-mark" aria-hidden="true">Aa</div>
            <div class="blog-empty-copy">
              <span class="topic-kicker">Tulisan</span>
              <h3 data-blog-empty-title>Tidak ada artikel di kategori ini</h3>
              <p data-blog-empty-message aria-live="polite">Pilih kategori lain untuk melihat tulisan.</p>
            </div>
          </article>
        @endif
      </div>
    </section>

    <section class="wrap section" id="kolaborasi" aria-labelledby="collab-title">
      <div class="collab-panel glass">
        <div class="collab-intro">
          <p class="eyebrow">Bimbingan &amp; kolaborasi</p>
          <h2 id="collab-title">Mari mulai percakapan.</h2>
          <p>Punya pertanyaan tentang tugas akhir, ide penelitian, atau peluang kolaborasi? Ceritakan singkat lewat formulir ini.</p>
          <div class="collab-note">
            <span class="collab-note-mark" aria-hidden="true">&rarr;</span>
            <p>Terbuka untuk mahasiswa dan rekan akademisi.</p>
          </div>
        </div>
        <form class="contact-form" action="{{ route('contact.store') }}" method="post" data-contact-form>
          @csrf
          <div class="contact-form-heading">
            <h3>Kirim pesan</h3>
            <p>Isi kolom berikut agar pesan Anda mudah saya pahami.</p>
          </div>
          <div class="contact-fields">
            <div class="contact-honeypot" aria-hidden="true">
              <label for="contact-website">Leave this field empty</label>
              <input id="contact-website" name="website" type="text" tabindex="-1" autocomplete="off">
            </div>
            <div class="contact-field">
              <label for="contact-name">Nama</label>
              <input id="contact-name" name="name" type="text" autocomplete="name" required>
            </div>
            <div class="contact-field">
              <label for="contact-email">Email</label>
              <input id="contact-email" name="email" type="email" autocomplete="email" required>
            </div>
            <div class="contact-field contact-field-wide">
              <label for="contact-topic">Topik</label>
              <select id="contact-topic" name="topic" required>
                <option value="" selected disabled>Pilih topik pesan</option>
                <option value="Bimbingan tugas akhir">Bimbingan tugas akhir</option>
                <option value="Kolaborasi penelitian">Kolaborasi penelitian</option>
                <option value="Pengabdian masyarakat">Pengabdian masyarakat</option>
                <option value="Lainnya">Lainnya</option>
              </select>
            </div>
            <div class="contact-field contact-field-wide">
              <label for="contact-message">Pesan</label>
              <textarea id="contact-message" name="message" rows="4" required></textarea>
            </div>
            <label class="contact-consent contact-field-wide">
              <input name="consent" type="checkbox" value="yes" required>
              <span>Saya memahami pesan ini disimpan di inbox situs agar dapat ditindaklanjuti.</span>
            </label>
          </div>
          <button class="button button-primary contact-submit" type="submit">Kirim pesan</button>
          <p class="contact-form-note" data-contact-status aria-live="polite" role="status">{{ session('contact_success', 'Nama, email, topik, dan pesan akan tersimpan di inbox situs.') }}</p>
        </form>
        <dialog class="contact-success-dialog" data-contact-dialog aria-labelledby="contact-dialog-title" aria-describedby="contact-dialog-message">
          <div class="contact-success-dialog-content">
            <p class="eyebrow">Bimbingan &amp; kolaborasi</p>
            <h3 id="contact-dialog-title" data-contact-dialog-title>Pesan tersimpan</h3>
            <p id="contact-dialog-message" data-contact-dialog-message></p>
            <button class="button button-primary" type="button" data-contact-dialog-close>Tutup</button>
          </div>
        </dialog>
      </div>
    </section>
  </main>
@endsection


