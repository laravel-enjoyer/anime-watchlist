@props(['anime', 'id'])

<div data-popover id="{{$id}}" role="tooltip" class="absolute z-10 invisible hidden md:inline-block text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 w-72 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400">
    <div class="p-3 space-y-2 flex-col">
        <h1 class="font-semibold text-gray-900 dark:text-white text-lg">{{ $anime->title }}</h1>
        <div class="border-b border-gray-600"></div>

        <div class="overflow-hidden overflow-ellipsis max-w-xs max-h-32 mb-2">
            <div class="line-clamp-6">
                {{ $anime->description }}
            </div>

        </div>
        <div class="flex space-x-2 space-between w-full text-gray-300">
            <h3 class="font-semibold text-gray-900 dark:text-white">Type: </h3>
            <div class="">
                {{ $anime->type }}
            </div>
            <div class="">
                {{ $anime->year }}
            </div>
            <div class="">
                @includeWhen($anime->status === App\Models\Anime::STATUS_FINISHED, 'components.status-badge-finished', ['text' => $anime->status])
                @includeWhen($anime->status === App\Models\Anime::STATUS_ONGOING, 'components.status-badge-ongoing', ['text' => $anime->status])
                @includeWhen($anime->status === App\Models\Anime::STATUS_UPCOMING, 'components.status-badge-upcoming', ['text' => $anime->status])
            </div>
        </div>
        @if ($anime->episodes)
        <div class="flex space-x-2 w-full text-gray-300">
            <h3 class="font-semibold text-gray-900 dark:text-white">Episodes: </h3>
            <span>{{ $anime->episodes }}</span>
        </div>
        @endif
        @if ($anime->aired_from)
            <div class="flex space-x-2 w-full text-gray-300">
                <h3 class="font-semibold text-gray-900 dark:text-white">Aired: </h3>
                <span>{{ $anime->aired_from }}</span>
            </div>
        @endif @if ($anime->aired_to)
            <div class="flex space-x-2 w-full text-gray-300">
                <h3 class="font-semibold text-gray-900 dark:text-white">Finished: </h3>
                <span>{{ $anime->aired_to }}</span>
            </div>
        @endif
        @if ($anime->genres)
        <div class="flex space-x-2 w-full text-gray-300">
            <h3 class="font-semibold text-gray-900 dark:text-white">Genres: </h3>
            <div class="flex flex-wrap">
                @foreach ($anime->genres as $genre)
                    <div class="flex-shrink-0 mr-2">
                        {{$genre->name}}
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        @auth
            <button type="button" class="text-blue-700 border border-blue-700 hover:bg-blue-700 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center me-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:focus:ring-blue-800 dark:hover:bg-blue-500">
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 18">
                    <path d="M3 7H1a1 1 0 0 0-1 1v8a2 2 0 0 0 4 0V8a1 1 0 0 0-1-1Zm12.954 0H12l1.558-4.5a1.778 1.778 0 0 0-3.331-1.06A24.859 24.859 0 0 1 6 6.8v9.586h.114C8.223 16.969 11.015 18 13.6 18c1.4 0 1.592-.526 1.88-1.317l2.354-7A2 2 0 0 0 15.954 7Z"/>
                </svg>
                <span class="sr-only">Icon description</span>
            </button>
            <button type="button" class="text-blue-700 border border-blue-700 hover:bg-blue-700 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center me-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:focus:ring-blue-800 dark:hover:bg-blue-500">
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 18">
                    <path d="M3 7H1a1 1 0 0 0-1 1v8a2 2 0 0 0 4 0V8a1 1 0 0 0-1-1Zm12.954 0H12l1.558-4.5a1.778 1.778 0 0 0-3.331-1.06A24.859 24.859 0 0 1 6 6.8v9.586h.114C8.223 16.969 11.015 18 13.6 18c1.4 0 1.592-.526 1.88-1.317l2.354-7A2 2 0 0 0 15.954 7Z"/>
                </svg>
                <span class="sr-only">Icon description</span>
            </button>
        @endauth

        <div class="border-b border-gray-600"></div>

        @if ($anime->score)
        <div class="flex space-x-2 w-full text-gray-300">
            <h1 class="font-semibold text-gray-900 dark:text-white text-lg">Score: </h1>
            <span class="text-lg">{{ $anime->score }}</span>
        </div>
        @endif
    </div>
    <div data-popper-arrow></div>
</div>
