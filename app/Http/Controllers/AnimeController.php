<?php

namespace App\Http\Controllers;

use App\Models\Anime;
use View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;


class AnimeController extends Controller
{
    public function index()
    {
        $animes = Anime::orderByRaw('`rank` is NULL ASC')
            ->orderBy('rank')
            ->orderByRaw('`score` is NULL ASC')
            ->paginate(30)
            ->withQueryString();


        $filters = $this->getFilterValues();

        return view('animes.index', [
            'animes' => $animes,
            'filters' => $filters,
        ]);
    }

    public function getRenderedData(Request $request): string
    {
        $animes = Anime::orderByRaw('`rank` is NULL ASC')
            ->orderBy('rank')
            ->orderByRaw('`score` is NULL ASC')
            ->paginate(30)
            ->withQueryString();

        $output = View::make("components.animes-grid")
            ->with('animes', $animes)
            ->render();

        return $output;
    }

    public function show(int $id): View
    {
        $anime = Anime::findOrFail($id);

        return view('anime.show', compact('anime'));
    }

    protected function getFilterValues(): array
    {
        $types = array_diff(Anime::getTypes(), [Anime::TYPE_UNKNOWN, Anime::TYPE_MUSIC]);

        $statuses = [
            Anime::STATUS_ONGOING,
            Anime::STATUS_FINISHED_RECENTLY,
            Anime::STATUS_FINISHED,
            Anime::STATUS_UPCOMING
        ];

        $minYear = Cache::rememberForever('anime_filter_min_year', function () {
            return Anime::min('year');
        });

        $years = array_map('intval', range($minYear, date('Y')));
        rsort($years);

        $sorting = ['rating', 'name'];

        return compact('types', 'statuses', 'years', 'sorting');
    }
}
