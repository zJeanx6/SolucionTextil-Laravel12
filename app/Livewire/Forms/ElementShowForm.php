<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use App\Models\Element;
use Livewire\Form;

class ElementShowForm extends Form
{
    public $code;
    public $name;
    public $stock;
    public $broad;
    public $long;
    public $color_id;
    public $element_type_id;
    public $image_path;

    public function show($code)
    {
        $element = Element::where('code', $code)->firstOrFail();

        $this->code            = $element->code;
        $this->name            = $element->name;
        $this->stock           = $element->stock;
        $this->broad           = $element->broad;
        $this->long            = $element->long;
        $this->color_id        = $element->color_id;
        $this->element_type_id = $element->element_type_id;
        $this->image_path      = $element->image;
    }
}

