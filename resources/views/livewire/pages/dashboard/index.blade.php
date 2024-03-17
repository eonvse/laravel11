<?php

use function Livewire\Volt\{state};

//

?>

<div>
    <div class="grid grid-cols-2">
        <div class="row-span-3 border">Основное окно</div>
        <div class="min-h-32 border">Блок 1</div>
        <div class="min-h-32 border">Блок 2</div>
        <div class="min-h-32 border">
            @canany(['log.view','role.view','user.view'])
            <div class="p-4">{{ __('Management') }}</div>
            <div class="">
                @can('role.view')
                <x-dropdown-link href="{{ route('roles') }}" :active="request()->routeIs('roles*')">
                    {{ __('Roles') }}
                </x-dropdown-link>
                @endcan

                @can('log.view')
                <div class="border-t border-gray-200 dark:border-gray-600"></div>
                <x-dropdown-link href="/log-viewer" target="_blank">
                    {{ __('Logs') }}
                </x-dropdown-link>
                @endcan
            </div>
            @endcanany
        </div>
        <div class="col-span-2 min-h-5 border">Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})</div>
    </div>
</div>
