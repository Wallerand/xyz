<?php

namespace App\Models;

use Carbon\CarbonPeriod;
use App\Services\WeekService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property-read string $uri
 * @property-read string $name
 */
class Week extends Model
{
    use HasFactory;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'week_starts_at' => 'datetime',
            'week_ends_at' => 'datetime',
        ];
    }

    /**
     * Get the week's name (e.g. "2024-S34").
     */
    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn () => "{$this->year}-S{$this->week_number}",
        );
    }

    /**
     * Get the week's URI (e.g. "2024/34").
     */
    protected function uri(): Attribute
    {
        return Attribute::make(
            get: fn () => "{$this->year}/{$this->week_number}",
        );
    }

    /**
     * Get the week as DatePeriod.
     */
    public function toPeriod()
    {
        return CarbonPeriod::create($this->week_starts_at, $this->week_ends_at);
    }

    /**
     * Get the current week.
     */
    static function current(): self
    {
        return Week::where('week_starts_at', now()->startOfWeek())->firstOrFail();
    }

    /**
     * Scope the last $previousWeeksCount weeks.
     */
    public function scopeLast(Builder $query, int $previousWeeksCount): Builder
    {
        return $query->whereIn('week_starts_at', 
            app(WeekService::class)->previous($previousWeeksCount)->map->start()
        );
    }

    /**
     * Get the track likes.
     */
    public function tracks(): HasMany
    {
        return $this->hasMany(Track::class);
    }

    /**
     * Retrieve the model for a bound value.
     *
     * @param  mixed  $value
     * @param  string|null  $field
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function resolveRouteBinding($value, $field = null)
    {
        if ($field === 'uri') {
            [$year, $weekNumber] = explode('/', $value);

            return $this->where('year', $year)
                        ->where('week_number', $weekNumber)
                        ->firstOrFail();
        }

        return $this->findOrFail($value);
    }

    /**
     * Get $track position in week ranking.
     */
    public function getTrackPosition(Track $track)
    {
        return $this->tracks()
            ->select('id', 'week_id')
            ->ranking()
            ->pluck('id')
            ->flip()
            ->map(fn ($position) => $position + 1)
            ->get($track->id);
    }
}
