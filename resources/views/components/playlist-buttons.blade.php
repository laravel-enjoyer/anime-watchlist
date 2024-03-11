@props(['anime'])

@auth
    <div x-data="{ backlogFilled: '{{ auth()->user()->isInPlaylist($anime->id, App\Models\Anime::PLAYLIST_BACKLOG)}}',
                    watchedFilled: '{{ auth()->user()->isInPlaylist($anime->id, App\Models\Anime::PLAYLIST_WATCHED)}}'}">
        <button type="button"
                @click="
                backlogFilled = !backlogFilled;
                sendPlaylistRequest({{ $anime->id }}, '{{ App\Models\Anime::PLAYLIST_BACKLOG }}');
            "
                class="text-blue-700 border border-blue-700 hover:text-blue focus:outline-none hover:ring-2 hover:ring-blue-500 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center me-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-blue dark:focus:ring-blue-800"
                :class="[backlogFilled ? 'bg-blue-500' : '']">
            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                 fill="currentColor" viewBox="0 0 24 24">
                <path
                    d="M7.8 2c-.5 0-1 .2-1.3.6A2 2 0 0 0 6 3.9V21a1 1 0 0 0 1.6.8l4.4-3.5 4.4 3.5A1 1 0 0 0 18 21V3.9c0-.5-.2-1-.5-1.3-.4-.4-.8-.6-1.3-.6H7.8Z"/>
            </svg>

            <span class="sr-only">Backlog</span>
        </button>
        <button type="button"
                @click="
                if (!watchedFilled && backlogFilled) {
                    backlogFilled = false;
                }
                watchedFilled = !watchedFilled;
                sendPlaylistRequest({{ $anime->id }}, '{{ App\Models\Anime::PLAYLIST_WATCHED }}');
            "
                :class="[watchedFilled ? 'bg-green-500' : '']"
                class="text-green-700 border border-blue-700 hover:text-green focus:outline-none hover:ring-2 hover:ring-green-500 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center me-2 dark:border-green-500 dark:text-green-500 dark:hover:text-green dark:focus:ring-green-800">
            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                 fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="m5 12 4.7 4.5 9.3-9"/>
            </svg>
            <span class="sr-only">Watched</span>
        </button>
    </div>
@endauth
