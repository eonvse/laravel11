<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\DB\Notes;

class Task extends Model
{
    protected $fillable = [ 'name',
                            'autor_id',
                            'team_id',
                            'color_id',
                            'day',
                            'start',
                            'end',
                            'content',
                            'isDone',
                            'dateDone',];
    protected $primaryKey = 'id';

    protected $appends =['created','updated','dayFormat','startFormat','endFormat','notesCount','dateDoneFormat'];

    protected $visible = ['name','dayFormat','startFormat','endFormat','content','notesCount','dateDoneFormat','created','updated'];

        //---------------------------------------------------------
        //            GET ATTRIBUTES
        //---------------------------------------------------------

    public function getCreatedAttribute()
    {

        return date('d.m.Y H:i', strtotime($this->created_at));

    }

    public function getUpdatedAttribute()
    {

        return date('d.m.Y H:i', strtotime($this->updated_at));

    }

    public function getDayFormatAttribute()
    {

        if (empty($this->day)) return $this->day;
        else return date('d.m.Y', strtotime($this->day));

    }

    public function getStartFormatAttribute()
    {

        if (empty($this->start)) return $this->start;
        else return date('H:i', strtotime($this->start));

    }

    public function getEndFormatAttribute()
    {

        if (empty($this->end)) return $this->end;
        else return date('H:i', strtotime($this->end));

    }

    public function getDateDoneFormatAttribute()
    {

        if (empty($this->dateDone)) return $this->dateDone;
        else return date('d.m.Y', strtotime($this->dateDone));

    }


    public function getNotesCountAttribute()
    {
        return Notes::getCount('tasks',$this->id);
    }

        //---------------------------------------------------------
        //              SET ATTRIBUTES
        //---------------------------------------------------------*/

    public function setDayAttribute($day)
    {

        $this->attributes['day'] = $day ?: null;

    }

    public function setStartAttribute($start)
    {

       $this->attributes['start'] = $start ?: null;

    }

    public function setEndAttribute($end)
    {

        $this->attributes['end'] = $end ?: null;

    }

    public function setContentAttribute($content)
    {

         $this->attributes['content'] = trim($content) ?: null;

    }

        //---------------------------------------------------------
        //              ОТНОШЕНИЯ
        //---------------------------------------------------------*/

    public function color()
    {
        return $this->hasOne(Color::class,'id','color_id');
    }

    public function autor()
    {
        return $this->hasOne(User::class,'id','autor_id');
    }

}
