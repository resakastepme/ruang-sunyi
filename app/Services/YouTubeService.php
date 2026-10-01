<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Http;
use RuntimeException;

/**
 * Integrasi YouTube Data API v3 via REST (tanpa SDK berat).
 * OAuth 2.0 untuk channel owner, lalu upload video (resumable) unlisted.
 */
class YouTubeService
{
    private const AUTH_URL     = 'https://accounts.google.com/o/oauth2/v2/auth';
    private const TOKEN_URL    = 'https://oauth2.googleapis.com/token';
    private const UPLOAD_URL   = 'https://www.googleapis.com/upload/youtube/v3/videos?uploadType=resumable&part=snippet,status';
    private const SCOPE        = 'https://www.googleapis.com/auth/youtube.upload';

    private function cfg(string $key): ?string
    {
        return config("services.youtube.$key");
    }

    /** Owner ruang (penulis tunggal). */
    public function owner(): ?User
    {
        return User::oldest('id')->first();
    }

    /** Client ID/Secret/redirect sudah diisi di .env? */
    public function isConfigured(): bool
    {
        return filled($this->cfg('client_id'))
            && filled($this->cfg('client_secret'))
            && filled($this->cfg('redirect'));
    }

    /** Owner sudah menyambungkan channel YouTube-nya? */
    public function isConnected(): bool
    {
        return $this->isConfigured() && filled($this->owner()?->youtube_refresh_token);
    }

    /** URL consent OAuth (minta refresh token: access_type=offline + prompt=consent). */
    public function authUrl(): string
    {
        return self::AUTH_URL . '?' . http_build_query([
            'client_id'     => $this->cfg('client_id'),
            'redirect_uri'  => $this->cfg('redirect'),
            'response_type' => 'code',
            'scope'         => self::SCOPE,
            'access_type'   => 'offline',
            'prompt'        => 'consent',
        ]);
    }

    /** Tukar authorization code menjadi refresh token, simpan ke owner. */
    public function exchangeCode(string $code): void
    {
        $res = Http::asForm()->post(self::TOKEN_URL, [
            'code'          => $code,
            'client_id'     => $this->cfg('client_id'),
            'client_secret' => $this->cfg('client_secret'),
            'redirect_uri'  => $this->cfg('redirect'),
            'grant_type'    => 'authorization_code',
        ]);

        if ($res->failed()) {
            throw new RuntimeException('Token exchange failed: ' . $res->body());
        }

        $refresh = $res->json('refresh_token');
        if (blank($refresh)) {
            throw new RuntimeException(
                'No refresh token returned. Revoke the app at myaccount.google.com/permissions, then connect again.'
            );
        }

        $owner = $this->owner();
        abort_unless($owner, 500, 'No owner account found.');

        $owner->youtube_refresh_token = $refresh;
        $owner->save();
    }

    /** Putuskan sambungan (hapus refresh token). */
    public function disconnect(): void
    {
        $owner = $this->owner();
        if ($owner) {
            $owner->youtube_refresh_token = null;
            $owner->save();
        }
    }

    /** Access token baru dari refresh token. */
    protected function accessToken(): string
    {
        $refresh = $this->owner()?->youtube_refresh_token;
        if (blank($refresh)) {
            throw new RuntimeException('YouTube is not connected.');
        }

        $res = Http::asForm()->post(self::TOKEN_URL, [
            'client_id'     => $this->cfg('client_id'),
            'client_secret' => $this->cfg('client_secret'),
            'refresh_token' => $refresh,
            'grant_type'    => 'refresh_token',
        ]);

        if ($res->failed()) {
            throw new RuntimeException('Could not refresh access token: ' . $res->body());
        }

        return (string) $res->json('access_token');
    }

    /**
     * Upload video ke channel owner. Mengembalikan video id (11 karakter).
     */
    public function uploadVideo(
        string $filePath,
        string $title,
        string $description = '',
        string $privacy = 'unlisted'
    ): string {
        $token = $this->accessToken();
        $size  = filesize($filePath);
        $mime  = mime_content_type($filePath) ?: 'video/*';

        // 1) Mulai sesi resumable (kirim metadata).
        $start = Http::withToken($token)
            ->timeout(60)
            ->withHeaders([
                'X-Upload-Content-Length' => (string) $size,
                'X-Upload-Content-Type'   => $mime,
            ])
            ->post(self::UPLOAD_URL, [
                'snippet' => [
                    'title'       => mb_substr($title, 0, 100),
                    'description' => $description,
                ],
                'status'  => [
                    'privacyStatus'           => $privacy,
                    'selfDeclaredMadeForKids' => false,
                ],
            ]);

        if ($start->failed()) {
            throw new RuntimeException('Failed to start upload: ' . $start->body());
        }

        $uploadUrl = $start->header('Location');
        if (blank($uploadUrl)) {
            throw new RuntimeException('YouTube did not return an upload URL.');
        }

        // 2) Kirim byte video (satu PUT, di-stream dari disk).
        $stream = fopen($filePath, 'r');

        try {
            $put = Http::withToken($token)
                ->timeout(1800)                       // beri waktu untuk file besar
                ->withHeaders(['Content-Length' => (string) $size])
                ->withBody($stream, $mime)
                ->put($uploadUrl);
        } finally {
            if (is_resource($stream)) {
                fclose($stream);
            }
        }

        if ($put->failed()) {
            throw new RuntimeException('Upload failed: ' . $put->body());
        }

        $id = $put->json('id');
        if (blank($id)) {
            throw new RuntimeException('Upload succeeded but no video id was returned.');
        }

        return $id;
    }

    /**
     * Mulai sesi upload resumable (server-side) dan kembalikan URL sesinya.
     * Browser lalu mengirim byte per-chunk ke server untuk diteruskan ke URL ini.
     */
    public function startResumableSession(
        string $title,
        int $size,
        string $mime,
        string $privacy = 'unlisted'
    ): string {
        $token = $this->accessToken();

        $res = Http::withToken($token)
            ->timeout(60)
            ->withHeaders([
                'X-Upload-Content-Length' => (string) $size,
                'X-Upload-Content-Type'   => $mime,
            ])
            ->post(self::UPLOAD_URL, [
                'snippet' => ['title' => mb_substr($title, 0, 100)],
                'status'  => [
                    'privacyStatus'           => $privacy,
                    'selfDeclaredMadeForKids' => false,
                ],
            ]);

        if ($res->failed()) {
            throw new RuntimeException('Failed to start upload: ' . $res->body());
        }

        $url = $res->header('Location');
        if (blank($url)) {
            throw new RuntimeException('YouTube did not return an upload URL.');
        }

        return $url;
    }

    /**
     * Teruskan satu chunk ke sesi resumable. Mengembalikan:
     *   ['status' => 'continue']                     — perlu chunk berikutnya
     *   ['status' => 'done', 'video_id' => '...']     — selesai
     */
    public function putChunk(string $sessionUrl, string $chunk, int $start, int $total): array
    {
        $length = strlen($chunk);
        $end    = $start + $length - 1;

        $res = Http::timeout(600)
            ->withoutRedirecting()
            ->withHeaders(['Content-Range' => "bytes {$start}-{$end}/{$total}"])
            ->withBody($chunk, 'application/octet-stream')
            ->put($sessionUrl);

        // 308 = Resume Incomplete (kirim chunk berikutnya).
        if ($res->status() === 308) {
            return ['status' => 'continue'];
        }

        if ($res->successful()) {
            $id = $res->json('id');
            if (blank($id)) {
                throw new RuntimeException('Upload finished but no video id was returned.');
            }

            return ['status' => 'done', 'video_id' => $id];
        }

        throw new RuntimeException('Chunk upload failed: ' . $res->body());
    }
}
