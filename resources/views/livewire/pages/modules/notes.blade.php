<?php

use App\DB\Notes;

use function Livewire\Volt\{state,mount};

state(['notes','type','item']);

state([
    'showAddNote' => false,
    'addNote' => '',
]);

mount(function($type,$item){
    $this->type = $type;
    $this->item = $item;
    $this->getNotes();
});

$getNotes = function(){
    $this->notes = Notes::get($this->type,$this->item);
};

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
};

?>

<div>
    <div class="shadow p-2 font-semibold flex items-center">
        <div class="grow">{{ __('Notes') }}</div>
        @can('note.create')
        <div class="flex items-center"><x-button.icon-create wire:click="openAddNote" /></div>
        @endcan
    </div>
    @can('note.create')
    <x-modal-wire.dropdown wire:model="showAddNote" maxWidth="sm">
        <form wire:submit="saveNote" class="flex-col space-y-2">
            <div><x-input.textarea wire:model="addNote" required /></div>
           	<x-button.create class="text-sm" type="submit">{{ __('Add') }}</x-button.create>
            <x-button.secondary class="text-sm" wire:click="closeAddNote()">{{ __('Cancel') }}</x-button.secondary>
        </form>
    </x-modal-wire.dropdown>
    @endcan
    <div class="p-2 tabular-nums text-sm">
        @foreach ($notes as $note)
        <div class="py-1 border-b">
            <div>{{ $note->created }} {{ __('by') }} {{ $note->autor->name }}</div>
            <div>{!! nl2br(e($note->note)) !!}</div>
        </div>
        @endforeach
    </div>

    <x-spinner wire:loading wire:target="getNotes" />
    <x-spinner wire:loading wire:target="openAddNote" />
    <x-spinner wire:loading wire:target="closeAddNote" />
    <x-spinner wire:loading wire:target="saveNote" />
</div>
