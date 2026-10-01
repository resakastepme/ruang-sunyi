@php
    $onLinimasa = request()->routeIs('linimasa.index');
    $onTentang = request()->routeIs('tentang.index');
@endphp

<nav class="navbar navbar-expand-lg sticky-top border-bottom"
     style="background-color: rgba(15, 19, 28, 0.88); backdrop-filter: blur(14px); border-color: rgba(255, 255, 255, 0.08) !important;">
    <div class="container py-1">
        <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('linimasa.index') }}">
            <img src="{{ asset('favico.png') }}"
                 alt="Nocturne Notes Logo" class="rounded-2" width="34" height="34">
            <div class="d-flex flex-column">
                <span class="fw-bold lh-1 text-light" style="letter-spacing: -0.02em;">Nocturne Notes</span>
                <span class="text-muted" style="font-size: 0.65rem; letter-spacing: 0.08em;">by stepme</span>
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
                       href="{{ route('linimasa.index') }}">Public Home</a>
                </li>
                {{-- <li class="nav-item">
                    <a class="nav-link rounded-pill px-3 py-1 {{ $onTentang ? 'active fw-medium text-light bg-secondary bg-opacity-25' : 'text-secondary' }}"
                       @if ($onTentang) aria-current="page" @endif
                       href="{{ route('tentang.index') }}">Tentang Saya</a>
                </li> --}}
            </ul>

            <div class="d-flex align-items-center gap-3">
                {{-- <a class="btn btn-sm btn-outline-secondary rounded-pill px-3 d-inline-flex align-items-center gap-2 border-opacity-25 text-light bg-surface-card" href="#">
                    <span class="spinner-grow spinner-grow-sm text-info" role="status" style="width: 7px; height: 7px;"></span>
                    <span style="font-size: 0.8rem;">Admin Panel</span>
                </a> --}}
                <button type="button"
                        class="btn btn-sm rounded-pill px-3 d-inline-flex align-items-center gap-2"
                        disabled aria-disabled="true" title="Can't login yet"
                        style="background-color: #181c24; border: 1px solid rgba(255, 255, 255, 0.08); color: #908fa0;">
                    <i class="bi bi-lock-fill"></i>
                    <span style="font-size: 0.8rem;">Can't login yet</span>
                </button>
            </div>
        </div>
    </div>
</nav>
