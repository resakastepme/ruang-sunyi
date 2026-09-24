@php
    $onLinimasa = request()->routeIs('linimasa.index');
    $onTentang = request()->routeIs('tentang.index');
@endphp

<nav class="navbar navbar-expand-lg sticky-top border-bottom"
     style="background-color: rgba(15, 19, 28, 0.88); backdrop-filter: blur(14px); border-color: rgba(255, 255, 255, 0.08) !important;">
    <div class="container py-1">
        <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('linimasa.index') }}">
            <img src="https://lh3.googleusercontent.com/aida/AEtjO1UGsqdxvU0WQSnPOcKdMkeQFNLOxTKPCh-H1ucVh9OGfF22NPTcuxU-KwZZTu4JCj_y_9Kczildmy5WH21VKhUfoZcXlVSrR1cIEfvmWcgXs5cNHkt1r6IvViBlFp1Y58s4B6dQhMxK7YgBzLTeaJqbnuOvrL3XZ2pY_niHl3H4B60EQY6w8nWigNwQefYBOZekiY--AS8SnX0_Wkvs9gyO63EMB8wYQ9I3BkqgGJMoiQGVHcv9jTK7QoqQ"
                 alt="Ruang Sunyi Logo" class="rounded-2" width="34" height="34">
            <div class="d-flex flex-column">
                <span class="fw-bold lh-1 text-light" style="letter-spacing: -0.02em;">Ruang Sunyi</span>
                <span class="text-uppercase text-muted" style="font-size: 0.65rem; letter-spacing: 0.15em;">Nocturne Notes</span>
            </div>
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarContent" aria-controls="navbarContent"
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="bi bi-list text-light fs-4"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0 bg-dark-subtle rounded-pill p-1 px-2 border border-secondary border-opacity-10">
                <li class="nav-item">
                    <a class="nav-link rounded-pill px-3 py-1 {{ $onLinimasa ? 'active fw-medium text-light bg-secondary bg-opacity-25' : 'text-secondary' }}"
                       @if ($onLinimasa) aria-current="page" @endif
                       href="{{ route('linimasa.index') }}">Linimasa Publik</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link rounded-pill px-3 py-1 {{ $onTentang ? 'active fw-medium text-light bg-secondary bg-opacity-25' : 'text-secondary' }}"
                       @if ($onTentang) aria-current="page" @endif
                       href="{{ route('tentang.index') }}">Tentang Saya</a>
                </li>
            </ul>

            <div class="d-flex align-items-center gap-3">
                <a class="btn btn-sm btn-outline-secondary rounded-pill px-3 d-inline-flex align-items-center gap-2 border-opacity-25 text-light bg-surface-card" href="#">
                    <span class="spinner-grow spinner-grow-sm text-info" role="status" style="width: 7px; height: 7px;"></span>
                    <span style="font-size: 0.8rem;">Admin Panel</span>
                </a>
                <img src="https://lh3.googleusercontent.com/aida/AEtjO1WFvF7Iq6ZoyAsINeCigTQed_XObjbC-yV7L5hg8CJknfK-ZsqNV0QDBXsRZ2bVTQuBUuRbPtkI0czTvDAQ0MyBz2aIspqBYU12KcMDzt1iLfs8nKHG7MuI2Q5aXI670nXvSQCMIsUgh575RVamDeYyMzODedg3i61x8SpGhrIl4SfJFdh6sQaW0CIaFKAjBX3YdwMsUWQSxCm5BIRCnZqy1cl-hkWPN_GFZXQyTHByrCcuNP_dwYyJ04U"
                     alt="Resa Komara Akbari" class="rounded-circle object-fit-cover border border-secondary border-opacity-25" width="36" height="36">
            </div>
        </div>
    </div>
</nav>
