{{-- Widget "Yap to me" — pesan anonim publik (dikirim via AJAX, lihat nocturne.js). --}}
<div class="card bg-surface-card rounded-4 border-0 shadow-sm p-4">
    <h4 class="h6 text-uppercase fw-bold text-light d-flex align-items-center gap-2 mb-2" style="letter-spacing: 0.05em; font-size: 0.8rem;">
        <i class="bi bi-heart text-info"></i> Yap to me
    </h4>
    <p class="text-secondary small mb-3">
        Leave a message anonimously for me without even login:
    </p>
    <div class="d-flex flex-column gap-2">
        <input type="text" maxlength="500"
               class="form-control form-control-sm bg-dark border-secondary border-opacity-25 text-light"
               id="anon-input" placeholder="Write one/two words or greatings..">
        <button type="button" data-yap-url="{{ route('yap.store') }}"
                class="btn btn-sm btn-primary rounded-3 d-flex align-items-center justify-content-center gap-2 fw-medium"
                id="send-salam-btn" style="background-color: #8083ff; border-color: #8083ff;">
            <i class="bi bi-send-fill"></i> Sent Message
        </button>
        <div class="d-none text-center py-2 text-info small" id="salam-feedback">
            ✨ Your Yap has been sent to the writer.
        </div>
    </div>
</div>
