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

    public $visibleFields = [];

    protected $groups = [
        'G1' => ['range' => [101, 118], 'fields' => ['broad', 'long', 'color_id']],
        'G2' => ['range' => [201, 211], 'fields' => ['color_id']],
        'G3' => ['range' => [301, 311], 'fields' => []],
        'G4' => ['range' => [401, 410], 'fields' => []],
    ];

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

        // Aquí actualizamos los campos visibles según el tipo de elemento
        $this->updateVisibleFields();
    }

    protected function updateVisibleFields()
    {
        $this->visibleFields = [];
        foreach ($this->groups as $g) {
            [$min, $max] = $g['range'];
            if ($this->element_type_id >= $min && $this->element_type_id <= $max) {
                $this->visibleFields = $g['fields'];
                break;
            }
        }
    }

}
