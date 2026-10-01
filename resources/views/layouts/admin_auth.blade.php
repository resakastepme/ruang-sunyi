<!DOCTYPE html>
<html data-bs-theme="dark" lang="id">
<head>
    @include('partials.admin-head')
</head>
<body class="d-flex flex-column min-vh-100">
    <main class="flex-grow-1 d-flex align-items-center justify-content-center px-3 py-5">
        @yield('content')
    </main>

    @include('partials.admin-scripts')
</body>
</html>
