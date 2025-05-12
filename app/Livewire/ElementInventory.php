<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\{Element, ElementType, Color};

class ElementInventory extends Component
{
    use WithPagination, WithFileUploads;

    /* ---------- estado y catálogos ----------- */
    public $view = 'index';
    public $elementTypes = [];
    public $colors       = [];

    /* ---------- formulario ----------- */
    public $code, $name, $stock, $broad, $long, $color_id, $element_type_id, $photo;                      
    public array $visibleFields = [];

    /* grupos → campos requeridos */
    protected array $groups = [
        'G1' => ['range'=>[101,118],'fields'=>['broad','long','color_id']],
        'G2' => ['range'=>[201,211],'fields'=>['color_id']],
        'G3' => ['range'=>[301,311],'fields'=>[]],
        'G4' => ['range'=>[401,410],'fields'=>[]],
    ];

    /* ---------------- ciclo de vida ---------------- */
    public function mount()
    {
        $this->elementTypes = ElementType::orderBy('name')->get();
        $this->colors       = Color::orderBy('name')->get();
    }

    /* ---------------- navegación ------------------- */
    public function index()  { $this->resetForm(); $this->view = 'index'; }
    public function create() { $this->resetForm(); $this->view = 'create'; }

    /* ---- al cambiar tipo decide campos visibles --- */
    public function updatedElementTypeId($value)
    {
        $this->visibleFields = [];
        foreach ($this->groups as $g) {
            [$min,$max] = $g['range'];
            if ($value >= $min && $value <= $max) {
                $this->visibleFields = $g['fields'];
                break;
            }
        }
    }

    /* ---------------- guardar ---------------------- */
    public function save()
    {
        $rules = [
            'code'            => 'required|integer|unique:elements,code',
            'name'            => 'required|string|max:255',
            'stock'           => 'required|integer|min:0',
            'element_type_id' => 'required|exists:element_types,id',
            'photo'           => 'nullable|image|max:2048',
        ];
        if (in_array('broad',$this->visibleFields))   $rules['broad']    = 'required|numeric|min:0.01';
        if (in_array('long',$this->visibleFields))    $rules['long']     = 'required|numeric|min:0.01';
        if (in_array('color_id',$this->visibleFields))$rules['color_id'] = 'required|exists:colors,id';

        $this->validate($rules);

        $path = $this->photo ? $this->photo->store('elements','public') : null;

        Element::create([
            'code'            => $this->code,
            'name'            => $this->name,
            'stock'           => $this->stock,
            'image'           => $path,
            'broad'           => $this->broad,
            'long'            => $this->long,
            'color_id'        => $this->color_id,
            'element_type_id' => $this->element_type_id,
        ]);

        $this->dispatch('notification', 'Elemento creado correctamente');
        $this->index();
    }

    /* ---------------- render ----------------------- */
    public function render()
    {
        $elements = Element::latest()->paginate(12);
        return view('livewire.element-inventory',compact('elements'));
    }

    /* ---------------- helpers ---------------------- */
    private function resetForm()
    {
        $this->reset([
            'code','name','stock','broad','long',
            'color_id','element_type_id','photo','visibleFields'
        ]);
    }
}
