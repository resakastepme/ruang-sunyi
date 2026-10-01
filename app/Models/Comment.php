<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'scope',
        'note_id',
        'author_name',
        'is_anonymous',
        'body',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_anonymous' => 'boolean',
        ];
    }

    public function note(): BelongsTo
    {
        return $this->belongsTo(Note::class);
    }

    /** Nama yang ditampilkan: "Anonymous" bila anonim atau nama kosong. */
    protected function displayName(): Attribute
    {
        return Attribute::make(
            get: fn (): string => $this->is_anonymous
                ? 'Anonymous'
                : (filled($this->author_name) ? $this->author_name : 'Anonymous'),
        );
    }
}
