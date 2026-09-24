<header class="navbar navbar-expand-lg sticky-top navbar-glass py-2 px-3 px-md-4">
    <div class="container-fluid px-0">
        {{-- Brand & Badge --}}
        <a class="navbar-brand d-flex align-items-center gap-2 me-3 text-decoration-none" href="{{ route('admin.index') }}">
            <div class="rounded-2 bg-primary bg-opacity-25 d-flex align-items-center justify-content-center text-primary" style="width: 34px; height: 34px;">
                <i class="bi bi-moon-stars-fill fs-6"></i>
            </div>
            <div>
                <span class="fw-bold tracking-tight text-light fs-5">Ruang Sunyi</span>
                <span class="badge badge-subtle-primary ms-2 font-mono text-uppercase py-1" style="font-size: 0.68rem;">Admin Panel</span>
            </div>
        </a>

        {{-- Right side controls --}}
        <div class="d-flex align-items-center gap-2 gap-md-3 ms-auto">
            {{-- Quick Action Link to Public Timeline --}}
            <a class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-1.5 px-3 py-1.5" href="{{ route('linimasa.index') }}" target="_blank" rel="noopener" title="Lihat Web Publik">
                <i class="bi bi-eye"></i>
                <span class="d-none d-sm-inline">Lihat Web Publik</span>
                <i class="bi bi-arrow-up-right small text-muted"></i>
            </a>

            <div class="vr d-none d-md-block opacity-25 my-1"></div>

            {{-- Writer Profile Dropdown --}}
            <div class="dropdown">
                <button aria-expanded="false" class="btn btn-link text-decoration-none d-flex align-items-center gap-2 p-1 text-light dropdown-toggle" data-bs-toggle="dropdown" type="button">
                    <div class="position-relative">
                        <img alt="{{ auth()->user()->name }}" class="rounded-circle border border-secondary border-opacity-50" height="36" width="36"
                             src="https://lh3.googleusercontent.com/aida-public/AB6AXuB8IvpWmUduVZFCKVdAtfeKabvwvlwFG2PEOPFN3fRTW1c58Q5K5znPXppPBKVBdPYmGYiBHB15TcEVyJgcNB1nQL1BjLV6Ys43N9e4lHH3jWIfE_ucB6z59oExmZhIDMWF1wcHTZn-yBxOBu0DN3od3sDDRnH1spDSXMuwB1fdOLh0sW-ZYmoq8L53oSHfMkwQecuceFw2R1WkQEa_TRn5V2N6zzU3lGWYmBGmPm7QFJzp7Zq5SEM5Qg">
                        <span class="position-absolute bottom-0 end-0 p-1 bg-success border border-dark rounded-circle" title="Online"></span>
                    </div>
                    <div class="d-none d-lg-flex flex-column text-start lh-sm">
                        <span class="fw-semibold small mb-0">{{ auth()->user()->name }}</span>
                        <div class="d-flex align-items-center gap-1">
                            <span class="status-badge-dot"></span>
                            <span class="text-secondary font-mono" style="font-size: 0.72rem;">@@StepMe • Mode Hening</span>
                        </div>
                    </div>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-lg border-secondary border-opacity-25">
                    <li class="dropdown-header font-mono text-muted small">STATUS: MODE HENING AKTIF</li>
                    <li><a class="dropdown-item d-flex align-items-center gap-2 small" href="#"><i class="bi bi-person"></i> Profil Pengarang</a></li>
                    <li><a class="dropdown-item d-flex align-items-center gap-2 small" href="#"><i class="bi bi-sliders"></i> Pengaturan Jurnal</a></li>
                    <li><a class="dropdown-item d-flex align-items-center gap-2 small" href="#"><i class="bi bi-palette"></i> Tema &amp; Tampilan</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('admin.logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger d-flex align-items-center gap-2 small">
                                <i class="bi bi-box-arrow-right"></i> Keluar Sesi
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>
