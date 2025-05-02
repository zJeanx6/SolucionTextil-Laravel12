<?php

namespace App\Livewire;

use App\Models\ElementType;
use App\Models\MachineType;
use App\Models\ProductType;
use Livewire\Component;

class TypeManager extends Component
{
    public $modelSelected = 'element_types';
    public $name;
    public $view = 'index';
    public $types = [];
    public $editId = null;
    public $search = '';


    protected $models = [
        'element_types' => ElementType::class,
        'product_types' => ProductType::class,
        'machine_types' => MachineType::class,
    ];

    public function mount()
    {
        $this->loadTypes();
    }

    public function getCurrentModel()
    {
        return $this->models[$this->modelSelected];
    }

    public function loadTypes()
    {
        $model = $this->getCurrentModel();
        // $this->types = $model::all();
        $this->types = $model::query()
            ->where('name', 'like', '%' . $this->search . '%')
            ->get();
    }

    public function updatedSearch()
    {
        $this->loadTypes();
    }


    public function updatedModelSelected()
    {
        $this->loadTypes();
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|min:3|max:50',
        ]);

        $model = $this->getCurrentModel();
        $model::create([
            'name' => $this->name,
        ]);

        $this->reset('name');
        $this->view = 'index';
        session()->flash('success', 'Tipo creado exitosamente.');
        $this->loadTypes();
    }

    public function create()
    {
        $this->view = 'create';
    }

    public function index()
    {
        $this->view = 'index';
        $this->loadTypes();
    }

    public function edit($id)
    {
        $model = $this->getCurrentModel();
        $type = $model::findOrFail($id);

        $this->editId = $type->id;
        $this->name = $type->name;
        $this->view = 'edit';
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|min:3|max:50',
        ]);

        $model = $this->getCurrentModel();
        $type = $model::findOrFail($this->editId);

        $type->update([
            'name' => $this->name,
        ]);

        $this->reset('name', 'editId');
        $this->view = 'index';
        session()->flash('success', 'Tipo actualizado exitosamente.');
        $this->loadTypes();
    }

    public function delete($id)
    {
        $model = $this->getCurrentModel();
        $type = $model::findOrFail($id);
        $type->delete();

        session()->flash('success', 'Tipo eliminado exitosamente.');
        $this->loadTypes();
    }

    public function render()
    {
        return view('livewire.type-manager');
    }
}
