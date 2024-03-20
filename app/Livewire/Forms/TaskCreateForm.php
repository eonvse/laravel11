<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

use Illuminate\Support\Facades\Auth;

use App\DB\Tasks;
use App\Models\Color;

class TaskCreateForm extends Form
{
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

    #[Validate('nullable')]
    public $endTask;

    public function store()
    {
        $this->validate();
        
        $data = [
            'name' => $this->nameTask,
            'autor_id' => Auth::id(),
            'team_id' => 0,
            'color_id' => $this->colorTask ?? 1,
            'day' => $this->dayTask ?? null,
            'start' => $this->startTask ?? null,
            'end' => $this->endTask ?? null,
            'content' => $this->contentTask ?? null,
            'isDone' => 0,
            'dateDone' => null,
        ];

        Tasks::create($data);

        $this->reset();
        $this->resetValidation();
    }
}
