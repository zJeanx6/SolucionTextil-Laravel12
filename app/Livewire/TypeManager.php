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

    public function getCurrentModel()
    {
        return $this->models[$this->modelSelected];
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingModelSelected()
    {
        $this->resetPage();
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
    }

    public function create()
    {
        $this->view = 'create';
    }

    public function index()
    {
        $this->view = 'index';
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
    }

    public function delete($id)
    {
        $model = $this->getCurrentModel();
        $type = $model::findOrFail($id);
        $type->delete();

        session()->flash('success', 'Tipo eliminado exitosamente.');
    }

    public function render()
    {
        $model = $this->getCurrentModel();

        $types = $model::query()
            ->where('name', 'like', '%' . $this->search . '%')
            ->orderBy('id', 'desc')
            ->paginate(12);

        return view('livewire.type-manager', compact('types'));
    }
}
