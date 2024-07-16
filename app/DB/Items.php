<?php

namespace App\DB;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

use App\Models\Type;

use Illuminate\Support\Facades\Log;
//Log::debug('types = ' . var_export($types));
//Log::notice('---App\DB\Items getTypeNames---');

class Items
{
    public static function getTypeNames()
    {

        $types = Type::orderBy('name','asc')->get(['id','name'])->toArray();

        return $types;

    }

    public static function getItems($type_id)
    {
        $table = DB::table('types')->where('id','=',$type_id)->get('model')->first()->model;
        $items = DB::table($table)->orderBy('created_at','desc')->first()->id;
        Log::debug('items = ' . $items);
        Log::notice('---App\DB\Items getItems---');        
    }

}
