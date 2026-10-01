<?php

namespace App\Http\Controllers;

use App\Models\Yap;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class YapController extends Controller
{
    /** Terima pesan anonim dari publik ("Yap to me"). */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'message' => ['required', 'string', 'max:500'],
        ]);

        Yap::create([
            'alias'   => Yap::randomAlias(),
            'message' => $data['message'],
        ]);

        return response()->json(['ok' => true], 201);
    }

    /** (Admin) Tandai yap sudah dibaca. */
    public function markRead(Yap $yap): RedirectResponse
    {
        $yap->update(['is_read' => true]);

        return back()->with('status_note', 'Yap marked as read.');
    }

    /** (Admin) Hapus yap (soft delete). */
    public function destroy(Yap $yap): RedirectResponse
    {
        $yap->delete();

        return back()->with('status_note', 'Yap deleted.');
    }
}
