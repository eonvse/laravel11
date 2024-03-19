@props(['id', 'maxWidth'])

@php
$id = $id ?? md5($attributes->wire('model'));

$maxWidth = [
    'sm' => 'sm:max-w-sm',
    'md' => 'sm:max-w-md',
    'lg' => 'sm:max-w-lg',
    'xl' => 'sm:max-w-xl',
    '2xl' => 'sm:max-w-2xl',
][$maxWidth ?? 'md'];
@endphp

<div
    x-data="{ show: @entangle($attributes->wire('model')) }"
    x-modelable="show"
    x-on:close.stop="show = false"
    x-on:keydown.escape.window="show = false"
    x-show="show"
    id="{{ $id }}"
    class="flex items-center justify-center fixed inset-0 overflow-y-auto z-[100]"
    style="display: none;"
>
    <div x-show="show" class="fixed inset-0 transform transition-all" x-on:click="show = false" x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0">
        <div class="absolute inset-0 bg-gray-500 opacity-50"></div>
    </div>

    <div x-show="show" class="bg-white absolute top-0 left-0 h-screen overflow-hidden transform transition-all sm:w-full {{ $maxWidth }} dark:bg-gray-400"
                    x-trap.inert.noscroll="show"
                    x-transition:enter="ease-in-out duration-500"
                    x-transition:enter-start="opacity-0 -translate-x-full"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0 -translate-x-full">
        {{ $slot }}
    </div>
</div>
