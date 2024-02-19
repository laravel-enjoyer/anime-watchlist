<?php

namespace Database\Seeders;

use App\Models\Anime;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use JsonMachine\Exception\InvalidArgumentException;
use JsonMachine\Items;
use JsonMachine\JsonDecoder\ExtJsonDecoder;

class AnimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @throws InvalidArgumentException
     */
    public function run(): void
    {
        // Read the JSON file
        $data = Items::fromFile(
            database_path('seeders/data/anime-offline-database.json'),
            ['decoder' => new ExtJsonDecoder(true), 'pointer' => '/data']
        );
        // Iterate over each anime data and insert into database
        foreach ($data as $animeData) {
            $anime = new Anime();
            $anime->title = $animeData['title'];
            $anime->type = $animeData['type'];
            $anime->episodes = $animeData['episodes'];
            $anime->status = $animeData['status'];

            $season = $animeData['animeSeason']['season'];
            $anime->season = $season == 'UNDEFINED' ? 'UNKNOWN' : $season;
            $anime->year = $animeData['animeSeason']['year'] ?? null;
            $anime->picture = $animeData['picture'];
            $anime->thumbnail = $animeData['thumbnail'];
            $anime->save();

            // Attach tags to anime
            $anime->tags()->createMany(array_map(
                fn($value) => ['name' => $value],
                $animeData['tags']
            ));

            $anime->synonyms()->createMany(array_map(
                fn($value) => ['name' => $value],
                $animeData['synonyms']
            ));
        }
    }
}
