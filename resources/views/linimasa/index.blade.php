@extends('layouts.app')

@section('title', 'Public Home - Nocturne Notes')

@section('content')
<div class="container">
    {{-- Profile Header Banner --}}
    <section class="card bg-surface-card rounded-4 shadow-sm border-0 mb-4 position-relative overflow-hidden">
        {{-- Hiasan bulan (vektor dari screen.html, tanpa latar) — redup di sisi kanan banner, hanya layar lebar --}}
        <svg class="profile-moon-deco d-none d-lg-block" viewBox="0 0 100 100" fill="none"
             xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
            <circle cx="50" cy="50" r="32" stroke="#6366F1" stroke-width="3" stroke-dasharray="4 4" opacity="0.7"/>
            <path d="M38 52C38 43 45 36 54 36C56 36 58 36.5 60 37.5C53.5 39 49 45 49 52C49 59 53.5 65 60 66.5C58 67.5 56 68 54 68C45 68 38 61 38 52Z" fill="#818CF8"/>
            <circle cx="64" cy="40" r="3.5" fill="#38BDF8"/>
        </svg>

        <div class="card-body p-4 p-md-5 position-relative">
            <div class="row align-items-center g-4">
                <div class="col-lg-8 d-flex flex-column flex-sm-row align-items-start gap-4">
                    <div class="position-relative flex-shrink-0">
                        <img src="{{ $owner?->avatar_url }}"
                             alt="{{ $owner?->name }}" class="img-preview rounded-circle object-fit-cover border border-2 border-primary border-opacity-50 shadow" width="120" height="120">
                        {{-- <span class="position-absolute bottom-0 end-0 p-1 bg-info border border-2 border-dark rounded-circle" title="Online late night"></span> --}}
                    </div>
                    <div>
                        <div class="d-flex align-items-center gap-2 flex-wrap mb-1">
                            <h1 class="h3 fw-bold mb-0 text-light">{{ $owner?->name }}</h1>
                            @if ($owner?->username)
                                <span class="badge badge-soft-info rounded-pill d-inline-flex align-items-center gap-1">
                                    <i class="bi bi-patch-check-fill"></i> {{ '@' . $owner->username }}
                                </span>
                            @endif
                            {{-- <span class="badge bg-secondary bg-opacity-25 text-light rounded-pill">Penulis Tunggal</span> --}}
                        </div>
                        @if ($owner?->bio)
                            <p class="text-secondary mb-2" style="font-size: 0.95rem;">
                                {{ $owner->bio }}
                            </p>
                        @endif
                        {{-- <div class="d-flex flex-wrap align-items-center gap-2 pt-1">
                            <span class="badge bg-dark border border-secondary border-opacity-25 text-light py-2 px-3 rounded-pill fw-normal">
                                <i class="bi bi-cloud-rain me-1 text-info"></i> Mendengarkan hujan &amp; merevisi naskah
                            </span>
                            <span class="badge badge-soft-secondary py-2 px-3 rounded-pill fw-normal">
                                🌙 Reflektif
                            </span>
                        </div> --}}
                    </div>
                </div>
                <div class="col-lg-4 border-start-lg border-secondary border-opacity-10">
                    {{-- <div class="d-flex justify-content-around text-center py-2">
                        <div class="px-2">
                            <div class="h4 fw-bold mb-0 text-light">148</div>
                            <small class="text-uppercase text-muted fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.08em;">Catatan</small>
                        </div>
                        <div class="vr bg-secondary opacity-25"></div>
                        <div class="px-2">
                            <div class="h4 fw-bold mb-0" style="color: #c0c1ff !important;">1.2k</div>
                            <small class="text-uppercase text-muted fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.08em;">Pembaca</small>
                        </div>
                        <div class="vr bg-secondary opacity-25"></div>
                        <div class="px-2">
                            <div class="h4 fw-bold mb-0 text-info">23:40</div>
                            <small class="text-uppercase text-muted fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.08em;">Waktu Aktif</small>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </section>

    {{-- Category Filter Pills (bersumber dari Note::CATEGORIES, filter server-side) --}}
    <div class="d-flex gap-2 overflow-x-auto pb-2 mb-4 scrollbar-none" id="filter-bar">
        <a href="{{ route('linimasa.index') }}"
           class="btn btn-pill-filter text-nowrap {{ $activeCategory === null ? 'active' : '' }}">Every Dump</a>
        @foreach ($categories as $key => $label)
            <a href="{{ route('linimasa.index', ['category' => $key]) }}"
               class="btn btn-pill-filter text-nowrap {{ $activeCategory === $key ? 'active' : '' }}">{{ $label }}</a>
        @endforeach
    </div>

    {{-- Main Layout Grid --}}
    <div class="row g-4">
        {{-- Feed Column (Col 8) --}}
        <div class="col-lg-8">
            @forelse ($notes as $note)
                @include('linimasa._note-card', ['note' => $note])
            @empty
                <div class="card bg-surface-card rounded-4 border-0 shadow-sm p-5 text-center mb-4">
                    <i class="bi bi-moon-stars text-secondary fs-1 mb-3 d-block"></i>
                    <h2 class="h5 text-light mb-1">
                        {{ $activeCategory ? 'No notes in this category yet' : 'The space is still quiet' }}
                    </h2>
                    <p class="text-secondary small mb-0">
                        {{ $activeCategory
                            ? 'Try another category, or browse every dump.'
                            : 'No public notes have been released yet. Come back after dark.' }}
                    </p>
                    @if ($activeCategory)
                        <div class="mt-3">
                            <a href="{{ route('linimasa.index') }}" class="btn btn-pill-filter active">View Every Dump</a>
                        </div>
                    @endif
                </div>
            @endforelse

            {{-- Pagination --}}
            @if ($notes->hasPages())
                <nav class="d-flex justify-content-center mb-3">
                    {{ $notes->onEachSide(1)->links() }}
                </nav>
            @endif

            {{-- Penanda akhir feed (hanya di halaman terakhir yang berisi) --}}
            @if ($notes->isNotEmpty() && ! $notes->hasMorePages())
                <div class="py-4 text-center">
                    <span class="text-muted text-uppercase fw-semibold" style="font-size: 0.75rem; letter-spacing: 0.15em;">
                        — End of spoils for this week —
                    </span>
                </div>
            @endif
        </div>

        {{-- Sidebar Column (Col 4) --}}
        <div class="col-lg-4">
            <aside class="d-flex flex-column gap-4 sticky-top" style="top: 5rem; z-index: 10;">
                {{-- Widget: About Space --}}
                <div class="card bg-surface-card rounded-4 border-0 shadow-sm p-4">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <img src="{{ $owner?->avatar_url }}"
                             alt="{{ $owner?->name }}" class="img-preview rounded-circle object-fit-cover border border-primary border-opacity-50" width="48" height="48">
                        <div>
                            <h3 class="h6 fw-bold mb-0 text-light">About Nocturne</h3>
                            <small class="text-muted">Self Note</small>
                        </div>
                    </div>
                    <p class="text-secondary small mb-3">
                        {{-- Hanya pemilik ruang ini yang dapat menerbitkan tulisan. Publik dipersilakan membaca, menikmati keheningan, atau sekadar meninggalkan tanda bahwa Anda pernah singgah. --}}
                        Only the owner of this places able to release a notes. All of these are available to read publicly. Enjoy the silence, or maybe leave a trace that you have been visiting.
                    </p>
                    {{-- <div class="p-3 rounded-3 bg-dark-subtle border border-secondary border-opacity-10 d-flex align-items-start gap-2 text-info small">
                        <i class="bi bi-moon-stars mt-1"></i>
                        <span>Rerata jam rilis catatan berkisar antara pukul 22.00 hingga 02.30 WIB.</span>
                    </div> --}}
                </div>

                {{-- Widget: Popular Topics --}}
                {{-- <div class="card bg-surface-card rounded-4 border-0 shadow-sm p-4">
                    <h4 class="h6 text-uppercase fw-bold text-light mb-3" style="letter-spacing: 0.05em; font-size: 0.8rem;">
                        Topik Populer
                    </h4>
                    <div class="d-flex flex-wrap gap-2">
                        <span class="badge bg-dark border border-secondary border-opacity-25 text-secondary rounded-pill px-3 py-2 fw-normal" role="button">#Refleksi (48)</span>
                        <span class="badge bg-dark border border-secondary border-opacity-25 text-secondary rounded-pill px-3 py-2 fw-normal" role="button">#LarutMalam (36)</span>
                        <span class="badge bg-dark border border-secondary border-opacity-25 text-secondary rounded-pill px-3 py-2 fw-normal" role="button">#KopiDanJalan (21)</span>
                        <span class="badge bg-dark border border-secondary border-opacity-25 text-secondary rounded-pill px-3 py-2 fw-normal" role="button">#Buku (19)</span>
                        <span class="badge bg-dark border border-secondary border-opacity-25 text-secondary rounded-pill px-3 py-2 fw-normal" role="button">#Keheningan (14)</span>
                        <span class="badge bg-dark border border-secondary border-opacity-25 text-secondary rounded-pill px-3 py-2 fw-normal" role="button">#CatatanLepas (10)</span>
                    </div>
                </div> --}}

                {{-- Widget: Monthly Archives --}}
                {{-- <div class="card bg-surface-card rounded-4 border-0 shadow-sm p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h4 class="h6 text-uppercase fw-bold text-light mb-0" style="letter-spacing: 0.05em; font-size: 0.8rem;">
                            Arsip Bulan Ini
                        </h4>
                        <span class="badge badge-soft-info rounded-pill">Maret 2025</span>
                    </div>
                    <ul class="list-unstyled mb-0 d-flex flex-column gap-2 small">
                        <li class="d-flex justify-content-between align-items-center py-2 border-bottom border-secondary border-opacity-10 text-secondary" role="button">
                            <span>Minggu ke-2 (Saat Ini)</span>
                            <span class="font-mono-code fw-medium" style="color: #c0c1ff !important;">6 catatan</span>
                        </li>
                        <li class="d-flex justify-content-between align-items-center py-2 border-bottom border-secondary border-opacity-10 text-secondary" role="button">
                            <span>Minggu ke-1</span>
                            <span class="font-mono-code text-muted">12 catatan</span>
                        </li>
                        <li class="d-flex justify-content-between align-items-center py-2 text-secondary" role="button">
                            <span>Februari 2025</span>
                            <span class="font-mono-code text-muted">38 catatan</span>
                        </li>
                    </ul>
                </div> --}}

                {{-- Widget: Yap to me (anonim) --}}
                @include('partials._yap-widget')
            </aside>
        </div>
    </div>
</div>
@endsection
