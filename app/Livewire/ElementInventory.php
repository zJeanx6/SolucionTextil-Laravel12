<?php

namespace App\Livewire;

use App\Models\Element;
use Livewire\Component;

class ElementInventory extends Component
{
    public $elements;

    public function mount()
    {
        $this->elements = Element::all();
    }

    public function render()
    {
        return view('livewire.element-inventory');
    }
}
