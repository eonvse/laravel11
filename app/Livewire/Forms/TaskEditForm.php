<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

use App\Models\Task;

class TaskEditForm extends Form
{
    public ?Task $task;

    #[Validate('required|min:3')]
    public $nameTask;

    #[Validate('nullable|digits_between:1,2')]
    public $colorTask;

    #[Validate('nullable|min:10')]
    public $contentTask;

    #[Validate('nullable|date')]
    public $dayTask;

    #[Validate('nullable')]
    public $startTask;

    #[Validate('nullable|after:startTask')]
    public $endTask;

    /*
    team_id
    isDone
    dateDone
    */
    public function setTask($task)
    {
        $this->task = $task;
        $this->nameTask = $task->name;
        $this->colorTask = $task->color_id;
        $this->dayTask = $task->day;
        $this->startTask = $task->start;
        $this->endTask = $task->end;

    }

    public function setTaskContent($task)
    {
        $this->task = $task;
        $this->contentTask = $task->content;

    }


    public function store()
    {

        $this->validate();

        $data = [
            'name' => $this->nameTask,
            'color_id' => $this->colorTask ?? 1,
            'day' => $this->dayTask ?? null,
            'start' => $this->startTask ?? null,
            'end' => $this->endTask ?? null,
        ];

        $this->task->update($data);
    }

    public function storeContent()
    {

        $this->validateOnly('contentTask');
        $this->contentTask = trim($this->contentTask);

        $this->task->update(['content' => $this->contentTask ?? null]);

    }


}
