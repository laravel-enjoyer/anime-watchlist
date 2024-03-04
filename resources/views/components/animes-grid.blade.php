@props(['animes'])

@if ($animes->count() >= 1)
    <div class="flex flex-wrap justify-center space-x-4 space-y-4">
        @foreach ($animes as $key => $anime)
            <x-anime-card
                :anime="$anime"
                class="{{ $key === 0 ? 'mt-4 ml-4' : '' }}"
            />
        @endforeach
    </div>
@endif
