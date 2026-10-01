@extends('layouts.app')

@section('title', 'Special Note - Nocturne Notes')

@section('content')
<div class="container">
    {{-- Tanpa banner profil & pil kategori — hanya kolom konten (catatan + komentar) & sidebar. --}}
    <div class="row g-4">
        {{-- Kolom konten (Col 8) --}}
        <div class="col-lg-8">
            {{-- ====================== Kartu Catatan Khusus ====================== --}}
            <article class="card bg-surface-card rounded-4 border-0 shadow-sm mb-4 position-relative overflow-hidden feed-entry"
                     data-category="special">
                {{-- Catatan disematkan → garis aksen atas --}}
                <div class="pinned-accent-bar"></div>

                <div class="card-body p-4 pt-4">
                    {{-- Meta header --}}
                    <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
                        <div class="d-flex align-items-center gap-2 flex-wrap">
                            <span class="badge badge-soft-primary rounded-pill d-inline-flex align-items-center gap-1">
                                <i class="bi bi-pin-angle-fill"></i> Pinned
                            </span>
                            <span class="badge badge-soft-secondary rounded-pill d-inline-flex align-items-center gap-1">
                                <i class="bi bi-eye-slash"></i> Unlisted
                            </span>
                            <small class="text-muted">{{ $publishedAt->format('F j, Y') }}</small>
                            <small class="text-muted">• {{ $readingTime }} min read</small>
                        </div>
                        <span class="badge bg-transparent text-info font-mono-code">{{ $categoryLabel }}</span>
                    </div>

                    {{-- Isi catatan (hardcoded, dipertahankan baris & paragrafnya) --}}
                    <div class="font-editorial note-markdown text-secondary mb-4">
                        @foreach ($paragraphs as $paragraph)
                            @if (trim($paragraph) === 'I LIKE YOU')
                                <p class="special-note-highlight">{{ trim($paragraph) }}</p>
                            @else
                                <p>{!! nl2br(e($paragraph)) !!}</p>
                            @endif
                        @endforeach
                    </div>

                    {{-- Tag --}}
                    @if (! empty($tags))
                        <div class="d-flex flex-wrap gap-2 mb-3">
                            @foreach ($tags as $tag)
                                <span class="font-mono-code text-secondary" style="font-size: 0.8rem;">#{{ $tag }}</span>
                            @endforeach
                        </div>
                    @endif

                    {{-- Footer: reaksi + aksi (reaksi ditangani nocturne.js, client-side) --}}
                    <div class="d-flex align-items-center justify-content-between pt-3 border-top border-secondary border-opacity-10 flex-wrap gap-2">
                        <div class="d-flex align-items-center gap-2">
                            <button type="button" class="btn btn-reaction d-flex align-items-center gap-1"
                                    data-react="love" data-scope="special" title="Love">
                                <span>❤️</span> <span class="font-mono-code rx-count">{{ $reaction?->love_count ?? 0 }}</span>
                            </button>
                            <button type="button" class="btn btn-reaction d-flex align-items-center gap-1"
                                    data-react="coffee" data-scope="special" title="Coffee">
                                <span>☕</span> <span class="font-mono-code rx-count">{{ $reaction?->coffee_count ?? 0 }}</span>
                            </button>
                            <a href="#comments-special" class="btn btn-reaction d-flex align-items-center gap-1" title="Comments">
                                <span>💭</span> <span class="font-mono-code">{{ $comments->count() }}</span>
                            </a>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <button type="button" class="btn btn-sm btn-outline-secondary rounded-circle border-0 text-muted" title="Not there yet">
                                <i class="bi bi-bookmark fs-6"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary rounded-circle border-0 text-muted share-btn" title="Share">
                                <i class="bi bi-share fs-6"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </article>

            {{-- ====================== Ruang Komentar ====================== --}}
            <section class="card bg-surface-card rounded-4 border-0 shadow-sm">
                <div class="card-body p-4">
                    @include('partials._comment-section', ['scope' => 'special', 'comments' => $comments])
                </div>
            </section>
        </div>

        {{-- Sidebar (Col 4) — About Nocturne & Yap to me tetap ada --}}
        <div class="col-lg-4">
            <aside class="d-flex flex-column gap-4 sticky-top" style="top: 5rem; z-index: 10;">
                {{-- Widget: About Nocturne --}}
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
                        Only the owner of this places able to release a notes. All of these are available to read publicly. Enjoy the silence, or maybe leave a trace that you have been visiting.
                    </p>
                </div>

                {{-- Widget: Yap to me (anonim) --}}
                @include('partials._yap-widget')
            </aside>
        </div>
    </div>
</div>
@endsection
