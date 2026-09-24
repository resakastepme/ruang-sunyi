<!DOCTYPE html>
<html data-bs-theme="dark" lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Ruang Sunyi')</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500&family=Newsreader:ital,opsz,wght@0,6..72,400;0,6..72,500;1,6..72,400&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap">

    {{-- Bootstrap 5.3.3 + Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    {{-- Tema Nocturne --}}
    <link rel="stylesheet" href="{{ asset('css/nocturne.css') }}">

    @stack('styles')
</head>
<body>
    @include('partials.navbar')

    <main class="flex-grow-1 py-5">
        @yield('content')
    </main>

    @include('partials.footer')

    {{-- jQuery lebih dulu, lalu bundle Bootstrap, terakhir logika aplikasi --}}
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/nocturne.js') }}"></script>

    @stack('scripts')
</body>
</html>
