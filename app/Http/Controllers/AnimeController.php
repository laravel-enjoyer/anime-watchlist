<?php

namespace App\Http\Controllers;

use App\Models\Anime;
use App\Models\Genre;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;


class AnimeController extends Controller
{
    public function index(Request $request)
    {
        $queryParams = $request->query();

        if ($this->isYearParameterIrrelevant($request)) {
            unset($queryParams['year']);

            return redirect()->route('animes', $queryParams);
        }

        if (!$request->has('sorting')) {
            $queryParams['sorting'] = 'rating';

            return redirect()->route('animes', $queryParams);
        }

        $queryFilters = ['search', 'type', 'status', 'genre', 'year', 'sorting'];

        if (auth()->check()) {
            $queryFilters[] = 'playlist';
        }

        $animes = Anime::filter(
            request($queryFilters)
        )->with('genres');

        if (auth()->check()) {
            $user = auth()->user();
            $animes->with(['users' => function ($query) use ($user) {
                $query->where('user_id', $user->id);
            }]);
        }

//        dd($animes->toRawSql());

        $animes = $animes->paginate(30)->withQueryString();

        $filters = $this->getFilterValues();

        return view('animes.index', [
            'animes' => $animes,
            'filters' => $filters,
        ]);
    }

    public function show(int $id): View
    {
        $anime = Anime::with('genres')->find($id);

        if (auth()->check()) {
            $anime->load(['users' => function ($query) {
                $query->where('user_id', auth()->id());
            }]);
        }

        return view('animes.show', compact('anime'));
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

        $genres = Genre::all();

        $sorting = ['rating', 'name'];

        return compact('types', 'statuses', 'genres', 'years', 'sorting');
    }

    private function isYearParameterIrrelevant(Request $request): bool
    {
        return $request->has('status') &&
            $request->filled('year') &&
            in_array(Anime::STATUS_FINISHED_RECENTLY, $request->input('status'));
    }
}
