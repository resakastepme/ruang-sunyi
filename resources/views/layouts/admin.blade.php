<!DOCTYPE html>
<html data-bs-theme="dark" lang="id">
<head>
    @include('partials.admin-head')
</head>
<body class="d-flex flex-column min-vh-100">
    @include('partials.admin-navbar')

    @yield('content')

    @include('partials.admin-footer')

    @include('partials.admin-scripts')
</body>
</html>
