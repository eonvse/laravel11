<?php

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Livewire\Forms\RoleEditForm;

use Livewire\Attributes\{Layout, Title};
use Livewire\Volt\Component;

use Illuminate\Support\Facades\DB;
//use Illuminate\Support\Facades\Log;
//Log::debug('selectedPermissions = ' . implode(',',$this->selectedPermissions));
//Log::notice('---Volt Roles---');

new
#[Layout('layouts.app')]
#[Title('Roles')]
class extends Component
{
    public ?Role $itemRole;

    public $roles, $selectedPermissions, $permissions;

    public $sortField = 'name';
    public $sortDirection = 'asc';
    public $showEdit = false;
    public $showDelete = false;
    public $editId = 0;

    public RoleEditForm $editForm;

    public function mount()
    {
        $this->roles = Role::orderBy($this->sortField,$this->sortDirection)->get();
        $this->selectedPermissions = array();
        $this->permissions = Permission::orderBy('name','asc')->get();
        $this->itemRole = null;

    }

    public function sortBy($field)
    {
        $this->sortDirection = $this->sortField === $field
                        ? $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc'
                        : 'asc';
        $this->sortField = $field;
        $this->roles = Role::orderBy($this->sortField,$this->sortDirection)->get();
    }

    public function setRole(Role $role)
    {
        $this->itemRole = $role;

        $rolePermissions = DB::table("role_has_permissions")->where("role_id",$role->id)
        ->pluck('permission_id')
        ->all();

        $this->selectedPermissions = DB::table("permissions")->whereIn("id",$rolePermissions)
        ->pluck('name')
        ->all();
    }

    public function openCreate()
    {
        $this->showEdit = true;
    }

    public function closeCreate()
    {
        $this->editForm->reset();
        $this->selectedPermissions = array();
        $this->showEdit = false;
    }

    public function openEdit(Role $role)
    {
        $this->setRole($role);
        $this->editForm->setRole($role);
        $this->showEdit = true;
    }

    public function save()
    {

        $message = "Роль: " . $this->editForm->nameRole . " coхранена.";

        $this->editForm->store();

        $this->dispatch('banner-message', style:'success', message: $message);

        $this->roles = Role::orderBy($this->sortField,$this->sortDirection)->get();
        $this->closeCreate();
    }

    public function openDelete(Role $role)
    {
        $this->setRole($role);
        $this->showDelete = true;
    }

    public function closeDelete()
    {
        $this->itemRole = null;
        $this->selectedPermissions = array();
        $this->showDelete = false;
    }

    public function destroy()
    {

        if($this->itemRole->name == 'Super Admin'){
            abort(403, 'SUPER ADMIN ROLE CAN NOT BE DELETED');
        }
        /*if(Auth::user()->hasRole($this->itemRole['name'])){
            abort(403, 'CAN NOT DELETE SELF ASSIGNED ROLE');
        }*/

        $message = "Роль: " . $this->itemRole->name . " удалена.";

        $this->itemRole->delete();

        $this->dispatch('banner-message', style:'danger', message: $message);

        $this->roles = Role::orderBy($this->sortField,$this->sortDirection)->get();
        $this->closeDelete();
    }


    private function updateSelectedPermission(array $selected)
    {

        $this->selectedPermissions = DB::table("permissions")->whereIn("id",$selected)
        ->pluck('name')
        ->all();

    }

    public function updated($field, $value)
    {
        // Normalize the field name and get the index and key if available
        $fieldParts = explode('.', $field);
        $index = $fieldParts[0];
        $key = $fieldParts[1] ?? null;

        if ($key=="selectPermission") {
            $this->updateSelectedPermission($this->editForm->selectPermission);
        }

    }
    // ..
}

?>

<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Roles') }}
    </h2>
</x-slot>

<div class="py-5">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            @can('role.create')
            <div class="p-2">
                <x-button.create wire:click="openCreate">{{ __('Add New Role') }}</x-button.create>
            </div>
            @endcan
            <div class="p-4 text-gray-900 dark:text-gray-100">
                <x-table>
                    <x-slot name="header">
                        <x-table.head class="hidden">ID</x-table.head>
                        <x-table.head class="inline-block"
                                sortable
                                wire:click="sortBy('name')"
                                :direction="$sortField === 'name' ? $sortDirection : null">
                                {{ __('Role Name') }}
                        </x-table.head>
                        <x-table.head class="block">{{ __('Role Permissions') }}</x-table.head>
                        <x-table.head class="block">{{ __('Action') }}</x-table.head>
                        </tr>
                    </x-slot>
                    @forelse ($roles as $role)
                    <x-table.row>
                        <x-table.cell class="hidden" scope="row">{{ $role->id }}</x-table.cell>
                        <x-table.cell class="inline-block text-black font-medium">{{ $role->name }}</x-table.cell>
                        <x-table.cell class="block">
                            @if ($role->name=='Super Admin')
                                <x-marker.permission name="{{ __('All') }}" />
                            @else
                                @forelse ($role->permissions as $permission)
                                <x-marker.permission :name="$permission->name" />
                                @empty
                                -
                                @endforelse
                            @endif
                        </x-table.cell>
                        <x-table.cell class="block">
                            <div class="flex items-center">
                                @if ($role->name!='Super Admin')
                                    @can('role.edit')
                                        <x-link.icon-edit wire:click="openEdit({{ $role->id }})" title="{{ __('Edit') }}"/>
                                    @endcan
                                    @can('role.delete')
                                        @if ($role->name!=Auth::user()->hasRole($role->name))
                                            <x-button.icon-del wire:click="openDelete({{ $role->id }})" title="{{ __('Delete') }}" />
                                        @endif
                                    @endcan
                                @endif
                            </div>
                        </x-table.cell>
                    </x-table.row>
                    @empty
                    <x-table.row>
                        <x-table.cell colspan="4">
                            <div class="text-center p-1">
                                <strong>{{ __('No Role Found!') }}</strong>
                            </div>
                        </x-table.cell>
                    </x-table.row>
                    @endforelse
                </x-table>
            </div>
        </div>
    </div>

    <x-modal-wire.dialog wire:model="showEdit" maxWidth="md">
        <x-slot name="title"><span class="grow">{{ empty($editForm->role) ? __('Add New Role') : __('Edit Role') }}</span><x-button.icon-cancel wire:click="closeCreate" class="text-gray-700 hover:text-white" /></x-slot>
        <x-slot name="content">
            <form wire:submit="save">
                <div class="p-2">
                    <x-input.label>{{ __('Role Name') }}</x-input.label>
                    <x-input.text wire:model="editForm.nameRole" required />
                    @error('editForm.nameRole') <x-error class="col-span-2">{{ $message }}</x-error> @enderror
                </div>

               <div class="p-2">
                    <x-input.label>{{ __('Role Permissions') }}</x-input.label>
                    <div class="flex flex-wrap items-center">
                        @foreach ($selectedPermissions as $permission)
                        <div class="m-1">
                            <x-marker.permission :name="$permission" />
                        </div>
                        @endforeach
                    </div>
                    <div class="">
                        <select multiple wire:model.live='editForm.selectPermission' style="height: 210px;" required>
                            <option value="">Выберите разрешение</option>
                            @foreach ($permissions as $permission)
                                <option value="{{ $permission->id }}" {{ in_array($permission->id, $itemRole['permissionsId'] ?? []) ? 'selected' : '' }}>
                                    {{ $permission->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('editForm.selectPermission') <x-error class="col-span-2">{{ $message }}</x-error> @enderror
                    </div>
                </div>
                <x-button.create type="submit">{{ __('Save') }}</x-button.create>
                <x-button.secondary wire:click="closeCreate">{{ __('Cancel') }}</x-button.secondary>
            </form>

        </x-slot>
    </x-modal-wire.dialog>

    <x-modal-wire.dialog wire:model="showDelete" maxWidth="md" type="warn">
        <x-slot name="title">
            <span class="grow">{{ __('Role delete') }}</span>
            <x-button.icon-cancel wire:click="closeDelete" class="text-gray-700 hover:text-white dark:hover:text-white" />
        </x-slot>
        <x-slot name="content">
            <div class="flex-col space-y-2">
                <x-input.label class="text-lg font-medium">Вы действительно хотите удалить запись?
                    <div class="text-black dark:text-white text-xl">
                        {{ $itemRole->name ?? '' }}
                    </div>
                </x-input.label>
                <div class="flex flex-wrap items-center">
                @foreach ($selectedPermissions as $permission)
                 <div class="m-1"><x-marker.permission :name="$permission" /></div>
                @endforeach
                </div>
                <div class="text-red-600 dark:text-red-200 shadow p-1">{{ __('Role Delete Message') }}</div>
                    <x-button.secondary wire:click="closeDelete">{{ __('Cancel') }}</x-button.secondary>
                    <x-button.danger wire:click="destroy()">{{ __('Delete')}}</x-button.danger>
                </div>
        </x-slot>
    </x-modal-wire.dialog>

    <x-spinner wire:loading wire:target="sortBy" />
    <x-spinner wire:loading wire:target="openCreate" />
    <x-spinner wire:loading wire:target="closeCreate" />
    <x-spinner wire:loading wire:target="openEdit" />
    <x-spinner wire:loading wire:target="save" />
    <x-spinner wire:loading wire:target="openDelete" />
    <x-spinner wire:loading wire:target="closeDelete" />
    <x-spinner wire:loading wire:target="destroy" />

</div>
