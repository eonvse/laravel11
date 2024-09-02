<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//Модель Events = События
class Event extends Model
{
    use HasFactory;

    protected $fillable = ['day','start','end','type_id','item_id','autor_id','name','content'];
    protected $primaryKey = 'id';

    protected $appends =['created','dayF','startF','endF'];

    protected $visible = ['name','dayF','startF','endF','content','created','updated'];    // ??? сразу включить текущий статус и тип.
                                                                                            // ??? через отношения

    //форматированная дата события
    public function getDayFAttribute()
    {
        $weekDays = array( 1 => 'Пн' , 'Вт' , 'Ср' , 'Чт' , 'Пт' , 'Сб' , 'Вс' );

        if(!empty($this->day)) return $weekDays[date('N',strtotime($this->day))].' '.date('d.m.Y', strtotime($this->day)) ;
        else return '';
    }

    //форматированное время начала
    public function getStartFAttribute()
    {
        if(!empty($this->start)) return date('H:i', strtotime($this->start));
        else return '';
    }

    //форматированное время завершения
    public function getEndFAttribute()
    {
        if(!empty($this->end)) return date('H:i', strtotime($this->end));
        else return '';
    }

    //форматированное время создания
    public function getCreatedAttribute()
    {
        return date('d.m.Y H:i', strtotime($this->created_at));
    }


    //---------------------------------------------------------
    //              ОТНОШЕНИЯ
    //---------------------------------------------------------*/

    public function autor()
    {
        return $this->hasOne(User::class,'id','autor_id');
    }

    public function type()
    {
        return $this->hasOne(Type::class,'id','type_id');
    }


}
