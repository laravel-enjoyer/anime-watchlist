<?php

namespace Database\Seeders;

use App\Models\Anime;
use App\Models\Genre;
use App\Services\IAnimeService;
use Illuminate\Database\Seeder;

class MyAnimeListSeeder extends Seeder
{
    public function __construct(protected IAnimeService $animeService)
    {

    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $seasonList = $this->animeService->getSeasonsList();

        while (!empty($seasonList)) {
            $seasonData = array_pop($seasonList);

            $year = $seasonData['year'];

            foreach ($seasonData['seasons'] as $season) {
                $this->command->info("Processing season $year - $season");

                $seasonAnime = $this->animeService->getSeasonAnime($year, $season);

                foreach ($seasonAnime as $animeData) {
                    $convertedData = $this->animeService->convertToModelData($animeData);

                    if (!$convertedData['year']) {
                        $convertedData['year'] = $year;
                    }

                    if ($convertedData['season'] == Anime::SEASON_UNKNOWN) {
                        $convertedData['season'] = $season;
                    }

                    $synonyms = $convertedData['synonyms'];
                    unset($convertedData['synonyms']);

                    $genres = $convertedData['genres'];
                    unset($convertedData['genres']);

                    $anime = Anime::firstOrCreate(['mal_id' => $convertedData['mal_id']], $convertedData);

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

                $this->command->info("Finished processing season $year - $season");

                // prevent rate limiting
                sleep(1);
            }
        }
    }
}
