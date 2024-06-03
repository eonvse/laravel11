<?php

use App\DB\Tasks;
use App\Models\Color;
use App\Events\TaskDelete;

use App\Livewire\Forms\TaskCreateForm;
use Livewire\WithoutUrlPagination;

use Illuminate\Support\Facades\Auth;
//use Illuminate\Support\Facades\Log;
//Log::debug('selectedPermissions = ' . implode(',',$this->selectedPermissions));
//Log::notice('---Volt Roles---');

use function Livewire\Volt\{layout, state, title, mount, form, updated,with, usesPagination, uses};

layout('layouts.app');

title(fn () => __('Tasks'));

usesPagination();
uses(WithoutUrlPagination::class);

with(fn () => ['tasksList' => Tasks::wire_list($this->sortField,$this->sortDirection,$this->filter)->paginate(10)]);

state(['colors','filter']);

state([
    'sortField' => 'created_at',
    'sortDirection' => 'desc',
    'showCreate' => false,
    'showDelete' =>false,
    'delRecord' => null,
    'taskInfo' => null,
    'statuses' => [0=>'Все',2=>'Выполненные',1=>'Невыполненные']
]);

form(TaskCreateForm::class);

mount(function() {
    $this->colors = Color::orderBy('base')->get()->toArray();
    $this->filter = ['status'=>0];
});

updated(['filter.status' => fn () => $this->resetPage()]);

$sortBy = function($field)
{
    $this->sortDirection = $this->sortField === $field
                        ? $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc'
                        : 'asc';

    $this->sortField = $field;
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

    $this->closeCreate();
    $this->resetPage();

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
    TaskDelete::dispatch(Tasks::get($task_id));

    $message = "Удалена задача: " . $this->delRecord->name;
    $this->closeDelete();

    $this->dispatch('banner-message', style:'danger', message: $message);

    $this->resetInfo();
    $this->resetPage();

};

$infoTask=function($task_id)
{
    $this->taskInfo = Tasks::get($task_id)->toArray();
};

$resetInfo=function()
{
    $this->taskInfo = null;
};

$perform=function($taskId)
{
    if (Auth::user()->can('task.edit'))
        Tasks::perform($taskId);
    else
        $this->dispatch('banner-message', style:'danger', message: 'Недостаточно прав');
}




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
                        <div class="text-black font-medium border-b text-center">{{ $taskInfo['name'] }}</div>
                        @isset($taskInfo['dayFormat'])
                        <div>{{ __('Event Day') }}</div>
                        <div class="text-black font-medium border-b">{{ $taskInfo['dayFormat'] }}</div>
                        @endisset
                        @isset($taskInfo['startFormat'])
                        <div>{{ __('Start') }}</div>
                        <div class="text-black font-medium border-b">{{ $taskInfo['startFormat'] }}</div>
                        @endisset
                        @isset($taskInfo['endFormat'])
                        <div>{{ __('End') }}</div>
                        <div class="text-black font-medium border-b">{{ $taskInfo['endFormat'] }}</div>
                        @endisset
                        @isset($taskInfo['content'])
                        <div>{{ __('Task content') }}</div>
                        <div class="text-black font-medium border-b">{!! $taskInfo['content'] !!}</div>
                        @endisset
                        @isset($taskInfo['dateDoneFormat'])
                        <div>{{ __('dateDone') }}</div>
                        <div class="text-black font-medium border-b">{{ $taskInfo['dateDoneFormat'] }}</div>
                        @endisset
                        @if ($taskInfo['notesCount']>0)
                        <div>{{ __('Notes Count') }}</div>
                        <div class="text-black font-medium border-b">{{ $taskInfo['notesCount'] }}</div>
                        @endif
                    @else
                        <div class="">
                            Для отображения информации по задаче нажмите на значок <x-link.icon-show  class="inline-block" /> напротив нужной задачи.
                        </div>
                    @endif
                </div>
                <div class="grow relative overflow-x-auto p-1">
                    <div class="flex" x-on:mouseover="$wire.resetInfo()">
                        @can('task.create')
                        <div class="p-2 border-r">
                            <x-button.create wire:click="openCreate">{{ __('Add New Task') }}</x-button.create>
                        </div>
                        @endcan
                        <div class="p-2 flex">
                            <div class="p-1 flex-none">{{ __('Task filter') }}</div>
                            <x-input.select-status :items="$statuses" wire:model.live="filter.status"/></div>
                    </div>
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
                        </x-slot>
                        @forelse ($tasksList as $task)
                            <x-table.row wire:key="{{ $task->id }}">
                                <x-table.cell class="block">
                                    <div class="relative items-center">
                                        <div class="flex">
                                            @can('task.edit')
                                            <div class="flex items-center">
                                                <x-link.icon-show wire:click="infoTask({{ $task->id }})" />
                                                <x-link.icon-edit href="{{ route('tasks.edit', ['task'=>$task, 'editable'=>1]) }}" title="{{ __('Edit') }}" />
                                                @can('task.delete')
                                                <x-button.icon-del  wire:click="openDelete({{ $task->id }})"/>
                                                @endcan
                                            </div>
                                            @endcan
                                           <div class="ml-2 grow flex items-center">
                                                <div class="w-4 mx-1 {{ $task->color->base ?? '' }} dark:{{ $task->color->dark ?? '' }}">&nbsp;</div>
                                                <div><x-link.table-cell href="{{ route('tasks.edit', $task) }}">{{ $task->name }}</x-link.table-cell></div>
                                            </div>
                                            <div class="justify-center align-middle">
                                                <x-marker.check :value="$task->isDone" wire:click="perform({{ $task->id }})" />
                                            </div>
                                        </div>
                                    </div>
                                </x-table.cell>
                                <x-table.cell class="inline-block tabular-nums">{{ $task->day_format }}</x-table.cell>
                                <x-table.cell class="inline-block tabular-nums">{{ $task->created }}</x-table.cell>
                                <x-table.cell class="inline-block">{{ $task->autor->name }}</x-table.cell>
                            </x-table.row>
                        @empty
                            <x-table.row>
                                <x-table.cell class="block text-center" colspan="6">
                                    {{ __('No tasks found') }}
                                </x-table.cell>
                            </x-table.row>
                        @endforelse
                    </x-table>
                    <div class="m-2"> {{ $tasksList->links() }} </div>
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
                            {{ __('Color') }}
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
                        <x-input.label>{{ __('Event Day') }}</x-input.label>
                        <x-input.text type="date" min="1970-01-01" max="2124-12-31" wire:model.blur="form.dayTask" />
                    </div>
                    <div class="my-1 sm:grid sm:grid-cols-[100px_minmax(0,_1fr)] items-center">
                        <x-input.label>{{ __('Start') }}</x-input.label>
                        <x-input.text type="time" wire:model.blur="form.startTask" />
                        @error('form.startTask') <x-error class="col-span-2">{{ $message }}</x-error> @enderror
                    </div>
                    <div class="my-1 sm:grid sm:grid-cols-[100px_minmax(0,_1fr)] items-center">
                        <x-input.label>{{ __('End') }}</x-input.label>
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
    <x-spinner wire:loading wire:target="gotoPage" />
    <x-spinner wire:loading wire:target="previousPage" />
    <x-spinner wire:loading wire:target="nextPage" />

</div>
