{{--
    Ruang komentar yang dapat dipakai ulang. Komentar tersimpan di tabel
    `comments` (lihat App\Models\Comment); pengiriman baru lewat AJAX ke
    route comments.store, ditangani public/js/nocturne.js dengan delegasi +
    traversal relatif ke .comment-section terdekat (aman untuk banyak instance).

    Param:
      - $scope    : penanda unik instance ('note-'.$note->id atau 'special').
      - $comments : koleksi App\Models\Comment (opsional; default kosong).
--}}
@php($scope = $scope ?? 'default')
@php($comments = $comments ?? collect())
@php($count = $comments->count())

<div class="comment-section" data-scope="{{ $scope }}" id="comments-{{ $scope }}">
    <h3 class="h6 text-uppercase fw-bold text-light d-flex align-items-center gap-2 mb-4"
        style="letter-spacing: 0.05em; font-size: 0.8rem;">
        <i class="bi bi-chat-square-text text-info"></i> Comments
        <span class="badge badge-soft-secondary rounded-pill ms-1 comment-count">{{ $count }}</span>
    </h3>

    {{-- Empty state (sembunyi bila sudah ada komentar) --}}
    <div class="text-center py-4 comment-empty {{ $count > 0 ? 'd-none' : '' }}">
        <div class="comment-empty-art mx-auto mb-3">
            <svg viewBox="0 0 120 120" width="112" height="112" fill="none"
                 xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
                {{-- Gelembung percakapan kosong + bulan sabit (tema nocturne) --}}
                <path d="M32 26 H88 a16 16 0 0 1 16 16 V62 a16 16 0 0 1 -16 16 H52 l-14 14 v-14 H32 a16 16 0 0 1 -16 -16 V42 a16 16 0 0 1 16 -16 Z"
                      stroke="#8083ff" stroke-width="3" stroke-linejoin="round" opacity="0.6"/>
                <path d="M44 52C44 43 51 36 60 36C62 36 64 36.5 66 37.5C59.5 39 55 45 55 52C55 59 59.5 65 66 66.5C64 67.5 62 68 60 68C51 68 44 61 44 52Z"
                      fill="#bdc2ff" opacity="0.85"/>
                <circle cx="76" cy="44" r="2.6" fill="#7bd0ff"/>
                <circle cx="82" cy="57" r="1.8" fill="#8083ff"/>
                <circle cx="72" cy="62" r="1.5" fill="#bdc2ff"/>
            </svg>
        </div>
        <h4 class="h6 text-light mb-1">No comment yet</h4>
        <p class="text-secondary small mb-0">Be the first to leave a trace in the silence.</p>
    </div>

    {{-- Daftar komentar (server-rendered; JS menambah entri baru di atas) --}}
    <ul class="list-unstyled mb-4 flex-column gap-3 comment-list {{ $count > 0 ? 'd-flex' : 'd-none' }}">
        @foreach ($comments as $comment)
            <li class="comment-item">
                <div class="comment-avatar">
                    @if ($comment->is_anonymous)
                        <i class="bi bi-incognito"></i>
                    @else
                        {{ strtoupper(mb_substr($comment->display_name, 0, 1)) }}
                    @endif
                </div>
                <div class="comment-bubble">
                    <div class="d-flex align-items-center justify-content-between gap-2 mb-1">
                        <span class="fw-semibold text-light" style="font-size: 0.9rem;">{{ $comment->display_name }}</span>
                        <small class="text-muted" style="font-size: 0.72rem;">{{ $comment->created_at->diffForHumans() }}</small>
                    </div>
                    <p class="comment-text text-secondary small mb-0">{{ $comment->body }}</p>
                </div>
            </li>
        @endforeach
    </ul>

    {{-- Form komentar (submit via AJAX) --}}
    <form class="comment-form pt-3 border-top border-secondary border-opacity-10"
          data-store-url="{{ route('comments.store') }}" autocomplete="off">
        <div class="row g-2 mb-2">
            <div class="col-sm-5">
                <label class="form-label small text-muted mb-1">Post as</label>
                <select class="form-select form-select-sm bg-dark border-secondary border-opacity-25 text-light comment-identity"
                        aria-label="Post as">
                    <option value="anonymous" selected>🎭 Anonymous</option>
                    <option value="named">✍️ Use a name</option>
                </select>
            </div>
            <div class="col-sm-7 d-none comment-username-wrap">
                <label class="form-label small text-muted mb-1">Your name</label>
                <input type="text" maxlength="40"
                       class="form-control form-control-sm bg-dark border-secondary border-opacity-25 text-light comment-username"
                       aria-label="Your name" placeholder="Type a username..">
            </div>
        </div>
        <div class="mb-2">
            <textarea class="form-control form-control-sm bg-dark border-secondary border-opacity-25 text-light comment-body"
                      rows="3" maxlength="1000" aria-label="Comment"
                      placeholder="Write something kind, or just a whisper.."></textarea>
        </div>
        <div class="small text-danger mb-2 d-none comment-error"></div>
        <div class="d-flex justify-content-end">
            <button type="submit"
                    class="btn btn-sm btn-primary rounded-3 d-flex align-items-center gap-2 fw-medium"
                    style="background-color: #8083ff; border-color: #8083ff;">
                <i class="bi bi-send-fill"></i> Post comment
            </button>
        </div>
    </form>
</div>
