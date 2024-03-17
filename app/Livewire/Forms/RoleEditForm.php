<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Illuminate\Support\Facades\DB;
//use Illuminate\Support\Facades\Log;
//Log::debug();
//Log::notice('---RoleEditForm---');

class RoleEditForm extends Form
{
    public ?Role $role;

    #[Validate('required|min:5|unique:Spatie\Permission\Models\Role,name')]
    public $name = '';

    #[Validate('required')]
    public $selectPermission = array();

    public function setRole($role)
    {
        $this->role = $role;
        $this->name = $role->name;

        $rolePermissions = DB::table("role_has_permissions")->where("role_id",$role->id)
        ->pluck('permission_id')
        ->all();

        $this->selectPermission =  $rolePermissions;

    }

    public function store()
    {

        if (empty($this->role)) {
            $this->validate();
            $this->role = Role::create(['name' => $this->name]);
        }else{
            $this->role->update(['name' => $this->name]);
        }

        $permissions = Permission::whereIn('id', $this->selectPermission)->get(['name'])->toArray();
        $this->role->syncPermissions($permissions);

        $this->reset();
        $this->resetValidation();
    }

}
