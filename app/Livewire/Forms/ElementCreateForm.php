<?php

namespace App\Livewire\Forms;

use App\Models\Element;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Rule;
use Livewire\Form;
use Livewire\WithFileUploads;

class ElementCreateForm extends Form
{
    use WithFileUploads;

    #[Rule('required|integer|unique:elements,code')]
    public $code;

    #[Rule('required|string|min:3|max:255')]
    public $name;

    #[Rule('required|integer|min:0')]
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

    public function save()
    {
        $this->validate();

        $path = $this->photo ? $this->photo->store('elements', 'public') : null;

        Element::create([
            'code'             => $this->code,
            'name'             => $this->name,
            'stock'            => $this->stock,
            'broad'            => $this->broad,
            'long'             => $this->long,
            'color_id'         => $this->color_id,
            'element_type_id'  => $this->element_type_id,
            'image'            => $path,
        ]);

        $this->reset();              // limpia todos los campos
    }
}
