<x-app-layout>
    <div class="max-w-6xl mx-auto mt-6 lg:mt-20 space-y-6 pb-20  p-4">
        @props(['anime'])

        <article class="container flex flex-col" id="{{ $anime->id }}">
            <div class="flex flex-col md:flex-row space-x-4">
                <img class="rounded-lg self-center" alt="{{ $anime->title }}" src="{{ $anime->picture }}" width="250px"
                     style="height: 350px!important">

                <div class="p-3 space-y-2 md:flex-2">
                    <h1 class="font-semibold text-gray-900 dark:text-white text-lg">{{ $anime->title }}</h1>
                    <div class="border-b border-gray-600"></div>

                    <div class="flex space-x-2 space-between w-full text-gray-300">
                        <h3 class="font-semibold text-gray-900 dark:text-white">Type: </h3>
                        <div class="">
                            {{ $anime->type }}
                        </div>
                    </div>
                    <div class="flex space-x-2 w-full text-gray-300">
                        <h3 class="font-semibold text-gray-900 dark:text-white">Season: </h3>
                        <span>{{ $anime->season. ' '. $anime->year }}</span>
                    </div>
                    <div class="flex space-x-2 w-full text-gray-300">
                        <h3 class="font-semibold text-gray-900 dark:text-white">Status: </h3>
                        @includeWhen($anime->status === App\Models\Anime::STATUS_FINISHED, 'components.status-badge-finished', ['text' => $anime->status])
                        @includeWhen($anime->status === App\Models\Anime::STATUS_ONGOING, 'components.status-badge-ongoing', ['text' => $anime->status])
                        @includeWhen($anime->status === App\Models\Anime::STATUS_UPCOMING, 'components.status-badge-upcoming', ['text' => $anime->status])
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
                    @if (!$anime->genres->isEmpty())
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

                    <x-playlist-buttons :anime="$anime"/>

                    <div class="border-b border-gray-600"></div>

                    @if ($anime->score)
                        <div class="flex space-x-2 w-full text-gray-300">
                            <h1 class="font-semibold text-gray-900 dark:text-white text-lg">Score: </h1>
                            <span class="text-lg">{{ $anime->score }}</span>
                        </div>
                    @endif
                </div>
            </div>

            @if ($anime->description)
                <div class="border-b border-gray-600 mt-4"></div>
                <div class="mb-2 text-white mt-4">
                    {{ $anime->description }}
                </div>
            @endif
        </article>
    </div>
</x-app-layout>
