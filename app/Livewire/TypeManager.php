<?php

namespace App\Livewire;

use App\Models\ElementType;
use App\Models\MachineType;
use App\Models\ProductType;
use Livewire\Component;
use Livewire\WithPagination;

class TypeManager extends Component
{
    use WithPagination;

    public $modelSelected = 'element_types';
    public $name;
    public $view = 'index';
    public $editId = null;
    public $search = '';

    protected $models = [
        'element_types' => ElementType::class,
        'product_types' => ProductType::class,
        'machine_types' => MachineType::class,
    ];

    // Persistir filtros
    protected $queryString = [
        'search'        => ['except' => ''],
        'modelSelected' => ['except' => 'element_types']
    ];

    public function mount(){
        $this->resetPage();
    }

    public function updatingSearch(){
        $this->resetPage(); // Resetea la paginación al buscar.
    }

    public function updatingModelSelected(){
        $this->resetPage(); // Resetea la paginación al cambiar el modelo seleccionado.
    }

    public function hydrate(){
        // Reinstanciar o refrescar datos no serializables si es necesario
    }

    public function dehydrate(){
        // Limpiar propiedades pesadas antes de enviar la respuesta
    }

    public function getCurrentModel(){
        return $this->models[$this->modelSelected];
    }

    protected function rules(){
        return ['name' => 'required|min:3|max:50'];
    }

    public function save()
    {
        $this->validate();
        $model = $this->getCurrentModel();
        $model::create(['name' => $this->name]);
        $this->reset('name');
        $this->view = 'index';
        $this->dispatch('notification-tipos', 'Tipo creado.');
    }

    public function create(){
        $this->reset('search');
        $this->view = 'create';
    }

    public function index(){
        $this->reset('search');
        $this->view = 'index';
    }

    public function edit($id)
    {
        $this->reset('search');
        $model = $this->getCurrentModel();
        $type = $model::findOrFail($id);
        $this->editId = $type->id;
        $this->name = $type->name;
        $this->view = 'edit';
    }

    public function update()
    {
        $this->validate();
        $model = $this->getCurrentModel();
        $type = $model::findOrFail($this->editId);
        $type->update(['name' => $this->name]);
        $this->reset(['name', 'editId']);
        $this->view = 'index';
        $this->dispatch('notification-tipos', 'Tipo Actualizado.');
    }

    public function delete($id)
    {
        $model = $this->getCurrentModel();
        $model::findOrFail($id)->delete();
        $this->dispatch('notification-tipos', 'Tipo Eliminado.');
    }

    public function render()
    {
        if ($this->view !== 'index') {
            return view('livewire.type-manager', ['types' => collect()]);
        }

        $model = $this->getCurrentModel();
        $types = $model::query()
            ->when($this->search, fn($q) => $q->where('name', 'like', "%{$this->search}%"))
            ->orderByDesc('id')
            ->paginate(12);
        return view('livewire.type-manager', compact('types'));
    }
}
