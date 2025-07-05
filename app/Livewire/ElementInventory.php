<?php

namespace App\Livewire;

// Importa formularios que encapsulan la lógica de creación, edición y visualización de elementos
use App\Livewire\Forms\{ElementCreateForm, ElementEditForm, ElementShowForm};

// Trae funcionalidades necesarias de Livewire
use Livewire\Component;
use Livewire\WithPagination;    // Para paginar resultados
use Livewire\WithFileUploads;   // Para permitir subida de archivos

// Importa modelos necesarios para el inventario
use App\Models\{Element, ElementType, Color};
use Illuminate\Support\Facades\Storage; // Para eliminar archivos del almacenamiento

// Importa atributos especiales de Livewire
use Livewire\Attributes\{Lazy, On, Url};

// Clase del componente Livewire
class ElementInventory extends Component
{
    // Habilita paginación y carga de archivos
    use WithPagination, WithFileUploads;

    // Controla la vista actual (index, create, edit, show)
    public $view = 'index';

    // Propiedad enlazada con la URL para mantener el término de búsqueda
    #[Url(except: '', keep: false, history: true)]
    public $search = '';

    // ID del elemento que se está editando (también se mantiene en la URL)
    #[Url(as: 'edit', except: '', keep: false, history: true)]
    public $editId = '';

    // Control de ordenamiento por campo y dirección (asc o desc)
    public $sortField = 'code';
    public $sortDirection = 'desc';

    // Filtros para tipo de elemento y color
    public $elementTypeFilter = '';
    public $colorFilter = '';

    // Listados que se llenan con los tipos y colores desde la base de datos
    public $elementTypes = [];
    public $colors = [];

    // Form objects que contienen lógica específica para mostrar, crear o editar
    public ElementShowForm $elementShow;
    public ElementCreateForm $elementCreate;
    public ElementEditForm $elementEdit;

    // Utilizado cuando se cambia el tipo de elemento en el formulario
    public $change_type_id = '';

    // Bandera para indicar si se está editando
    public $editing = null;

    /**
     * Se ejecuta al cargar el componente
     */
    public function mount(): void
    {
        // Carga todos los tipos de elementos y colores, ordenados por nombre
        $this->elementTypes = ElementType::orderBy('name')->get();
        $this->colors = Color::orderBy('name')->get();

        // Si hay un ID en la URL, llama al método para editar ese elemento
        if ($this->editId) {
            $this->edit($this->editId);
        }
    }

    /**
     * Renderiza un placeholder mientras se carga el contenido (skeleton loading)
     */
    public function placeholder()
    {
        return view('livewire.placeholders.skeleton');
    }

    /**
     * Cambia la vista a index y resetea filtros
     */
    public function index()
    {
        $this->reset('search', 'elementTypeFilter', 'colorFilter');
        $this->editId = '';
        $this->view   = 'index';
    }

    /**
     * Cambia la vista a mostrar detalles del elemento
     */
    public function show($code)
    {
        $this->elementShow->show($code);
        $this->view = 'show';
    }

    /**
     * Alterna el estado activo/inactivo de un elemento desde la vista de detalle
     */
    public function toggleInactive()
    {
        $this->elementShow->toggleInactive();
    }

    /**
     * Cambia la vista a la de creación de nuevo elemento
     */
    public function create(): void
    {
        $this->reset('search', 'elementTypeFilter', 'colorFilter');
        $this->editId = '';
        $this->elementCreate->reset();
        $this->view   = 'create';
    }

    /**
     * Cambia la vista a edición de un elemento específico
     */
    public function edit($code)
    {
        $this->resetValidation();
        $this->editId = $code;
        $this->elementEdit->edit($code);
        $this->view = 'edit';
    }

    /**
     * Guarda un nuevo elemento usando el formulario de creación
     */
    public function save()
    {
        $this->elementCreate->save();
        $this->dispatch('event-notify', 'Elemento creado'); // Envía notificación al frontend
        $this->index(); // Vuelve a la vista principal
    }

    /**
     * Actualiza un elemento existente usando el formulario de edición
     */
    public function update()
    {
        $this->elementEdit->update();
        $this->dispatch('event-notify', 'Elemento actualizado.');
        $this->index();
    }

    /**
     * Confirma la eliminación de un elemento (muestra alerta en el frontend)
     */
    public function delete($code)
    {
        $this->dispatch('event-confirm', $code);
    }

    /**
     * Elimina el elemento cuando el usuario confirma (despachado por evento de JS)
     */
    #[On('deleteConfirmed')] 
    public function deleteConfirmed($code)
    {
        $element = Element::where('code', $code)->firstOrFail();

        // Elimina la imagen del almacenamiento si existe
        if ($element->image && Storage::disk('public')->exists($element->image)) {
            Storage::disk('public')->delete($element->image);
        }

        $element->delete(); // Elimina el registro de la base de datos
        $this->dispatch('event-notify', 'Elemento eliminado.');
    }

    /**
     * Método invocado cuando se cambia el tipo de elemento en el formulario de creación
     */
    public function updatedChangeTypeId($value)
    {  
        $this->elementCreate->updatedElementTypeId($value);
    }

    /**
     * Método principal que renderiza el componente y filtra la lista de elementos
     */
    public function render()
    {
        $elements = Element::query()
            // Filtra por búsqueda (nombre o código)
            ->when(
                $this->search,
                fn($q) => $q->where(function ($sub) {
                    $sub->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('code', 'like', '%' . $this->search . '%');
                })
            )
            // Filtra por tipo de elemento si está seleccionado
            ->when(
                $this->elementTypeFilter,
                fn($q) => $q->where('element_type_id', $this->elementTypeFilter)
            )
            // Filtra por color si está seleccionado
            ->when(
                $this->colorFilter,
                fn($q) => $q->where('color_id', $this->colorFilter)
            )
            // Ordena por el campo y dirección definidos
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(12); // Paginación de 12 elementos por página

        return view('livewire.element-inventory', compact('elements'));
    }

    /**
     * Resetea la paginación al cambiar el término de búsqueda
     */
    public function updatingSearch()
    {
        $this->resetPage();
    }

    /**
     * Resetea la paginación al cambiar el filtro de tipo
     */
    public function updatingElementTypeFilter()
    {
        $this->resetPage();
    }

    /**
     * Resetea la paginación al cambiar el filtro de color
     */
    public function updatingColorFilter()
    {
        $this->resetPage();
    }

    /**
     * Cambia el ordenamiento cuando se hace clic en un encabezado de columna
     */
    public function sortBy($field)
    {
        // Si ya se está ordenando por ese campo, invierte la dirección
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            // Si es un nuevo campo, lo establece como campo de orden y empieza en ascendente
            $this->sortField     = $field;
            $this->sortDirection = 'asc';
        }
    }
}
