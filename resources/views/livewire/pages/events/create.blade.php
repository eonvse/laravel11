<?php
use Carbon\Carbon;

use App\Livewire\Forms\EventForm;
use App\DB\Items;

use function Livewire\Volt\{state,form,on, updated, mount};

form(EventForm::class);

state([
    'showCreate' => false,
]);

state(['types','items']);

mount(function() {
    $this->types = Items::getTypeNames();
    $this->items = array();
});

on(['edit' => function () {
    $this->closeCreate();
}]);

on(['view' => function () {
    $this->closeCreate();
}]);

updated(['form.end' => fn () => $this->editEndTime()]);
updated(['form.type_id' => fn () => $this->setItems() ]);

//если время окончания меньше начала, то устанавливается на +1 час.
$editEndTime = function() {
    $st = strtotime($this->form->start);
    $end = strtotime($this->form->end);
    if ($end <= $st) {
        $dateEnd = Carbon::createFromTime(date('H',$st),date('i',$st));
        $dateEnd->addHour();

        $this->form->end = $dateEnd->format('H:i');
    }

};

//список элементов выбранного типа
$setItems = function() {
    if (!empty($this->form->type_id)) $this->items = Items::getItems($this->form->type_id);
    $this->form->resetValidation('item_id');
    $this->form->reset('item_id');
};

//открыть модальное окно создания события
$openCreate = function() {
    $this->showCreate = true;
};

//закрыть модальное окно создания события
$closeCreate = function() {
    $this->showCreate = false;
    $this->form->reset();
    $this->form->resetValidation();
    $this->items = array();

};

//сохранить новое событие
$save = function () {
    $name = $this->form->name;
    $day = $this->form->day;
    $this->form->create();
    $this->dispatch('event-created', name: $name , day: $day);
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
                        <x-input.label value="{{ __('Event name') }}" />
                        <x-input.text wire:model="form.name" autofocus />
                        @error('form.name') <x-error>{{ $message }}</x-error> @enderror
                    </div>
                    <div class="mt-2 sm:grid sm:grid-cols-[100px_minmax(0,_1fr)] items-center">
                        <x-input.label>Дата</x-input.label>
                        <div>
                            <x-input.text type="date" wire:model.blur="form.day" />
                            @error('form.day') <x-error>{{ $message }}</x-error> @enderror
                        </div>
                    </div>
                    <div class="mt-2 sm:grid sm:grid-cols-[100px_minmax(0,_1fr)] items-center">
                        <x-input.label>Начало</x-input.label>
                        <div>
                            <x-input.text type="time" wire:model.blur="form.start"  />
                            @error('form.start') <x-error>{{ $message }}</x-error> @enderror
                        </div>
                    </div>
                    <div class="mt-2 sm:grid sm:grid-cols-[100px_minmax(0,_1fr)] items-center">
                        <x-input.label>Завершение</x-input.label>
                        <div>
                            <x-input.text type="time" wire:model.blur="form.end"  />
                            @error('form.end') <x-error>{{ $message }}</x-error> @enderror
                        </div>
                    </div>
                    <div class="mt-2">
                        <x-input.select-types :items="$types" wire:model.live="form.type_id" />
                        @error('form.type_id') <x-error>{{ $message }}</x-error> @enderror
                    </div>
                    
                    <div class="mt-2">
                        <x-input.select-items :items="$items" wire:model.live="form.item_id" />
                        @error('form.item_id') <x-error>{{ $message }}</x-error> @enderror
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
