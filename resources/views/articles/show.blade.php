@extends('layouts.site')

@section('title', $article->title . ' | Dede Husen, M.Kom.')
@section('description', $article->excerpt)

@push('styles')
<style>
  /* ── Article Detail Layout ──────────────────────── */
  .article-detail {
    max-width: 800px;
    margin-inline: auto;
  }

  /* Hero image */
  .article-hero {
    position: relative;
    width: 100%;
    aspect-ratio: 16 / 9;
    overflow: hidden;
    border-radius: var(--radius-card);
    background: var(--accent-soft);
    margin-bottom: 32px;
    box-shadow: var(--shadow);
  }

  .article-hero img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform .5s ease;
  }

  .article-hero:hover img {
    transform: scale(1.02);
  }

  /* No-image placeholder */
  .article-hero-placeholder {
    width: 100%;
    aspect-ratio: 16 / 9;
    border-radius: var(--radius-card);
    background: linear-gradient(135deg, var(--accent-soft) 0%, rgba(11, 107, 116, .06) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 32px;
    border: 1px dashed var(--line);
  }

  .article-hero-placeholder svg {
    width: 64px;
    height: 64px;
    color: var(--muted);
    opacity: .3;
  }

  /* Meta bar */
  .article-meta-bar {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 10px 16px;
    margin-bottom: 24px;
    font-size: .86rem;
    color: var(--muted);
  }

  .article-category-badge {
    display: inline-flex;
    align-items: center;
    padding: 5px 16px;
    border-radius: var(--radius-pill);
    background: var(--accent-soft);
    color: var(--accent);
    font-weight: 700;
    font-size: .78rem;
    text-transform: uppercase;
    letter-spacing: .04em;
    text-decoration: none;
    transition: all .2s ease;
  }

  .article-category-badge:hover {
    background: var(--accent);
    color: #fff;
  }

  .article-date,
  .article-reading-time {
    display: flex;
    align-items: center;
    gap: 5px;
    color: var(--muted);
  }

  .meta-dot {
    color: var(--line);
    font-size: .7rem;
  }

  /* Title */
  .article-detail-title {
    font-family: var(--display);
    font-size: clamp(1.8rem, 4.5vw, 2.8rem);
    font-weight: 800;
    line-height: 1.18;
    letter-spacing: -.025em;
    margin: 0 0 20px 0;
    color: var(--text);
  }

  /* Excerpt / lead */
  .article-excerpt {
    font-size: clamp(1.05rem, 1.6vw, 1.18rem);
    line-height: 1.65;
    color: var(--muted);
    margin: 0 0 32px 0;
    padding-bottom: 32px;
    border-bottom: 1px solid var(--line);
    max-width: 66ch;
    font-style: italic;
  }

  /* ── Article Body Prose ─────────────────────────── */
  .article-body {
    font-size: clamp(1rem, 1.3vw, 1.1rem);
    line-height: 1.85;
    color: var(--text);
    word-wrap: break-word;
    overflow-wrap: break-word;
  }

  .article-body > * + * {
    margin-top: 1.4em;
  }

  .article-body h2 {
    font-family: var(--display);
    font-size: 1.55rem;
    font-weight: 700;
    margin-top: 2.2em;
    margin-bottom: .6em;
    color: var(--text);
    letter-spacing: -.01em;
    padding-bottom: 8px;
    border-bottom: 2px solid var(--accent-soft);
  }

  .article-body h3 {
    font-family: var(--display);
    font-size: 1.25rem;
    font-weight: 700;
    margin-top: 1.6em;
    margin-bottom: .5em;
  }

  .article-body p {
    margin: 0 0 1.2em 0;
    max-width: 66ch;
  }

  .article-body a {
    color: var(--accent);
    text-decoration: underline;
    text-underline-offset: 3px;
    text-decoration-color: rgba(11, 107, 116, .3);
    transition: text-decoration-color .2s ease;
  }

  .article-body a:hover {
    text-decoration-color: currentColor;
  }

  .article-body ul,
  .article-body ol {
    padding-left: 1.6em;
    max-width: 66ch;
  }

  .article-body li + li {
    margin-top: .5em;
  }

  .article-body blockquote {
    margin: 1.6em 0;
    padding: 18px 24px;
    border-left: 4px solid var(--accent);
    background: var(--accent-soft);
    border-radius: 0 14px 14px 0;
    color: var(--text);
    font-style: italic;
  }

  .article-body blockquote p {
    margin: 0;
  }

  .article-body img {
    max-width: 100%;
    height: auto;
    border-radius: 14px;
    margin: 1.4em 0;
    box-shadow: var(--shadow);
  }

  .article-body pre {
    padding: 20px 24px;
    background: rgba(0, 0, 0, .06);
    border-radius: 14px;
    overflow-x: auto;
    font-size: .88rem;
    line-height: 1.6;
    border: 1px solid var(--line);
  }

  [data-theme="dark"] .article-body pre {
    background: rgba(255, 255, 255, .06);
  }

  .article-body code {
    padding: 2px 7px;
    background: rgba(0, 0, 0, .06);
    border-radius: 6px;
    font-size: .88em;
  }

  [data-theme="dark"] .article-body code {
    background: rgba(255, 255, 255, .08);
  }

  .article-body pre code {
    padding: 0;
    background: none;
    border-radius: 0;
  }

  .article-body table {
    width: 100%;
    border-collapse: collapse;
    margin: 1.4em 0;
    font-size: .92rem;
  }

  .article-body th,
  .article-body td {
    padding: 10px 14px;
    border: 1px solid var(--line);
    text-align: left;
  }

  .article-body th {
    background: var(--accent-soft);
    font-weight: 700;
  }

  .article-body hr {
    border: none;
    border-top: 1px solid var(--line);
    margin: 2em 0;
  }

  /* ── Share buttons ──────────────────────────────── */
  .article-share {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-top: 36px;
    padding-top: 24px;
    border-top: 1px solid var(--line);
  }

  .share-label {
    font-size: .82rem;
    font-weight: 700;
    color: var(--muted);
    text-transform: uppercase;
    letter-spacing: .04em;
  }

  .share-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    border: 1px solid var(--line);
    color: var(--muted);
    text-decoration: none;
    transition: all .2s ease;
    cursor: pointer;
    background: transparent;
  }

  .share-btn:hover {
    background: var(--accent);
    color: #fff;
    border-color: var(--accent);
    transform: translateY(-2px);
  }

  /* ── Author Card ─────────────────────────────────── */
  .article-author-card {
    margin-top: 40px;
    padding: 28px;
    background: var(--glass);
    border: 1px solid var(--glass-border);
    border-radius: var(--radius-card);
    display: flex;
    align-items: center;
    gap: 18px;
    box-shadow: var(--shadow);
  }

  .author-avatar {
    width: 56px;
    height: 56px;
    border-radius: 50%;
    background: var(--accent-soft);
    border: 2px solid var(--accent);
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: var(--display);
    font-weight: 800;
    font-size: 1.2rem;
    color: var(--accent);
    flex-shrink: 0;
  }

  .author-info {
    display: flex;
    flex-direction: column;
    gap: 4px;
  }

  .author-written-by {
    font-size: .72rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: .06em;
    color: var(--muted);
  }

  .author-name {
    font-family: var(--display);
    font-weight: 700;
    font-size: 1.05rem;
    color: var(--text);
  }

  .author-role {
    font-size: .84rem;
    color: var(--muted);
    line-height: 1.4;
  }

  /* ── Prev / Next Navigation ──────────────────────── */
  .article-nav {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
    margin-top: 40px;
  }

  .article-nav-link {
    display: flex;
    flex-direction: column;
    gap: 6px;
    padding: 20px;
    border-radius: var(--radius-card);
    background: var(--glass);
    border: 1px solid var(--glass-border);
    text-decoration: none;
    transition: all .25s ease;
    box-shadow: var(--shadow);
  }

  .article-nav-link:hover {
    background: var(--glass-hover);
    box-shadow: var(--shadow-hover);
    transform: translateY(-2px);
  }

  .article-nav-link--next {
    text-align: right;
    grid-column: 2;
  }

  .article-nav-label {
    font-size: .72rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .05em;
    color: var(--muted);
    display: flex;
    align-items: center;
    gap: 5px;
  }

  .article-nav-link--next .article-nav-label {
    justify-content: flex-end;
  }

  .article-nav-title {
    font-family: var(--display);
    font-weight: 700;
    font-size: .95rem;
    color: var(--text);
    line-height: 1.35;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  /* ── Related Articles ────────────────────────────── */
  .related-articles {
    margin-top: 48px;
    padding-top: 40px;
    border-top: 1px solid var(--line);
  }

  .related-articles-title {
    font-family: var(--display);
    font-size: 1.35rem;
    font-weight: 700;
    margin: 0 0 24px 0;
    color: var(--text);
  }

  .related-articles-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
    gap: 16px;
  }

  .related-article-card {
    padding: 20px;
    background: var(--glass);
    border: 1px solid var(--glass-border);
    border-radius: var(--radius-card);
    text-decoration: none;
    transition: all .25s ease;
    box-shadow: var(--shadow);
    display: flex;
    flex-direction: column;
    gap: 10px;
  }

  .related-article-card:hover {
    background: var(--glass-hover);
    box-shadow: var(--shadow-hover);
    transform: translateY(-3px);
  }

  .related-article-card .related-card-thumb {
    width: 100%;
    aspect-ratio: 16 / 10;
    border-radius: 12px;
    object-fit: cover;
    background: var(--accent-soft);
  }

  .related-card-category {
    font-size: .72rem;
    font-weight: 700;
    color: var(--accent);
    text-transform: uppercase;
    letter-spacing: .04em;
  }

  .related-card-title {
    font-family: var(--display);
    font-weight: 700;
    font-size: .95rem;
    color: var(--text);
    line-height: 1.35;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  .related-card-date {
    font-size: .78rem;
    color: var(--muted);
  }

  /* ── Back link ───────────────────────────────────── */
  .article-back-row {
    margin-top: 40px;
    display: flex;
    justify-content: center;
  }

  .article-back-link {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 10px 24px;
    font-size: .88rem;
    font-weight: 700;
    color: var(--text);
    background: var(--glass);
    border: 1px solid var(--glass-border);
    border-radius: var(--radius-pill);
    text-decoration: none;
    transition: all .2s ease;
    box-shadow: var(--shadow);
  }

  .article-back-link:hover {
    background: var(--accent);
    color: #fff;
    border-color: var(--accent);
    transform: translateY(-1px);
  }

  /* ── Explore Section ─────────────────────────────── */
  .explore-section {
    margin-top: 48px;
    padding-top: 32px;
    border-top: 1px solid var(--line);
  }

  .explore-section h2 {
    font-family: var(--display);
    font-size: 1.2rem;
    font-weight: 700;
    color: var(--text);
    margin: 0 0 16px 0;
  }

  .explore-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 12px;
  }

  .explore-card {
    padding: 18px;
    border-radius: 16px;
    background: var(--glass);
    border: 1px solid var(--glass-border);
    text-decoration: none;
    display: flex;
    flex-direction: column;
    gap: 4px;
    transition: all .2s ease;
  }

  .explore-card:hover {
    background: var(--glass-hover);
    transform: translateY(-2px);
  }

  .explore-card strong {
    color: var(--text);
    font-size: .92rem;
  }

  .explore-card span {
    font-size: .78rem;
    color: var(--muted);
  }

  @media (max-width: 640px) {
    .article-hero {
      aspect-ratio: 16 / 10;
      border-radius: 16px;
    }

    .article-nav {
      grid-template-columns: 1fr;
    }

    .article-nav-link--next {
      grid-column: 1;
      text-align: left;
    }

    .article-nav-link--next .article-nav-label {
      justify-content: flex-start;
    }

    .article-author-card {
      flex-direction: column;
      text-align: center;
    }

    .related-articles-grid {
      grid-template-columns: 1fr;
    }
  }
</style>
@endpush

@section('content')
<main id="main" class="wrap page-main">

  <nav class="page-breadcrumb" aria-label="Lokasi halaman">
    <a href="{{ route('home') }}">Beranda</a> /
    <a href="{{ route('articles.index') }}">Artikel &amp; blog</a> /
    <span>{{ Str::limit($article->title, 40) }}</span>
  </nav>

  <article class="article-detail">

    {{-- Hero Image --}}
    @if ($article->thumbnail_url)
      <div class="article-hero">
        <img src="{{ $article->thumbnail_url }}" alt="{{ $article->thumbnail_alt ?: $article->title }}" width="1200" height="675" loading="eager">
      </div>
    @else
      <div class="article-hero-placeholder" aria-hidden="true">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round">
          <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/>
        </svg>
      </div>
    @endif

    {{-- Meta Bar --}}
    <div class="article-meta-bar">
      <a href="{{ route('articles.index', ['category' => $article->category]) }}" class="article-category-badge">
        {{ ucfirst($article->category) }}
      </a>
      <span class="meta-dot">&middot;</span>
      <time class="article-date" datetime="{{ $article->published_at->toDateString() }}">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
        </svg>
        {{ $article->published_at->translatedFormat('d F Y') }}
      </time>
      @php
        $wordCount = str_word_count(strip_tags($article->body ?? ''));
        $readingMinutes = max(1, (int) ceil($wordCount / 200));
      @endphp
      <span class="meta-dot">&middot;</span>
      <span class="article-reading-time">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
        </svg>
        {{ $readingMinutes }} menit baca
      </span>
    </div>

    {{-- Title --}}
    <h1 class="article-detail-title">{{ $article->title }}</h1>

    {{-- Excerpt / Lead --}}
    @if ($article->excerpt)
      <p class="article-excerpt">{{ $article->excerpt }}</p>
    @endif

    {{-- Article Body --}}
    <div class="article-body">
      {!! $article->body_html !!}
    </div>

    {{-- Share --}}
    <div class="article-share">
      <span class="share-label">Bagikan:</span>
      <a href="https://twitter.com/intent/tweet?text={{ urlencode($article->title) }}&url={{ urlencode(request()->url()) }}"
         target="_blank" rel="noopener noreferrer" class="share-btn" title="Bagikan ke X / Twitter" aria-label="Bagikan ke X / Twitter">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
      </a>
      <a href="https://wa.me/?text={{ urlencode($article->title . ' — ' . request()->url()) }}"
         target="_blank" rel="noopener noreferrer" class="share-btn" title="Bagikan ke WhatsApp" aria-label="Bagikan ke WhatsApp">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
      </a>
      <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(request()->url()) }}&title={{ urlencode($article->title) }}"
         target="_blank" rel="noopener noreferrer" class="share-btn" title="Bagikan ke LinkedIn" aria-label="Bagikan ke LinkedIn">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
      </a>
      <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}"
         target="_blank" rel="noopener noreferrer" class="share-btn" title="Bagikan ke Facebook" aria-label="Bagikan ke Facebook">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
      </a>
      <button type="button" class="share-btn" title="Salin tautan" aria-label="Salin tautan artikel" onclick="navigator.clipboard.writeText(window.location.href).then(()=>{this.style.background='var(--accent)';this.style.color='#fff';this.style.borderColor='var(--accent)';setTimeout(()=>{this.style.background='';this.style.color='';this.style.borderColor='';},1500)})">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/>
          <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/>
        </svg>
      </button>
    </div>

    {{-- Author Card --}}
    <div class="article-author-card">
      <div class="author-avatar" aria-hidden="true">DH</div>
      <div class="author-info">
        <span class="author-written-by">Ditulis oleh</span>
        <span class="author-name">Dede Husen, M.Kom.</span>
        <span class="author-role">Dosen Teknik Informatika &middot; Universitas Kuningan</span>
      </div>
    </div>

    {{-- Prev / Next Navigation --}}
    @if (($prevArticle ?? null) || ($nextArticle ?? null))
      <nav class="article-nav" aria-label="Navigasi artikel">
        @if ($prevArticle)
          <a href="{{ route('articles.show', $prevArticle->slug) }}" class="article-nav-link">
            <span class="article-nav-label">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
              Sebelumnya
            </span>
            <span class="article-nav-title">{{ $prevArticle->title }}</span>
          </a>
        @endif
        @if ($nextArticle)
          <a href="{{ route('articles.show', $nextArticle->slug) }}" class="article-nav-link article-nav-link--next">
            <span class="article-nav-label">
              Selanjutnya
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </span>
            <span class="article-nav-title">{{ $nextArticle->title }}</span>
          </a>
        @endif
      </nav>
    @endif

    {{-- Related Articles --}}
    @if (($relatedArticles ?? collect())->isNotEmpty())
      <section class="related-articles" aria-labelledby="related-articles-title">
        <h2 id="related-articles-title">Artikel terkait</h2>
        <div class="related-articles-grid">
          @foreach ($relatedArticles as $related)
            <a href="{{ route('articles.show', $related->slug) }}" class="related-article-card">
              @if ($related->thumbnail_url)
                <img class="related-card-thumb" src="{{ $related->thumbnail_url }}" alt="{{ $related->thumbnail_alt ?: $related->title }}" loading="lazy">
              @endif
              <span class="related-card-category">{{ ucfirst($related->category) }}</span>
              <span class="related-card-title">{{ $related->title }}</span>
              <span class="related-card-date">{{ $related->published_at->translatedFormat('d M Y') }}</span>
            </a>
          @endforeach
        </div>
      </section>
    @endif

    {{-- Back to articles --}}
    <div class="article-back-row">
      <a href="{{ route('articles.index') }}" class="article-back-link">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
          <line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/>
        </svg>
        Semua Artikel
      </a>
    </div>

  </article>

  {{-- Explore Other Sections --}}
  <section class="explore-section" aria-labelledby="explore-title">
    <h2 id="explore-title">Jelajahi bagian lain</h2>
    <div class="explore-grid">
      <a class="explore-card" href="/research"><strong>Penelitian</strong><span>Hasil dan proyek penelitian</span></a>
      <a class="explore-card" href="/publications"><strong>Publikasi</strong><span>Jurnal &amp; metrik sitasi</span></a>
      <a class="explore-card" href="/portfolio"><strong>Portofolio</strong><span>Karya terapan</span></a>
      <a class="explore-card" href="/courses"><strong>Bahan Kuliah</strong><span>Materi perkuliahan</span></a>
    </div>
  </section>

</main>
@endsection
