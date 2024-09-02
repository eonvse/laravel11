<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

use Illuminate\Support\Facades\Auth;

use App\DB\Events;

class EventForm extends Form
{
    #[Validate('required|min:3')]
    public $name;

    #[Validate('required|date')]
    public $day;

    #[Validate('nullable')]
    public $start;

    #[Validate('nullable')]
    public $end;

    #[Validate('required|numeric')]
    public $type_id;

    #[Validate('required|numeric')]
    public $item_id;

    #[Validate('nullable|min:10')]
    public $content;



    public function create()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'autor_id' => Auth::id(),
            'type_id' => $this->type_id,
            'item_id' => $this->item_id,
            'day' => $this->day,
            'start' => $this->start ?? null,
            'end' => $this->end ?? null,
            'content' => $this->content ?? null,
        ];

        Events::create($data);

        $this->reset();
        $this->resetValidation();
    }
}
