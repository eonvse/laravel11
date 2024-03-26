<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/*
?????
Под вопросом наличие самой модели в проекте 
?????
*/
class Type extends Model
{
    use HasFactory;
    protected $fillable = ['model','name'];
    protected $primaryKey = 'id';
    public $timestamps = false;

}
