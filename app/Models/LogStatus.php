<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'type_id',  // id типа (модель)
        'item_id',  // id элемента модели
        'new_id',   // новый статус на дату создания (id)
        'old_id',   // старый статус на дату создания (id)
        'autor_id', // автор записи (id)
    ];
    protected $primaryKey = 'id';

    public function getCreatedAttribute()
    {
        return date('d.m.y H:i', strtotime($this->created_at));
    }
}
