<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="theme-color" content="#edf3f7">
  <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}?v={{ filemtime(public_path('favicon.svg')) }}">
  <meta name="description" content="@yield('description', 'Profil akademik, karya, publikasi, bahan kuliah, dan kolaborasi Dede Husen, dosen Teknik Informatika Universitas Kuningan.')">
  <title>@yield('title', 'Dede Husen, M.Kom. | Akademik & Rekayasa Perangkat Lunak')</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  @php
    $displayFont = $settings?->font_display ?? 'Space Grotesk';
    $bodyFont = $settings?->font_body ?? 'Plus Jakarta Sans';
    $fontStylesheet = 'https://fonts.googleapis.com/css2?family='.urlencode($displayFont).':wght@400;500;600;700&family='.urlencode($bodyFont).':wght@400;500;600;700;800&display=swap';
  @endphp
  <script>
    (() => {
      try {
        const saved = localStorage.getItem('dedehusen-theme');
        const preferred = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
        document.documentElement.dataset.theme = saved || preferred;
      } catch (_) {
        document.documentElement.dataset.theme = 'light';
      }
    })();
  </script>
  <link rel="stylesheet" href="{{ asset('site.css') }}?v={{ filemtime(public_path('site.css')) }}">
  @if (isset($settings) && $settings)
    <style>
      :root { --display: "{{ $settings->font_display }}", sans-serif; --sans: "{{ $settings->font_body }}", sans-serif; --accent: {{ $settings->color_accent }}; --bg: {{ $settings->color_background }}; --text: {{ $settings->color_text }}; }
      [data-theme="dark"] { --bg: {{ $settings->color_dark_background }}; --text: {{ $settings->color_dark_text }}; --accent: {{ $settings->color_dark_accent }}; }
    </style>
  @endif
  <link href="{{ $fontStylesheet }}" rel="stylesheet" media="print" onload="this.media='all'">
  <noscript><link href="{{ $fontStylesheet }}" rel="stylesheet"></noscript>
  @stack('styles')
</head>
<body>
  @include('partials.site-header')
  @yield('content')
  @include('partials.site-footer')
  <script src="{{ asset('site.js') }}?v={{ filemtime(public_path('site.js')) }}"></script>
  @stack('scripts')
</body>
</html>

