<?php

namespace App\Services;

use App\Models\Anime;
use App\Models\Genre;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AnimeUpdater
{
    public function __construct(protected IAnimeService $animeService)
    {

    }

    public function updateAnime(): void
    {
        Log::info('Beginning anime sync');

        $currentSeason = $this->animeService->getCurrentSeasonAnime();

        $this->updateCurrentSeason($currentSeason);

        $excludeIDs = array_column($currentSeason, 'mal_id');

        $this->updateOngoingsAndUpcomings($excludeIDs);
    }

    private function updateOngoingsAndUpcomings(array $excludeIDs): void
    {
        $oldOngoings = Anime::where('status', Anime::STATUS_ONGOING)
            ->where(function ($query) {
                $query->whereDate('aired_to', '<', now())
                    ->orWhereNull('aired_to');
            })
            ->whereNotIn(DB::raw('CAST(mal_id AS UNSIGNED)'), $excludeIDs)->get();

        $upcomings = Anime::where('status', Anime::STATUS_UPCOMING)
            ->where(function ($query) {
                $query->whereDate('aired_from', '<', now())
                    ->orWhereNull('aired_from');
            })
            ->whereNotIn(DB::raw('CAST(mal_id AS UNSIGNED)'), $excludeIDs)->get();

        $animes = $oldOngoings->concat($upcomings);

        foreach ($animes as $anime) {
            $animeData = $this->animeService->getAnimeDataByRemoteID($anime->getAttribute('mal_id'));

            $animeData['year'] = $anime->getAttribute('year');
            $animeData['season'] = $anime->getAttribute('season');

            $this->updateRecord($animeData);

            // prevent rate limiting
//            sleep(1);
            self::delay(1000);
        }
    }

    private function updateCurrentSeason(array $currentSeasonAnime): void
    {
        foreach ($currentSeasonAnime as $animeData) {
            if (!$animeData['year']) {
                $animeData['year'] = date('Y');
            }

            if (!$animeData['season']) {
                $animeData['season'] = Anime::getCurrentSeason();
            }

            $this->updateRecord($animeData);
        }
    }

    private function updateRecord(array $animeData): void
    {
        $convertedData = $this->animeService->convertToModelData($animeData);

        $synonyms = $convertedData['synonyms'];
        unset($convertedData['synonyms']);

        $genres = $convertedData['genres'];
        unset($convertedData['genres']);

        $anime = Anime::updateOrCreate(['mal_id' => $convertedData['mal_id']], $convertedData);

        Log::info("Updated anime: id: $anime->id, mal_id: $anime->mal_id, title:$anime->title");

        if ($anime->wasRecentlyCreated) {
            $anime->synonyms()->createMany(array_map(
                fn($value) => ['name' => $value],
                $synonyms
            ));

            $genres = collect($genres)->map(function ($name) {
                return Genre::firstOrCreate(['name' => $name]);
            });

            $anime->genres()->sync($genres->pluck('id'));
        }
    }

    public static function delay(float $milliseconds) {
        $microseconds = $milliseconds * 1000;
        $start = microtime(true);
        while (microtime(true) - $start < $milliseconds / 1000) {
            // Do nothing, just wait
        }
    }

}
