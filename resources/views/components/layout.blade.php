<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Música educativa de programación web</title>
@php
    $artistName = $artistName ?? 'AlgoRitmo Flow';
    $brandTagline = $brandTagline ?? 'Letras didácticas sobre programación web con ritmo';
    $artistUrl = $artistUrl ?? 'https://open.spotify.com/artist/5gkzdmNQ7rGN27mIzJxg4H';
    $primaryColor = $primaryColor ?? '#0ea5e9';
    $message = $message ?? '';
@endphp
  <!-- Open Graph / Social -->
  <meta property="og:title" content="{{ $artistName}} — Música de programación web">
  <meta property="og:description" content="{{ $brandTagline }}">
  <meta property="og:type" content="music.musician">
  <meta property="og:url" content="{{ $artistUrl}}">
    @if(!empty($ogImage))
        <meta property="og:image" content="{{ $ogImage }}">
    @endif
    <meta name="twitter:card" content="summary_large_image">
  <!-- Tailwind (CDN) para estilos rápidos y responsivos -->
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    /* Fuente fallback elegante */
    :root { --brand: {{ $primaryColor}}; }
    body { font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Ubuntu, Cantarell, Noto Sans, Helvetica, Arial, "Apple Color Emoji", "Segoe UI Emoji"; }
  </style>
</head>
<body class="bg-slate-950 text-slate-100">
    <x-partials.nav artist-name="{{$artistName}}" />
    {{ $slot }}
    <x-partials.footer artist-name="{{$artistName }}"/>
</body>
</html>


