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

    private static function getTypeId($type)
    {
        return DB::table('types')->where('model','=',$type)->get('id')->first()->id;
    }

    public static function get($id)
    {
        return Note::find($id);
    }

    public static function getList($type,$item)
    {
        $typeId = self::getTypeId($type);
        //if paginate then delete ->get()
        $notes = Note::where('type_id','=',$typeId)->where('item_id','=',$item)->orderBy('created_at','desc'); 

        return $notes;
    }

    public static function getCount($type,$item)
    {
        $typeId = self::getTypeId($type);
        $count = Note::where('type_id','=',$typeId)->where('item_id','=',$item)->count();
        
        return $count;
    }

    public static function create($type,$item,$note)
    {
        $data =[
            'parent_id' => 0,
            'autor_id' => Auth::id(),
            'type_id' => self::getTypeId($type),
            'item_id' => $item,
            'note' => trim($note)
        ];

        Note::create($data);
    }

    public static function delete($id)
    {
        Note::find($id)->delete();
    }
    
}
