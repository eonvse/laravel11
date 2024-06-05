<div {{ $attributes->merge(['class'=>'overflow-y-auto cursor-pointer dark:text-gray-300']) }}
    x-data="{ tooltip: false }"
    x-on:mouseover="tooltip = true"
    x-on:mouseleave="tooltip = false">
    @isset($tooltip)
    <div x-cloak x-show="tooltip" class="z-50 px-2 border absolute left-3/4 top-3/4 bg-yellow-100 text-black p-1 overflow-hidden transform transition-all rounded my-1 dark:bg-gray-500">
        {{ $tooltip }}
    </div>
    @endisset
    <div class="z-40">{{ $slot }}</div>

</div>
