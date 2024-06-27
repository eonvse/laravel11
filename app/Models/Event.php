<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//Модель Events = События
class Event extends Model
{
    use HasFactory;

    protected $fillable = ['day','start','end','type_id','item_id','autor_id','title','content','status_id'];
    protected $primaryKey = 'id';

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


}
