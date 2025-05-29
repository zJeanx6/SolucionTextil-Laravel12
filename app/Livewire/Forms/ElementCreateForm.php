<?php

namespace App\Livewire\Forms;

use App\Models\{Element, Roll};
use Livewire\Form;
use Livewire\WithFileUploads;

class ElementCreateForm extends Form
{
    use WithFileUploads;

    public $code;
    public $name;
    public $stock;
    public $broad;
    public $long;
    public $color_id = '';
    public $element_type_id = '';
    public $photo;

    // Para rollos (solo G-01)
    public $roll_count = 1;
    public $roll_codes = [];

    public $visibleFields = [];

    protected $groups = [
        'G1' => [
            'range'  => [1100, 1999],
            'fields' => ['color_id'],
            'is_metraje' => true,
        ],
        'G2' => [
            'range'  => [2100, 2999],
            'fields' => ['color_id', 'stock'],
            'is_metraje' => false,
        ],
        'G3' => [
            'range'  => [3100, 3999],
            'fields' => ['stock'],
            'is_metraje' => false,
        ],
        'G4' => [
            'range'  => [4100, 4999],
            'fields' => ['stock'],
            'is_metraje' => false,
        ],
    ];

    // ------------ VISIBILIDAD Y GRUPO ------------

    public function updatedElementTypeId($value)
    {
        $this->element_type_id = $value;
        $this->visibleFields = [];
        foreach ($this->groups as $g) {
            [$min, $max] = $g['range'];
            if ($value >= $min && $value <= $max) {
                $this->visibleFields = $g['fields'];
                break;
            }
        }
    }

    public function isMetrajeType()
    {
        foreach ($this->groups as $g) {
            [$min, $max] = $g['range'];
            if ($this->element_type_id >= $min && $this->element_type_id <= $max) {
                return $g['is_metraje'];
            }
        }
        return false;
    }

    // ------------ VALIDACIÓN DINÁMICA ------------

    public function rules()
    {
        $rules = [
            'code'             => 'required|digits_between:5,10|unique:elements,code',
            'name'             => 'required|string|min:3|max:255',
            'element_type_id'  => 'required|integer|exists:element_types,id',
            'photo'            => 'nullable|image|max:2048',
        ];

        if (in_array('color_id', $this->visibleFields)) {
            $rules['color_id'] = 'required|exists:colors,id';
        }

        if (in_array('stock', $this->visibleFields)) {
            $rules['stock'] = 'required|integer|min:0';
        }

        // G-01: metraje (rollos)
        if ($this->isMetrajeType()) {
            $rules['broad'] = 'required|numeric|min:0.01';
            $rules['long']  = 'required|numeric|min:0.01';
            $rules['roll_count'] = 'required|integer|min:1|max:20';
            $rules['roll_codes'] = 'required|array|size:' . $this->roll_count;
            foreach ($this->roll_codes as $k => $code) {
                $rules["roll_codes.$k"] = 'required|digits_between:5,10|unique:rolls,code';
            }
        }

        return $rules;
    }

    // ------------ GUARDADO ------------

    public function save()
    {
        $this->validate();

        $path = $this->photo ? $this->photo->store('elements', 'public') : null;

        if ($this->isMetrajeType()) {
            $element = Element::create([
                'code'            => $this->code,
                'name'            => $this->name,
                'stock'           => 0, // metraje no usa stock aquí
                'color_id'        => $this->color_id,
                'element_type_id' => $this->element_type_id,
                'image'           => $path,
            ]);
            // Crear N rollos
            foreach ($this->roll_codes as $roll_code) {
                Roll::create([
                    'code'         => $roll_code,
                    'broad'        => $this->broad,
                    'long'         => $this->long,
                    'element_code' => $element->code,
                ]);
            }
        } else {
            Element::create([
                'code'            => $this->code,
                'name'            => $this->name,
                'stock'           => $this->stock,
                'color_id'        => in_array('color_id', $this->visibleFields) ? $this->color_id : null,
                'element_type_id' => $this->element_type_id,
                'image'           => $path,
            ]);
        }

        $this->reset(['code', 'name', 'stock', 'broad', 'long', 'color_id', 'element_type_id', 'photo', 'roll_count', 'roll_codes', 'visibleFields']);
    }
}
