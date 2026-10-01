<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'avatar',
        'bio',
        'password',
        'youtube_refresh_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'youtube_refresh_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'youtube_refresh_token' => 'encrypted',
        ];
    }

    /**
     * Catatan/jurnal milik pengguna ini.
     */
    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }

    /**
     * URL foto profil — mengembalikan berkas tersimpan atau placeholder SVG.
     */
    protected function avatarUrl(): Attribute
    {
        return Attribute::make(
            get: fn (): string => $this->avatar
                ? asset('storage/' . $this->avatar)
                : 'data:image/svg+xml;base64,' . base64_encode(
                    '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="120" height="120">'
                    . '<rect width="24" height="24" rx="12" fill="#232733"/>'
                    . '<circle cx="12" cy="9.4" r="3.4" fill="#5a5f70"/>'
                    . '<path d="M5.4 19.4c0-3.7 2.95-5.7 6.6-5.7s6.6 2 6.6 5.7z" fill="#5a5f70"/>'
                    . '</svg>'
                ),
        );
    }
}
