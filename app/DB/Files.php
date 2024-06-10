<?php

namespace App\DB;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

use App\Models\File;

//use Illuminate\Support\Facades\Log;
//Log::debug('variable = ' . $variable);
//Log::notice('---App\DB\Files item---');

class Files
{

    private static function getTypeId($type)
    {
        return DB::table('types')->where('model','=',$type)->get('id')->first()->id;
    }

    public static function get($id)
    {
        return File::find($id);
    }

    public static function getList($type,$item)
    {
        $typeId = self::getTypeId($type);
        //if paginate then delete ->get()
        $files = File::where('type_id','=',$typeId)->where('item_id','=',$item)->orderBy('created_at','desc'); 

        return $files;
    }

    public static function getCount($type,$item)
    {
        $typeId = self::getTypeId($type);
        $count = File::where('type_id','=',$typeId)->where('item_id','=',$item)->count();
        
        return $count;
    }

    public static function create($type,$item,$file,$webName,$webUrl)
    {
        $name = $webName;
        $url = $webUrl;
        $isLocal = 0;

        if (!empty($file)) {
            $patch = ''.$type.'/'.$item;
            $name = $file->getClientOriginalName();
            $nameLocal = Str::random(3).'_'.$name;
            $isLocal = 1;
            $url = $patch.'/'.$nameLocal;
            $file->storeAs($patch,$nameLocal,'public');
        };

        $data = array(
            'name'=>$name,
            'url'=>$url,
            'autor_id'=>Auth::id(),
            'type_id'=>self::getTypeId($type),
            'item_id'=>$item,
            'isLocal'=>$isLocal 
        );

        File::create($data);
    }

    public static function delete($id)
    {
        File::find($id)->delete();
    }

    public static function setFieldValue($id, $field,$value) : void
    {
        File::where('id','=',$id)->update([$field=>$value]);
    }
    
}
