<?php

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Illuminate\Support\Facades\DB;

use function Livewire\Volt\{layout, mount, state, title};

layout('layouts.app');
title('Roles');

state(['roles']);
state([
    'sortField' => 'name',
    'sortDirection' => 'asc'
]);

mount(function () {
    $this->roles = Role::orderBy($this->sortField,$this->sortDirection)->get();
});







?>

<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Roles') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <x-table>
                    <x-slot name="header">
                        <x-table.head>ID</x-table.head>
                        <x-table.head
                                sortable
                                wire:click="sortBy('name')"
                                :direction="$sortField === 'name' ? $sortDirection : null">
                                {{ __('Role Name') }}
                        </x-table.head>
                        <x-table.head>{{ __('Role Permissions') }}</x-table.head>
                        <x-table.head>{{ __('Action') }}</x-table.head>
                        </tr>
                    </x-slot>
                    @forelse ($roles as $role)
                    <x-table.row>
                        <x-table.cell scope="row">{{ $role->id }}</x-table.cell>
                        <x-table.cell>{{ $role->name }}</x-table.cell>
                        <x-table.cell>
                            @if ($role->name=='Super Admin')
                                <x-marker.permission name="{{ __('All') }}" />
                            @else
                                @forelse ($role->permissions as $permission)
                                <x-marker.permission :name="$permission->name" />
                                @empty
                                -
                                @endforelse
                            @endif
                        </x-table.cell>
                        <x-table.cell>
                            <div class="flex items-center">
                                @if ($role->name!='Super Admin')
                                    @can('role.edit')
                                        <x-link.icon-edit wire:click="openEdit({{ $role->id }})" title="{{ __('Edit') }}"/>
                                    @endcan
                                    @can('role.delete')
                                        @if ($role->name!=Auth::user()->hasRole($role->name))
                                            <x-button.icon-del wire:click="openDelete({{ $role->id }})" title="{{ __('Delete') }}" />
                                        @endif
                                    @endcan
                                @endif
                            </div>
                        </x-table.cell>
                    </x-table.row>
                    @empty
                    <x-table.row>
                        <x-table.cell colspan="4">
                            <div class="text-center p-1">
                                <strong>{{ __('No Role Found!') }}</strong>
                            </div>
                        </x-table.cell>
                    </x-table.row>
                    @endforelse
                </x-table>
            </div>
        </div>
    </div>
</div>
