<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\NoteController;
use App\Http\Controllers\Admin\YouTubeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LegalController;
use App\Http\Controllers\ReactionController;
use App\Http\Controllers\LinimasaController;
use App\Http\Controllers\SpecialNoteController;
use App\Http\Controllers\TentangController;
use App\Http\Controllers\YapController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LinimasaController::class, 'index'])->name('linimasa.index');
Route::get('/tentang', [TentangController::class, 'index'])->name('tentang.index');
Route::get('/special-note', [SpecialNoteController::class, 'index'])->name('special-note.index');

// Komentar publik (anonim / bernama) — client mengirim via AJAX.
Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');

// Yap to me — pesan anonim publik (AJAX).
Route::post('/yap', [YapController::class, 'store'])->name('yap.store');

// Reaksi (love / coffee) publik (AJAX).
Route::post('/reactions', [ReactionController::class, 'store'])->name('reactions.store');

// Halaman legal (dibutuhkan juga untuk audit YouTube API).
Route::get('/privacy', [LegalController::class, 'privacy'])->name('privacy.index');
Route::get('/tos', [LegalController::class, 'tos'])->name('tos.index');

/*
|--------------------------------------------------------------------------
| Admin (URL sengaja disamarkan)
|--------------------------------------------------------------------------
*/
Route::prefix('admin-ca9ef168e63c4863')->name('admin.')->group(function () {
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.attempt');

    Route::middleware('auth')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('index');
        Route::get('/edit-profile', [DashboardController::class, 'EditProfilePage'])->name('edit-profile');
        Route::post('/edit-profile', [DashboardController::class, 'updateProfile'])->name('update-profile');
        Route::post('/edit-profile/password', [DashboardController::class, 'updatePassword'])->name('update-password');

        // Catatan / jurnal (CRUD dasbor)
        Route::post('/notes', [NoteController::class, 'store'])->name('notes.store');
        Route::get('/notes/{note}/edit', [NoteController::class, 'edit'])->name('notes.edit');
        Route::put('/notes/{note}', [NoteController::class, 'update'])->name('notes.update');
        Route::delete('/notes/{note}', [NoteController::class, 'destroy'])->name('notes.destroy');
        Route::patch('/notes/{note}/pin', [NoteController::class, 'togglePin'])->name('notes.pin');
        Route::patch('/notes/{note}/visibility', [NoteController::class, 'toggleVisibility'])->name('notes.visibility');
        Route::patch('/notes/{note}/publish', [NoteController::class, 'publish'])->name('notes.publish');

        // Yap to me (kelola pesan masuk)
        Route::patch('/yaps/{yap}/read', [YapController::class, 'markRead'])->name('yaps.read');
        Route::delete('/yaps/{yap}', [YapController::class, 'destroy'])->name('yaps.destroy');

        // YouTube (OAuth + upload)
        Route::get('/youtube/connect', [YouTubeController::class, 'connect'])->name('youtube.connect');
        Route::get('/youtube/callback', [YouTubeController::class, 'callback'])->name('youtube.callback');
        Route::post('/youtube/disconnect', [YouTubeController::class, 'disconnect'])->name('youtube.disconnect');
        Route::post('/youtube/upload', [YouTubeController::class, 'upload'])->name('youtube.upload');
        Route::post('/youtube/upload-session', [YouTubeController::class, 'uploadSession'])->name('youtube.upload-session');
        Route::post('/youtube/upload-chunk', [YouTubeController::class, 'uploadChunk'])->name('youtube.upload-chunk');

        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    });
});
