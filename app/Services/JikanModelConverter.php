<?php

namespace App\Services;

use App\Models\Anime;
use Carbon\Carbon;

class JikanModelConverter
{
    public static function convert(array $animeData): array
    {
        $data = [];

        $data['mal_id'] = $animeData['mal_id'];

        $titleData = self::getPreparedTitleData($animeData['titles']);

        $data['title'] = $titleData['main'];
        $data['synonyms'] = $titleData['synonyms'];
        $data['genres'] = self::getPreparedGenres($animeData);
        $data['type'] = self::getPreparedType($animeData['type']);
        $data['episodes'] = $animeData['episodes'];
        $data['description'] = $animeData['synopsis'];
        $data['score'] = $animeData['score'];
        $data['rank'] = $animeData['rank'];
        $data['status'] = self::getPreparedStatus($animeData['status']);
        $data['season'] = self::getPreparedSeason($animeData['season']);
        $data['year'] = $animeData['year'];
        $data['picture'] = self::getPreparedPicture($animeData['images'], 'large_');
        $data['thumbnail'] = self::getPreparedPicture($animeData['images'], '');
        $data['aired_from'] = self::getPreparedDate($animeData['aired']['from']);
        $data['aired_to'] = self::getPreparedDate($animeData['aired']['to']);

        return $data;
    }

    private static function getPreparedGenres(array $animeData): array
    {
        $genres = array_merge($animeData['genres'], $animeData['themes'], $animeData['demographics']);

        return array_map(fn($x) => $x['name'], $genres);
    }

    private static function getPreparedDate(?string $date): ?string
    {
        if (!$date) {
            return null;
        }

        return Carbon::parse($date)->format('Y-m-d');
    }

    private static function getPreparedPicture(array $imageData, string $sizePrefix): string
    {
        return $imageData['webp']["{$sizePrefix}image_url"] ?? $imageData['jpg']["{$sizePrefix}image_url"];
    }

    private static function getPreparedSeason(?string $season): string
    {
        if (!$season) {
            return Anime::SEASON_UNKNOWN;
        }

        $season = strtoupper($season);

        return in_array($season, Anime::getSeasons()) ? $season : Anime::SEASON_UNKNOWN;
    }

    private static function getPreparedStatus(?string $status): string
    {
        $default = Anime::STATUS_UNKNOWN;

        switch ($status) {
            case 'Finished Airing':
                $default = Anime::STATUS_FINISHED;
                break;
            case 'Currently Airing':
                $default = Anime::STATUS_ONGOING;
                break;
            case 'Not yet aired':
                $default = Anime::STATUS_UPCOMING;
                break;
        }

        return $default;
    }

    private static function getPreparedType(?string $type): string
    {
        if (!$type) {
            return Anime::TYPE_UNKNOWN;
        }

        $type = strtoupper($type);

        return in_array($type, Anime::getTypes()) ? $type : Anime::TYPE_UNKNOWN;
    }

    private static function getPreparedTitleData(array $titles): array
    {
        $main = '';
        $synonyms = [];

        foreach ($titles as $title) {
            if ($title['type'] == 'English') {
                $main = $title['title'];
            } else {
                $synonyms[] = $title['title'];
            }
        }

        //if doesn't have english title, take default
        if (!$main && $titles) {
            $main = $titles[0]['title'];
        }

        return [
            'main' => $main,
            'synonyms' => $synonyms
        ];
    }
}
