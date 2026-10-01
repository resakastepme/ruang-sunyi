<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;

class LinimasaController extends Controller
{
    /**
     * Tampilkan linimasa publik (halaman utama).
     */
    public function index(Request $request)
    {
        // Hanya tampilkan kategori yang benar-benar punya catatan terbit & publik.
        // Urutan & label tetap mengikuti Note::CATEGORIES.
        $usedCategories = Note::query()
            ->published()
            ->public()
            ->distinct()
            ->pluck('category')
            ->all();

        $categories = array_intersect_key(Note::CATEGORIES, array_flip($usedCategories));

        // Kategori aktif dari query string; abaikan nilai yang tak dikenal / kosong (-> "semua").
        $activeCategory = $request->query('category');
        if (! array_key_exists($activeCategory, $categories)) {
            $activeCategory = null;
        }

        $notes = Note::query()
            ->published()
            ->public()
            ->with(['comments' => fn ($query) => $query->latest(), 'reaction'])
            ->when($activeCategory, fn ($query) => $query->where('category', $activeCategory))
            ->ordered()
            ->paginate(8)
            ->withQueryString();

        return view('linimasa.index', compact('notes', 'categories', 'activeCategory'));
    }
}
