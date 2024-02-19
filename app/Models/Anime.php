<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Anime extends Model
{
    use HasFactory;

    protected $table = 'anime';
    protected $fillable = [
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
        'type' => ['TV', 'MOVIE', 'OVA', 'ONA', 'SPECIAL', 'UNKNOWN'],
        'status' => ['FINISHED', 'ONGOING', 'UPCOMING', 'UNKNOWN'],
        'season' => ['SPRING', 'SUMMER', 'FALL', 'WINTER', 'UNKNOWN'],
    ];

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function synonyms(): HasMany
    {
        return $this->hasMany(Synonym::class);
    }

    public function getTypeAttribute($value)
    {
        return $this->enumColumns['type'][$value];
    }

    public function getStatusAttribute($value)
    {
        return $this->enumColumns['status'][$value];
    }

    public function getSeasonAttribute($value)
    {
        return $this->enumColumns['season'][$value];
    }
}
