<?php

namespace Database\Seeders;

use App\Models\Genre;
use App\Services\IAnimeService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    public function __construct(protected IAnimeService $animeService)
    {

    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $genres = $this->animeService->getGenreList();

        foreach ($genres as $genre) {
            Genre::create([
                'name' => $genre['name']
            ]);
        }
    }
}
