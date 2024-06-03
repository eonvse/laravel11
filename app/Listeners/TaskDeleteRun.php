<?php

namespace App\Listeners;

use App\Events\TaskDelete;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use Illuminate\Support\Facades\DB;

class TaskDeleteRun
{
    private const TYPE = 'tasks';
    
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    private function getTypeId($type)
    {
        return DB::table('types')->where('model','=',$type)->get('id')->first()->id;
    }

    /**
     * Handle the event.
     */
    public function handle(TaskDelete $event): void
    {
        $task = $event->task;
        $typeId = $this->getTypeId(self::TYPE);
        $notes = DB::table('notes')->where('type_id','=',$typeId)->where('item_id','=',$task->id)->delete();
        $task->delete(); 

    }
}
