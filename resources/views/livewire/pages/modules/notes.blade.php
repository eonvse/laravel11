<?php

use App\DB\Notes;

use Livewire\WithoutUrlPagination;

use Illuminate\Support\Facades\Log;

use function Livewire\Volt\{state,mount,with,usesPagination,uses};

usesPagination();
uses(WithoutUrlPagination::class);

state(['type','item','delNote']);

state([
    'showAddNote' => false,
    'showDeleteNote' => false,
    'addNote' => '',
    'per_page' => 5, // количество отображаемых заметок
    'per_pages' => [3,5,10,15], // варианты разбиок по количеству
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
    $this->getNotes();

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
            <div><x-input.textarea wire:model="addNote" required /></div>
           	<x-button.create class="text-sm" type="submit">{{ __('Add') }}</x-button.create>
            <x-button.secondary class="text-sm" wire:click="closeAddNote()">{{ __('Cancel') }}</x-button.secondary>
        </form>
    </x-modal-wire.dropdown-r>
    @endcan
    <div class="p-2 tabular-nums text-sm">
        @foreach ($notes as $note)
        <div class="flex items-center">
            <div class="py-1 border-b grow">
                <div>{{ $note->created }} {{ __('by') }} {{ $note->autor->name }}</div>
                <div>{!! nl2br(e($note->note)) !!}</div>
            </div>
            @can('note.delete')
            <div>
                <x-button.icon-del wire:click="openDeleteNote({{ $note->id }})" />
            </div>
            @endcan
        </div>
        @endforeach
        <div class="mt-1"> {{ $notes->links('vendor/livewire/simple-notes') }} </div>
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
                        <div>{!! nl2br(e($delNote->note ?? '')) !!}</div>
                    </div>
                </x-input.label>
                <x-button.secondary wire:click="closeDeleteNote">{{ __('Cancel') }}</x-button.secondary>
                <x-button.danger wire:click="destroy({{ $delNote->id ?? 0 }})">{{ __('Delete')}}</x-button.danger>
            </div>
        </x-slot>
    </x-modal-wire.dialog>

    @endcan
    <x-spinner wire:loading wire:target="getNotes" />
    <x-spinner wire:loading wire:target="openAddNote" />
    <x-spinner wire:loading wire:target="closeAddNote" />
    <x-spinner wire:loading wire:target="saveNote" />
    <x-spinner wire:loading wire:target="previousPage" />
    <x-spinner wire:loading wire:target="nextPage" />
    <x-spinner wire:loading wire:target="setPerPage" />
</div>
