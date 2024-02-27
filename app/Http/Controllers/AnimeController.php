<?php

namespace App\Http\Controllers;

use App\Models\Anime;
use Illuminate\Http\Request;

class AnimeController extends Controller
{
    public function index()
    {
        $animes = Anime::latest()->filter(
            request(['search', 'category', 'author'])
        )->with('category', 'author')->paginate(50)->withQueryString();

        return view('animes.index', [
            'animes' => $animes,
        ]);
    }
}
