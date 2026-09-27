@extends('layouts.admin')

@section('title', 'Admin Panel - Writing Space | Ruang Sunyi')

@push('styles')
<style>
    .pagination {
        --bs-pagination-bg: #181c24;
        --bs-pagination-border-color: #262a33;
        --bs-pagination-color: #dfe2ee;
        --bs-pagination-hover-bg: #262a33;
        --bs-pagination-hover-border-color: #2b303d;
        --bs-pagination-hover-color: #fff;
        --bs-pagination-focus-bg: #262a33;
        --bs-pagination-focus-box-shadow: 0 0 0 0.2rem rgba(128, 131, 255, 0.25);
        --bs-pagination-active-bg: #8083ff;
        --bs-pagination-active-border-color: #8083ff;
        --bs-pagination-active-color: #10122e;
        --bs-pagination-disabled-bg: #14171f;
        --bs-pagination-disabled-border-color: #262a33;
        --bs-pagination-disabled-color: #5a5f70;
    }
    .note-content p:last-child { margin-bottom: 0; }
    .note-content :is(h1, h2, h3, h4) { font-size: 1.15rem; font-weight: 600; }
    .note-content pre { background: #0f131c; border: 1px solid #262a33; border-radius: 8px; padding: 0.75rem; overflow: auto; }
    .note-content code { color: #bdc2ff; }
    .note-content blockquote { border-left: 3px solid var(--bs-primary); padding-left: 0.85rem; color: #9499ab; }
</style>
@endpush

@section('content')
<main class="flex-grow-1 py-4">
    <div class="container-fluid px-3 px-md-4">
        {{-- Breadcrumb & Page Title Banner --}}
        <div class="row mb-4 align-items-center">
            <div class="col-12 col-md-8">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1 font-mono small text-secondary">
                        <li class="breadcrumb-item"><a class="text-secondary text-decoration-none" href="{{ route('admin.index') }}">Nocturne Notes</a></li>
                        <li class="breadcrumb-item"><a class="text-secondary text-decoration-none" href="{{ route('admin.index') }}">Admin Panel</a></li>
                        <li aria-current="page" class="breadcrumb-item active text-light">Writing Space</li>
                    </ol>
                </nav>
                <h1 class="h3 fw-bold text-light mb-1">Writing Space &amp; New Note</h1>
                <p class="text-secondary mb-0 small">Good evening, <strong>{{ auth()->user()->name }}</strong> (@@StepMe). Pour out the quiet of the night and document your reflections.</p>
            </div>
            <div class="col-12 col-md-4 mt-3 mt-md-0 text-md-end">
                <span class="badge bg-dark border border-secondary text-secondary px-3 py-2 font-mono small">
                    <i class="bi bi-cloud-check text-success me-1"></i> Local Sync Active
                </span>
            </div>
        </div>

        <div class="row g-4">
            {{-- ================= PRIMARY COLUMN: COMPOSER & CONTENT LIST ================= --}}
            <div class="col-lg-8">
                {{-- COMPOSER CARD --}}
                <div class="card card-custom mb-4 shadow-sm">
                    <div class="card-header bg-transparent border-bottom border-secondary border-opacity-25 py-3 d-flex flex-wrap align-items-center justify-content-between gap-2">
                        <div class="d-flex align-items-center gap-2">
                            <div class="text-primary bg-primary bg-opacity-10 p-1.5 rounded">
                                <i class="bi bi-pen-fill"></i>
                            </div>
                            <span class="fw-semibold text-light small text-uppercase font-mono">Note &amp; Status Editor</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-secondary bg-opacity-25 text-secondary font-mono small">
                                <span id="wordCounter">0</span> words
                            </span>
                            <span class="badge badge-subtle-info font-mono small">Markdown Ready</span>
                        </div>
                    </div>
                    <div class="card-body p-3 p-md-4">
                        @if (session('status_note'))
                            <div class="alert alert-success d-flex align-items-center gap-2 py-2 px-3 small" role="alert">
                                <i class="bi bi-check-circle-fill"></i>
                                <span>{{ session('status_note') }}</span>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('admin.notes.store') }}" enctype="multipart/form-data" novalidate>
                            @csrf

                            {{-- Formatting Toolbar (decorative helpers) --}}
                            <div class="d-flex flex-wrap align-items-center gap-1 mb-3 pb-2 border-bottom border-secondary border-opacity-25">
                                <button class="editor-toolbar-btn" title="Bold (Ctrl+B)" type="button"><i class="bi bi-type-bold"></i></button>
                                <button class="editor-toolbar-btn" title="Italic (Ctrl+I)" type="button"><i class="bi bi-type-italic"></i></button>
                                <button class="editor-toolbar-btn" title="Code Block" type="button"><i class="bi bi-code-slash"></i></button>
                                <button class="editor-toolbar-btn" title="Quote Block" type="button"><i class="bi bi-quote"></i></button>
                                <button class="editor-toolbar-btn" title="Web Link" type="button"><i class="bi bi-link-45deg"></i></button>
                                <span class="badge badge-subtle-info font-mono small ms-auto"><i class="bi bi-markdown me-1"></i>Markdown</span>
                            </div>

                            @include('admin.notes._form')

                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <button class="btn btn-outline-secondary btn-sm px-3" type="submit" name="status" value="draft">
                                    <i class="bi bi-file-earmark-text me-1"></i>Save Draft
                                </button>
                                <button class="btn btn-primary btn-sm px-3 d-flex align-items-center gap-1.5 shadow" type="submit" name="status" value="published">
                                    <span>Publish Note</span>
                                    <i class="bi bi-send-fill"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- POSTS MANAGEMENT --}}
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div>
                        <h2 class="h5 fw-bold text-light mb-0">Manage Journal Notes</h2>
                        <span class="text-secondary small">Archive of statuses, saved drafts, and published notes</span>
                    </div>
                    <form class="d-flex gap-2" method="GET" action="{{ route('admin.index') }}">
                        @if ($tab !== 'all')<input type="hidden" name="tab" value="{{ $tab }}">@endif
                        <div class="input-group input-group-sm" style="max-width: 260px;">
                            <span class="input-group-text bg-dark border-secondary border-opacity-50 text-secondary"><i class="bi bi-search"></i></span>
                            <input class="form-control bg-dark border-secondary border-opacity-50 text-light" placeholder="Search notes..." type="text" name="q" value="{{ $q }}">
                            @if ($q)
                                <a class="btn btn-outline-secondary" href="{{ route('admin.index', $tab !== 'all' ? ['tab' => $tab] : []) }}" title="Clear search"><i class="bi bi-x-lg"></i></a>
                            @endif
                        </div>
                    </form>
                </div>

                {{-- Tabs Filter --}}
                @php
                    $tabs = [
                        'all'       => ['label' => 'All',       'count' => $counts['total']],
                        'published' => ['label' => 'Published', 'count' => $counts['published']],
                        'drafts'    => ['label' => 'Drafts',    'count' => $counts['drafts']],
                        'pinned'    => ['label' => 'Pinned',    'count' => $counts['pinned']],
                    ];
                @endphp
                <ul class="nav nav-pills mb-3 gap-1 font-mono small">
                    @foreach ($tabs as $key => $meta)
                        <li class="nav-item">
                            <a class="nav-link py-1.5 px-3 rounded-pill {{ $tab === $key ? 'active' : 'text-secondary' }}"
                               href="{{ route('admin.index', array_filter(['tab' => $key === 'all' ? null : $key, 'q' => $q])) }}">
                                {{ $meta['label'] }} ({{ $meta['count'] }})
                            </a>
                        </li>
                    @endforeach
                </ul>

                {{-- List of Posts --}}
                <div class="d-flex flex-column gap-3 mb-4">
                    @forelse ($notes as $note)
                        <div class="card card-custom p-3 p-md-4 {{ $note->status === 'draft' ? 'border-warning border-opacity-25' : '' }}">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div class="d-flex flex-wrap align-items-center gap-2">
                                    @if ($note->status === 'draft')
                                        <span class="badge badge-subtle-secondary font-mono"><i class="bi bi-file-earmark-text me-1"></i>Draft</span>
                                    @elseif ($note->visibility === 'public')
                                        <span class="badge badge-subtle-info font-mono"><i class="bi bi-globe2 me-1"></i>Public</span>
                                    @else
                                        <span class="badge badge-subtle-secondary font-mono"><i class="bi bi-lock-fill me-1"></i>Private</span>
                                    @endif
                                    @if ($note->is_pinned)
                                        <span class="badge badge-subtle-primary font-mono"><i class="bi bi-pin-angle-fill me-1"></i>Pinned</span>
                                    @endif
                                    <span class="font-mono text-secondary small">{{ ($note->published_at ?? $note->created_at)->format('d M Y, H:i') }}</span>
                                    <span class="text-secondary">•</span>
                                    <span class="small text-light">{{ $note->category_label }}</span>
                                </div>
                                <div class="d-flex align-items-center gap-1">
                                    <a class="btn-action-icon" href="{{ route('admin.notes.edit', $note) }}" title="Edit Note"><i class="bi bi-pencil"></i></a>
                                    @if ($note->status === 'draft')
                                        <form method="POST" action="{{ route('admin.notes.publish', $note) }}" class="d-inline">
                                            @csrf @method('PATCH')
                                            <button class="btn-action-icon" type="submit" title="Publish Now"><i class="bi bi-upload"></i></button>
                                        </form>
                                    @endif
                                    <form method="POST" action="{{ route('admin.notes.pin', $note) }}" class="d-inline">
                                        @csrf @method('PATCH')
                                        <button class="btn-action-icon" type="submit" title="{{ $note->is_pinned ? 'Unpin' : 'Pin' }}"><i class="bi bi-pin-angle{{ $note->is_pinned ? '-fill' : '' }}"></i></button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.notes.visibility', $note) }}" class="d-inline">
                                        @csrf @method('PATCH')
                                        <button class="btn-action-icon" type="submit" title="{{ $note->visibility === 'public' ? 'Switch to Private' : 'Switch to Public' }}"><i class="bi bi-{{ $note->visibility === 'public' ? 'eye-slash' : 'globe2' }}"></i></button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.notes.destroy', $note) }}" class="d-inline" data-confirm="Delete this note permanently?">
                                        @csrf @method('DELETE')
                                        <button class="btn-action-icon btn-action-danger" type="submit" title="Delete"><i class="bi bi-trash3"></i></button>
                                    </form>
                                </div>
                            </div>

                            <div class="font-editorial fs-5 note-content leading-relaxed mb-3 {{ $note->status === 'draft' ? 'text-secondary' : 'text-light' }}">
                                {!! \Illuminate\Support\Str::markdown($note->content, ['html_input' => 'strip', 'allow_unsafe_links' => false]) !!}
                            </div>

                            @if ($note->image_url)
                                <img src="{{ $note->image_url }}" alt="Note attachment" class="img-fluid rounded border border-secondary border-opacity-25 mb-3" style="max-height: 260px;">
                            @endif

                            <div class="d-flex flex-wrap justify-content-between align-items-center pt-2 border-top border-secondary border-opacity-25 gap-2">
                                <div class="d-flex flex-wrap gap-2 font-mono text-secondary" style="font-size: 0.8rem;">
                                    @forelse ($note->tags ?? [] as $tag)
                                        <span>#{{ $tag }}</span>
                                    @empty
                                        <span class="opacity-50">no tags</span>
                                    @endforelse
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="reaction-pill font-mono">❤️ {{ $note->likes_count }}</span>
                                    <span class="reaction-pill font-mono">☕ {{ $note->coffees_count }}</span>
                                    <span class="reaction-pill font-mono">💬 {{ $note->responses_count }}</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="card card-custom p-5 text-center">
                            <i class="bi bi-moon-stars text-secondary fs-1 mb-3 d-block"></i>
                            <h3 class="h6 text-light mb-1">{{ $q ? 'No notes match your search' : 'No notes yet' }}</h3>
                            <p class="text-secondary small mb-0">
                                {{ $q ? 'Try a different keyword or clear the search.' : 'Write your first reflection in the composer above.' }}
                            </p>
                        </div>
                    @endforelse
                </div>

                {{-- Pagination --}}
                @if ($notes->total() > 0)
                    <nav class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
                        <span class="small font-mono text-secondary">
                            Showing {{ $notes->firstItem() }}&ndash;{{ $notes->lastItem() }} of {{ $notes->total() }} notes
                        </span>
                        {{ $notes->onEachSide(1)->links() }}
                    </nav>
                @endif
            </div>

            {{-- ================= SIDEBAR COLUMN ================= --}}
            <div class="col-lg-4">
                {{-- 1. QUICK STATS PANEL --}}
                <div class="card card-custom mb-4 shadow-sm">
                    <div class="card-header bg-transparent border-bottom border-secondary border-opacity-25 py-3 d-flex align-items-center justify-content-between">
                        <span class="fw-semibold text-light small text-uppercase font-mono">
                            <i class="bi bi-graph-up-arrow me-1.5 text-primary"></i>Quick Stats
                        </span>
                        <span class="badge bg-dark border border-secondary text-secondary font-mono" style="font-size: 0.7rem;">Realtime</span>
                    </div>
                    <div class="card-body p-3">
                        <div class="row g-2 text-center">
                            <div class="col-4">
                                <div class="card-nested p-2.5">
                                    <div class="text-secondary small font-mono">Total Notes</div>
                                    <div class="fs-4 fw-bold text-light mt-1">{{ $counts['total'] }}</div>
                                    <div class="text-success font-mono" style="font-size: 0.7rem;">{{ $counts['published'] }} live</div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="card-nested p-2.5">
                                    <div class="text-secondary small font-mono">Readers</div>
                                    <div class="fs-4 fw-bold text-info mt-1">4.8k</div>
                                    <div class="text-secondary font-mono" style="font-size: 0.7rem;">This Month</div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="card-nested p-2.5">
                                    <div class="text-secondary small font-mono">Active Time</div>
                                    <div class="fs-4 fw-bold text-light mt-1">22:00</div>
                                    <div class="text-primary font-mono" style="font-size: 0.7rem;">Night Owl</div>
                                </div>
                            </div>
                        </div>
                        {{-- Writing Streak --}}
                        <div class="mt-3 p-2 rounded bg-dark border border-secondary border-opacity-25">
                            <div class="d-flex justify-content-between small font-mono mb-1">
                                <span class="text-secondary">Writing Streak</span>
                                <span class="text-primary">12 Day Streak 🔥</span>
                            </div>
                            <div class="progress" style="height: 6px;">
                                <div aria-valuemax="100" aria-valuemin="0" aria-valuenow="80" class="progress-bar bg-primary" role="progressbar" style="width: 80%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 2. BROADCAST SETTINGS --}}
                <div class="card card-custom mb-4 shadow-sm">
                    <div class="card-header bg-transparent border-bottom border-secondary border-opacity-25 py-3">
                        <span class="fw-semibold text-light small text-uppercase font-mono">
                            <i class="bi bi-sliders2 me-1.5 text-warning"></i>Broadcast &amp; Interaction Settings
                        </span>
                    </div>
                    <div class="card-body p-3">
                        <div class="list-group list-group-flush bg-transparent">
                            <div class="list-group-item bg-transparent border-secondary border-opacity-25 px-0 py-2.5 d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="small fw-semibold text-light">Receive Anonymous Letters</div>
                                    <div class="text-secondary small" style="font-size: 0.78rem;">Allow readers to send secret messages</div>
                                </div>
                                <div class="form-check form-switch mb-0">
                                    <input checked class="form-check-input" id="toggleAnonymousMsg" role="switch" type="checkbox">
                                </div>
                            </div>
                            <div class="list-group-item bg-transparent border-secondary border-opacity-25 px-0 py-2.5 d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="small fw-semibold text-light">Show Reaction Metrics</div>
                                    <div class="text-secondary small" style="font-size: 0.78rem;">Display like, coffee, and response counts</div>
                                </div>
                                <div class="form-check form-switch mb-0">
                                    <input checked class="form-check-input" id="toggleReactions" role="switch" type="checkbox">
                                </div>
                            </div>
                            <div class="list-group-item bg-transparent border-0 px-0 py-2.5 d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="small fw-semibold text-light">Automatic Night Mode</div>
                                    <div class="text-secondary small" style="font-size: 0.78rem;">Dim the contrast after 21:00 WIB</div>
                                </div>
                                <div class="form-check form-switch mb-0">
                                    <input checked class="form-check-input" id="toggleNightMode" role="switch" type="checkbox">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 3. INBOX --}}
                <div class="card card-custom mb-4 shadow-sm">
                    <div class="card-header bg-transparent border-bottom border-secondary border-opacity-25 py-3 d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-envelope-heart-fill text-danger"></i>
                            <span class="fw-semibold text-light small text-uppercase font-mono">Readers' Digital Letters</span>
                        </div>
                        <span class="badge bg-danger rounded-pill font-mono" style="font-size: 0.7rem;">2 New</span>
                    </div>
                    <div class="card-body p-3">
                        <div class="d-flex flex-column gap-2.5">
                            <div class="card-nested p-3">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="badge bg-secondary bg-opacity-25 text-light font-mono small">Night Wanderer #92</span>
                                    <span class="text-secondary font-mono" style="font-size: 0.72rem;">1 hour ago</span>
                                </div>
                                <p class="font-editorial fst-italic text-light small mb-2">
                                    "Your writing about the grace of leaving the capital struck me and embraced me all at once as I sit restless in this overtime office. Thank you, Resa."
                                </p>
                                <div class="d-flex justify-content-end gap-1">
                                    <button class="btn btn-outline-secondary btn-sm py-0 px-2 font-mono" style="font-size: 0.72rem;"><i class="bi bi-check2"></i> Mark as Read</button>
                                    <button class="btn btn-outline-primary btn-sm py-0 px-2 font-mono" style="font-size: 0.72rem;"><i class="bi bi-reply-fill"></i> Reply</button>
                                </div>
                            </div>
                            <div class="card-nested p-3">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="badge bg-secondary bg-opacity-25 text-light font-mono small">Dusk &amp; Coffee Lover</span>
                                    <span class="text-secondary font-mono" style="font-size: 0.72rem;">Yesterday, 21:04</span>
                                </div>
                                <p class="font-editorial fst-italic text-light small mb-2">
                                    "The chamomile blend you recommended in last night's status worked wonders for my insomnia. Looking forward to your next archived piece!"
                                </p>
                                <div class="d-flex justify-content-end gap-1">
                                    <button class="btn btn-outline-secondary btn-sm py-0 px-2 font-mono" style="font-size: 0.72rem;"><i class="bi bi-check2"></i> Mark as Read</button>
                                    <button class="btn btn-outline-primary btn-sm py-0 px-2 font-mono" style="font-size: 0.72rem;"><i class="bi bi-reply-fill"></i> Reply</button>
                                </div>
                            </div>
                            <div class="text-center mt-3 pt-2 border-top border-secondary border-opacity-25">
                                <a class="small text-decoration-none text-secondary hover-text-light font-mono" href="#">
                                    Open All Letters Archive (48) <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 4. SYSTEM BACKUP WIDGET --}}
                {{-- <div class="card card-custom shadow-sm">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="small font-mono text-secondary"><i class="bi bi-database-check me-1 text-success"></i>Last Backup</span>
                            <span class="font-mono text-light small">10 min ago</span>
                        </div>
                        <div class="d-grid gap-2">
                            <button class="btn btn-outline-secondary btn-sm font-mono py-1.5" type="button">
                                <i class="bi bi-download me-1"></i>Export Journal (.Markdown)
                            </button>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
$(function () {
    'use strict';
    // Konfirmasi sebelum menghapus catatan.
    $('form[data-confirm]').on('submit', function (e) {
        if (! window.confirm($(this).attr('data-confirm'))) {
            e.preventDefault();
        }
    });
});
</script>
@endpush
