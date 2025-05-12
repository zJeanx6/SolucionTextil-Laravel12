<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\{Element, ElementType, Color};

class ElementInventory extends Component
{
    use WithPagination, WithFileUploads;

    /* ---------- navegación ---------- */
    public string $view = 'index';

    /* ---------- catálogos ----------- */
    public $elementTypes = [];
    public $colors       = [];

    /* ---------- formulario ----------- */
    public ?int    $code            = null;   // ← ahora sí
    public ?string $name            = null;
    public ?int    $stock           = null;
    public ?float  $broad           = null;
    public ?float  $long            = null;
    public ?int    $color_id        = null;
    public ?int    $element_type_id = null;
    public $photo                   = null;   // imagen (TemporaryUploadedFile)

    public array $visibleFields = [];

    /* grupos → campos requeridos (imagen ya no está aquí) */
    protected array $groups = [
        'G1' => ['range'=>[101,118],'fields'=>['broad','long','color_id']],
        'G2' => ['range'=>[201,211],'fields'=>['color_id']],
        'G3' => ['range'=>[301,311],'fields'=>[]],
        'G4' => ['range'=>[401,410],'fields'=>[]],
    ];

    /* ---------------- ciclo de vida ---------------- */
    public function mount(): void
    {
        $this->elementTypes = ElementType::orderBy('name')->get();
        $this->colors       = Color::orderBy('name')->get();
    }

    /* ---------------- navegación ------------------- */
    public function index(): void  { $this->resetForm(); $this->view = 'index'; }
    public function create(): void { $this->resetForm(); $this->view = 'create'; }

    /* ---- al cambiar tipo decide campos visibles --- */
    public function updatedElementTypeId($value): void
    {
        $this->visibleFields = [];
        foreach ($this->groups as $g) {
            [$min,$max] = $g['range'];
            if ($value >= $min && $value <= $max) {
                $this->visibleFields = $g['fields'];
                break;
            }
        }

        /*  sugerir código si aún no se escribió  */
        if (blank($this->code) && $value) {
            // Ej: 115 → 11501
            $this->code = $value * 100 + 1;
        }
    }

    /* ---------------- guardar ---------------------- */
    public function save(): void
    {
        /* reglas base */
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
    private function resetForm(): void
    {
        $this->reset([
            'code','name','stock','broad','long',
            'color_id','element_type_id','photo','visibleFields'
        ]);
    }
}
