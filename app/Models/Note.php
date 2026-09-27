<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Note extends Model
{
    use HasFactory;

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

    protected function categoryLabel(): Attribute
    {
        return Attribute::make(
            get: fn (): string => self::CATEGORIES[$this->category] ?? $this->category,
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
