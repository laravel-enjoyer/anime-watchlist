<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin Builder
 * @mixin IdeHelperAnime
 */
class Anime extends Model
{
    use HasFactory;

    public const TYPE_TV = 'TV';
    public const TYPE_MOVIE = 'MOVIE';
    public const TYPE_OVA = 'OVA';
    public const TYPE_ONA = 'ONA';
    public const TYPE_SPECIAL = 'SPECIAL';
    public const TYPE_MUSIC = 'MUSIC';
    public const TYPE_UNKNOWN = 'UNKNOWN';
    public const STATUS_FINISHED = 'FINISHED';
    public const STATUS_ONGOING = 'ONGOING';
    public const STATUS_UPCOMING = 'UPCOMING';
    public const STATUS_UNKNOWN = 'UNKNOWN';
    public const STATUS_FINISHED_RECENTLY = 'FINISHED_RECENTLY';
    public const SEASON_SPRING = 'SPRING';
    public const SEASON_SUMMER = 'SUMMER';
    public const SEASON_FALL = 'FALL';
    public const SEASON_WINTER = 'WINTER';
    public const SEASON_UNKNOWN = 'UNKNOWN';

    public const PLAYLIST_BACKLOG = 'backlog';
    public const PLAYLIST_WATCHED = 'watched';

    protected $table = 'anime';
    protected $fillable = [
        'mal_id',
        'title',
        'type',
        'episodes',
        'status',
        'season',
        'year',
        'picture',
        'thumbnail',
        'synonyms',
    ];

    protected $casts = [
        'synonyms' => 'array',
    ];

    protected $enumColumns = [
        'type' => [
            self::TYPE_TV,
            self::TYPE_MOVIE,
            self::TYPE_OVA,
            self::TYPE_ONA,
            self::TYPE_SPECIAL,
            self::TYPE_MUSIC,
            self::TYPE_UNKNOWN
        ],
        'status' => [self::STATUS_FINISHED, self::STATUS_ONGOING, self::STATUS_UPCOMING, self::STATUS_UNKNOWN],
        'season' => [
            self::SEASON_SPRING,
            self::SEASON_SUMMER,
            self::SEASON_FALL,
            self::SEASON_WINTER,
            self::SEASON_UNKNOWN
        ],
    ];

    public function scopeFilter($query, array $filters): void
    {
        if ($filters['search'] ?? false) {
            $query->where(function ($query) use ($filters) {
                $search = $filters['search'];

                $query->where('title', 'like', "%$search%")
                    ->orWhereHas('synonyms', function ($query) use ($search) {
                        $query->where('name', 'like', "%$search%");
                    });
            });
        }

        if ($filters['status'] ?? false) {
            $query->where(function($query) use ($filters) {
                foreach ($filters['status'] as $status) {
                    if ($status !== Anime::STATUS_FINISHED_RECENTLY) {
                        $query->orWhere('status', $status);
                    } else {
                        $dateFrom = now()->subMonths(4)->format('Y-m-d');
                        $query->orWhere(function($query) use ($dateFrom) {
                            $query->where('status', Anime::STATUS_FINISHED)
                                ->where('aired_to', '>', $dateFrom);
                        });
                    }
                }
            });
        }

        if ($filters['type'] ?? false) {
            $query->whereIn('type', $filters['type']);
        }

        if ($filters['genre'] ?? false) {
            $genre = $filters['genre'];

            $query->whereHas('genres', function ($query) use ($genre) {
                $query->where('genres.id', $genre);
            });
        }

        if ($filters['year'] ?? false) {
            $query->where('year', request('year'));
        }

        if (auth()->check() and $filters['playlist'] ?? false) {
            $user = auth()->user();
            $status = $filters['playlist'];

            $query->whereHas('users', function ($query) use ($user, $status) {
                $query->where('user_id', $user->id)->where('status', $status);
            });
        }

        if ($filters['sorting'] ?? false) {
            if ($filters['sorting'] == 'rating') {
                $query->orderByRaw('`rank` is NULL ASC')
                    ->orderBy('rank')
                    ->orderByRaw('`score` is NULL ASC');
            } elseif ($filters['sorting'] == 'name') {
                $query->orderByRaw("REGEXP_REPLACE(LOWER(title), '[^a-zA-Z]', '') ASC");
            }
        }
    }

    public static function getTypes(): array
    {
        return [
            self::TYPE_TV,
            self::TYPE_MOVIE,
            self::TYPE_OVA,
            self::TYPE_SPECIAL,
            self::TYPE_ONA,
            self::TYPE_MUSIC,
            self::TYPE_UNKNOWN
        ];
    }

    public static function getStatusDisplayName(string $status): string
    {
        return match ($status) {
            self::STATUS_UPCOMING => 'Upcoming',
            self::STATUS_FINISHED_RECENTLY => 'Finished recently',
            self::STATUS_ONGOING => 'Ongoing',
            self::STATUS_FINISHED => 'Finished',
            default => 'Unknown',
        };
    }

    public static function getSeasons(): array
    {
        return [
            self::SEASON_SPRING,
            self::SEASON_SUMMER,
            self::SEASON_FALL,
            self::SEASON_WINTER,
            self::SEASON_UNKNOWN
        ];
    }

    public static function getCurrentSeason(): string
    {
        $season = self::SEASON_UNKNOWN;

        switch ($month = date('n')) {
            case $month <= 3:
                $season = self::SEASON_WINTER;
                break;
            case $month <= 6:
                $season = self::SEASON_SPRING;
                break;
            case $month <= 9:
                $season = self::SEASON_SUMMER;
                break;
            case $month <= 12:
                $season = self::SEASON_FALL;
                break;
        }

        return $season;
    }

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class);
    }

    public function synonyms(): HasMany
    {
        return $this->hasMany(Synonym::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'anime_user')->withPivot('status')->withTimestamps();
    }

    public function getTypeAttribute(string $value): ?string
    {
        return in_array($value, $this->enumColumns['type'], true) ? $value : null;
    }

    public function getStatusAttribute(string $value): ?string
    {
        return in_array($value, $this->enumColumns['status'], true) ? $value : null;
    }

    public function getSeasonAttribute(string $value): ?string
    {
        return in_array($value, $this->enumColumns['season'], true) ? $value : null;
    }
}
