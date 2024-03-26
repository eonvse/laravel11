<?php

namespace App\DB;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
//use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

use App\Models\Note;

//use Illuminate\Support\Facades\Log;
//Log::debug('variable = ' . $variable);
//Log::notice('---App\DB\Notes item---');

class Notes
{

    public static function get($model,$modelId)
    {
        $typeId = DB::table('types')->where('model','=',$model)->get('id')->first()->id;
        //if paginate then delete ->get()
        $notes = Note::where('type_id','=',$typeId)->where('item_id','=',$modelId)->orderBy('created_at','desc')->get(); 

        return $notes;
    }
    
}
