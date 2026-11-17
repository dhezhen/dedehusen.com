@extends('layouts.site')

@section('title', 'Bahan Kuliah | Dede Husen, M.Kom.')
@section('content')
  <main id="main" class="wrap page-main">
    <nav class="page-breadcrumb" aria-label="Lokasi halaman"><a href="/">Beranda</a> / <span>Bahan kuliah</span></nav>
    <header class="page-intro">
      <p class="eyebrow">Untuk mahasiswa</p>
      <h1>Mata kuliah & bahan kuliah</h1>
      <p class="page-lead">RPS, slide, modul praktikum, dan sumber belajar akan saya bagikan di halaman ini.</p>
    </header>
    @forelse ($courses as $course)
      <section class="course-content-panel content-panel" aria-labelledby="course-{{ $course->slug }}">
        <header class="course-content-heading">
          <div>
            <p class="eyebrow">Mata kuliah</p>
            <h2 id="course-{{ $course->slug }}">{{ $course->name }}</h2>
          </div>
          <div class="course-content-meta">
            @if ($course->course_code)<span>{{ $course->course_code }}</span>@endif
            @if ($course->semester)<span>{{ $course->semester }}</span>@endif
          </div>
        </header>
        @if ($course->description)<p class="course-content-description">{{ $course->description }}</p>@endif
        <ul class="course-material-list">
          @foreach ($course->materials as $material)
            <li class="course-material-item">
              <div class="course-material-copy">
                <p class="course-material-type">{{ \App\Enums\CourseMaterialType::tryFrom($material->material_type)?->label() ?? 'Materi' }}</p>
                <h3>{{ $material->title }}</h3>
                @if ($material->description)<p>{{ $material->description }}</p>@endif
              </div>
              @if ($material->resource_type === 'file')
                <a class="course-material-link" href="{{ $material->resourceUrl() }}" download>Unduh berkas</a>
              @else
                <a class="course-material-link" href="{{ $material->resourceUrl() }}" target="_blank" rel="noopener noreferrer" aria-label="Buka tautan untuk {{ $material->title }} di tab baru">Buka tautan</a>
              @endif
            </li>
          @endforeach
        </ul>
      </section>
    @empty
      <section class="content-panel course-empty-state" aria-labelledby="empty-title">
        <h2 id="empty-title">Belum ada materi yang diterbitkan</h2>
        <p>Materi akan tampil di sini setelah diterbitkan melalui dashboard.</p>
      </section>
    @endforelse
    <section class="related-section" aria-labelledby="related-title">
      <h2 id="related-title">Jelajahi bagian lain</h2>
      <div class="related-grid"><a class="related-card" href="/education"><strong>Pendidikan</strong><span>Kegiatan mengajar</span></a><a class="related-card" href="/articles"><strong>Artikel &amp; blog</strong><span>Catatan akademik</span></a><a class="related-card" href="/research"><strong>Penelitian</strong><span>Publikasi dan hasil riset</span></a></div>
    </section>
  </main>
@endsection


