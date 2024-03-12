<?php

namespace App\Http\Controllers;

use App\Services\AnimeUpdater;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AnimeSyncController extends Controller
{
    public function __construct(protected AnimeUpdater $animeUpdater)
    {

    }

    public function sync(): void
    {
        if (Cache::has('anime_synced')) {
            return;
        }

        $this->animeUpdater->updateAnime();

        Cache::add('anime_synced', true, now()->addHours(20));
    }
}
