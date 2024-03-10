<?php

namespace App\Http\Controllers;

use App\Models\Anime;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PlaylistController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'status' => [
                'required',
                 Rule::in([Anime::PLAYLIST_BACKLOG, Anime::PLAYLIST_WATCHED]),
            ],
            'animeId' => 'required|exists:anime,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error'
            ]);
        }

        $user = auth()->user();
        $status = $request->get('status');
        $animeId = $request->get('animeId');

        $anime = $user->anime()->where('anime.id', $animeId)->wherePivot('status', $status)->first();

        $displayStatus = ucfirst($status);

        if ($anime) {
            $msg = "Anime removed from '$displayStatus'";
            //TODO: Detach for given status (currently detaching all)
            $user->anime()->wherePivot('status', $status)->detach($animeId);
        } else {
            $msg = "Anime added to '$displayStatus'";
            $user->anime()->attach($animeId, ['status' => $status]);

            if ($status == Anime::PLAYLIST_WATCHED) {
                $user->anime()->wherePivot('status', Anime::PLAYLIST_BACKLOG)->detach($animeId);
            }
        }

        session()->flash('text', $msg);

        return response()->json([
            'status' => 'success',
            'message' => $msg
        ]);
    }
}
