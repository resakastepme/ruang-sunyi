<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Pesan anonim singkat ("Yap to me") dari pembaca publik.
 */
class Yap extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'alias',
        'message',
        'is_read',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_read' => 'boolean',
        ];
    }

    public function scopeUnread(Builder $query): Builder
    {
        return $query->where('is_read', false);
    }

    /** Alias anonim bergaya nocturne (mis. "Dusk Wanderer #42"). */
    public static function randomAlias(): string
    {
        $adjectives = [
            'Night', 'Dusk', 'Midnight', 'Quiet', 'Silent', 'Lunar', 'Velvet', 'Amber',
            'Hollow', 'Distant', 'Wandering', 'Sleepless', 'Faded', 'Rainy', 'Drifting',
            'Pale', 'Dim', 'Starlit',
        ];
        $nouns = [
            'Wanderer', 'Reader', 'Visitor', 'Owl', 'Moth', 'Shadow', 'Stranger',
            'Dreamer', 'Comet', 'Drifter', 'Echo', 'Lantern', 'Traveler', 'Ghost', 'Nomad',
        ];

        return $adjectives[array_rand($adjectives)]
            . ' ' . $nouns[array_rand($nouns)]
            . ' #' . random_int(10, 99);
    }
}
