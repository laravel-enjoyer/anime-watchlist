<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Anime
 *
 * @mixin Builder
 * @property int $id
 * @property int $mal_id
 * @property string $title
 * @property string $type
 * @property int|null $episodes
 * @property string|null $description
 * @property float|null $score
 * @property int|null $rank
 * @property string $status
 * @property string $season
 * @property int|null $year
 * @property string $picture
 * @property string $thumbnail
 * @property string|null $aired_from
 * @property string|null $aired_to
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Genre> $genres
 * @property-read int|null $genres_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Synonym> $synonyms
 * @property-read int|null $synonyms_count
 * @method static \Illuminate\Database\Eloquent\Builder|Anime newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Anime newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Anime query()
 * @method static \Illuminate\Database\Eloquent\Builder|Anime whereAiredFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Anime whereAiredTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Anime whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Anime whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Anime whereEpisodes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Anime whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Anime whereMalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Anime wherePicture($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Anime whereRank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Anime whereScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Anime whereSeason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Anime whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Anime whereThumbnail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Anime whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Anime whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Anime whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Anime whereYear($value)
 */
	class Anime extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Genre
 *
 * @property int $id
 * @property string $name
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Anime> $anime
 * @property-read int|null $anime_count
 * @method static \Illuminate\Database\Eloquent\Builder|Genre newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Genre newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Genre query()
 * @method static \Illuminate\Database\Eloquent\Builder|Genre whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Genre whereName($value)
 */
	class Genre extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Synonym
 *
 * @property int $id
 * @property string $name
 * @property int $anime_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Anime $anime
 * @method static \Illuminate\Database\Eloquent\Builder|Synonym newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Synonym newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Synonym query()
 * @method static \Illuminate\Database\Eloquent\Builder|Synonym whereAnimeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Synonym whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Synonym whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Synonym whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Synonym whereUpdatedAt($value)
 */
	class Synonym extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property mixed $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

