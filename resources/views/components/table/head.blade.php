@props([
    'sortable',
    'direction'
])

<th {{ $attributes->merge(['class' => 'px-6 py-1 text-cyan-900 dark:text-cyan-200 text-xs sm:table-cell']) }}>
    @isset($sortable)
    <div class="flex">
        <span class="underline {{ isset($direction) ? 'decoration-solid' : 'decoration-dotted' }} hover:cursor-pointer" title="Сортировать">{{$slot}}</span>
        @isset($direction)
            @if ($direction=='desc')
                <span><svg class="h-4 w-4"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <polyline points="18 15 12 9 6 15" /></svg></span>
            @else
                <span><svg class="h-4 w-4"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <polyline points="6 9 12 15 18 9" /></svg></span>
            @endif
        @endisset
    </div>
    @else

        {{$slot}}

    @endisset
</th>
