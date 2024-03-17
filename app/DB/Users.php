<?php

namespace App\DB;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\Models\User;



class Users
{

    public static function list($sortField, $sortDirection, $filter=null)
    {
        $users = User::orderBy($sortField,$sortDirection)->get();

        return $users;

    }

    public static function get($id)
    {
        return User::find($id);
    }

    public static function getFieldValue($id, $field)
    {
        return User::where('id','=',$id)->pluck($field)->toArray()[0];
    }

    public static function getRolesId($id)
    {
        return DB::table("model_has_roles")->where("model_id",$id)
        ->pluck('role_id')
        ->all();
    }

    public static function getSelectedRolesName($selected)
    {
        return DB::table("roles")->whereIn("id",$selected)
        ->pluck('name')
        ->all();
    }


    public static function getRolesList()
    {
        return DB::table('roles')->where('name','<>','Super Admin')->orderBy('name','asc')->get();
    }

    public static function setFieldValue($id, $field,$value) : void
    {
        User::where('id','=',$id)->update([$field=>$value]);
    }

    public static function create($data)
    {
        return User::create($data);
    }

    public static function update($id,$data)
    {
        $user = User::find($id);
        $user->update($data);

        return $user;
    }

    public static function delete($userId)
    {
        User::findOrFail($userId)->delete();
    }

}
