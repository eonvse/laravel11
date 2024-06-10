<?php

use App\DB\Notes;

use Livewire\WithoutUrlPagination;

use Illuminate\Support\Facades\Log;

use function Livewire\Volt\{state,mount,with,usesPagination,uses};

usesPagination();
uses(WithoutUrlPagination::class);

state(['type','item','delNote']);

state([
    'showAddNote' => false,     //отображение окна добавления
    'showDeleteNote' => false,  //отображение окна удаления
    'addNote' => '',            // новая заметка
    'per_page' => 5,            // количество отображаемых заметок
    'per_pages' => [3,5,10,15], // варианты разбивок по количеству
    'edit_note_id' => 0,        // id редактируемой заметки   
    'editNote' => '',           //текст редактируемой заметки
]);

with(fn () => ['notes' => Notes::getList($this->type,$this->item)->simplePaginate($this->per_page)]);

mount(function($type,$item){
    $this->type = $type;
    $this->item = $item;
});

$openAddNote = function() {
    $this->showAddNote = true;
};

$closeAddNote = function() {
    $this->showAddNote = false;
    $this->addNote = '';
};

$saveNote = function() {

    Notes::create($this->type,$this->item,$this->addNote);
    $this->closeAddNote();

    $message = "Заметка добавлена.";
    $this->dispatch('banner-message', style:'success', message: $message);
};

$setPerPage = function($value){
    $this->per_page = $value;
    $this->resetPage();
};

$openDeleteNote = function($idNote){
    $this->showDeleteNote = true;
    $this->delNote = Notes::get($idNote);
};

$closeDeleteNote = function(){
    $this->showDeleteNote = false;
    $this->delNote = '';
};

$destroy = function($idNote){
    $message = "Заметка удалена";
    Notes::delete($idNote);
    $this->closeDeleteNote();
    $this->dispatch('banner-message', style:'danger', message: $message);
    $this->resetPage();
};

$setEditNote = function(int $id){
    $this->edit_note_id = $id;
    $this->editNote = Notes::get($id)->note;
};

$cancelEdit = function(){
    $this->edit_note_id = 0;
    $this->editNote = '';
};

$saveEditNote = function($id){
    
    Notes::setFieldValue($id,'note',$this->editNote);

    $message = "Заметка сохранена.";
    $this->dispatch('banner-message', style:'success', message: $message);

    $this->cancelEdit();

};


?>

<div>
    <div class="shadow p-2 font-semibold flex items-center">
        <div class="grow">{{ __('Notes') }}</div>
        <div class="flex space-x-1 px-1">
            @foreach($per_pages as $countItem)
                <div class="px-1 border rounded cursor-pointer text-sm {{ $countItem==$per_page ? 'text-black' : 'text-gray-400' }}" wire:click="setPerPage({{ $countItem }})">{{ $countItem }}</div>
            @endforeach
        </div>
        @can('note.create')
        <div class="flex items-center"><x-button.icon-create wire:click="openAddNote" /></div>
        @endcan
    </div>
    @can('note.create')
    <x-modal-wire.dropdown-r wire:model="showAddNote" maxWidth="sm">
        <form wire:submit="saveNote" class="flex-col space-y-2">
            <div>
                <x-input.div-editable editable="true" wire:model="addNote">
                    {!! $addNote !!}
                </x-input.div-editable>
            </div>
           	<x-button.create class="text-sm" type="submit">{{ __('Add') }}</x-button.create>
            <x-button.secondary class="text-sm" wire:click="closeAddNote()">{{ __('Cancel') }}</x-button.secondary>
        </form>
    </x-modal-wire.dropdown-r>
    @endcan
    <div class="p-2 tabular-nums text-sm">
        @foreach ($notes as $note)
        <div class="flex items-center justify-center border-b border-gray-300 p-[2px]">
            <div class="py-1 grow">
                <div>{{ $note->created }} {{ __('by') }} {{ $note->autor->name }}</div>
                @if ($edit_note_id != $note->id)
                <div>{!! $note->note !!}</div>
                @else
                <div class="flex items-center">
                    <x-input.div-editable editable="true" wire:model="editNote">
                        {!! $editNote !!}
                    </x-input.div-editable>
                </div>
                @endif
            </div>

            <div class="flex items-center">
            @if ($edit_note_id != $note->id)
                @can('note.edit')
                <x-button.icon-edit size=4 wire:click="setEditNote({{ $note->id }})" />
                @endcan

                @can('note.delete')
                <x-button.icon-del size=4 wire:click="openDeleteNote({{ $note->id }})" />
                @endcan
            @else
                <x-button.icon-ok size=4 wire:click="saveEditNote({{ $note->id }})" />
                <x-button.icon-cancel size=4 wire:click="cancelEdit"/>
            @endif
            </div>
        </div>
        @endforeach
        <div class="mt-1"> {{ $notes->links('vendor/livewire/simple-module') }} </div>
    </div>

    @can('note.delete')
    <x-modal-wire.dialog wire:model="showDeleteNote" maxWidth="md" type="warn">
        <x-slot name="title">
            <span class="grow">{{ __('Note delete') }}</span>
            <x-button.icon-cancel wire:click="closeDeleteNote" class="text-gray-700 hover:text-white dark:hover:text-white" /></x-slot>
        <x-slot name="content">
            <div class="flex-col space-y-2">
                <x-input.label class="text-lg font-medium">Вы действительно хотите удалить заметку?
                    <div class="text-black dark:text-white flex items-center">
                        <div>{!! $delNote->note ?? '' !!}</div>
                    </div>
                </x-input.label>
                <x-button.secondary wire:click="closeDeleteNote">{{ __('Cancel') }}</x-button.secondary>
                <x-button.danger wire:click="destroy({{ $delNote->id ?? 0 }})">{{ __('Delete')}}</x-button.danger>
            </div>
        </x-slot>
    </x-modal-wire.dialog>
    @endcan

    <x-spinner wire:loading wire:target="openAddNote" />
    <x-spinner wire:loading wire:target="closeAddNote" />
    <x-spinner wire:loading wire:target="saveNote" />
    <x-spinner wire:loading wire:target="previousPage" />
    <x-spinner wire:loading wire:target="nextPage" />
    <x-spinner wire:loading wire:target="setPerPage" />
    <x-spinner wire:loading wire:target="setEditNote" />
    <x-spinner wire:loading wire:target="cancelEdit" />
    <x-spinner wire:loading wire:target="saveEditNote" />

</div>
