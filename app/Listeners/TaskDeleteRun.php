<?php

namespace App\Listeners;

use App\Events\TaskDelete;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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

        // удаление заметок
        DB::table('notes')->where('type_id','=',$typeId)->where('item_id','=',$task->id)->delete();

        // удаление вложений
        DB::table('files')->where('type_id','=',$typeId)->where('item_id','=',$task->id)->delete();
        Storage::disk('public')->deleteDirectory('/'.self::TYPE.'/'.$task->id);

        // удаление задачи
        $task->delete(); 

    }
}
