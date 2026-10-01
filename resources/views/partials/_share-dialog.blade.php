{{-- Dialog share (dibuka dari tombol .share-btn; membagikan APP_URL). --}}
@php
    $shareUrl  = config('app.url');
    $shareText = 'Nocturne Notes — a quiet place for nightly notes.';
    $enc       = rawurlencode($shareUrl);
    $encText   = rawurlencode($shareText);
@endphp
<div class="share-pop" id="share-pop" aria-hidden="true">
    <div class="share-card">
        <button type="button" class="share-close" id="share-close" aria-label="Close">&times;</button>
        <h3 class="h6 fw-bold text-light mb-1">Share Nocturne Notes</h3>
        <p class="text-secondary small mb-3">Spread the silence.</p>

        <div class="input-group input-group-sm mb-3">
            <input type="text" readonly id="share-url"
                   class="form-control bg-dark border-secondary border-opacity-25 text-light"
                   value="{{ $shareUrl }}">
            <button type="button" class="btn btn-primary" id="share-copy"
                    style="background-color:#8083ff;border-color:#8083ff;">Copy</button>
        </div>

        <div class="d-flex flex-wrap gap-2">
            <a class="btn btn-sm btn-outline-secondary flex-grow-1" target="_blank" rel="noopener"
               href="https://wa.me/?text={{ $encText }}%20{{ $enc }}"><i class="bi bi-whatsapp me-1"></i>WhatsApp</a>
            <a class="btn btn-sm btn-outline-secondary flex-grow-1" target="_blank" rel="noopener"
               href="https://twitter.com/intent/tweet?url={{ $enc }}&text={{ $encText }}"><i class="bi bi-twitter-x me-1"></i>X</a>
            <a class="btn btn-sm btn-outline-secondary flex-grow-1" target="_blank" rel="noopener"
               href="https://t.me/share/url?url={{ $enc }}&text={{ $encText }}"><i class="bi bi-telegram me-1"></i>Telegram</a>
            <a class="btn btn-sm btn-outline-secondary flex-grow-1" target="_blank" rel="noopener"
               href="https://www.facebook.com/sharer/sharer.php?u={{ $enc }}"><i class="bi bi-facebook me-1"></i>Facebook</a>
        </div>

        <div class="d-none text-center text-info small mt-2" id="share-copied">✨ Link copied.</div>
    </div>
</div>
