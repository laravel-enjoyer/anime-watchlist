@props(['anime'])

{{--<article class=" {{ $attributes->merge(['class' =>"transition-colors duration-300 hover:bg-gray-100 border border-black border-opacity-0 hover:border-opacity-5 rounded-xl "]) }}"--}}
{{--         id="{{ $anime->id }}">--}}
{{--    <a class=""--}}
{{--       href="{{ route('anime.show', ['id' => $anime->id]) }}">--}}

{{--        <img class="rounded-lg max-w-[225px] max-h-[320px]" alt="{{ $anime->title }}"--}}
{{--             src="{{  $anime->thumbnail }}">--}}

{{--        <div class="flex flex-wrap flex-shrink-0">--}}
{{--            <span class="text-white truncate max-w-[150px] flex-shrink-0">{{ $anime->title }}</span>--}}
{{--            <div class="flex-grow"></div>--}}
{{--            <span class="text-white ml-auto mr-1">{{ $anime->type }}</span>--}}
{{--            <span class="text-white">{{ $anime->year }}</span>--}}
{{--        </div>--}}
{{--    </a>--}}
{{--</article>--}}

<article {{ $attributes->merge(['class' => '']) }}
         id="{{ $anime->id }}">
    <a href="{{ route('anime.show', ['id' => $anime->id]) }}" class="flex flex-col h-full">
        <img class="rounded-lg" alt="{{ $anime->title }}" src="{{ $anime->thumbnail }}" width="235px" style="height: 320px!important">
        <div class="flex flex-col flex-wrap items-center justify-between p-2">
            <span class="text-white truncate max-w-[220px]">{{ $anime->title }}</span>
            <div class="flex justify-between items-center flex-shrink-0">
                <span class="text-white ml-1">{{ $anime->type }}</span>
                <span class="text-white ml-2">{{ $anime->year }}</span>
            </div>
        </div>
    </a>
</article>

