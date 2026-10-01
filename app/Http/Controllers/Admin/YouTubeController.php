<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\YouTubeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class YouTubeController extends Controller
{
    public function __construct(private readonly YouTubeService $youtube)
    {
    }

    /** Mulai alur OAuth: arahkan ke consent Google. */
    public function connect(): RedirectResponse
    {
        if (! $this->youtube->isConfigured()) {
            return back()->with('status_note', 'Set YOUTUBE_CLIENT_ID & YOUTUBE_CLIENT_SECRET in .env first.');
        }

        return redirect()->away($this->youtube->authUrl());
    }

    /** Callback OAuth: tukar code -> refresh token. */
    public function callback(Request $request): RedirectResponse
    {
        if ($request->filled('error')) {
            return redirect()->route('admin.index')
                ->with('status_note', 'YouTube authorization was cancelled.');
        }

        $code = $request->query('code');
        if (blank($code)) {
            return redirect()->route('admin.index')
                ->with('status_note', 'No authorization code received from Google.');
        }

        try {
            $this->youtube->exchangeCode($code);
            $message = 'YouTube connected successfully.';
        } catch (\Throwable $e) {
            $message = 'YouTube connect failed: ' . $e->getMessage();
        }

        return redirect()->route('admin.index')->with('status_note', $message);
    }

    /** Putuskan sambungan channel. */
    public function disconnect(): RedirectResponse
    {
        $this->youtube->disconnect();

        return back()->with('status_note', 'YouTube disconnected.');
    }

    /** Mulai sesi upload resumable; kembalikan URL sesi untuk dikirimi chunk. */
    public function uploadSession(Request $request): JsonResponse
    {
        if (! $this->youtube->isConnected()) {
            return response()->json(['message' => 'YouTube is not connected yet.'], 409);
        }

        $data = $request->validate([
            'title'    => ['nullable', 'string', 'max:100'],
            'size'     => ['required', 'integer', 'min:1', 'max:' . (5 * 1024 * 1024 * 1024)], // 5 GB
            'mimeType' => ['required', 'string', 'max:100'],
        ]);

        try {
            $title = $data['title'] ?: ('Nocturne Notes — ' . now()->format('Y-m-d H:i'));

            $url = $this->youtube->startResumableSession(
                $title,
                (int) $data['size'],
                $data['mimeType'],
                'unlisted',
            );
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }

        return response()->json(['upload_url' => $url]);
    }

    /** Teruskan satu chunk (raw body) ke sesi resumable YouTube. */
    public function uploadChunk(Request $request): JsonResponse
    {
        if (! $this->youtube->isConnected()) {
            return response()->json(['message' => 'YouTube is not connected yet.'], 409);
        }

        $sessionUrl = (string) $request->header('X-Session-Url');
        $start      = (int) $request->header('X-Chunk-Start');
        $total      = (int) $request->header('X-Total-Size');

        // Cegah SSRF: hanya izinkan URL sesi upload milik Google.
        if (! preg_match('~^https://[a-z0-9.-]*googleapis\.com/upload/~i', $sessionUrl)) {
            return response()->json(['message' => 'Invalid upload session URL.'], 422);
        }

        $chunk = $request->getContent();
        if ($chunk === '' || $total <= 0) {
            return response()->json(['message' => 'Empty chunk.'], 422);
        }

        try {
            $result = $this->youtube->putChunk($sessionUrl, $chunk, $start, $total);
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }

        return response()->json($result);
    }

    /** Terima file video (rekaman/upload) lalu unggah ke YouTube sebagai unlisted. */
    public function upload(Request $request): JsonResponse
    {
        if (! $this->youtube->isConnected()) {
            return response()->json(['message' => 'YouTube is not connected yet.'], 409);
        }

        $request->validate([
            'video' => [
                'required', 'file',
                'mimetypes:video/webm,video/mp4,video/quicktime,video/x-matroska,video/ogg',
                'max:262144', // 256 MB (dibatasi juga oleh php.ini)
            ],
            'title' => ['nullable', 'string', 'max:100'],
        ]);

        try {
            $title = $request->input('title')
                ?: ('Nocturne Notes — ' . now()->format('Y-m-d H:i'));

            $videoId = $this->youtube->uploadVideo(
                $request->file('video')->getRealPath(),
                $title,
                'Uploaded from Nocturne Notes.',
                'unlisted',
            );
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }

        return response()->json([
            'video_id' => $videoId,
            'url'      => 'https://youtu.be/' . $videoId,
        ], 201);
    }
}
