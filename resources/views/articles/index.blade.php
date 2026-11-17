@extends('layouts.site')

@section('title', 'Artikel & blog | Dede Husen')
@section('content')
<main id="main" class="wrap page-main" data-articles-page>
    <nav class="page-breadcrumb" aria-label="Lokasi halaman"><a href="{{ route('home') }}">Beranda</a> / <span>Artikel &amp; blog</span></nav>
    <header class="page-intro"><p class="eyebrow">Artikel &amp; blog</p><h1>Catatan dan tulisan</h1><p class="page-lead">Tulisan tentang pengajaran, penelitian, dan teknologi.</p></header>
    <div data-article-content>
        <nav class="blog-filters" aria-label="Filter artikel berdasarkan kategori">
            <a class="blog-filter {{ $activeCategory === null ? 'is-active' : '' }}" href="{{ route('articles.index') }}" @if ($activeCategory === null) aria-current="page" @endif>Semua</a>
            @foreach ($categories as $value => $label)
                <a class="blog-filter {{ $activeCategory === $value ? 'is-active' : '' }}" href="{{ route('articles.index', ['category' => $value]) }}" @if ($activeCategory === $value) aria-current="page" @endif>{{ $label }}</a>
            @endforeach
        </nav>
        <p data-article-filter-status role="status" aria-live="polite" hidden>Memuat artikel…</p>
        <section class="blog-post-grid" aria-label="Daftar artikel">
            @forelse ($articles as $article)
                <article class="blog-post-card glass">
                    @if ($article->thumbnail)<a href="{{ route('articles.show', $article->slug) }}" class="blog-post-media" aria-label="{{ $article->title }}"><img src="{{ $article->thumbnail_url }}" alt="{{ $article->thumbnail_alt ?: $article->title }}" loading="lazy"></a>@endif
                    <div class="blog-post-meta"><span class="topic-kicker">{{ ucfirst($article->category) }}</span><time datetime="{{ $article->published_at->toDateString() }}">{{ $article->published_at->format('d M Y') }}</time></div>
                    <div class="blog-post-copy"><h2><a href="{{ route('articles.show', $article->slug) }}">{{ $article->title }}</a></h2><p>{{ $article->excerpt }}</p><a class="blog-post-link" href="{{ route('articles.show', $article->slug) }}">Baca artikel</a></div>
                </article>
            @empty
                <article class="blog-empty-card glass"><div class="blog-card-mark" aria-hidden="true">Aa</div><div class="blog-empty-copy"><span class="topic-kicker">Artikel &amp; blog</span><h2>{{ $activeCategory ? 'Belum ada tulisan tentang '.$categories[$activeCategory] : 'Belum ada tulisan terbit' }}</h2><p>{{ $activeCategory ? 'Pilih kategori lain untuk melihat artikel yang tersedia.' : 'Artikel yang diterbitkan melalui dashboard akan tampil di halaman ini.' }}</p></div></article>
            @endforelse
        </section>
        <div class="pagination">{{ $articles->links() }}</div>
    </div>
</main>
@endsection
