<?php
namespace App\Services;

use App\Models\Anime;
use Carbon\Carbon;
use Generator;
use GuzzleHttp\Client;

class JikanService implements IAnimeService
{
    public function __construct(protected Client $client)
    {
        $this->client = new Client([
            'base_uri' => 'https://api.jikan.moe/v4/',
        ]);
    }

    public function getCurrentSeasonAnime(): array
    {
        $data = [];

        foreach ($this->paginateApi('seasons/now') as $item) {
            $data[] = $item;
        }

        return $data;
    }

    public function getSeasonsList(): array
    {
        $response = $this->client->get('seasons');

        $data = json_decode($response->getBody()->getContents(), true);

        return $data['data'];
    }

    public function getGenreList(): array
    {
        $response = $this->client->get('genres/anime');

        $data = json_decode($response->getBody()->getContents(), true);

        return $data['data'];
    }

    public function getSeasonAnime(int $year, string $season)
    {
        $data = [];

        foreach ($this->paginateApi("seasons/$year/$season") as $item) {
            $data[] = $item;
        }

        return $data;
    }

    public function convertToModelData(array $animeData): array
    {
        $data = [];

        $data['mal_id'] = $animeData['mal_id'];

        $titleData = $this->getPreparedTitleData($animeData['titles']);

        $data['title'] = $titleData['main'];
        $data['synonyms'] = $titleData['synonyms'];
        $data['genres'] = $this->getPreparedGenres($animeData['genres']);
        $data['type'] = $this->getPreparedType($animeData['type']);
        $data['episodes'] = $animeData['episodes'];
        $data['description'] = $animeData['synopsis'];
        $data['score'] = $animeData['score'];
        $data['rank'] = $animeData['rank'];
        $data['status'] = $this->getPreparedStatus($animeData['status']);
        $data['season'] = $this->getPreparedSeason($animeData['season']);
        $data['year'] = $animeData['year'];
        $data['picture'] = $this->getPreparedPicture($animeData['images'], 'large_');
        $data['thumbnail'] = $this->getPreparedPicture($animeData['images'], '');
        $data['aired_from'] = $this->getPreparedDate($animeData['aired']['from']);
        $data['aired_to'] = $this->getPreparedDate($animeData['aired']['to']);

        return $data;
    }

    private function getPreparedGenres(array $genresData): array
    {
        return array_map(fn($x) => $x['name'], $genresData);
    }

    private function getPreparedDate(?string $date): ?string
    {
        if (!$date) {
            return null;
        }

        return Carbon::parse($date)->format('Y-m-d');
    }

    private function getPreparedPicture(array $imageData, string $sizePrefix): string
    {
        return $imageData['webp']["{$sizePrefix}image_url"] ?? $imageData['jpg']["{$sizePrefix}image_url"];
    }

    private function getPreparedSeason(?string $season): string
    {
        if (!$season) {
            return Anime::SEASON_UNKNOWN;
        }

        $season = strtoupper($season);

        return in_array($season, Anime::getSeasons()) ? $season : Anime::SEASON_UNKNOWN;
    }

    private function getPreparedStatus(?string $status): string
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

    private function getPreparedType(?string $type): string
    {
        if (!$type) {
            return Anime::TYPE_UNKNOWN;
        }

        $type = strtoupper($type);

        return in_array($type, Anime::getTypes()) ? $type : Anime::TYPE_UNKNOWN;
    }

    private function getPreparedTitleData(array $titles): array
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


    protected function paginateApi($apiUrl): Generator {
        $page = 1;

        while (true) {
            //TODO: add error validation

            $response = $this->client->get($apiUrl, [
                'query' => ['page' => $page],
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            if (!$data || empty($data['data'])) {
                break;
            }

            foreach ($data['data'] as $item) {
                yield $item;
            }

            $page++;

            if (!isset($data['pagination']['items']['total']) ||
                $page > $data['pagination']['last_visible_page'])
            {
                break;
            }

            // rate limiting protection
            sleep(1);
            usleep(200000);
        }
    }
}
