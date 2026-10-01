{{--
    Shared note form fields (create + edit).
    Expects an optional $note for edit prefill. The wrapping <form>, toolbar,
    and submit buttons live in the including view.
--}}
@php
    $editing      = isset($note);
    $noteImageUrl = $editing ? $note->image_url : null;
    $curCategory  = old('category', $note->category ?? 'renungan');
    $curVis       = old('visibility', $note->visibility ?? 'public');
    $curTags      = old('tags', $editing ? implode(', ', $note->tags ?? []) : '');
    $curYoutube   = old('youtube', $editing ? $note->youtube_video_id : '');
@endphp

{{-- Content --}}
<div class="card-nested p-3 mb-2">
    <textarea name="content" id="mainComposerText" rows="5" required
              class="form-control composer-textarea p-0 @error('content') is-invalid @enderror"
              placeholder="Write what you're feeling, experiencing, or reflecting on tonight...">{{ old('content', $note->content ?? '') }}</textarea>
</div>
<div class="form-text text-secondary font-mono mb-3" style="font-size: 0.72rem;">
    <i class="bi bi-markdown me-1"></i>Markdown supported — **bold**, *italic*, `code`, &gt; quote, - lists.
</div>
@error('content')<div class="invalid-feedback d-block small mb-3">{{ $message }}</div>@enderror

{{-- Image attachment (optional) --}}
<div class="mb-3">
    <label for="noteImage" class="form-label font-mono small text-secondary">Image Attachment <span class="text-secondary">(optional)</span></label>
    <div class="d-flex align-items-center gap-3">
        <img id="noteImagePreview" src="{{ $noteImageUrl ?? '' }}" alt="Image preview"
             class="rounded object-fit-cover border border-secondary border-opacity-25 flex-shrink-0 {{ $noteImageUrl ? '' : 'd-none' }}"
             width="86" height="86" style="width: 86px; height: 86px;">
        <div class="flex-grow-1">
            <input type="file" name="image" id="noteImage" accept="image/png,image/jpeg,image/webp"
                   class="form-control form-control-sm bg-dark border-secondary border-opacity-50 text-light @error('image') is-invalid @enderror">
            <div class="form-text text-secondary font-mono" style="font-size: 0.72rem;">
                <i class="bi bi-info-circle me-1"></i>JPG, PNG, or WEBP. Max 4&nbsp;MB.@if ($noteImageUrl) Upload a new file to replace the current image.@endif
            </div>
            @error('image')<div class="invalid-feedback d-block small">{{ $message }}</div>@enderror
        </div>
    </div>
</div>

{{-- Video (YouTube) --}}
<div class="mb-3">
    <label for="noteYoutube" class="form-label font-mono small text-secondary">
        Video <span class="text-secondary">(YouTube — optional)</span>
    </label>
    <input type="text" name="youtube" id="noteYoutube" value="{{ $curYoutube }}" maxlength="255"
           class="form-control bg-dark border-secondary border-opacity-50 text-light @error('youtube') is-invalid @enderror"
           placeholder="Paste a YouTube link or video ID (e.g. https://youtu.be/XXXXXXXXXXX)">
    <div class="form-text text-secondary font-mono" style="font-size: 0.72rem;">
        <i class="bi bi-youtube me-1"></i>Paste a YouTube URL/ID to embed the video on this note. Unlisted links work too.
    </div>
    @error('youtube')<div class="invalid-feedback d-block small">{{ $message }}</div>@enderror

    {{-- Status koneksi YouTube (OAuth) --}}
    <div class="d-flex align-items-center flex-wrap gap-2 mt-2">
        @if ($youtubeConnected ?? false)
            <span class="badge badge-subtle-info font-mono"><i class="bi bi-youtube me-1 text-danger"></i>YouTube connected</span>
            {{-- Tombol biasa (bukan <form> nested, agar tidak merusak form composer) --}}
            <button type="button" id="yt-disconnect" data-url="{{ route('admin.youtube.disconnect') }}"
                    class="btn btn-outline-secondary btn-sm py-0 px-2" style="font-size: 0.72rem;">Disconnect</button>
        @else
            <span class="badge badge-subtle-secondary font-mono"><i class="bi bi-youtube me-1"></i>YouTube not connected</span>
            <a href="{{ route('admin.youtube.connect') }}" target="_blank" rel="noopener"
               class="btn btn-outline-info btn-sm py-0 px-2" style="font-size: 0.72rem;">
                <i class="bi bi-box-arrow-up-right me-1"></i>Connect YouTube
            </a>
            <span class="text-secondary font-mono" style="font-size: 0.7rem;">to enable auto-upload (unlisted)</span>
        @endif
    </div>

    {{-- In-browser recorder + auto-upload --}}
    <div class="card-nested p-3 mt-3" id="videoRecorder"
         data-connected="{{ ($youtubeConnected ?? false) ? '1' : '0' }}"
         data-session-url="{{ route('admin.youtube.upload-session') }}"
         data-chunk-url="{{ route('admin.youtube.upload-chunk') }}">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
            <span class="font-mono small text-light"><i class="bi bi-record-circle me-1 text-danger"></i>Record a clip</span>
            <span class="badge badge-subtle-secondary font-mono" style="font-size: 0.68rem;">camera + mic</span>
        </div>

        <div class="row g-2 mb-2">
            <div class="col-sm-6">
                <select id="recCamera" class="form-select form-select-sm bg-dark border-secondary border-opacity-50 text-light" aria-label="Camera">
                    <option value="">Default camera</option>
                </select>
            </div>
            <div class="col-sm-6">
                <select id="recMic" class="form-select form-select-sm bg-dark border-secondary border-opacity-50 text-light" aria-label="Microphone">
                    <option value="">Default microphone</option>
                </select>
            </div>
        </div>

        <video id="recPreview" autoplay muted playsinline class="w-100 rounded" style="max-height: 260px; background:#000;"></video>

        <div class="d-flex flex-wrap gap-2 mt-2">
            <button type="button" id="recEnable" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-camera-video me-1"></i>Enable camera &amp; mic
            </button>
            <button type="button" id="recStart" class="btn btn-danger btn-sm" disabled>
                <i class="bi bi-record-fill me-1"></i>Record
            </button>
            <button type="button" id="recStop" class="btn btn-outline-light btn-sm" disabled>
                <i class="bi bi-stop-fill me-1"></i>Stop
            </button>
            <a id="recDownload" class="btn btn-outline-info btn-sm d-none" download="nocturne-clip.webm">
                <i class="bi bi-download me-1"></i>Download
            </a>
            <button type="button" id="recUpload" class="btn btn-danger btn-sm d-none">
                <i class="bi bi-youtube me-1"></i>Upload to YouTube
            </button>
        </div>

        <video id="recPlayback" controls class="w-100 rounded mt-2 d-none" style="max-height: 260px; background:#000;"></video>

        {{-- Upload file video yang sudah ada --}}
        <div class="mt-3">
            <label class="form-label font-mono small text-secondary mb-1">Or upload an existing video</label>
            <div class="input-group input-group-sm">
                <input type="file" id="recFile" accept="video/*"
                       class="form-control bg-dark border-secondary border-opacity-50 text-light">
                <button type="button" id="recUploadFile" class="btn btn-outline-danger">
                    <i class="bi bi-youtube me-1"></i>Upload
                </button>
            </div>
        </div>

        <div id="recUploadStatus" class="small mt-2 d-none"></div>
        <div class="form-text text-secondary font-mono mt-2" style="font-size: 0.72rem;">
            <i class="bi bi-info-circle me-1"></i>@if ($youtubeConnected ?? false)Record or pick a video, then <strong>Upload to YouTube</strong> — it uploads as <strong>unlisted</strong> and fills the link above automatically.@else Connect YouTube above to auto-upload. For now you can record &amp; download, then upload manually and paste the link.@endif
        </div>
        <div id="recError" class="small text-danger mt-1 d-none"></div>
    </div>
</div>

{{-- Tags --}}
<div class="mb-3">
    <label for="noteTags" class="form-label font-mono small text-secondary">Tags</label>
    <input type="text" name="tags" id="noteTags" value="{{ $curTags }}" maxlength="255"
           class="form-control bg-dark border-secondary border-opacity-50 text-light @error('tags') is-invalid @enderror"
           placeholder="latenight, coffee, reflection">
    <div class="form-text text-secondary font-mono" style="font-size: 0.72rem;">
        <i class="bi bi-hash"></i>Separate with commas or spaces. Up to 10 tags.
    </div>
    @error('tags')<div class="invalid-feedback d-block small">{{ $message }}</div>@enderror
</div>

{{-- Category & Visibility --}}
<div class="row g-3 align-items-start">
    <div class="col-12 col-md-6">
        <label class="form-label font-mono small text-secondary mb-1" for="categoryPicker">Note Category / Mood</label>
        <select name="category" class="form-select form-select-sm bg-dark border-secondary border-opacity-50 text-light" id="categoryPicker">
            @foreach (\App\Models\Note::CATEGORIES as $key => $label)
                <option value="{{ $key }}" @selected($curCategory === $key)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-12 col-md-6">
        <label class="form-label font-mono small text-secondary mb-1">Accessibility</label>
        <div aria-label="Privacy Toggle" class="btn-group btn-group-sm w-100" role="group">
            <input autocomplete="off" class="btn-check" id="privPublic" name="visibility" value="public" type="radio" @checked($curVis === 'public')>
            <label class="btn btn-outline-secondary" for="privPublic"><i class="bi bi-globe2 me-1"></i>Public</label>
            <input autocomplete="off" class="btn-check" id="privPrivate" name="visibility" value="private" type="radio" @checked($curVis === 'private')>
            <label class="btn btn-outline-secondary" for="privPrivate"><i class="bi bi-lock-fill me-1"></i>Private</label>
        </div>
    </div>
</div>

@push('scripts')
<script>
    (function () {
        var input = document.getElementById('noteImage');
        var preview = document.getElementById('noteImagePreview');
        if (!input || !preview) return;
        input.addEventListener('change', function () {
            var file = this.files && this.files[0];
            if (!file) return;
            preview.src = URL.createObjectURL(file);
            preview.classList.remove('d-none');
        });
    })();
</script>
<script src="{{ asset('js/recorder.js') }}"></script>
@endpush
