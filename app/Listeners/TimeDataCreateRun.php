<?php

namespace App\Listeners;

use App\Events\TimeDataCreate;
use App\Models\LogStatus;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use Illuminate\Support\Facades\DB;

class TimeDataCreateRun
{
    private const TYPE = 'time_data';  
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
    public function handle(TimeDataCreate $event): void
    {
        $timeData = $event->timeData;
        $typeId = $this->getTypeId(self::TYPE);
        $statusId = $this->getStatusNew($typeId);

        $data = [
            'type_id'=>$typeId,
            'item_id'=>$timeData->id,
            'status_id'=>$statusId,
            'autor_id'=>$timeData->autor_id,
        ];

        LogStatus::create($data);



    }
}
