<footer class="mt-auto py-5 border-top"
        style="background-color: #0a0e16; border-color: rgba(255, 255, 255, 0.08) !important;">
    <div class="container">
        <div class="row gy-4 align-items-center">
            <div class="col-12 text-center text-md-start">
                <h5 class="fw-bold text-light mb-1">Nocturne Notes</h5>
                <p class="text-secondary small mb-0">A digital sanctuary for nightly thoughts, brief notes, and fragments of ideas.</p>
            </div>
        </div>
        <div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-2 pt-4 mt-4 border-top border-secondary border-opacity-10 text-muted small">
            <span class="font-mono-code" style="font-size: 0.8rem;">echo "silence is golden"; // nocturne notes</span>
            <span>&copy; {{ date('Y') }} Nocturne Notes &mdash; {{ $owner?->name ?? 'Nocturne Notes' }}. All reflections preserved.</span>
        </div>
    </div>
</footer>
