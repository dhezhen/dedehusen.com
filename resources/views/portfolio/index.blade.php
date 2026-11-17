@extends('layouts.site')

@section('title', 'Portofolio | Dede Husen')
@section('content')
<main id="main" class="wrap page-main">
    <nav class="page-breadcrumb" aria-label="Lokasi halaman"><a href="{{ route('home') }}">Beranda</a> / <span>Portofolio</span></nav>
    <header class="page-intro"><p class="eyebrow">Karya &amp; pengetahuan</p><h1>Portofolio proyek</h1><p class="page-lead">Proyek dan kegiatan yang dirangkum dari publikasi dan sumber Universitas.</p></header>
    <section class="project-list" aria-label="Portofolio proyek">
        @forelse ($projects as $project)
            <article class="project-list-card glass" id="{{ $project->slug }}">
                <a href="{{ route('portfolio.show', $project->slug) }}" class="project-card-media" aria-label="{{ $project->title }}"><img src="{{ $project->thumbnail_url ?? asset('assets/blog/thumbnail-placeholder.svg') }}" alt="{{ $project->thumbnail_alt ?: $project->title }}" loading="lazy"></a>
                <div class="project-list-meta"><time class="project-year">{{ $project->published_at->format('Y') }}</time><span class="topic-kicker">{{ $project->category }}</span></div>
                <div class="project-list-copy"><h2><a href="{{ route('portfolio.show', $project->slug) }}">{{ $project->title }}</a></h2><p>{{ $project->summary }}</p>@if ($project->source_url)<a class="project-source-link" href="{{ $project->source_url }}" target="_blank" rel="noopener noreferrer">Baca sumber</a>@endif</div>
            </article>
        @empty
            <p>Belum ada proyek yang diterbitkan.</p>
        @endforelse
    </section>
</main>
@endsection

