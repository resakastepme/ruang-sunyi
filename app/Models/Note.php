<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Note extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Kategori / mood catatan — sumber tunggal yang dipakai composer,
     * form edit, tampilan kartu, dan validasi.
     *
     * @var array<string, string>
     */
    public const CATEGORIES = [
        'renungan'      => '🌙 Night Reflection',
        'keseharian'    => '☕ Daily Life & Coffee',
        'catatan-lepas' => '🍃 Loose Notes',
        'buku-ide'      => '📚 Books & Ideas',
        'teknis'        => '⚡ Technical Notes',
    ];

    /**
     * @var list<string>
     */
    protected $fillable = [
        'content',
        'category',
        'visibility',
        'status',
        'is_pinned',
        'image',
        'youtube_video_id',
        'tags',
        'published_at',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'tags'            => 'array',
            'is_pinned'       => 'boolean',
            'published_at'    => 'datetime',
            'likes_count'     => 'integer',
            'coffees_count'   => 'integer',
            'responses_count' => 'integer',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function reaction(): HasOne
    {
        return $this->hasOne(Reaction::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */
    protected function imageUrl(): Attribute
    {
        return Attribute::make(
            get: fn (): ?string => $this->image ? asset('storage/' . $this->image) : null,
        );
    }

    /** URL embed YouTube (privacy-enhanced) dari video id, bila ada. */
    protected function youtubeEmbedUrl(): Attribute
    {
        return Attribute::make(
            get: fn (): ?string => $this->youtube_video_id
                ? 'https://www.youtube-nocookie.com/embed/' . $this->youtube_video_id
                : null,
        );
    }

    /**
     * Ambil ID video (11 karakter) dari input: ID langsung atau berbagai
     * bentuk URL YouTube (watch, youtu.be, embed, shorts, live).
     * Mengembalikan null bila tak dikenali / kosong.
     */
    public static function parseYoutubeId(?string $input): ?string
    {
        $input = trim((string) $input);

        if ($input === '') {
            return null;
        }

        if (preg_match('/^[A-Za-z0-9_-]{11}$/', $input)) {
            return $input;
        }

        $pattern = '~(?:youtube\.com/(?:watch\?(?:.*&)?v=|embed/|shorts/|live/)|youtu\.be/)([A-Za-z0-9_-]{11})~';

        return preg_match($pattern, $input, $m) ? $m[1] : null;
    }

    protected function categoryLabel(): Attribute
    {
        return Attribute::make(
            get: fn (): string => self::CATEGORIES[$this->category] ?? $this->category,
        );
    }

    /** Estimasi waktu baca dalam menit (≈200 kata/menit, minimal 1). */
    protected function readingTime(): Attribute
    {
        return Attribute::make(
            get: function (): int {
                $words = str_word_count(strip_tags((string) $this->content));

                return max(1, (int) ceil($words / 200));
            },
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Query Scopes
    |--------------------------------------------------------------------------
    */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published');
    }

    /** Hanya catatan yang ditujukan untuk konsumsi publik. */
    public function scopePublic(Builder $query): Builder
    {
        return $query->where('visibility', 'public');
    }

    public function scopeDrafts(Builder $query): Builder
    {
        return $query->where('status', 'draft');
    }

    public function scopePinned(Builder $query): Builder
    {
        return $query->where('is_pinned', true);
    }

    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        return $query->when(
            filled($term),
            fn (Builder $q) => $q->where('content', 'like', '%' . $term . '%'),
        );
    }

    /** Urutan default: catatan tersemat dulu, lalu yang terbaru. */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderByDesc('is_pinned')
            ->orderByDesc('published_at')
            ->orderByDesc('created_at');
    }
}
