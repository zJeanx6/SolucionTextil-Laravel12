<?php

namespace App\Livewire;

use App\Models\ElementType;
use App\Models\MachineType;
use App\Models\ProductType;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class TypeManager extends Component
{
    use WithPagination;

    // Propiedades públicas
    public $modelSelected = '';      // Modelo actualmente seleccionado (element, machine o product)
    public $name;                    // Nombre del nuevo tipo
    public $elementGroup = '';       // Grupo seleccionado (solo para tipos de elementos)
    public $view = 'index';          // Vista actual (index, create, edit)
    public $editId = null;           // ID del tipo que se está editando
    public $search = '';             // Término de búsqueda

    // Mapeo entre claves y modelos Eloquent
    protected $models = [
        'element_types' => ElementType::class,
        'product_types' => ProductType::class,
        'machine_types' => MachineType::class,
    ];

    // Persistencia de filtros en la URL
    protected $queryString = [
        'search'        => ['except' => ''],
        'modelSelected' => ['except' => ''],
    ];

    // Al montar el componente, resetea la paginación
    public function mount(){
        $this->resetPage();
    }

    // Al buscar, reinicia la página
    public function updatingSearch(){
        $this->resetPage();
    }

    // Al cambiar de modelo, reinicia la página
    public function updatingModelSelected(){
        $this->resetPage();
    }

    // Retorna la clase del modelo actual seleccionado
    public function getCurrentModel(){
        return $this->models[$this->modelSelected];
    }

    // Reglas de validación comunes
    protected function rules(){
        return ['name' => 'required|min:3|max:50'];
    }

    // Guardar un nuevo tipo
    public function save()
    {
        $this->validate();

        // Si el modelo seleccionado es de elementos, asigna un ID personalizado según grupo
        if ($this->modelSelected === 'element_types') {
            // Rangos definidos por grupo
            $ranges = [
                'G-01' => [1100, 1999],
                'G-02' => [2100, 2999],
                'G-03' => [3100, 3999],
                'G-04' => [4100, 4999],
            ];

            // Obtener rango del grupo
            [$min, $max] = $ranges[$this->elementGroup];

            // Buscar último ID en ese rango
            $last = ElementType::whereBetween('id', [$min, $max])->max('id');

            // Calcular nuevo ID (si no hay ninguno, usar mínimo)
            $newId = $last ? min($last + 1, $max) : $min;

            // Crear el nuevo tipo de elemento con ID personalizado
            ElementType::create(['id' => $newId, 'name' => $this->name]);

            // Limpiar campos
            $this->reset(['name', 'elementGroup']);
        } else {
            // Para máquinas y productos, crear normalmente
            $model = $this->getCurrentModel();
            $model::create(['name' => $this->name]);
            $this->reset('name');
        }

        // Volver a la vista index y mostrar notificación
        $this->view = 'index';
        $this->dispatch('event-notify', 'Tipo creado.');
    }

    // Cambiar a vista de creación
    public function create(){
        $this->reset('search');
        $this->view = 'create';
    }

    // Cambiar a vista index
    public function index(){
        $this->reset('search');
        $this->view = 'index';
    }

    // Cargar tipo a editar
    public function edit($id)
    {
        $this->reset('search');

        $model = $this->getCurrentModel();
        $type = $model::findOrFail($id);

        $this->editId = $type->id;
        $this->name = $type->name;
        $this->view = 'edit';
    }

    // Actualizar un tipo existente
    public function update()
    {
        $this->validate();

        $model = $this->getCurrentModel();
        $type = $model::findOrFail($this->editId);

        $type->update(['name' => $this->name]);

        $this->reset(['name', 'editId']);
        $this->view = 'index';
        $this->dispatch('event-notify', 'Tipo Actualizado.');
    }

    // Lanza confirmación de eliminación
    public function delete($id){
        $this->dispatch('event-confirm', $id);
    }

    // Acción que se ejecuta cuando el evento 'deleteConfirmed' es disparado
    #[On('deleteConfirmed')]
    public function deleteConfirmed($id)
    {
        $model = $this->getCurrentModel();
        $model::findOrFail($id)->delete();
        $this->dispatch('event-notify', 'Tipo Eliminado.');
    }

    // Renderiza la vista
    public function render()
    {
        // Si no se está en index o no hay modelo seleccionado, retorna vacío
        if ($this->view !== 'index' || ! $this->modelSelected) {
            return view('livewire.type-manager', ['types' => collect()]);
        }

        // Obtener tipos filtrados y paginados
        $model = $this->getCurrentModel();
        $types = $model::query()
            ->when($this->search, fn($q) => $q->where('name', 'like', "%{$this->search}%"))
            ->orderByDesc('id')
            ->paginate(12);

        return view('livewire.type-manager', compact('types'));
    }
}
