<?php

use function Livewire\Volt\{state};

//

?>

<div>
    <div class="sm:grid sm:grid-cols-2">
        <div class="row-span-3 border-r border-r-gray-300">
            <div class="p-3 border-b text-black font-medium bg-gray-200">Основное окно</div>
            <div>
                @can('task.view')
                <x-dropdown-link href="{{ route('tasks') }}" wire:navigate>
                    {{ __('Tasks') }}
                </x-dropdown-link>
                @endcan
            </div>
        </div>
        <div class="min-h-32 border-b">
            <div class="p-3 border-b text-black font-medium bg-gray-200">Блок 1</div>
        </div>
        <div class="border-b">
            <div class="p-3 border-b text-black font-medium bg-gray-200">{{ __('Account') }}: {{ auth()->user()->name }}</div>
            <div class="p-2 border-b">
                @foreach (auth()->user()->getRoleNames() as $roleName)
                <x-marker.role  :name="$roleName" />
                @endforeach
            </div>
            <div class="">
                <x-dropdown-link :href="route('profile')" wire:navigate>
                    {{ __('Profile') }}
                </x-dropdown-link>
            </div>
        </div>
        <div class="border-b">
            @canany(['log.view','role.view','user.view'])
            <div class="p-3 text-black font-medium bg-gray-200">{{ __('Management') }}</div>
            <div class="">
                @can('role.view')
                <x-dropdown-link href="{{ route('roles') }}" wire:navigate >
                    {{ __('Roles') }}
                </x-dropdown-link>
                @endcan

                @can('user.view')
                <x-dropdown-link href="{{ route('users') }}" wire:navigate >
                    {{ __('Users') }}
                </x-dropdown-link>
                @endcan

                @can('log.view')
                <div class="border-t border-gray-200 dark:border-gray-600"></div>
                <x-dropdown-link href="{{ env('APP_URL') }}/log-viewer" target="_blank">
                    {{ __('Logs') }}
                </x-dropdown-link>
                @endcan
            </div>
            @endcanany
        </div>
    </div>
    <div class="mt-3 text-center text-gray-500">Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})</div>
</div>
