<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;
    protected $fillable = ['name','url','autor_id','type_id','item_id','local'];
    protected $primaryKey = 'id';

    public function getCreatedAttribute()
    {
        return date('d.m.y H:i', strtotime($this->created_at));
    }

    public function autor()
    {
        return $this->hasOne(User::class,'id','autor_id');
    }


}
