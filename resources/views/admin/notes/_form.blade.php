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
@endpush
