<?php

use App\DB\Tasks;
use App\Models\Color;

use App\Livewire\Forms\TaskCreateForm;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
//Log::debug('selectedPermissions = ' . implode(',',$this->selectedPermissions));
//Log::notice('---Volt Roles---');

use function Livewire\Volt\{layout, state, title, mount, form};
 
layout('layouts.app');
 
title(fn () => __('Tasks'));

state(['colors','tasksList']);

state([
    'sortField' => 'created_at',
    'sortDirection' => 'desc',
    'filter' => null,
    'showCreate' => false,
    'showDelete' =>false,
    'delRecord' => null,
    'taskInfo' => null
]);

form(TaskCreateForm::class);

mount(function() {
    $this->colors = Color::orderBy('base')->get()->toArray();
    $this->tasksList = Tasks::wire_list($this->sortField,$this->sortDirection,$this->filter)->get();
});

$sortBy = function($field)
{
    $this->sortDirection = $this->sortField === $field
                        ? $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc'
                        : 'asc';

    $this->sortField = $field;
    $this->tasksList = Tasks::wire_list($this->sortField,$this->sortDirection,$this->filter)->get();
};

$openCreate = function()
{
    $this->showCreate = true;
};

$closeCreate = function()
{
    $this->form->reset();
    $this->form->resetValidation();
    $this->showCreate = false;
};

$save = function()
{
    $message = "Задача: " . $this->form->nameTask . " добавлена.";

    $this->form->store();

    $this->dispatch('banner-message', style:'success', message: $message);

    $this->tasksList = Tasks::wire_list($this->sortField,$this->sortDirection,$this->filter)->get();
    $this->closeCreate();

};

$openDelete=function($task_id)
{
    $this->delRecord = Tasks::getDelMessage($task_id);
    $this->showDelete = true;
};

$closeDelete=function()
{
    $this->delRecord = null;
    $this->showDelete = false;
};

$destroy=function($task_id)
{
    $message = "Удалена задача: " . $this->delRecord->name;
    Tasks::delete($task_id);
    $this->closeDelete();
    $this->dispatch('banner-message', style:'danger', message: $message);
    $this->tasksList = Tasks::wire_list($this->sortField,$this->sortDirection,$this->filter)->get();
    $this->resetInfo();

};

$infoTask=function($task_id)
{
    $task = Tasks::get($task_id)->toArray();
    $this->taskInfo = $task;//'<strong>Задача:</strong><br />'.$task->name.'<br /><strong>Содержание:</strong><br />'.$task->content;
};

$resetInfo=function()
{
    $this->taskInfo = null;
};




?>

<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight" >
            {{ __('Tasks list') }}
        </h2>
    </x-slot>

    <div class="py-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="flex">
                <div class="hidden md:block p-3 md:w-[200px] lg:w-[300px] text-gray-500">
                    @if (is_array($taskInfo))
                        <div>{{ __('Task name') }}</div>
                        <div class="text-black font-medium border-b">{{ $taskInfo['name'] }}</div>
                        @isset($taskInfo['content'])
                        <div>{{ __('Task content') }}</div>
                        <div class="text-black font-medium border-b">{!! $taskInfo['content'] !!}</div>
                        @endisset
                        @isset($taskInfo['day'])
                        <div>{{ __('Event Day') }}</div>
                        <div class="text-black font-medium border-b">{{ date('d.m.Y', strtotime($taskInfo['day'])) }}</div>
                        @endisset
                        @isset($taskInfo['start'])
                        <div>{{ __('Start') }}</div>
                        <div class="text-black font-medium border-b">{{ date('H:i', strtotime($taskInfo['start'])) }}</div>
                        @endisset
                        @isset($taskInfo['end'])
                        <div>{{ __('End') }}</div>
                        <div class="text-black font-medium border-b">{{ date('H:i', strtotime($taskInfo['end'])) }}</div>
                        @endisset
                    @else
                        Для отображения информации наведите указателем мыши на задачу.
                    @endif
                </div>
                <div class="grow relative overflow-x-auto p-1">
                    @can('task.create')
                    <div class="p-2" x-on:mouseover="$wire.resetInfo()">
                        <x-button.create wire:click="openCreate">{{ __('Add New Task') }}</x-button.create>
                    </div>
                    @endcan
                    <x-table>
                        <x-slot name="header">
                            <x-table.head class="block">
                                {{ __('Task name') }}
                            </x-table.head>
                            <x-table.head class="inline-block" 
                                        x-on:mouseover="$wire.resetInfo()"
                                        scope="col"
                                        sortable
                                        wire:click="sortBy('day')"
                                        :direction="$sortField === 'day' ? $sortDirection : null">
                                        {{ __('Event Day') }}
                            </x-table.head>
                            <x-table.head class="inline-block" 
                                        x-on:mouseover="$wire.resetInfo()"
                                        scope="col"
                                        sortable
                                        wire:click="sortBy('created_at')"
                                        :direction="$sortField === 'created_at' ? $sortDirection : null">
                                        {{ __('Created_at') }}
                            </x-table.head>
                            <x-table.head class="inline-block">{{ __('Autor') }}</x-table.head>
                            @can('task.edit')
                            <x-table.head class="block">{{ __('Action') }}</x-table.head>
                            @endcan
                        </x-slot>
                        @forelse ($tasksList as $task)
                            <x-table.row wire:key="{{ $task->id }}" x-on:mouseover="$wire.infoTask({{ $task->id }})" >
                                <x-table.cell class="block">
                                    <div class="relative items-center">
                                        <x-tooltip.bottom-cell class="px-2">
                                            <div class="flex items-center">
                                                <div class="w-4 mx-1 {{ $task->color->base ?? '' }} dark:{{ $task->color->dark ?? '' }}">&nbsp;</div>
                                                <div><x-link.table-cell href="">{{ $task->name }}</x-link.table-cell></div>
                                            </div>
                                        </x-tooltip.bottom-cell>
                                    </div>
                                </x-table.cell>
                                <x-table.cell class="inline-block tabular-nums">{{ $task->day_format }}</x-table.cell>
                                <x-table.cell class="inline-block tabular-nums">{{ $task->created }}</x-table.cell>
                                <x-table.cell class="inline-block">{{ $task->autor->name }}</x-table.cell>
                                @can('task.edit')
                                <x-table.cell class="block">
                                    <div class="flex items-center">
                                    <x-link.icon-edit />
                                    @can('task.delete')
                                    <x-button.icon-del  wire:click="openDelete({{ $task->id }})"/>
                                    @endcan
                                    </div>

                                </x-table.cell>
                                @endcan
                            </x-table.row>
                        @empty
                            <x-table.row>
                                <x-table.cell class="block text-center" colspan="6">
                                    {{ __('No tasks found') }}
                                </x-table.cell>
                            </x-table.row>
                        @endforelse
                    </x-table>
                    <div class="m-2"> $list->links() </div>
                </div>
            </div>
            </div>
        </div>
    </div>

    <x-sidebar wire:model="showCreate">
        <div class="w-full p-5 text-center shadow font-semibold text-xl">
            {{ __('Add New Task') }}
        </div>
        <div class="p-10 flex-col space-y-2">
            <div>

                <form wire:submit="save">
                    <div>
                        <x-input.label value="{{ __('Task name') }}" />
                        <x-input.text wire:model="form.nameTask" required autofocus />
                        @error('form.nameTask') <x-error>{{ $message }}</x-error> @enderror
                    </div>
                    <div>
                        @php
                        $colorBg = '';
                        foreach ($colors as $color)
                            if ($color['id']==$form->colorTask) $colorBg = $color['base'].' dark:'.$color['dark'];
                        @endphp
                        <x-input.label class="flex items-center">
                            Цвет
                            <div class="{{ $colorBg }} w-full m-2">&nbsp;</div>
                        </x-input.label>
                        <x-input.select-color :items="$colors" wire:model.live="form.colorTask"/>
                        @error('form.colorTask') <x-error>{{ $message }}</x-error> @enderror
                    </div>
                    <div class="my-1">
                        <x-input.label class="my-2" value="{{ __('Task content') }}" />
                        <x-input.div-editable wire:model="form.contentTask" editable="true" >{!! $form->contentTask !!}</x-input.div-editable>
                        @error('form.contentTask') <x-error>{{ $message }}</x-error> @enderror
                    </div>
                    <div class="my-1 sm:grid sm:grid-cols-[100px_minmax(0,_1fr)] items-center">
                        <x-input.label>Дата</x-input.label>
                        <x-input.text type="date" min="1970-01-01" max="2124-12-31" wire:model.blur="form.dayTask" />
                    </div>
                    <div class="my-1 sm:grid sm:grid-cols-[100px_minmax(0,_1fr)] items-center">
                        <x-input.label>Начало</x-input.label>
                        <x-input.text type="time" wire:model.blur="form.startTask" />
                        @error('form.startTask') <x-error class="col-span-2">{{ $message }}</x-error> @enderror
                    </div>
                    <div class="my-1 sm:grid sm:grid-cols-[100px_minmax(0,_1fr)] items-center">
                        <x-input.label>Завершение</x-input.label>
                        <x-input.text type="time" wire:model.blur="form.endTask" />
                        @error('form.endTask') <x-error class="col-span-2">{{ $message }}</x-error> @enderror
                    </div>
                    <div class="flex mt-4">
                        <x-button.create>{{ __('Save') }}</x-button.create>
                        <x-button.secondary wire:click="closeCreate">{{ __('Cancel') }}</x-button.secondary>
                    </div>
                </form>
            </div>
        </div>
    </x-sidebar>

    <x-modal-wire.dialog wire:model="showDelete" maxWidth="md" type="warn">
        <x-slot name="title">
            <span class="grow">{{ __('Task delete') }}</span>
            <x-button.icon-cancel wire:click="closeDelete" class="text-gray-700 hover:text-white dark:hover:text-white" /></x-slot>
        <x-slot name="content">
            <div class="flex-col space-y-2">
                <x-input.label class="text-lg font-medium">Вы действительно хотите удалить запись?
                    <div class="text-black dark:text-white flex items-center">
                        <div class="w-4 mx-1 {{ $delRecord->base ?? '' }} dark:{{ $delRecord->dark ?? '' }}">&nbsp;</div>
                        <div>{{ $delRecord->name ?? '' }}</div>
                    </div>
                    <div>{!! $delRecord->content ?? '' !!}</div>
                    <div class="text-red-600 dark:text-red-200 shadow p-1">{{ __('Task Delete Message') }}</div>
                </x-input.label>
                <x-button.secondary wire:click="closeDelete">{{ __('Cancel') }}</x-button.secondary>
                <x-button.danger wire:click="destroy({{ $delRecord->id ?? 0 }})">{{ __('Delete')}}</x-button.danger>
            </div>
        </x-slot>
    </x-modal-wire.dialog>

    <x-spinner wire:loading wire:target="sortBy" />
    <x-spinner wire:loading wire:target="openCreate" />
    <x-spinner wire:loading wire:target="closeCreate" />
    <x-spinner wire:loading wire:target="save" />
    <x-spinner wire:loading wire:target="openDelete" />
    <x-spinner wire:loading wire:target="closeDelete" />
    <x-spinner wire:loading wire:target="destroy" />


</div>
