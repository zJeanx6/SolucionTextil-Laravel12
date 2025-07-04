<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\{Product, ProductType, Color, Size};
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\{Lazy, On, Url};

// #[Lazy]
class ProductInventory extends Component
{
    use WithPagination, WithFileUploads;

    public $view = 'index';

    #[Url(except: '', keep: false, history: true)]
    public $search = '';

    #[Url(as: 'edit', except: '', keep: false, history: true)]
    public $editId = '';

    public $sortField = 'code';
    public $sortDirection = 'desc';

    public $productTypeFilter = '';
    public $colorFilter = '';

    public $productTypes = [];
    public $colors = [];
    public $sizes = [];

    // Propiedades para create/edit/show
    public $code, $name, $stock, $photo, $image_path;
    public $color_id = '', $size_id = '', $product_type_id = '';

    // Extra para editar
    public $code_edit = '';

    //modales
    public $showNewTypeModal = false;
    public $showNewColorModal = false;
    public $showNewSizeModal = false;

    // Nuevos colores y tipos
    public $newProductTypeName = '';
    public $newColorName = '';
    public $newColorCode = ''; // Esta propiedad almacena el valor hexadecimal
    public $newSizeName = '';
    public $newSizeAbbreviation = ''; // Añadir esta propiedad para la abreviatura

    // --- Métodos de ciclo de vida ---
    public function mount(): void
    {
        $this->productTypes = ProductType::orderBy('name')->get();
        $this->colors = Color::orderBy('name')->get();
        $this->sizes = Size::orderBy('name')->get();

        if ($this->editId) {
            $this->edit($this->editId);
        }
    }

    public function placeholder()
    {
        return view('livewire.placeholders.skeleton');
    }

    public function index()
    {
        $this->resetAll();
        $this->view = 'index';
    }

    public function create()
    {
        $this->resetAll();
        $this->view = 'create';
    }

    public function show($code)
    {
        $this->resetAll();
        $product = Product::where('code', $code)->firstOrFail();

        $this->code = $product->code;
        $this->name = $product->name;
        $this->stock = $product->stock;
        $this->color_id = $product->color_id;
        $this->size_id = $product->size_id;
        $this->product_type_id = $product->product_type_id;
        $this->image_path = $product->image;

        $this->view = 'show';
    }

    public function edit($code)
    {
        $this->resetAll();
        $product = Product::where('code', $code)->firstOrFail();

        $this->code = $product->code;
        $this->code_edit = $product->code;
        $this->name = $product->name;
        $this->stock = $product->stock;
        $this->color_id = $product->color_id;
        $this->size_id = $product->size_id;
        $this->product_type_id = $product->product_type_id;
        $this->image_path = $product->image;
        $this->photo = null;

        $this->view = 'edit';
    }

    public function save()
    {
        $this->validate($this->rulesCreate(), $this->messages(), $this->attributes());
        $path = $this->photo ? $this->photo->store('products', 'public') : null;

        Product::create([
            'code'            => $this->code,
            'name'            => $this->name,
            'stock'           => $this->stock,
            'color_id'        => $this->color_id,
            'size_id'         => $this->size_id,
            'product_type_id' => $this->product_type_id,
            'image'           => $path,
        ]);

        $this->dispatch('event-notify', 'Producto creado.');
        $this->index();
    }

    public function update()
    {
        $this->validate($this->rulesEdit(), $this->messages(), $this->attributes());

        $product = Product::where('code', $this->code)->firstOrFail();

        // Nueva foto
        if ($this->photo) {
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $product->image = $this->photo->store('products', 'public');
        }

        // Sin nueva foto, pero usuario quitó la actual
        if (!$this->photo && is_null($this->image_path) && $product->image) {
            if (Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $product->image = null;
        }

        $product->update([
            'name'             => $this->name,
            'stock'            => $this->stock,
            'color_id'         => $this->color_id,
            'size_id'          => $this->size_id,
            'product_type_id'  => $this->product_type_id,
            'image'            => $product->image,
        ]);

        $this->dispatch('event-notify', 'Producto actualizado.');
        $this->index();
    }

    public function delete($code)
    {
        $this->dispatch('event-confirm', $code);
    }

    #[On('deleteConfirmed')]
    public function deleteConfirmed($code)
    {
        $product = Product::where('code', $code)->firstOrFail();
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();
        $this->dispatch('event-notify', 'Producto eliminado.');
    }

    // --- Renderizado ---
    public function render()
    {
        $products = Product::query()
            ->when(
                $this->search,
                fn($q) => $q->where(function ($sub) {
                    $sub->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('code', 'like', '%' . $this->search . '%');
                })
            )
            ->when(
                $this->productTypeFilter,
                fn($q) => $q->where('product_type_id', $this->productTypeFilter)
            )
            ->when(
                $this->colorFilter,
                fn($q) => $q->where('color_id', $this->colorFilter)
            )
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(12);

        return view('livewire.product-inventory', compact('products'));
    }

    // --- Reseteos y helpers ---
    public function resetAll()
    {
        $this->reset([
            'search', 'productTypeFilter', 'colorFilter',
            'code', 'name', 'stock', 'photo', 'image_path',
            'color_id', 'size_id', 'product_type_id', 'code_edit'
        ]);
    }

    public function updatingSearch() { $this->resetPage(); }
    public function updatingProductTypeFilter() { $this->resetPage(); }
    public function updatingColorFilter() { $this->resetPage(); }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField     = $field;
            $this->sortDirection = 'asc';
        }
    }

    // --- Validaciones y mensajes ---
    public function rulesCreate()
    {
        return [
            'code'            => 'required|digits_between:5,10|unique:products,code',
            'name'            => 'required|string|min:3|max:255',
            'stock'           => 'required|integer|min:0',
            'color_id'        => 'required|exists:colors,id',
            'size_id'         => 'required|exists:sizes,id',
            'product_type_id' => 'required|exists:product_types,id',
            'photo'           => 'nullable|image|max:2048',
        ];
    }

    public function rulesEdit()
    {
        return [
            'code_edit'        => 'required|integer|exists:products,code',
            'name'             => 'required|string|min:3|max:255',
            'stock'            => 'required|integer|min:0',
            'color_id'         => 'required|exists:colors,id',
            'size_id'          => 'required|exists:sizes,id',
            'product_type_id'  => 'required|exists:product_types,id',
            'photo'            => 'nullable|image|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'El campo :attribute es obligatorio.',
            'min'      => 'El campo :attribute debe tener al menos :min.',
            'max'      => 'El campo :attribute no puede ser mayor a :max.',
            'integer'  => 'El campo :attribute debe ser un número entero.',
            'numeric'  => 'El campo :attribute debe ser un número.',
            'image'    => 'El archivo debe ser una imagen.',
            'unique'   => 'Ese código ya está registrado.',
            'exists'   => 'El valor seleccionado no existe.',
            'digits_between' => 'El código debe tener entre :min y :max dígitos.',
            'newColorCode.max' => 'El código de color no puede exceder los 7 caracteres.',
        ];
    }

    public function attributes()
    {
        return [
            'code'            => 'código',
            'code_edit'       => 'código',
            'name'            => 'nombre',
            'stock'           => 'stock',
            'color_id'        => 'color',
            'size_id'         => 'talla',
            'product_type_id' => 'tipo de producto',
            'photo'           => 'imagen',
            'newColorCode'    => 'código de color',
            'newColorName'    => 'nombre del color',
        ];
    }

    public function updatedProductTypeId($value)
    {
        if ($value === 'new_type') {
            $this->product_type_id = '';
            $this->showNewTypeModal = true;
        }
    }

    public function updatedSizeId($value)
    {
        if ($value === 'new_size') {
            $this->size_id = '';
            $this->showNewSizeModal = true;
        }
    }

    public function updatedColorId($value)
    {
        if ($value === 'new_color') {
            $this->color_id = '';
            $this->showNewColorModal = true;
        }
    }
    
    public function saveNewColor()
    {
        $this->validate([
            'newColorName' => 'required|string|min:2|max:50',
            'newColorCode' => 'required|string|max:7',
        ]);
        
        $colorCode = substr($this->newColorCode, 0, 7); 

        $color = Color::create([
            'code' => $colorCode, // Usamos newColorCode para el valor hexadecimal
            'name' => $this->newColorName,
        ]);

        $this->colors = Color::orderBy('name')->get();
        $this->reset(['newColorName', 'newColorCode']); // Resetear los campos del formulario
        $this->color_id = $color->id; // El ID es asignado automáticamente por la base de datos
        $this->showNewColorModal = false;

        $this->dispatch('event-notify', 'Color creado correctamente');
    }

    public function saveNewSize()
    {
        $this->validate([
            'newSizeName' => 'required|string|min:1|max:50',
        ]);
        
        $size = Size::create([
            'name' => $this->newSizeName,
            'abbreviation' => $this->newSizeAbbreviation ?? null, // Añadir abreviatura si existe
        ]);

        $this->sizes = Size::orderBy('name')->get();
        $this->reset(['newSizeName', 'newSizeAbbreviation']); // Resetear ambos campos
        $this->size_id = $size->id;
        $this->showNewSizeModal = false;

        $this->dispatch('event-notify', 'Talla creada correctamente');
    }

    public function saveNewType()
    {
        $type = ProductType::create([
            'name' => $this->newProductTypeName,
        ]);

        $this->productTypes = ProductType::orderBy('name')->get();
        $this->newProductTypeName = '';
        $this->product_type_id = $type->id;

        $this->showNewTypeModal = false;

        $this->dispatch('event-notify', 'Tipo creado correctamente');
    }
}
