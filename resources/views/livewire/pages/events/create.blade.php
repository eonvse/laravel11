<?php

use App\Livewire\Forms\EventForm;

use function Livewire\Volt\{state, form,on};

form(EventForm::class);

state([
    'showCreate' => false,
]);

on(['edit' => function () {
    $this->closeCreate();
}]);

on(['view' => function () {
    $this->closeCreate();
}]);

//открыть модальное окно создания события
$openCreate = function() {
    $this->showCreate = true;
};

//закрыть модальное окно создания события
$closeCreate = function() {
    $this->showCreate = false;
    $this->form->reset();
    $this->form->resetValidation();

};

//сохранить новое событие
$save = function () {
    $this->form->create();
    $this->dispatch('event-created');
    $this->closeCreate();
};

/*
$addAttr = function () {
    array_push($this->form->data, []);
};

$delAttr = function ($i) {
    array_splice($this->form->data, $i, 1);
};
*/
?>
<div>
    <div class="p-2 border-r">
        <x-button.create wire:click="openCreate">{{ __('Add New Event') }}</x-button.create>
    </div>

    <x-sidebar wire:model="showCreate">
        <div class="w-full p-5 text-center shadow font-semibold text-xl">
            {{ __('Add New Event') }}
        </div>
        <div class="p-10 flex-col space-y-2">
            <div>
                <form wire:submit="save">
                    <div>
                        <x-input.label value="{{ __('Event title') }}" />
                        <x-input.text wire:model="form.title" required autofocus />
                        @error('form.title') <x-error>{{ $message }}</x-error> @enderror
                    </div>
                    <div class="mt-2 sm:grid sm:grid-cols-[100px_minmax(0,_1fr)] items-center">
                        <x-input.label>Дата</x-input.label>
                        <x-input.text type="date" wire:model.blur="form.day" required />
                        @error('form.day') <x-error>{{ $message }}</x-error> @enderror
                    </div>
                    <div class="mt-2 sm:grid sm:grid-cols-[100px_minmax(0,_1fr)] items-center">
                        <x-input.label>Начало</x-input.label>
                        <x-input.text type="time" wire:model.blur="form.start"  />
                        @error('form.start') <x-error>{{ $message }}</x-error> @enderror
                    </div>
                    <div class="mt-2 sm:grid sm:grid-cols-[100px_minmax(0,_1fr)] items-center">
                        <x-input.label>Завершение</x-input.label>
                        <x-input.text type="time" wire:model.blur="form.end"  />
                        @error('form.start') <x-error>{{ $message }}</x-error> @enderror
                    </div>
                    <div class="flex mt-4">
                        <x-button.create>{{ __('Save') }}</x-button.create>
                        <x-button.secondary wire:click="closeCreate">{{ __('Cancel') }}</x-button.secondary>
                    </div>
                </form>
            </div>
        </div>
    </x-sidebar>

    <x-spinner wire:loading wire:target="openCreate" />
    <x-spinner wire:loading wire:target="closeCreate" />
    <x-spinner wire:loading wire:target="save" />
</div>
