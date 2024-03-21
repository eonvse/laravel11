<?php

use App\Models\Task;
use App\Livewire\Forms\TaskEditForm;

use Illuminate\Support\Facades\Auth;
//use Illuminate\Support\Facades\Log;

use function Livewire\Volt\{state, mount, form};

state(['content','taskId']);

state([
    'editable' => false,
]);

form(TaskEditForm::class,'editForm');

mount(function(Task $task) {

    $this->taskId = $task->id;
    $this->content = $task->content;

});

$openContent = function (){
    $this->editForm->setTaskContent(Task::find($this->taskId));
    $this->editable = true;
};

$closeContent = function (){
    $this->editForm->reset();
    $this->editForm->resetValidation();
    $this->editable = false;
};

$saveContent = function (){

    $this->editForm->storeContent();

    $message = "Содержание задачи обновлено";
    session()->flash('flash.banner', $message);
    session()->flash('flash.bannerStyle', 'success');

    $this->redirectRoute('tasks.edit', ['task'=>Task::find($this->taskId)]);

};


?>

<div>
    <form wire:submit="saveContent">
    <div class="text-sm text-neutral-600 flex items-center">
        <div class="text-center grow">{{ __('Task content') }}</div>
        <div class="flex items-center">
            @if ($editable)
                <x-button.icon-ok title="{{ __('Save') }} " />
                <x-button.icon-cancel type="button" wire:click="closeContent" title="{{ __('Cancel') }}" />
            @else
                <x-button.icon-edit type="button" wire:click="openContent" title="{{ __('Edit') }}"/>
            @endif
        </div>

    </div>
    <div>
        @if ($editable)
            <x-input.div-editable wire:model="editForm.contentTask" editable="true" >{!! $editForm->contentTask !!}</x-input.div-editable>
            @error('editForm.contentTask') <x-error>{{ $message }}</x-error> @enderror
        @else
            {!! empty($content) ? __('empty') : $content !!}
        @endif
    </div>
    </form>
</div>
