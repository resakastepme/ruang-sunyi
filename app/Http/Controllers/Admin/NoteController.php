<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class NoteController extends Controller
{
    /**
     * Simpan catatan baru dari composer dasbor.
     */
    public function store(Request $request)
    {
        $data = $this->validated($request);
        unset($data['image']); // jangan pernah mass-assign objek UploadedFile

        $data['tags'] = $this->parseTags($request->input('tags'));

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('notes', 'public');
        }

        $data['published_at'] = $data['status'] === 'published' ? now() : null;

        $request->user()->notes()->create($data);

        return redirect()
            ->route('admin.index')
            ->with('status_note', $data['status'] === 'published' ? 'Note published.' : 'Draft saved.');
    }

    /**
     * Tampilkan halaman edit catatan.
     */
    public function edit(Note $note)
    {
        return view('admin.notes.edit', compact('note'));
    }

    /**
     * Perbarui catatan yang ada.
     */
    public function update(Request $request, Note $note)
    {
        $data = $this->validated($request);
        unset($data['image']);

        $data['tags'] = $this->parseTags($request->input('tags'));

        if ($request->hasFile('image')) {
            if ($note->image) {
                Storage::disk('public')->delete($note->image);
            }
            $data['image'] = $request->file('image')->store('notes', 'public');
        }

        // Tetapkan waktu terbit saat berpindah ke published (pertahankan bila sudah ada).
        $data['published_at'] = $data['status'] === 'published'
            ? ($note->published_at ?? now())
            : null;

        $note->update($data);

        return redirect()
            ->route('admin.index')
            ->with('status_note', 'Note updated.');
    }

    /**
     * Hapus catatan beserta berkas gambarnya.
     */
    public function destroy(Note $note)
    {
        if ($note->image) {
            Storage::disk('public')->delete($note->image);
        }

        $note->delete();

        return redirect()
            ->route('admin.index')
            ->with('status_note', 'Note deleted.');
    }

    /**
     * Sematkan / lepas sematan catatan.
     */
    public function togglePin(Note $note)
    {
        $note->update(['is_pinned' => ! $note->is_pinned]);

        return back()->with('status_note', $note->is_pinned ? 'Note pinned.' : 'Note unpinned.');
    }

    /**
     * Ganti visibilitas publik <-> pribadi.
     */
    public function toggleVisibility(Note $note)
    {
        $note->update([
            'visibility' => $note->visibility === 'public' ? 'private' : 'public',
        ]);

        return back()->with('status_note', 'Visibility set to ' . $note->visibility . '.');
    }

    /**
     * Terbitkan draf.
     */
    public function publish(Note $note)
    {
        $note->update([
            'status'       => 'published',
            'published_at' => $note->published_at ?? now(),
        ]);

        return back()->with('status_note', 'Note published.');
    }

    /**
     * Aturan validasi bersama untuk store & update.
     *
     * @return array<string, mixed>
     */
    protected function validated(Request $request): array
    {
        return $request->validate([
            'content'    => ['required', 'string'],
            'category'   => ['required', Rule::in(array_keys(Note::CATEGORIES))],
            'visibility' => ['required', Rule::in(['public', 'private'])],
            'status'     => ['required', Rule::in(['draft', 'published'])],
            'tags'       => ['nullable', 'string', 'max:255'],
            'image'      => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:4096'],
        ], [], [
            'content' => 'note content',
        ]);
    }

    /**
     * Ubah string tag ("#latenight, coffee senja") menjadi array bersih.
     *
     * @return array<int, string>
     */
    protected function parseTags(?string $raw): array
    {
        if (blank($raw)) {
            return [];
        }

        return collect(preg_split('/[,\s]+/', $raw))
            ->map(fn ($tag) => ltrim(trim($tag), '#'))
            ->filter()
            ->unique()
            ->take(10)
            ->values()
            ->all();
    }
}
