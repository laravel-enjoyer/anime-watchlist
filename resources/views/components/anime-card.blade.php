@props(['anime'])

<article {{ $attributes->merge(['class' => '']) }}
         id="{{ $anime->id }}"
         data-popover-target="anime-popover-{{ $anime->id }}" data-popover-placement="right">
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

<x-anime-popup
    :anime="$anime"
    id="anime-popover-{{ $anime->id }}"
/>
