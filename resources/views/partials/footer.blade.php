<footer class="mt-auto py-5 border-top"
        style="background-color: #0a0e16; border-color: rgba(255, 255, 255, 0.08) !important;">
    <div class="container">
        <div class="row gy-4 align-items-center justify-content-between">
            <div class="col-md-6 text-center text-md-start">
                <h5 class="fw-bold text-light mb-1">Ruang Sunyi</h5>
                <p class="text-secondary small mb-0">Suatu suaka digital bagi pikiran malam, catatan ringkas, dan fragmentasi ide.</p>
            </div>
            <div class="col-md-6 text-center text-md-end">
                <div class="d-inline-flex gap-4">
                    <a class="text-secondary text-decoration-none small hover-light" href="{{ route('linimasa.index') }}">Linimasa</a>
                    <a class="text-secondary text-decoration-none small hover-light" href="#">Tentang</a>
                    <a class="text-secondary text-decoration-none small hover-light" href="#">Admin</a>
                </div>
            </div>
        </div>
        <div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-2 pt-4 mt-4 border-top border-secondary border-opacity-10 text-muted small">
            <span class="font-mono-code" style="font-size: 0.8rem;">echo "silence is golden"; // nocturne notes</span>
            <span>&copy; {{ date('Y') }} Ruang Sunyi &mdash; Resa Komara Akbari. Seluruh refleksi terpelihara.</span>
        </div>
    </div>
</footer>
