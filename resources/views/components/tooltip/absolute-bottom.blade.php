<div {{ $attributes->merge(['class'=>'cursor-pointer']) }} 
    x-data="{ tooltip: false }" 
    x-on:mouseover="tooltip = true" 
    x-on:mouseleave="tooltip = false">
    {{ $slot }}
    @isset($tooltip)
    <div x-cloak x-show="tooltip" {{ $attributes->merge(['class'=>'absolute z-50 left-0 bottom-0 p-2 overflow-hidden shadow-xl transform transition-all sm:w-full sm:mx-auto tabular-nums']) }}>
        {{ $tooltip }}
    </div>
    @endisset
</div>
