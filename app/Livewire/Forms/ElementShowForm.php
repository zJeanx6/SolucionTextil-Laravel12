<?php

namespace App\Livewire\Forms;

use App\Models\Element;
use App\Models\Roll;
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

    public $visibleFields   = [];
    public $activeRolls     = [];
    public $inactiveRolls   = [];
    public $showInactive    = false;

    protected $groups = [
        // Rangos reales para cada tipo:
        'G1' => ['range' => [1100, 1999], 'fields' => ['broad', 'long', 'color_id'], 'is_metraje' => true],
        'G2' => ['range' => [2100, 2999], 'fields' => ['color_id','stock'],        'is_metraje' => false],
        'G3' => ['range' => [3100, 3999], 'fields' => ['stock'],                     'is_metraje' => false],
        'G4' => ['range' => [4100, 4999], 'fields' => ['stock'],                     'is_metraje' => false],
    ];

    public function show($code)
    {
        $el = Element::where('code', $code)->firstOrFail();

        $this->code            = $el->code;
        $this->name            = $el->name;
        $this->stock           = $el->stock;
        $this->broad           = $el->broad;
        $this->long            = $el->long;
        $this->color_id        = $el->color_id;
        $this->element_type_id = $el->element_type_id;
        $this->image_path      = $el->image;

        $this->updateVisibleFields();

        if ($this->isMetrajeType()) {
            // Rollos disponibles (state_id = 1)
            $this->activeRolls = Roll::where('element_code', $this->code)
                                     ->where('state_id', 1)
                                     ->get();

            // Rollos agotados (state_id = 2)
            $this->inactiveRolls = Roll::where('element_code', $this->code)
                                       ->where('state_id', 2)
                                       ->get();
        } else {
            $this->activeRolls   = [];
            $this->inactiveRolls = [];
        }
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

    public function isMetrajeType(): bool
    {
        foreach ($this->groups as $g) {
            [$min, $max] = $g['range'];
            if ($this->element_type_id >= $min && $this->element_type_id <= $max) {
                return $g['is_metraje'];
            }
        }
        return false;
    }

    public function toggleInactive()
    {
        $this->showInactive = ! $this->showInactive;
    }
}
