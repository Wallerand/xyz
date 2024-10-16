<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property-read int $current_tracks_count
 */
class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's username (e.g. user0001).
     */
    protected function username(): Attribute
    {
        return Attribute::make(
            get: fn () => ($this->exists === true)
                ? "user" . str_pad((string) $this->id, 4, "0", STR_PAD_LEFT)
                : trans('auth.missing_user')
        );
    }

    /**
     * Get the user codes.
     */
    public function codes(): HasMany
    {
        return $this->hasMany(Code::class, 'host_id');
    }

    /**
     * Get the user tracks.
     */
    public function tracks(): HasMany
    {
        return $this->hasMany(Track::class);
    }

    /**
     * Get the user likes.
     */
    public function likes(): BelongsToMany
    {
        return $this->belongsToMany(Track::class, 'likes')
                    ->withPivot('liked_at');
    }

    /**
     * Eager load current week's track counts on the model.
     *
     * @return $this
     */
    public function loadCurrentTracksCount()
    {
        return $this->loadCount([
            'tracks as current_tracks_count' => fn ($query) => $query->currentWeek()
        ]);
    }
}
