<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AnimeUserController extends Controller
{
    public function markAsWatched(Request $request, $animeId): RedirectResponse
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:watched,to_watch',
        ]);

        // If the validation fails, redirect back with error messages
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Retrieve the authenticated user
        $user = auth()->user();

        // Add the anime to the user's watched list with the provided status
        $user->anime()->syncWithoutDetaching([$animeId => ['status' => $request->input('status')]]);

        return redirect()->back()->with('success', 'Anime marked as watched successfully.');
    }

    public function watchedList(): View
    {
        // Retrieve the authenticated user
        $user = auth()->user();

        // Retrieve the user's watched anime list
        $watchedList = $user->anime()->wherePivot('status', 'watched')->get();

        return view('watched-anime', compact('watchedList'));
    }

    public function backlogList(): View
    {
        // Retrieve the authenticated user
        $user = auth()->user();

        // Retrieve the user's watched anime list
        $backlogList = $user->anime()->wherePivot('status', 'to_watch')->get();

        return view('watched-anime', compact('backlogList'));
    }
}
