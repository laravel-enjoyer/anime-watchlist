<x-app-layout>
    @include ('animes._filter-bar')
    <div class="max-w-6xl mx-auto mt-6 lg:mt-20 space-y-6 pb-20 flex-grow p-4">
        @if ($animes->count())
            <x-animes-grid :animes="$animes"/>

            <div class="pt-6">
                {{ $animes->links() }}
            </div>
        @else
            <p class="text-2xl text-white">List is currently empty</p>
        @endif
    </div>
</x-app-layout>
