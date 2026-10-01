<footer class="mt-auto py-5 border-top"
        style="background-color: #0a0e16; border-color: rgba(255, 255, 255, 0.08) !important;">
    <div class="container">
        <div class="row gy-4 align-items-center justify-content-between">
            <div class="col-md-7 text-center text-md-start">
                <h5 class="fw-bold text-light mb-1">Nocturne Notes</h5>
                <p class="text-secondary small mb-0">A digital sanctuary for nightly thoughts, brief notes, and fragments of ideas.</p>
            </div>
            <div class="col-md-5 text-center text-md-end">
                <div class="d-flex flex-wrap gap-3 justify-content-center justify-content-md-end small">
                    <a class="text-secondary text-decoration-none hover-light" href="{{ route('privacy.index') }}">Privacy Policy</a>
                    <a class="text-secondary text-decoration-none hover-light" href="{{ route('tos.index') }}">Terms of Service</a>
                </div>
            </div>
        </div>
        <div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-2 pt-4 mt-4 border-top border-secondary border-opacity-10 text-muted small">
            <span class="font-mono-code" style="font-size: 0.8rem;">echo "silence is golden"; // nocturne notes</span>
            <span>&copy; {{ date('Y') }} Nocturne Notes &mdash; {{ $owner?->name ?? 'Nocturne Notes' }}. All reflections preserved.</span>
        </div>
        <div class="text-center text-md-start pt-3 text-muted" style="font-size: 0.78rem;">
            This site uses <a class="text-secondary text-decoration-none hover-light" href="https://www.youtube.com/t/terms" target="_blank" rel="noopener">YouTube API Services</a>.
            Your use is also subject to the <a class="text-secondary text-decoration-none hover-light" href="https://www.youtube.com/t/terms" target="_blank" rel="noopener">YouTube Terms of Service</a>
            and the <a class="text-secondary text-decoration-none hover-light" href="https://policies.google.com/privacy" target="_blank" rel="noopener">Google Privacy Policy</a>.
        </div>
    </div>
</footer>
