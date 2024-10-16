<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Track extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'artist',
        'url',
    ];

    /**
     * Get the user who shared this track.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)
                    ->withDefault();
    }

    /**
     * Get the track likes.
     */
    public function likes(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'likes')
                    ->withPivot('liked_at');
    }

    /**
     * Get the track likes.
     */
    public function week(): BelongsTo
    {
        return $this->belongsTo(Week::class);
    }

    /**
     * Get current week tracks.
     */
    public function scopeCurrentWeek(Builder $query): Builder
    {
        return $query->whereRelation('week', 'year', date('Y'))
            ->whereRelation('week', 'week_number', date('W'));
    }

    /**
     * Get tracks ranking.
     */
    public function scopeRanking(Builder $query): Builder
    {
        return $query->withCount('likes')
            ->orderBy('likes_count', 'desc')
            ->orderBy('created_at', 'asc');
    }
}
