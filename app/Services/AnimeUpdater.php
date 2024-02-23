<?php

namespace App\Services;

use App\Models\Anime;

class AnimeUpdater
{
    public function __construct(protected IAnimeService $animeService)
    {

    }

    public function updateAnime(): void
    {
        $animeData = $this->animeService->getCurrentSeasonAnime();


        /* TODO:
           1. retrieve data from db for current season and compare to existing data
           2. if not found entry, add new
           3. if found entry, update existing

         */

//        Anime::with();
        foreach ($animeData as $anime) {
            print_r($anime['mal_id']. PHP_EOL);
        }
    }
}
