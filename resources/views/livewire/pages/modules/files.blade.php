<?php

use App\DB\Files;

use Livewire\WithoutUrlPagination;

use function Livewire\Volt\{state,mount,with,uses,usesFileUploads,usesPagination,rules};

usesPagination();
uses(WithoutUrlPagination::class);
usesFileUploads();

state(['type','item']);

state([
    'showAddFile' => false,     // отображение окна добавления
    'addFile' => '',            // новый файл
    'showDeleteFile' => false,  // отображение окна удаления
    'delFile' => '',            // удаляемый файл
    'per_page' => 5,            // количество отображаемых файлов
    'per_pages' => [3,5,10,15], // варианты разбивок по количеству
    'isLocalFile' => true,      // признак локального файла, иначе веб адрес со своим именем
    'webName' => '',            // имя ссылки
    'webUrl' => '',             // адрес ссылки
]);

rules(['webName' => 'nullable|min:5','webUrl' => 'nullable|url:http,https']);

with(fn () => ['files' => Files::getList($this->type,$this->item)->simplePaginate($this->per_page)]);

mount(function($type,$item){
    $this->type = $type;
    $this->item = $item;
});

// открыть модальное окно добавления файла
$openAddFile = function() {
    $this->showAddFile = true;
};

// закрыть добавление файла
$closeAddFile = function() {
    $this->showAddFile = false;
    $this->webName = $this->webUrl = '';
    $this->addFile = null;
    $this->isLocalFile = true;

};

// сохранить файл/ссылку
$saveFile = function() {
    $this->validate();
    Files::create($this->type,$this->item,$this->addFile,$this->webName,$this->webUrl);
    $this->closeAddFile();
    $message = "Добавлено новое вложение.";
    $this->dispatch('banner-message', style:'success', message: $message);

};

// открыть модальное окно удаления вложения
$openDelFile = function($idFile) {
    $this->showDeleteFile = true;
    $this->delFile = Files::get($idFile);
};

// закрыть модальное окно удаления вложения
$closeDelFile = function() {
    $this->showDeleteFile = false;
    $this->delFile = '';
};

// удаление записи из БД и загруженного файла (если есть)
$destroy = function() {
    Files::delete($this->delFile->id);
    $message = "Вложение удалено";
    $this->dispatch('banner-message', style:'danger', message: $message);
    $this->closeDelFile();
};

// установить количество отображаемых в списке файлов
$setPerPage = function($value){
    $this->per_page = $value;
    $this->resetPage();
};

?>

<!-- HTML МОДУЛЬ ФАЙЛЫ -->

<div>
    <div class="shadow p-2 font-semibold flex items-center">
        <div class="grow">{{ __('Files') }}</div>
        <div class="flex space-x-1 px-1">
            @foreach($per_pages as $countItem)
                <div class="px-1 border rounded cursor-pointer text-sm {{ $countItem==$per_page ? 'text-black' : 'text-gray-400' }}" wire:click="setPerPage({{ $countItem }})">{{ $countItem }}</div>
            @endforeach
        </div>
        @can('file.create')
        <div class="flex items-center"><x-button.icon-create wire:click="openAddFile" /></div>
        @endcan
    </div>
    @can('file.create')
    <x-modal-wire.dropdown-r wire:model="showAddFile" maxWidth="sm">
        <form wire:submit="saveFile" class="flex-col space-y-2">
            <input type="checkbox" wire:model.live = "isLocalFile"><span class="mx-2">Локальный файл</span>
            @if ($isLocalFile)
                <div>
                    <input type="file" wire:model="addFile" class="text-sm">
                    @error('addFile') <x-error>{{ $message }}</x-error> @enderror
                </div>
            @else
                <div>
                    <x-input.label>{{ __('Web Name') }}</x-input.label>
                    <x-input.text wire:model.live="webName" required />
                    @error('webName') <x-error>{{ $message }}</x-error> @enderror
                    <x-input.label>{{ __('Web Url') }}</x-input.label>
                    <x-input.text wire:model.live="webUrl" required />
                    @error('webUrl') <x-error>{{ $message }}</x-error> @enderror
                </div>
            @endif
        	<x-button.create class="text-sm" type="submit" wire:loading.attr="disabled" wire:target="addFile">{{ __('Add') }}</x-button.create>
            <x-button.secondary class="text-sm" wire:click="closeAddFile">{{ __('Cancel') }}</x-button.secondary>
       	</form>
    </x-modal-wire.dropdown-r>
    @endcan
    <div class="p-2 tabular-nums text-sm">
        @foreach ($files as $file)
        <div class="flex items-center justify-center border-b border-gray-300 p-[2px]">
            <div class="py-1 grow">
                <x-link.table-cell href="{{ $file->isLocal ? url('storage/'.$file->url) : $file->url }}" target="_blank">
                    {{ $file->name }}
                </x-link.table-cell>
            </div>

            <div class="flex items-center">
                @can('file.delete')
                <x-button.icon-del size=4 wire:click="openDelFile({{ $file->id }})" />
                @endcan
            </div>
        </div>
        @endforeach
        <div class="mt-1"> {{ $files->links('vendor/livewire/simple-module') }} </div>
    </div>

    @can('file.delete')
    <x-modal-wire.dialog wire:model="showDeleteFile" maxWidth="md" type="warn">
        <x-slot name="title">
            <span class="grow">{{ __('File delete') }}</span>
            <x-button.icon-cancel  class="text-gray-700 hover:text-white dark:hover:text-white" wire:click="closeDelFile" /></x-slot>
        <x-slot name="content">
            <div class="flex-col space-y-2">
                <x-input.label class="text-lg font-medium">Вы действительно хотите удалить вложение?
                    <div class="text-black dark:text-white flex items-center">
                        <div>{{ $delFile->name ?? '' }}</div>
                    </div>
                </x-input.label>
                <x-button.secondary wire:click="closeDelFile" >{{ __('Cancel') }}</x-button.secondary>
                <x-button.danger wire:click="destroy" >{{ __('Delete')}}</x-button.danger>
            </div>
        </x-slot>
    </x-modal-wire.dialog>
    @endcan

    <x-spinner wire:loading wire:target="openAddFile" />
    <x-spinner wire:loading wire:target="closeAddFile" />
    <x-spinner wire:loading wire:target="saveFile" />
    <x-spinner wire:loading wire:target="previousPage" />
    <x-spinner wire:loading wire:target="nextPage" />
    <x-spinner wire:loading wire:target="setPerPage" />
    <x-spinner wire:loading wire:target="openDelFile" />
    <x-spinner wire:loading wire:target="closeDelFile" />
    <x-spinner wire:loading wire:target="destroy" />


</div>
