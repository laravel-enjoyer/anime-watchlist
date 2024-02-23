<?php
namespace App\Services;

use App\Models\Anime;

interface IAnimeService
{
    public function getCurrentSeasonAnime(): array;

    public function getSeasonsList(): array;

    public function getSeasonAnime(int $year, string $season);

    public function getGenreList(): array;

    public function convertToModelData(array $animeData): array;
}
