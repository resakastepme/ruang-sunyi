{{--
    Satu kartu catatan pada linimasa publik.
    Menerima $note (App\Models\Note) yang sudah published + public.
--}}
@php
    $isPinned    = (bool) $note->is_pinned;
    $publishedAt = $note->published_at ?? $note->created_at;
    $noteTags    = $note->tags ?? [];
@endphp

<article class="card bg-surface-card rounded-4 border-0 shadow-sm mb-4 position-relative overflow-hidden feed-entry"
         data-category="{{ $note->category }}">
    @if ($isPinned)
        <div class="pinned-accent-bar"></div>
    @endif

    <div class="card-body p-4 pt-4">
        {{-- Meta header --}}
        <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
            <div class="d-flex align-items-center gap-2 flex-wrap">
                @if ($isPinned)
                    <span class="badge badge-soft-primary rounded-pill d-inline-flex align-items-center gap-1">
                        <i class="bi bi-pin-angle-fill"></i> Pinned
                    </span>
                @endif
                <small class="text-muted">{{ $publishedAt->format('F j, Y') }}</small>
                <small class="text-muted">• {{ $note->reading_time }} min read</small>
            </div>
            <span class="badge bg-transparent text-info font-mono-code">{{ $note->category_label }}</span>
        </div>

        {{-- Isi catatan (markdown) --}}
        <div class="font-editorial note-markdown text-secondary mb-4">
            {!! \Illuminate\Support\Str::markdown($note->content, ['html_input' => 'strip', 'allow_unsafe_links' => false]) !!}
        </div>

        {{-- Lampiran gambar (opsional) --}}
        @if ($note->image_url)
            <div class="position-relative rounded-3 overflow-hidden mb-4" style="max-height: 380px;">
                <img src="{{ $note->image_url }}" alt="Note attachment"
                     class="w-100 object-fit-cover" style="max-height: 380px;">
            </div>
        @endif

        {{-- Video YouTube tertanam (opsional) --}}
        @if ($note->youtube_video_id)
            <div class="ratio ratio-16x9 rounded-3 overflow-hidden mb-4">
                <iframe src="{{ $note->youtube_embed_url }}" title="Note video"
                        frameborder="0" loading="lazy" allowfullscreen
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"></iframe>
            </div>
        @endif

        {{-- Tag --}}
        @if (! empty($noteTags))
            <div class="d-flex flex-wrap gap-2 mb-3">
                @foreach ($noteTags as $tag)
                    <span class="font-mono-code text-secondary" style="font-size: 0.8rem;">#{{ $tag }}</span>
                @endforeach
            </div>
        @endif

        {{-- Footer: reaksi + aksi --}}
        <div class="d-flex align-items-center justify-content-between pt-3 border-top border-secondary border-opacity-10 flex-wrap gap-2">
            <div class="d-flex align-items-center gap-2">
                <button type="button" class="btn btn-reaction d-flex align-items-center gap-1" title="Loves">
                    <span>❤️</span> <span class="font-mono-code">{{ $note->likes_count }}</span>
                </button>
                <button type="button" class="btn btn-reaction d-flex align-items-center gap-1" title="Coffees">
                    <span>☕</span> <span class="font-mono-code">{{ $note->coffees_count }}</span>
                </button>
                <button type="button" class="btn btn-reaction d-flex align-items-center gap-1" title="Responses">
                    <span>💭</span> <span class="font-mono-code">{{ $note->responses_count }}</span>
                </button>
            </div>
            <div class="d-flex align-items-center gap-2">
                <button type="button" class="btn btn-sm btn-outline-secondary rounded-circle border-0 text-muted" title="Save note">
                    <i class="bi bi-bookmark fs-6"></i>
                </button>
                <button type="button" class="btn btn-sm btn-outline-secondary rounded-circle border-0 text-muted" title="Share">
                    <i class="bi bi-share fs-6"></i>
                </button>
            </div>
        </div>

        {{-- Ruang komentar (client-side, reusable per-catatan) --}}
        <div class="mt-4 pt-4 border-top border-secondary border-opacity-10">
            @include('partials._comment-section', ['scope' => 'note-'.$note->id, 'comments' => $note->comments])
        </div>
    </div>
</article>
