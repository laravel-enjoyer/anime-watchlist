<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin Builder
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
    public const SEASON_SPRING = 'SPRING';
    public const SEASON_SUMMER = 'SUMMER';
    public const SEASON_FALL = 'FALL';
    public const SEASON_WINTER = 'WINTER';
    public const SEASON_UNKNOWN = 'UNKNOWN';

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

    public static function getTypes(): array
    {
        return [
            self::TYPE_TV,
            self::TYPE_MOVIE,
            self::TYPE_OVA,
            self::TYPE_ONA,
            self::TYPE_SPECIAL,
            self::TYPE_MUSIC,
            self::TYPE_UNKNOWN
        ];
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

    public function getTypeAttribute($value): ?string
    {
        return $this->enumColumns['type'][$value] ?? null;
    }

    public function getStatusAttribute($value): ?string
    {
        return $this->enumColumns['status'][$value] ?? null;
    }

    public function getSeasonAttribute($value): ?string
    {
        return $this->enumColumns['season'][$value] ?? null;
    }
}
