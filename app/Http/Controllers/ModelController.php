<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Task;
use App\DB\Notes;

class ModelController extends Controller
{

    public function taskEdit(Task $task, bool $editable=false)
    {
        $notes = Notes::get('tasks',$task->id);
        return view('models.taskEdit', ['task' => $task, 'editable'=>$editable, 'notes'=>$notes]);
    }

}
