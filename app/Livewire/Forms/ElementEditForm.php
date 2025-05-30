<?php

namespace App\Livewire\Forms;

use App\Models\Element;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Rule;
use Livewire\Form;
use Livewire\WithFileUploads;

class ElementEditForm extends Form
{
    use WithFileUploads;

    public $code = '';

    #[Rule('required|integer')]
    public $code_edit;

    #[Rule('required|string|max:255')]
    public $name;

    #[Rule('required|numeric|min:0')]
    public $stock;

    #[Rule('nullable|numeric|min:0.01')]
    public $broad;

    #[Rule('nullable|numeric|min:0.01')]
    public $long;

    #[Rule('nullable|exists:colors,id')]
    public $color_id;

    #[Rule('required|exists:element_types,id')]
    public $element_type_id;

    #[Rule('nullable|image|max:2048')]
    public $photo;

    public $image_path = null;

    public $visibleFields = [];

    protected $groups = [
        'G1' => ['range' => [101, 118], 'fields' => ['broad', 'long', 'color_id']],
        'G2' => ['range' => [201, 211], 'fields' => ['color_id']],
        'G3' => ['range' => [301, 311], 'fields' => []],
        'G4' => ['range' => [401, 410], 'fields' => []],
    ];

    public function edit($code)
    {
        $element = Element::where('code', $code)->firstOrFail();

        $this->code            = $element->code;
        $this->code_edit       = $element->code;
        $this->name            = $element->name;
        $this->stock           = $element->stock;
        $this->broad           = $element->broad;
        $this->long            = $element->long;
        $this->color_id        = $element->color_id;
        $this->element_type_id = $element->element_type_id;
        $this->photo           = null;
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

    public function update()
    {
        $this->validate();

        $element = Element::where('code', $this->code)->firstOrFail();

        // manejo de imagen
        if ($this->photo) {
            if ($element->image && Storage::disk('public')->exists($element->image)) {
                Storage::disk('public')->delete($element->image);
            }
            $element->image = $this->photo->store('elements', 'public');
        }

        $element->update([
            // 'code'             => $this->code_edit, // descomenta si permites cambiar code
            'name'             => $this->name,
            'stock'            => $this->stock,
            'broad'            => $this->broad,
            'long'             => $this->long,
            'color_id'         => $this->color_id,
            'element_type_id'  => $this->element_type_id,
            'image'            => $element->image,
        ]);

        $this->reset();
    }
}
