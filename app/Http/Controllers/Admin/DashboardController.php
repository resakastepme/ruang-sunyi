<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Note;
use App\Models\Yap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class DashboardController extends Controller
{
    /**
     * Tampilkan dasbor "Ruang Tulis" admin.
     */
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'all');
        $q   = $request->query('q');

        $query = Note::query()->search($q);

        $query = match ($tab) {
            'published' => $query->published(),
            'drafts'    => $query->drafts(),
            'pinned'    => $query->pinned(),
            default     => $query,
        };

        $notes = $query->ordered()->paginate(10)->withQueryString();

        $counts = [
            'total'     => Note::count(),
            'published' => Note::published()->count(),
            'drafts'    => Note::drafts()->count(),
            'pinned'    => Note::pinned()->count(),
        ];

        // Yap to me — pesan anonim pembaca (terbaru dulu).
        $yaps      = Yap::latest()->take(8)->get();
        $yapUnread = Yap::unread()->count();
        $yapTotal  = Yap::count();

        return view('admin.index', compact('notes', 'counts', 'tab', 'q', 'yaps', 'yapUnread', 'yapTotal'));
    }

    /**
     * Tampilkan halaman ubah profil pengarang.
     */
    public function EditProfilePage()
    {
        return view('admin.edit-profile');
    }

    /**
     * Perbarui data profil: nama, username, bio, dan foto profil.
     */
    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:100'],
            'username' => [
                'nullable', 'string', 'max:30', 'alpha_dash',
                Rule::unique('users', 'username')->ignore($user->id),
            ],
            'bio'      => ['nullable', 'string', 'max:500'],
            'avatar'   => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
        ], [], [
            'name'     => 'nama lengkap',
            'username' => 'nama pengguna',
            'bio'      => 'deskripsi',
            'avatar'   => 'foto profil',
        ]);

        // Unggah & ganti foto profil bila ada berkas baru.
        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
        } else {
            unset($validated['avatar']);
        }

        $user->fill($validated)->save();

        return redirect()
            ->route('admin.edit-profile')
            ->with('status_profile', 'Profil berhasil diperbarui.');
    }

    /**
     * Perbarui kata sandi akun.
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password'         => ['required', 'confirmed', Password::min(8)],
        ], [], [
            'current_password' => 'kata sandi saat ini',
            'password'         => 'kata sandi baru',
        ]);

        $request->user()->update([
            'password' => $validated['password'],
        ]);

        return redirect()
            ->route('admin.edit-profile')
            ->with('status_password', 'Kata sandi berhasil diperbarui.');
    }
}
