<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Task;

class ModelController extends Controller
{

    public function taskEdit(Task $task, bool $editable=false)
    {
        return view('models.taskEdit', ['task' => $task, 'editable'=>$editable]);
    }

}
