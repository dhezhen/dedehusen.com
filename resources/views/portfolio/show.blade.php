@extends('layouts.site')

@section('title', $project->title . ' | Dede Husen')
@section('content')
<main id="main" class="wrap page-main">
    <nav class="page-breadcrumb" aria-label="Lokasi halaman"><a href="{{ route('home') }}">Beranda</a> / <a href="{{ route('portfolio.index') }}">Portofolio</a></nav>
    <article class="content-panel project-detail-panel">
        <p class="eyebrow">{{ $project->category }} · {{ $project->published_at->format('Y') }}</p>
        <h1>{{ $project->title }}</h1>
        @if ($project->thumbnail_url)
            <img class="project-detail-image" src="{{ $project->thumbnail_url }}" alt="{{ $project->thumbnail_alt ?: $project->title }}">
        @endif
        <p>{{ $project->summary }}</p>
        @if ($project->details)
            <div class="project-detail-copy">{!! $project->details_html !!}</div>
        @endif
        @if ($project->source_url)<p><a class="project-source-link" href="{{ $project->source_url }}" target="_blank" rel="noopener noreferrer">Buka sumber publik</a></p>@endif
    </article>
</main>
@endsection

