<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\{Element, ElementType, Color};
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\{Lazy, Url};

#[Lazy]
class ElementInventory extends Component
{
    use WithPagination, WithFileUploads;

    /* ------------------------- estado global inicial ------------------------- */
    public $view = 'index';

    #[Url(except: '', keep: false, history: true)]
    public $search = '';

    #[Url(as: 'edit', except: '', keep: false, history: true)]
    public $editId = '';       //  ← inicia en cadena vacía



    public $sortField = 'code';
    public $sortDirection = 'desc';

    /* filtros en la tabla del estado index */
    public $elementTypeFilter = '';
    public $colorFilter       = '';

    /* catálogos de los selects */
    public $elementTypes = [];
    public $colors       = [];

    /* -------------------- propiedades del formulario ----------------- */
    public $code, $name, $stock, $broad, $long;
    public $color_id = '';
    public $element_type_id = '';
    public $photo; // TemporaryUploadedFile (imagen)

    /** @var Element|null  elemento que estamos editando */
    public $editing = null;

    /* campos visibles según grupo */
    public array $visibleFields = [];

    protected array $groups = [
        'G1' => ['range' => [101, 118], 'fields' => ['broad', 'long', 'color_id']],
        'G2' => ['range' => [201, 211], 'fields' => ['color_id']],
        'G3' => ['range' => [301, 311], 'fields' => []],
        'G4' => ['range' => [401, 410], 'fields' => []],
    ];

    /* ---------------- ciclo de vida ---------------- */
    public function mount(): void
    {
        if (!$this->elementTypes) {
            $this->elementTypes = ElementType::orderBy('name')->get();
        }
        if (!$this->colors) {
            $this->colors = Color::orderBy('name')->get();
        }

        // si llega ?edit=…
        if ($this->editId) {
            $this->edit($this->editId);   // carga el formulario si llega ?edit=
        }
    }

    public function placeholder()
    {
        return view('livewire.placeholders.skeleton');
    }

    /* ---------------- navegación ------------------- */
    public function index()
    {
        $this->resetForm();
        $this->reset('search','elementTypeFilter','colorFilter');
        $this->editId = '';    // quita ?edit
        $this->view   = 'index';
    }
    public function create(): void
    {
        $this->resetForm();
        $this->reset('search', 'elementTypeFilter', 'colorFilter');
        $this->editId = '';      // limpia ?edit
        $this->view   = 'create';
    }


    /* ---------------- cargar elemento en estado de edición ---------------- */
    public function edit($code)
    {
        $this->resetForm();
        $this->editing = Element::findOrFail($code);

        // Pasa atributos a las propiedades públicas
        $this->code            = $this->editing->code;
        $this->name            = $this->editing->name;
        $this->stock           = $this->editing->stock;
        $this->broad           = $this->editing->broad;
        $this->long            = $this->editing->long;
        $this->color_id        = $this->editing->color_id;
        $this->element_type_id = $this->editing->element_type_id;

        // calcula campos visibles
        $this->updatedElementTypeId($this->editing->element_type_id);

        $this->search = '';   // opcional: quita búsqueda
        $this->editId = $code;     // ahora aparece ?edit=#####
        $this->view   = 'edit';
    }

    /* ---------------- hook select live ---------------- */
    public function updatedElementTypeId($value)
    {
        $this->visibleFields = [];
        foreach ($this->groups as $g) {
            [$min, $max] = $g['range'];
            if ($value >= $min && $value <= $max) {
                $this->visibleFields = $g['fields'];
                break;
            }
        }
    }

    /* ---------------- guardar nuevo ------------------ */
    public function save()
    {
        $rules = $this->validationRules();
        $this->validate($rules);

        $path = $this->photo ? $this->photo->store('elements', 'public') : null;

        Element::create($this->payload($path));

        $this->dispatch('notification', ['Elemento creado correctamente']);
        $this->index();
    }

    /* ---------------- actualizar existente ----------- */
    public function update()
    {
        if (!$this->editing) return;

        $rules = $this->validationRules($this->editing->code);
        $this->validate($rules);

        /* imagen: si llega una nueva -> guardamos y (opcional) borramos la vieja */
        $path = $this->editing->image;
        if ($this->photo) {
            // elimina imagen antigua si la hay
            if ($path && Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
            $path = $this->photo->store('elements', 'public');
        }

        $this->editing->update($this->payload($path));

        $this->dispatch('notification', ['Elemento actualizado.']);
        $this->index();
    }

    /* ---------------- eliminar ----------------------- */
    public function delete($code)
    {
        $element = Element::findOrFail($code);
        // borra la imagen asociada si existe
        if ($element->image && Storage::disk('public')->exists($element->image)) {
            Storage::disk('public')->delete($element->image);
        }
        $element->delete();

        $this->dispatch('notification', ['Elemento eliminado.']);
    }

    /* ---------------- render ------------------------- */
    public function render()
    {
        $elements = Element::query()
            ->when(
                $this->search,
                fn($q) =>
                $q->where(function ($sub) {
                    $sub->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('code', 'like', '%' . $this->search . '%');
                })
            )
            ->when(
                $this->elementTypeFilter,
                fn($q) =>
                $q->where('element_type_id', $this->elementTypeFilter)
            )
            ->when(
                $this->colorFilter,
                fn($q) =>
                $q->where('color_id', $this->colorFilter)
            )
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(8);

        return view('livewire.element-inventory', compact('elements'));
    }

    /* ---------------- helpers ------------------------ */
    private function resetForm()
    {
        $this->reset([
            'code',
            'name',
            'stock',
            'broad',
            'long',
            'color_id',
            'element_type_id',
            'photo',
            'visibleFields',
            'editing'
        ]);
    }

    /** Reglas; $ignoreCode permite excluir el código propio en update */
    private function validationRules($ignoreCode = 0)
    {
        $rules = [
            'code'            => 'required|integer|unique:elements,code,' . ($ignoreCode ?: 'NULL') . ',code',
            'name'            => 'required|string|max:255',
            'stock'           => 'required|integer|min:0',
            'element_type_id' => 'required|exists:element_types,id',
            'photo'           => 'nullable|image|max:2048',
        ];
        if (in_array('broad', $this->visibleFields))   $rules['broad']    = 'required|numeric|min:0.01';
        if (in_array('long', $this->visibleFields))    $rules['long']     = 'required|numeric|min:0.01';
        if (in_array('color_id', $this->visibleFields)) $rules['color_id'] = 'required|exists:colors,id';

        return $rules;
    }

    /** Arma arreglo listo para create/update */
    private function payload($imagePath)
    {
        return [
            'code'            => $this->code,
            'name'            => $this->name,
            'stock'           => $this->stock,
            'image'           => $imagePath,
            'broad'           => $this->broad,
            'long'            => $this->long,
            'color_id'        => $this->color_id ?: null,
            'element_type_id' => $this->element_type_id,
        ];
    }

    /* ------------- helpers paginación / sort -------- */
    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function updatingElementTypeFilter()
    {
        $this->resetPage();
    }
    public function updatingColorFilter()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }
}
