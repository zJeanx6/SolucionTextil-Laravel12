<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\{Product, ProductType, Color, Size};
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\{Lazy, On, Url};

// Componente para gestionar el inventario de productos
class ProductInventory extends Component
{
    use WithPagination, WithFileUploads;

    // Vista actual
    public $view = 'index';

    // Filtros de búsqueda y URL
    #[Url(except: '', keep: false, history: true)]
    public $search = '';

    #[Url(as: 'edit', except: '', keep: false, history: true)]
    public $editId = '';

    // Ordenamiento
    public $sortField = 'code';
    public $sortDirection = 'desc';

    // Filtros por tipo y color
    public $productTypeFilter = '';
    public $colorFilter = '';

    // Listas para selects
    public $productTypes = [];
    public $colors = [];
    public $sizes = [];

    // Propiedades del formulario de producto
    public $code, $name, $stock, $photo, $image_path;
    public $color_id = '', $size_id = '', $product_type_id = '';

    // Código editado
    public $code_edit = '';

    // Modales
    public $showNewTypeModal = false;
    public $showNewColorModal = false;
    public $showNewSizeModal = false;

    // Nuevos valores para crear tipos, colores y tallas
    public $newProductTypeName = '';
    public $newColorName = '';
    public $newColorCode = '';
    public $newSizeName = '';
    public $newSizeAbbreviation = '';

    // Cargar listas iniciales y editar si hay ID
    public function mount(): void
    {
        $this->productTypes = ProductType::orderBy('name')->get();
        $this->colors = Color::orderBy('name')->get();
        $this->sizes = Size::orderBy('name')->get();

        if ($this->editId) {
            $this->edit($this->editId);
        }
    }

    // Vista de carga inicial
    public function placeholder()
    {
        return view('livewire.placeholders.skeleton');
    }

    // Mostrar vista index
    public function index()
    {
        $this->resetAll();
        $this->view = 'index';
    }

    // Mostrar formulario de creación
    public function create()
    {
        $this->resetAll();
        $this->view = 'create';
    }

    // Mostrar detalles de un producto
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

    // Cargar datos para edición
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

    // Guardar nuevo producto
    public function save()
    {
        $this->validate($this->rulesCreate(), $this->messages(), $this->attributes());
        $path = $this->photo ? $this->photo->store('products', 'public') : null;

        Product::create([
            'code' => $this->code,
            'name' => $this->name,
            'stock' => $this->stock,
            'color_id' => $this->color_id,
            'size_id' => $this->size_id,
            'product_type_id' => $this->product_type_id,
            'image' => $path,
        ]);

        $this->dispatch('event-notify', 'Producto creado.');
        $this->index();
    }

    // Actualizar producto existente
    public function update()
    {
        $this->validate($this->rulesEdit(), $this->messages(), $this->attributes());

        $product = Product::where('code', $this->code)->firstOrFail();

        // Si hay nueva imagen
        if ($this->photo) {
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $product->image = $this->photo->store('products', 'public');
        }

        // Eliminar imagen si fue quitada
        if (!$this->photo && is_null($this->image_path) && $product->image) {
            if (Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $product->image = null;
        }

        // Actualizar datos
        $product->update([
            'name' => $this->name,
            'stock' => $this->stock,
            'color_id' => $this->color_id,
            'size_id' => $this->size_id,
            'product_type_id' => $this->product_type_id,
            'image' => $product->image,
        ]);

        $this->dispatch('event-notify', 'Producto actualizado.');
        $this->index();
    }

    // Confirmación para eliminar
    public function delete($code)
    {
        $this->dispatch('event-confirm', $code);
    }

    // Confirmación recibida para eliminar
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

    // Renderiza la vista con datos filtrados y ordenados
    public function render()
    {
        $products = Product::query()
            ->when($this->search, fn($q) => $q->where(fn($sub) => $sub
                ->where('name', 'like', "%{$this->search}%")
                ->orWhere('code', 'like', "%{$this->search}%")
            ))
            ->when($this->productTypeFilter, fn($q) => $q->where('product_type_id', $this->productTypeFilter))
            ->when($this->colorFilter, fn($q) => $q->where('color_id', $this->colorFilter))
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(12);

        return view('livewire.product-inventory', compact('products'));
    }

    // Resetear todos los campos
    public function resetAll()
    {
        $this->reset([
            'search', 'productTypeFilter', 'colorFilter',
            'code', 'name', 'stock', 'photo', 'image_path',
            'color_id', 'size_id', 'product_type_id', 'code_edit'
        ]);
    }

    // Reinicia la paginación al cambiar filtros
    public function updatingSearch() { $this->resetPage(); }
    public function updatingProductTypeFilter() { $this->resetPage(); }
    public function updatingColorFilter() { $this->resetPage(); }

    // Cambiar ordenamiento
    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    // Reglas de validación para crear
    public function rulesCreate()
    {
        return [
            'code' => 'required|digits_between:5,10|unique:products,code',
            'name' => 'required|string|min:3|max:255',
            'stock' => 'required|integer|min:0',
            'color_id' => 'required|exists:colors,id',
            'size_id' => 'required|exists:sizes,id',
            'product_type_id' => 'required|exists:product_types,id',
            'photo' => 'nullable|image|max:2048',
        ];
    }

    // Reglas de validación para editar
    public function rulesEdit()
    {
        return [
            'code_edit' => 'required|integer|exists:products,code',
            'name' => 'required|string|min:3|max:255',
            'stock' => 'required|integer|min:0',
            'color_id' => 'required|exists:colors,id',
            'size_id' => 'required|exists:sizes,id',
            'product_type_id' => 'required|exists:product_types,id',
            'photo' => 'nullable|image|max:2048',
        ];
    }

    // Mensajes personalizados
    public function messages()
    {
        return [
            'required' => 'El campo :attribute es obligatorio.',
            'min' => 'El campo :attribute debe tener al menos :min.',
            'max' => 'El campo :attribute no puede ser mayor a :max.',
            'integer' => 'El campo :attribute debe ser un número entero.',
            'numeric' => 'El campo :attribute debe ser un número.',
            'image' => 'El archivo debe ser una imagen.',
            'unique' => 'Ese código ya está registrado.',
            'exists' => 'El valor seleccionado no existe.',
            'digits_between' => 'El código debe tener entre :min y :max dígitos.',
            'newColorCode.max' => 'El código de color no puede exceder los 7 caracteres.',
        ];
    }

    // Etiquetas personalizadas
    public function attributes()
    {
        return [
            'code' => 'código',
            'code_edit' => 'código',
            'name' => 'nombre',
            'stock' => 'stock',
            'color_id' => 'color',
            'size_id' => 'talla',
            'product_type_id' => 'tipo de producto',
            'photo' => 'imagen',
            'newColorCode' => 'código de color',
            'newColorName' => 'nombre del color',
        ];
    }

    // Abrir modal nuevo tipo si se selecciona "crear nuevo"
    public function updatedProductTypeId($value)
    {
        if ($value === 'new_type') {
            $this->product_type_id = '';
            $this->showNewTypeModal = true;
        }
    }

    // Abrir modal nueva talla
    public function updatedSizeId($value)
    {
        if ($value === 'new_size') {
            $this->size_id = '';
            $this->showNewSizeModal = true;
        }
    }

    // Abrir modal nuevo color
    public function updatedColorId($value)
    {
        if ($value === 'new_color') {
            $this->color_id = '';
            $this->showNewColorModal = true;
        }
    }

    // Guardar nuevo color desde el modal
    public function saveNewColor()
    {
        $this->validate([
            'newColorName' => 'required|string|min:2|max:50',
            'newColorCode' => 'required|string|max:7',
        ]);

        $colorCode = substr($this->newColorCode, 0, 7);

        $color = Color::create([
            'code' => $colorCode,
            'name' => $this->newColorName,
        ]);

        $this->colors = Color::orderBy('name')->get();
        $this->reset(['newColorName', 'newColorCode']);
        $this->color_id = $color->id;
        $this->showNewColorModal = false;

        $this->dispatch('event-notify', 'Color creado correctamente');
    }

    // Guardar nueva talla desde el modal
    public function saveNewSize()
    {
        $this->validate([
            'newSizeName' => 'required|string|min:1|max:50',
        ]);

        $size = Size::create([
            'name' => $this->newSizeName,
            'abbreviation' => $this->newSizeAbbreviation ?? null,
        ]);

        $this->sizes = Size::orderBy('name')->get();
        $this->reset(['newSizeName', 'newSizeAbbreviation']);
        $this->size_id = $size->id;
        $this->showNewSizeModal = false;

        $this->dispatch('event-notify', 'Talla creada correctamente');
    }

    // Guardar nuevo tipo desde el modal
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
