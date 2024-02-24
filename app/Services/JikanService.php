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

    public function getAnimeDataByRemoteID(mixed $remoteID): array
    {
        $response = $this->client->get("anime/$remoteID");

        $data = json_decode($response->getBody()->getContents(), true);

        return $data['data'];
    }

    public function convertToModelData(array $animeData): array
    {
        return JikanModelConverter::convert($animeData);
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
