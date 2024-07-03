<?php

use App\DB\Events;

use Livewire\WithoutUrlPagination;

use function Livewire\Volt\{layout, state, title, mount, form, updated,with, usesPagination, uses};

layout('layouts.app');

title(fn () => __('Events'));

usesPagination();
uses(WithoutUrlPagination::class);

state(['filter'=>null]);

state([
    'sortField' => 'day',
    'sortDirection' => 'desc',
    'showCreate' => false,
    'showDelete' =>false,
    'delRecord' => null,
    'taskInfo' => null, //переименовать в eventInfo
    ]);

with(fn () => ['eventsList' => Events::wire_list($this->sortField,$this->sortDirection,$this->filter)->paginate(10)]);

//сортировка по полю
$sortBy = function($field)
{
    $this->sortDirection = $this->sortField === $field
                        ? $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc'
                        : 'asc';

    $this->sortField = $field;
};

//открыть левый sidebar формы создания/редактирования
$openCreate = function()
{
    $this->showCreate = true;
};

//закрыть левый sidebar формы создания/редактирования
$closeCreate = function()
{
    $this->form->reset();
    $this->form->resetValidation();
    $this->showCreate = false;
};

?>

<div>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight" >
            {{ __('Events list') }}
        </h2>
    </x-slot>


    <div class="py-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="flex">
                    <div class="hidden md:block p-3 md:w-[200px] lg:w-[300px] text-gray-500">
                        @if (is_array($taskInfo))
                            <div>{{ __('Events Info') }}</div>
                        @else
                            <div class="">
                                Для отображения информации по задаче нажмите на значок <x-link.icon-show  class="inline-block" /> напротив события.
                            </div>
                        @endif
                    </div>
                    <div class="grow relative overflow-x-auto p-1">
                        <div class="flex">
                            @can('event.create')
                            <div class="p-2 border-r">
                                <x-button.create wire:click="openCreate">{{ __('Add New Event') }}</x-button.create>
                            </div>
                            @endcan
                            <div class="p-2 flex">
                                <div class="p-1 flex-none">{{ __('Event filter') }}</div>

                            </div>
                        </div>
                        <div>
                        <x-table>
                        <x-slot name="header">
                            <x-table.head class="block">
                                {{ __('Event title') }}
                            </x-table.head>
                            <x-table.head class="inline-block"
                                        scope="col"
                                        sortable
                                        wire:click="sortBy('day')"
                                        :direction="$sortField === 'day' ? $sortDirection : null">
                                        {{ __('Event Day') }}
                            </x-table.head>
                            <x-table.head class="inline-block"
                                        scope="col"
                                        sortable
                                        wire:click="sortBy('created_at')"
                                        :direction="$sortField === 'created_at' ? $sortDirection : null">
                                        {{ __('Created_at') }}
                            </x-table.head>
                            <x-table.head class="inline-block">{{ __('Autor') }}</x-table.head>
                        </x-slot>
                        @forelse ($eventsList as $event)
                            <x-table.row wire:key="{{ $event->id }}">
                                <x-table.cell class="block">
                                    <div class="relative items-center">
                                        <div class="flex">
                                            @can('event.edit')
                                            <div class="flex items-center">
                                                <x-link.icon-show  />
                                                <x-link.icon-edit  title="{{ __('Edit') }}" />
                                                @can('event.delete')
                                                <x-button.icon-del  />
                                                @endcan
                                            </div>
                                            @endcan
                                           <div class="ml-2 grow flex items-center">
                                                <div><x-link.table-cell >{{ $event->title }}</x-link.table-cell></div>
                                            </div>
                                        </div>
                                    </div>
                                </x-table.cell>
                                <x-table.cell class="inline-block tabular-nums">{{ $event->day_f }}</x-table.cell>
                                <x-table.cell class="inline-block tabular-nums">{{ $event->created }}</x-table.cell>
                                <x-table.cell class="inline-block">{{ $event->autor->name }}</x-table.cell>
                            </x-table.row>
                        @empty
                            <x-table.row>
                                <x-table.cell class="block text-center" colspan="6">
                                    {{ __('No events found') }}
                                </x-table.cell>
                            </x-table.row>
                        @endforelse
                    </x-table>
                    <div class="m-2"> {{ $eventsList->links() }} </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-sidebar wire:model="showCreate">
        <div class="w-full p-5 text-center shadow font-semibold text-xl">
            {{ __('Add New Event') }}
        </div>
        <div class="p-10 flex-col space-y-2">
            <div>

                <form wire:submit="save">
                </form>

            </div>
        </div>
    </x-sidebar>


    <x-spinner wire:loading wire:target="sortBy" />
    <x-spinner wire:loading wire:target="openCreate" />
    <x-spinner wire:loading wire:target="closeCreate" />

</div>