<?php

use App\Models\Task;
use App\Models\Color;

use App\DB\Tasks;

use App\Livewire\Forms\TaskEditForm;

use Illuminate\Support\Facades\Auth;
//use Illuminate\Support\Facades\Log;
//Log::debug('selectedPermissions = ' . implode(',',$this->selectedPermissions));
//Log::notice('---Volt Roles---');

use function Livewire\Volt\{state, mount, form};

state(['colors','task']);

state([
    'editable' => false,
    'delete' => false,
]);

form(TaskEditForm::class);

mount(function(Task $task, bool $editable=false) {

    $this->colors = Color::orderBy('base')->get()->toArray();
    $this->task = $task;
    $this->editable = $editable;
    $this->form->setTask($this->task);

});

$openEdit = function(){
    $this->form->setTask($this->task);
    $this->editable = true;
};

$cancelEdit = function(){
    $this->form->reset();
    $this->form->resetValidation();
    $this->editable = false;
};

$clearField = function($field){
    $this->form->reset($field);
};

$save = function(){

    $message = "Задача " . $this->form->nameTask . " сохранена";
    $this->form->store();
    session()->flash('flash.banner', $message);
    session()->flash('flash.bannerStyle', 'success');
    $this->redirectRoute('tasks.edit', ['task'=>$this->task]);
};

$showDelete = function(){
    $this->delete = true;
};

$closeDelete = function(){
    $this->delete = false;
};

$destroy = function(){
    $this->task->delete();
    $this->delete = false;

    $message = "Удалена задача: " . $this->task->name;
    session()->flash('flash.banner', $message);
    session()->flash('flash.bannerStyle', 'danger');

    $this->redirect('/tasks');

};

$perform=function($taskId)
{
    if (Auth::user()->can('task.edit')) {
        Tasks::perform($taskId);
        $this->task = Tasks::get($taskId);
    }
    else 
        $this->dispatch('banner-message', style:'danger', message: 'Недостаточно прав'); 
};

?>
<div class="bg-neutral-200">
    <form wire:submit="save" class="sm:flex">
    <div class="grow mx-2 text-center">
        <div class="sm:grid sm:grid-cols-6  text-sm text-neutral-600">
            <div class="col-span-3">{{ __('Task name') }}</div>
            <div>{{ __('Color') }}</div>
            <div>{{ __('Team') }}</div>
            <div>{{ __('Autor') }}</div>
        </div>
        @if ($editable)
        @can('task.edit')
        <div class="sm:grid sm:grid-cols-6 font-medium items-center border-b border-neutral-400 border-dashed">
            <div class="col-span-3 p-1">
                <x-input.text wire:model='form.nameTask' />
                @error('form.nameTask') <x-error>{{ $message }}</x-error> @enderror
            </div>
            <div class="p-1 flex space-x-1">
                @php
                $colorBg = '';
                foreach ($colors as $color)
                    if ($color['id']==$form->colorTask) $colorBg = $color['base'].' dark:'.$color['dark'];
                @endphp
                <div class="{{ $colorBg }} w-4 border border-black">&nbsp;</div>
                <div class="grow"><x-input.select-color :items="$colors" wire:model.live="form.colorTask" /></div>

            </div>
            <div class="p-1">{{ $task->team_id }}</div>
            <div class="p-1">{{ $task->autor->name }}</div>
        </div>
        <div class="sm:grid sm:grid-cols-6 font-medium">
            <div class="p-1">
                <div class="relative">
                    <x-input.text type="date" min="1970-01-01" max="2124-12-31" wire:model.blur="form.dayTask" />
                    <x-button.icon-clear class="absolute top-0 right-0" title="{{ __('Clear field') }}" wire:click="clearField('dayTask')" />
                </div>
            </div>
            <div class="p-1">
                <div class="relative">
                    <x-input.text type="time" wire:model.blur="form.startTask" />
                    <x-button.icon-clear class="absolute top-0 right-0" title="{{ __('Clear field') }}" wire:click="clearField('startTask')" />
                </div>
            </div>
            <div class="p-1">
                <div class="relative">
                    <x-input.text type="time" wire:model.blur="form.endTask" />
                    <x-button.icon-clear class="absolute top-0 right-0" title="{{ __('Clear field') }}" wire:click="clearField('endTask')" />
                    @error('form.endTask') <x-error>{{ $message }}</x-error> @enderror
                </div>
            </div>
            <div class="p-1 col-span-2"><x-marker.check :value="$task->isDone" type="form" wire:click="perform({{ $task->id }})" /></div>
            <div class="p-1">{{ empty($task->dateDone) ? '-' : date('d.m.Y',strtotime($task->dateDone)) }}</div>
        </div>
        @endcan
        @else
        <div class="sm:grid sm:grid-cols-6 font-medium items-center border-b border-neutral-400 border-dashed">
            <div class="col-span-3">{{ $task->name }}</div>
            <div class="p-2 {{ $task->color->base }} dark:{{ $task->color->dark }}">&nbsp;</div>
            <div class="p-2">{{ $task->team_id }}</div>
            <div class="p-2">{{ $task->autor->name }}</div>
        </div>
        <div class="sm:grid sm:grid-cols-6 font-medium">
            <div class="p-2">{{ empty($task->day) ? '-' : $task->day_format }}</div>
            <div class="p-2">{{ empty($task->start) ? '-' : $task->start_format }}</div>
            <div class="p-2">{{ empty($task->end) ? '-' : $task->end_format }}</div>
            <div class="p-2 col-span-2"><x-marker.check :value="$task->isDone" type="form" wire:click="perform({{ $task->id }})" /></div>
            <div class="p-2">{{ empty($task->dateDone) ? '-' : $task->dateDoneFormat }}</div>
        </div>
        @endif
        <div class="sm:grid sm:grid-cols-6 text-center text-sm text-neutral-600">
            <div>{{ __('Event Day')}}</div>
            <div>{{ __('Start')}}</div>
            <div>{{ __('End')}}</div>
            <div class="col-span-2">{{ __('isDone')}}</div>
            <div>{{ __('dateDone')}}</div>
        </div>
    </div>
    <div class="grid items-center p-2">
        @if ($editable)
        @can('task.edit')
        <div class="flex justify-center items-center">
            <x-button.icon-ok type="submit" title="{{ __('Save') }}" />
            <x-button.icon-cancel type="button" wire:click='cancelEdit' title="{{ __('Cancel') }}" />
        </div>
        @endcan
        @else
        <div class="flex justify-center items-center">
            @can('task.edit')
                <x-button.icon-edit type="button" wire:click='openEdit' title="{{ __('Edit') }}" />
            @endcan
            @can('task.delete')
                <x-button.icon-del type="button" title="{{ __('Delete') }}" wire:click="showDelete" />
            @endcan
        </div>
        @endif
    </div>
    </form>
    <x-modal-wire.dialog wire:model="delete" maxWidth="md" type="warn">
        <x-slot name="title">
            <span class="grow">{{ __('Task delete') }}</span>
            <x-button.icon-cancel wire:click="closeDelete" class="text-gray-700 hover:text-white dark:hover:text-white" /></x-slot>
        <x-slot name="content">
            <div class="flex-col space-y-2">
                <x-input.label class="text-lg font-medium">Вы действительно хотите удалить запись?
                    <div class="text-black dark:text-white flex items-center">
                        <div class="w-4 mx-1 {{ $task->color->base ?? '' }} dark:{{ $task->color->dark ?? '' }}">&nbsp;</div>
                        <div>{{ $task->name ?? '' }}</div>
                    </div>
                    <div class="text-red-600 dark:text-red-200 shadow p-1">{{ __('Task Delete Message') }}</div>
                </x-input.label>
                <x-button.secondary wire:click="closeDelete">{{ __('Cancel') }}</x-button.secondary>
                <x-button.danger wire:click="destroy">{{ __('Delete')}}</x-button.danger>
            </div>
        </x-slot>
    </x-modal-wire.dialog>

    <x-spinner wire:loading wire:target="openEdit" />
    <x-spinner wire:loading wire:target="cancelEdit" />
    <x-spinner wire:loading wire:target="clearField" />
    <x-spinner wire:loading wire:target="save" />
    <x-spinner wire:loading wire:target="showDelete" />
    <x-spinner wire:loading wire:target="closeDelete" />
    <x-spinner wire:loading wire:target="destroy" />

</div>
