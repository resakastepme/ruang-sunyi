<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Note;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Simpan komentar publik (anonim atau bernama) untuk sebuah scope.
     * Scope valid: 'special' atau 'note-{id}' (catatan terbit & publik).
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'scope'       => ['required', 'string', 'max:255'],
            'identity'    => ['required', 'in:anonymous,named'],
            'author_name' => ['nullable', 'string', 'max:40'],
            'body'        => ['required', 'string', 'max:1000'],
        ]);

        // Petakan scope -> note_id bila merujuk catatan nyata, lalu validasi keberadaannya.
        $noteId = null;
        if ($data['scope'] === 'special') {
            // oke, catatan khusus hardcoded.
        } elseif (preg_match('/^note-(\d+)$/', $data['scope'], $m)) {
            $noteId = (int) $m[1];

            $isVisible = Note::query()->published()->public()->whereKey($noteId)->exists();
            abort_unless($isVisible, 404, 'Note not found.');
        } else {
            abort(422, 'Unknown comment scope.');
        }

        // "named" tapi nama kosong diperlakukan sebagai anonim (selaras perilaku UI).
        $isAnonymous = $data['identity'] === 'anonymous'
            || blank($data['author_name'] ?? null);

        $comment = Comment::create([
            'scope'        => $data['scope'],
            'note_id'      => $noteId,
            'author_name'  => $isAnonymous ? null : trim($data['author_name']),
            'is_anonymous' => $isAnonymous,
            'body'         => $data['body'],
        ]);

        return response()->json([
            'id'               => $comment->id,
            'name'             => $comment->display_name,
            'is_anonymous'     => $comment->is_anonymous,
            'body'             => $comment->body,
            'created_at_human' => $comment->created_at->diffForHumans(),
        ], 201);
    }
}
