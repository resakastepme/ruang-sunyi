<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Reaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReactionController extends Controller
{
    /**
     * Tambah / kurangi reaksi (love / coffee) untuk sebuah scope.
     * Scope valid: 'special' atau 'note-{id}' (catatan terbit & publik).
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'scope'  => ['required', 'string', 'max:255'],
            'type'   => ['required', 'in:love,coffee'],
            'action' => ['required', 'in:add,remove'],
        ]);

        // Petakan scope -> note_id & validasi keberadaannya.
        $noteId = null;
        if ($data['scope'] === 'special') {
            // oke
        } elseif (preg_match('/^note-(\d+)$/', $data['scope'], $m)) {
            $noteId = (int) $m[1];
            abort_unless(
                Note::query()->published()->public()->whereKey($noteId)->exists(),
                404,
                'Note not found.'
            );
        } else {
            abort(422, 'Unknown reaction scope.');
        }

        $reaction = Reaction::firstOrCreate(
            ['scope' => $data['scope']],
            ['note_id' => $noteId, 'love_count' => 0, 'coffee_count' => 0],
        );

        $column = $data['type'] === 'love' ? 'love_count' : 'coffee_count';

        if ($data['action'] === 'add') {
            $reaction->increment($column);
        } elseif ($reaction->{$column} > 0) {
            $reaction->decrement($column);
        }

        $reaction->refresh();

        return response()->json([
            'love'   => $reaction->love_count,
            'coffee' => $reaction->coffee_count,
        ]);
    }
}
