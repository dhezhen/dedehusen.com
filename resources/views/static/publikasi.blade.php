@extends('layouts.site')

@section('title', 'Publikasi Ilmiah | Dede Husen, M.Kom.')
@section('description', 'Daftar publikasi ilmiah, prosiding konferensi, dan metrik sitasi Google Scholar Dede Husen, dosen Teknik Informatika Universitas Kuningan.')

@push('styles')
<style>
  /* ── Metrics Grid ───────────────────────────────── */
  .scholar-dashboard { display: flex; flex-direction: column; gap: 24px; margin-top: 24px; }

  .metrics-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(190px, 1fr));
    gap: 16px;
  }

  .metric-card {
    padding: 20px 22px;
    background: var(--glass);
    border: 1px solid var(--glass-border);
    border-radius: var(--radius-card);
    box-shadow: var(--shadow);
    display: flex;
    flex-direction: column;
    transition: transform .2s ease, box-shadow .2s ease;
  }

  .metric-card:hover { transform: translateY(-2px); box-shadow: var(--shadow-hover); }
  .metric-label { font-size: .84rem; font-weight: 700; text-transform: uppercase; letter-spacing: .05em; color: var(--muted); margin-bottom: 6px; }
  .metric-value { font-family: var(--display); font-size: clamp(2rem, 3.5vw, 2.6rem); font-weight: 800; line-height: 1.1; color: var(--accent); margin-bottom: 6px; }
  .metric-desc { font-size: .82rem; color: var(--muted); margin: 0; }

  /* ── Citation Trend ─────────────────────────────── */
  .trend-panel {
    padding: 22px 24px;
    background: var(--glass);
    border: 1px solid var(--glass-border);
    border-radius: var(--radius-card);
    box-shadow: var(--shadow);
  }

  .trend-header { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; margin-bottom: 20px; }
  .trend-title { font-size: 1.05rem; font-weight: 700; margin: 0; }
  .trend-bars { display: flex; align-items: flex-end; gap: 16px; height: 120px; padding-top: 10px; }
  .trend-col { flex: 1; display: flex; flex-direction: column; align-items: center; height: 100%; justify-content: flex-end; gap: 6px; }
  .trend-count { font-size: .8rem; font-weight: 700; color: var(--accent); }
  .trend-bar { width: 100%; max-width: 44px; background: linear-gradient(180deg, var(--accent) 0%, rgba(13, 148, 136, .4) 100%); border-radius: 6px 6px 2px 2px; transition: height .4s ease; min-height: 6px; }
  .trend-year { font-size: .78rem; font-weight: 600; color: var(--muted); }

  /* ── Sync Bar ───────────────────────────────────── */
  .sync-bar {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: space-between;
    gap: 14px;
    padding: 16px 22px;
    background: var(--glass);
    border: 1px solid var(--glass-border);
    border-radius: var(--radius-card);
    font-size: .88rem;
  }

  .sync-info { color: var(--muted); display: flex; align-items: center; gap: 8px; }
  .sync-status-dot { width: 8px; height: 8px; border-radius: 50%; background: #10b981; box-shadow: 0 0 8px rgba(16,185,129,.6); display: inline-block; flex-shrink: 0; }
  .btn-sync {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 8px 16px; font-size: .82rem; font-weight: 700;
    color: var(--text); background: var(--accent-soft);
    border: 1px solid var(--line); border-radius: var(--radius-pill);
    cursor: pointer; transition: all .2s ease;
  }
  .btn-sync:hover { background: var(--accent); color: #fff; border-color: var(--accent); }

  /* ── Search & Filter Bar ────────────────────────── */
  .filter-section {
    margin-top: 36px;
    display: flex;
    flex-direction: column;
    gap: 16px;
  }

  .filter-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 16px;
  }

  .filter-header h2 { margin: 0; font-size: 1.35rem; }

  .sort-pills {
    display: flex;
    gap: 8px;
    background: var(--glass);
    padding: 4px;
    border-radius: var(--radius-pill);
    border: 1px solid var(--line);
  }

  .sort-pill {
    padding: 6px 14px;
    font-size: .82rem;
    font-weight: 600;
    border-radius: var(--radius-pill);
    color: var(--muted);
    text-decoration: none;
    transition: all .2s ease;
    white-space: nowrap;
    cursor: pointer;
  }

  .sort-pill.active { background: var(--accent); color: #fff; }

  /* Search box */
  .search-row {
    display: flex;
    align-items: stretch;
    gap: 10px;
    flex-wrap: wrap;
  }

  .search-wrap {
    flex: 1;
    min-width: 240px;
    position: relative;
    display: flex;
    align-items: center;
  }

  .search-icon {
    position: absolute;
    left: 14px;
    color: var(--muted);
    pointer-events: none;
    display: flex;
  }

  .search-input {
    width: 100%;
    min-height: 44px;
    padding: 10px 42px 10px 42px;
    border: 1px solid var(--line);
    border-radius: var(--radius-pill);
    background: var(--glass);
    color: var(--text);
    font: 500 .9rem/1 var(--sans);
    outline: none;
    transition: border-color .2s ease, box-shadow .2s ease;
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
  }

  .search-input:focus {
    border-color: var(--accent);
    box-shadow: 0 0 0 3px var(--accent-soft);
  }

  .search-input::placeholder { color: var(--muted); }

  .btn-search-clear {
    position: absolute;
    right: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 22px;
    height: 22px;
    border-radius: 50%;
    background: var(--muted);
    color: #fff;
    text-decoration: none;
    font-size: .7rem;
    transition: background .2s ease;
    cursor: pointer;
    border: none;
  }

  .btn-search-clear:hover { background: var(--accent); }

  .btn-apply-search {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 10px 20px; font-size: .88rem; font-weight: 700;
    color: #fff; background: var(--accent);
    border: none; border-radius: var(--radius-pill);
    cursor: pointer; transition: all .2s ease; white-space: nowrap;
    min-height: 44px;
  }

  .btn-apply-search:hover { background: var(--accent-strong); transform: translateY(-1px); }

  /* Year filter pills */
  .year-filter {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 8px;
  }

  .year-filter-label {
    font-size: .82rem;
    font-weight: 700;
    color: var(--muted);
    text-transform: uppercase;
    letter-spacing: .04em;
    margin-right: 4px;
    white-space: nowrap;
  }

  .year-pill {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 5px 14px;
    border: 1px solid var(--line);
    border-radius: var(--radius-pill);
    font-size: .82rem;
    font-weight: 600;
    color: var(--muted);
    text-decoration: none;
    background: transparent;
    transition: all .2s ease;
    white-space: nowrap;
    cursor: pointer;
  }

  .year-pill:hover { border-color: var(--accent); color: var(--accent); background: var(--accent-soft); }
  .year-pill.active { background: var(--accent); color: #fff; border-color: var(--accent); }

  /* Active filter summary */
  .filter-summary {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
    padding: 10px 16px;
    background: var(--accent-soft);
    border: 1px solid var(--accent);
    border-radius: 12px;
    font-size: .86rem;
    color: var(--text);
  }

  .filter-summary strong { color: var(--accent); }
  .filter-summary-clear {
    margin-left: auto;
    padding: 4px 10px;
    font-size: .78rem;
    font-weight: 700;
    color: var(--muted);
    border: 1px solid var(--line);
    border-radius: var(--radius-pill);
    text-decoration: none;
    transition: all .2s;
    cursor: pointer;
  }
  .filter-summary-clear:hover { color: var(--text); border-color: var(--muted); }

  /* ── Publications List ──────────────────────────── */
  .pubs-list { display: flex; flex-direction: column; gap: 14px; margin-top: 20px; }

  .pub-item {
    display: grid;
    grid-template-columns: auto 1fr auto;
    gap: 18px;
    align-items: center;
    padding: 20px 24px;
    background: var(--glass);
    border: 1px solid var(--glass-border);
    border-radius: var(--radius-card);
    box-shadow: var(--shadow);
    transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease, opacity .2s ease;
  }

  .pub-item:hover { transform: translateY(-2px); box-shadow: var(--shadow-hover); border-color: var(--accent); }

  .pub-cite-badge {
    min-width: 68px;
    padding: 8px 10px;
    background: var(--accent-soft);
    border: 1px solid var(--line);
    border-radius: 12px;
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
  }

  .pub-cite-num { font-family: var(--display); font-size: 1.3rem; font-weight: 800; color: var(--accent); line-height: 1; }
  .pub-cite-label { font-size: .68rem; font-weight: 700; text-transform: uppercase; color: var(--muted); margin-top: 3px; }

  .pub-content { min-width: 0; }
  .pub-title { margin: 0 0 6px 0; font-size: 1.05rem; font-weight: 700; line-height: 1.4; }
  .pub-title a { color: var(--text); text-decoration: none; transition: color .2s ease; }
  .pub-title a:hover { color: var(--accent); }
  .pub-title mark, .pub-authors mark { background: rgba(255, 220, 50, .4); border-radius: 3px; padding: 0 2px; color: inherit; }

  .pub-authors { font-size: .86rem; color: var(--muted); margin: 0 0 6px 0; }
  .pub-authors strong { color: var(--text); }

  .pub-meta { display: flex; flex-wrap: wrap; align-items: center; gap: 10px; font-size: .82rem; }
  .pub-venue { color: var(--muted); font-style: italic; }
  .pub-year-badge {
    padding: 2px 10px; border-radius: var(--radius-pill);
    background: var(--accent-soft); color: var(--accent);
    font-weight: 700; font-size: .75rem; white-space: nowrap;
    text-decoration: none;
    cursor: pointer;
  }

  .pub-action-btn {
    display: inline-flex; align-items: center; justify-content: center;
    width: 38px; height: 38px; border-radius: 50%;
    border: 1px solid var(--line); color: var(--muted);
    text-decoration: none; transition: all .2s ease;
  }
  .pub-action-btn:hover { background: var(--accent); color: #fff; border-color: var(--accent); }

  /* Empty state */
  .empty-state {
    padding: 48px 32px;
    text-align: center;
    background: var(--glass);
    border: 1px dashed var(--line);
    border-radius: var(--radius-card);
  }
  .empty-state-icon { font-size: 2.5rem; margin-bottom: 14px; }
  .empty-state h3 { font-size: 1.1rem; margin-bottom: 8px; }
  .empty-state p { color: var(--muted); font-size: .92rem; max-width: 42ch; margin: 0 auto; }

  /* Status banners */
  .status-banner { padding: 12px 18px; border-radius: 12px; margin-bottom: 20px; font-size: .9rem; font-weight: 600; }
  .status-banner.success { background: rgba(16,185,129,.15); border: 1px solid rgba(16,185,129,.4); color: #065f46; }
  [data-theme="dark"] .status-banner.success { color: #34d399; }
  .status-banner.error { background: rgba(239,68,68,.15); border: 1px solid rgba(239,68,68,.4); color: #991b1b; }
  [data-theme="dark"] .status-banner.error { color: #f87171; }

  @media (max-width: 640px) {
    .pub-item { grid-template-columns: 1fr; gap: 12px; }
    .pub-cite-badge { width: fit-content; flex-direction: row; gap: 6px; padding: 4px 10px; }
    .pub-action-btn { display: none; }
    .sort-pills { width: 100%; justify-content: center; }
  }
</style>
@endpush

@section('content')
<main id="main" class="wrap page-main">

  <nav class="page-breadcrumb" aria-label="Lokasi halaman">
    <a href="/">Beranda</a> / <span>Publikasi</span>
  </nav>

  <header class="page-intro">
    <p class="eyebrow">Karya &amp; pengetahuan</p>
    <h1>Publikasi Ilmiah &amp; Sitasi</h1>
    <p class="page-lead">Daftar karya ilmiah, prosiding konferensi, dan jurnal nasional/internasional yang terindeks Google Scholar. Data diperbarui otomatis setiap hari.</p>
  </header>

  @if (session('status'))
    <div class="status-banner success" role="alert">{{ session('status') }}</div>
  @endif
  @if (session('error'))
    <div class="status-banner error" role="alert">{{ session('error') }}</div>
  @endif

  {{-- ── Dashboard ─────────────────────────────── --}}
  <div class="scholar-dashboard">

    {{-- Metrics --}}
    <section class="metrics-grid" aria-label="Statistik sitasi Google Scholar">
      <div class="metric-card">
        <span class="metric-label">Total Sitasi</span>
        <span class="metric-value">{{ $profile?->citations_all ?? 0 }}</span>
        <p class="metric-desc">Semua waktu ({{ $profile?->citations_since ?? 0 }} dalam 5 thn)</p>
      </div>
      <div class="metric-card">
        <span class="metric-label">h-index</span>
        <span class="metric-value">{{ $profile?->h_index_all ?? 0 }}</span>
        <p class="metric-desc">Produktivitas &amp; dampak sitasi</p>
      </div>
      <div class="metric-card">
        <span class="metric-label">i10-index</span>
        <span class="metric-value">{{ $profile?->i10_index_all ?? 0 }}</span>
        <p class="metric-desc">Artikel dengan ≥10 sitasi</p>
      </div>
      <div class="metric-card">
        <span class="metric-label">Total Artikel</span>
        <span class="metric-value">{{ $totalPublications }}</span>
        <p class="metric-desc">Terindeks di Google Scholar</p>
      </div>
    </section>

    {{-- Citation Trend Histogram --}}
    @if ($profile && !empty($profile->citation_history))
      @php
        $history  = $profile->citation_history;
        $maxCount = max(array_values($history) ?: [1]);
      @endphp
      <section class="trend-panel" aria-label="Tren sitasi per tahun">
        <div class="trend-header">
          <h2 class="trend-title">Grafik Pertumbuhan Sitasi per Tahun</h2>
          <span class="metric-desc">Sumber: Google Scholar</span>
        </div>
        <div class="trend-bars">
          @foreach ($history as $yr => $cnt)
            @php $pct = $maxCount > 0 ? max(8, round(($cnt / $maxCount) * 100)) : 8; @endphp
            <div class="trend-col">
              <span class="trend-count">{{ $cnt }}</span>
              <div class="trend-bar" style="height:{{ $pct }}%" title="{{ $cnt }} sitasi — {{ $yr }}"></div>
              <span class="trend-year">{{ $yr }}</span>
            </div>
          @endforeach
        </div>
      </section>
    @endif

    {{-- Sync Status --}}
    <section class="sync-bar">
      <div class="sync-info">
        <span class="sync-status-dot" title="Sinkronisasi otomatis aktif"></span>
        @if ($profile && $profile->last_synced_at)
          Diperbarui: <strong>{{ $profile->last_synced_at->translatedFormat('d F Y, H:i') }} WIB</strong>
          &nbsp;·&nbsp; {{ $profile->last_synced_at->diffForHumans() }}
        @else
          Menunggu sinkronisasi pertama
        @endif
      </div>
      <form action="{{ route('publications.sync') }}" method="POST" style="margin:0">
        @csrf
        <button type="submit" class="btn-sync" title="Ambil data terbaru dari Google Scholar">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M21.5 2v6h-6M21.34 15.57a10 10 0 1 1-.57-8.38l5.67-5.67"/>
          </svg>
          Sinkronkan Sekarang
        </button>
      </form>
    </section>

    {{-- Academic Profile Links --}}
    <section class="content-panel" aria-labelledby="academic-profiles-title">
      <h2 id="academic-profiles-title">Profil Akademik</h2>
      <p>Akses profil peneliti resmi pada pangkalan data ilmiah:</p>
      <div class="profile-shortcuts">
        <a href="https://scholar.google.com/citations?hl=id&user=euC8dCYAAAAJ" target="_blank" rel="noopener noreferrer">Google Scholar</a>
        <a href="https://sinta.kemdiktisaintek.go.id/authors/profile/6856149/" target="_blank" rel="noopener noreferrer">SINTA</a>
        <a href="https://www.scopus.com/authid/detail.uri?authorId=57223431544" target="_blank" rel="noopener noreferrer">Scopus</a>
        <a href="https://orcid.org/0009-0005-0441-6681" target="_blank" rel="noopener noreferrer">ORCID</a>
      </div>
    </section>

  </div>{{-- /.scholar-dashboard --}}

  {{-- ── Filter & Search Section ───────────────── --}}
  <section class="filter-section" id="publications-section" aria-label="Cari dan filter publikasi">

    <div class="filter-header">
      <h2>
        Daftar Publikasi
        <span id="pubs-counter" style="font-weight:400; font-size:.85em; color:var(--muted);">({{ $totalFiltered }}
          @if ($totalFiltered !== $totalPublications) dari {{ $totalPublications }} @endif
          artikel)</span>
      </h2>
      <div class="sort-pills" role="group" aria-label="Urutan tampilan">
        <a href="{{ route('publications.index', array_filter(['sort' => 'year',      'q' => $search, 'year' => $year])) }}"
           data-sort="year"
           class="sort-pill {{ $sort !== 'citations' ? 'active' : '' }}">Tahun Terbaru</a>
        <a href="{{ route('publications.index', array_filter(['sort' => 'citations', 'q' => $search, 'year' => $year])) }}"
           data-sort="citations"
           class="sort-pill {{ $sort === 'citations' ? 'active' : '' }}">Sitasi Terbanyak</a>
      </div>
    </div>

    {{-- Search Box --}}
    <form id="pubs-search-form" method="GET" action="{{ route('publications.index') }}" role="search" aria-label="Cari publikasi">
      @if ($sort !== 'year') <input type="hidden" name="sort" value="{{ $sort }}"> @endif
      @if ($year !== '')     <input type="hidden" name="year" value="{{ $year }}"> @endif

      <div class="search-row">
        <div class="search-wrap">
          <span class="search-icon" aria-hidden="true">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
          </span>
          <input
            type="search"
            name="q"
            id="pubs-search-input"
            class="search-input"
            value="{{ $search }}"
            placeholder="Cari judul, penulis, atau nama jurnal…"
            aria-label="Kata kunci pencarian"
            autocomplete="off"
          >
          <button type="button" id="btn-clear-search" class="btn-search-clear" title="Hapus pencarian" aria-label="Hapus pencarian" style="{{ $search !== '' ? '' : 'display:none;' }}">
            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
              <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
            </svg>
          </button>
        </div>
        <button type="submit" class="btn-apply-search">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
          </svg>
          Cari
        </button>
      </div>
    </form>

    {{-- Year Filter Pills --}}
    @if ($availableYears->isNotEmpty())
      <div class="year-filter" role="group" aria-label="Filter berdasarkan tahun">
        <span class="year-filter-label">Tahun:</span>
        <a href="{{ route('publications.index', array_filter(['sort' => $sort, 'q' => $search])) }}"
           data-year=""
           class="year-pill {{ $year === '' ? 'active' : '' }}">
          Semua
        </a>
        @foreach ($availableYears as $y)
          <a href="{{ route('publications.index', array_filter(['sort' => $sort, 'q' => $search, 'year' => $y])) }}"
             data-year="{{ $y }}"
             class="year-pill {{ $year === $y ? 'active' : '' }}">
            {{ $y }}
          </a>
        @endforeach
      </div>
    @endif

    {{-- Active filter summary --}}
    <div id="filter-summary-box" class="filter-summary" style="{{ ($search !== '' || $year !== '') ? '' : 'display:none;' }}">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
        <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/>
      </svg>
      <span id="filter-summary-text">
        Filter aktif:
        @if ($search !== '') <strong>&ldquo;{{ $search }}&rdquo;</strong> @endif
        @if ($year !== '') Tahun <strong>{{ $year }}</strong> @endif
        &mdash; menampilkan <strong>{{ $totalFiltered }}</strong> hasil
      </span>
      <a href="{{ route('publications.index', ['sort' => $sort]) }}" id="btn-clear-all-filters" class="filter-summary-clear">× Hapus semua filter</a>
    </div>

  </section>

  {{-- ── Publications List ────────────────────── --}}
  <div id="empty-state-box" class="empty-state" style="{{ $publications->isEmpty() ? '' : 'display:none;' }}">
    <div class="empty-state-icon">🔍</div>
    <h3>Tidak ada publikasi yang cocok</h3>
    <p>Coba ubah kata kunci atau pilih tahun yang berbeda.</p>
  </div>

  @if ($publications->isNotEmpty())
    <div class="pubs-list" id="publications-container">
      @foreach ($publications as $pub)
        @php
          $displayTitle   = $pub->title;
          $displayAuthors = e($pub->authors ?? '');

          if ($search !== '') {
            $esc = preg_quote(e($search), '/');
            $displayTitle   = preg_replace('/('.$esc.')/iu', '<mark>$1</mark>', e($pub->title));
            $displayAuthors = preg_replace('/('.$esc.')/iu', '<mark>$1</mark>', $displayAuthors);
          } else {
            $displayTitle = e($pub->title);
          }

          // Bold author's own name
          $displayAuthors = preg_replace(
            '/\b(D Husen|Dede Husen)\b/i',
            '<strong>$1</strong>',
            $displayAuthors
          );
        @endphp

        <article class="pub-item"
          data-title="{{ strtolower($pub->title) }}"
          data-authors="{{ strtolower($pub->authors ?? '') }}"
          data-venue="{{ strtolower($pub->venue ?? '') }}"
          data-year="{{ $pub->year ?? '' }}"
          data-citations="{{ (int) $pub->citations }}">

          <div class="pub-cite-badge" title="{{ $pub->citations }} sitasi di Google Scholar">
            <span class="pub-cite-num">{{ $pub->citations }}</span>
            <span class="pub-cite-label">Sitasi</span>
          </div>

          <div class="pub-content">
            <h3 class="pub-title" data-raw-title="{{ e($pub->title) }}">
              @if ($pub->scholar_citation_url)
                <a href="{{ $pub->scholar_citation_url }}" target="_blank" rel="noopener noreferrer">
                  {!! $displayTitle !!}
                </a>
              @else
                {!! $displayTitle !!}
              @endif
            </h3>

            @if ($pub->authors)
              <p class="pub-authors" data-raw-authors="{{ e($pub->authors) }}">{!! $displayAuthors !!}</p>
            @endif

            <div class="pub-meta">
              @if ($pub->venue)
                <span class="pub-venue">{{ $pub->venue }}</span>
              @endif
              @if ($pub->year)
                <a href="{{ route('publications.index', array_filter(['sort' => $sort, 'q' => $search, 'year' => $pub->year])) }}"
                   data-filter-year="{{ $pub->year }}"
                   class="pub-year-badge" title="Filter tahun {{ $pub->year }}">
                  {{ $pub->year }}
                </a>
              @endif
            </div>
          </div>

          @if ($pub->scholar_citation_url)
            <a href="{{ $pub->scholar_citation_url }}" target="_blank" rel="noopener noreferrer"
               class="pub-action-btn" title="Buka di Google Scholar"
               aria-label="Buka '{{ $pub->title }}' di Google Scholar">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/>
                <polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/>
              </svg>
            </a>
          @endif
        </article>
      @endforeach
    </div>
  @endif

  {{-- ── Related Section ──────────────────────── --}}
  <section class="related-section" aria-labelledby="related-title">
    <h2 id="related-title">Jelajahi bagian lain</h2>
    <div class="related-grid">
      <a class="related-card" href="/research"><strong>Penelitian</strong><span>Hasil dan proyek penelitian</span></a>
      <a class="related-card" href="/articles"><strong>Artikel &amp; blog</strong><span>Catatan akademik</span></a>
      <a class="related-card" href="/portfolio"><strong>Portofolio</strong><span>Karya terapan</span></a>
    </div>
  </section>

</main>
@endsection

@push('scripts')
<script>
(() => {
  const container = document.getElementById('publications-container');
  if (!container) return;

  const searchInput = document.getElementById('pubs-search-input');
  const clearBtn = document.getElementById('btn-clear-search');
  const searchForm = document.getElementById('pubs-search-form');
  const yearPills = document.querySelectorAll('.year-pill');
  const sortPills = document.querySelectorAll('.sort-pill');
  const summaryBox = document.getElementById('filter-summary-box');
  const summaryText = document.getElementById('filter-summary-text');
  const clearAllBtn = document.getElementById('btn-clear-all-filters');
  const emptyBox = document.getElementById('empty-state-box');
  const counterEl = document.getElementById('pubs-counter');
  const pubItems = Array.from(container.querySelectorAll('.pub-item'));

  const totalAll = {{ (int) $totalPublications }};
  const isServerSubset = pubItems.length < totalAll;

  let state = {
    q: searchInput ? searchInput.value.trim().toLowerCase() : '',
    year: '{{ $year }}',
    sort: '{{ $sort }}'
  };

  function escapeRegExp(string) {
    return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
  }

  function highlight(text, query) {
    if (!query) return text;
    const regex = new RegExp('(' + escapeRegExp(query) + ')', 'gi');
    return text.replace(regex, '<mark>$1</mark>');
  }

  function formatAuthors(rawAuthors, query) {
    let out = highlight(rawAuthors, query);
    out = out.replace(/\b(D Husen|Dede Husen)\b/gi, '<strong>$1</strong>');
    return out;
  }

  function updateUrl() {
    const params = new URLSearchParams();
    if (state.sort && state.sort !== 'year') params.set('sort', state.sort);
    if (state.year) params.set('year', state.year);
    if (state.q) params.set('q', state.q);
    const qs = params.toString();
    const newUrl = window.location.pathname + (qs ? '?' + qs : '');
    window.history.replaceState({}, '', newUrl);
  }

  function render() {
    let visibleCount = 0;
    const query = state.q;
    const year = state.year;
    const sort = state.sort;

    // Filter items
    pubItems.forEach(item => {
      const title = item.dataset.title || '';
      const authors = item.dataset.authors || '';
      const venue = item.dataset.venue || '';
      const itemYear = item.dataset.year || '';

      const matchQ = !query || title.includes(query) || authors.includes(query) || venue.includes(query);
      const matchYear = !year || itemYear === year;

      if (matchQ && matchYear) {
        item.style.display = 'grid';
        visibleCount++;

        // Live highlight
        const titleEl = item.querySelector('.pub-title');
        const rawTitle = titleEl ? titleEl.dataset.rawTitle : '';
        const titleLink = titleEl ? titleEl.querySelector('a') : null;
        if (titleLink && rawTitle) {
          titleLink.innerHTML = highlight(rawTitle, query);
        } else if (titleEl && rawTitle) {
          titleEl.innerHTML = highlight(rawTitle, query);
        }

        const authorsEl = item.querySelector('.pub-authors');
        const rawAuthors = authorsEl ? authorsEl.dataset.rawAuthors : '';
        if (authorsEl && rawAuthors) {
          authorsEl.innerHTML = formatAuthors(rawAuthors, query);
        }
      } else {
        item.style.display = 'none';
      }
    });

    // Sort visible items in DOM
    const sorted = pubItems.slice().sort((a, b) => {
      if (sort === 'citations') {
        const citeDiff = (parseInt(b.dataset.citations, 10) || 0) - (parseInt(a.dataset.citations, 10) || 0);
        if (citeDiff !== 0) return citeDiff;
        return (parseInt(b.dataset.year, 10) || 0) - (parseInt(a.dataset.year, 10) || 0);
      } else {
        const yearDiff = (parseInt(b.dataset.year, 10) || 0) - (parseInt(a.dataset.year, 10) || 0);
        if (yearDiff !== 0) return yearDiff;
        return (parseInt(b.dataset.citations, 10) || 0) - (parseInt(a.dataset.citations, 10) || 0);
      }
    });

    sorted.forEach(el => container.appendChild(el));

    // Update Counter
    if (counterEl) {
      if (visibleCount !== totalAll) {
        counterEl.textContent = `(${visibleCount} dari ${totalAll} artikel)`;
      } else {
        counterEl.textContent = `(${totalAll} artikel)`;
      }
    }

    // Toggle Empty State
    if (emptyBox) {
      emptyBox.style.display = visibleCount === 0 ? 'block' : 'none';
    }

    // Toggle Clear button
    if (clearBtn) {
      clearBtn.style.display = query ? 'flex' : 'none';
    }

    // Update Year Pills active state
    yearPills.forEach(pill => {
      const pYear = pill.dataset.year || '';
      pill.classList.toggle('active', pYear === year);
    });

    // Update Sort Pills active state
    sortPills.forEach(pill => {
      const pSort = pill.dataset.sort || 'year';
      pill.classList.toggle('active', pSort === sort);
    });

    // Update Summary Box
    if (summaryBox && summaryText) {
      if (query || year) {
        let parts = [];
        if (query) parts.push(`&ldquo;${query}&rdquo;`);
        if (year) parts.push(`Tahun <strong>${year}</strong>`);
        summaryText.innerHTML = `Filter aktif: ${parts.join(' &amp; ')} &mdash; menampilkan <strong>${visibleCount}</strong> hasil`;
        summaryBox.style.display = 'flex';
      } else {
        summaryBox.style.display = 'none';
      }
    }

    updateUrl();
  }

  // Event: Live Search as typing
  if (searchInput) {
    searchInput.addEventListener('input', () => {
      state.q = searchInput.value.trim().toLowerCase();
      render();
    });
  }

  // Prevent form reload on enter
  if (searchForm) {
    searchForm.addEventListener('submit', (e) => {
      e.preventDefault();
      if (searchInput) {
        state.q = searchInput.value.trim().toLowerCase();
        render();
      }
    });
  }

  // Event: Clear Search
  if (clearBtn) {
    clearBtn.addEventListener('click', (e) => {
      e.preventDefault();
      if (searchInput) searchInput.value = '';
      state.q = '';
      render();
      if (searchInput) searchInput.focus();
    });
  }

  // Event: Year Pill Click
  yearPills.forEach(pill => {
    pill.addEventListener('click', (e) => {
      const targetYear = pill.dataset.year || '';

      // If server only gave a subset and user wants another year or all, reload
      if (isServerSubset && targetYear === '') {
        return; // allow normal link navigation
      }

      e.preventDefault();
      state.year = targetYear;
      render();
    });
  });

  // Event: Click Year Badge inside cards
  container.addEventListener('click', (e) => {
    const badge = e.target.closest('[data-filter-year]');
    if (!badge) return;

    const clickedYear = badge.dataset.filterYear;
    if (isServerSubset && clickedYear !== state.year) {
      return; // allow link navigation
    }

    e.preventDefault();
    state.year = clickedYear;
    render();
  });

  // Event: Sort Pill Click
  sortPills.forEach(pill => {
    pill.addEventListener('click', (e) => {
      e.preventDefault();
      state.sort = pill.dataset.sort || 'year';
      render();
    });
  });

  // Event: Clear All Filters
  if (clearAllBtn) {
    clearAllBtn.addEventListener('click', (e) => {
      if (isServerSubset) {
        return; // allow link navigation to reset subset
      }
      e.preventDefault();
      state.q = '';
      state.year = '';
      if (searchInput) searchInput.value = '';
      render();
    });
  }

})();
</script>
@endpush
