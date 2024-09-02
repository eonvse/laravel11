<?php

namespace App\Listeners;

use App\Events\EventCreate;
use App\Models\LogStatus;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use Illuminate\Support\Facades\DB;

class EventCreateRun
{
    private const TYPE = 'events';  
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */

    private function getStatusNew($type)
    {
        return DB::table('statuses')->where('type_id','=',$type)->where('name','=','Создано')->get('id')->first()->id;
    }

    private function getTypeId($type)
    {
        return DB::table('types')->where('model','=',$type)->get('id')->first()->id;
    }

    //При добавлении нового события автоматом писать в лог статусов "Создано"
    public function handle(EventCreate $create): void
    {
        $event = $create->event;
        $typeId = $this->getTypeId(self::TYPE);
        $statusId = $this->getStatusNew($typeId);

        $data = [
            'type_id'=>$typeId,
            'item_id'=>$event->id,
            'status_id'=>$statusId,
            'autor_id'=>$event->autor_id,
        ];

        LogStatus::create($data);



    }
}
