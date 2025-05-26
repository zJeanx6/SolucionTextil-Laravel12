<?php

namespace App\Livewire;

use App\Models\MaintenanceType;
use Livewire\Component;
use Livewire\WithPagination;

class TypeMaintenance extends Component
{

    use WithPagination;
    public $name, $description;
    public $modelSelected = 'maintenance_types';
    public $view = 'index';
    public $editId = null;
    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|min:3|max:50|unique:maintenance_types,name',
            'description' => 'required|min:3|max:50',
        ]);

        MaintenanceType::create([
            'name' => $this->name,
            'description' => $this->description,
        ]);

        $this->resetFields();
        $this->view = 'index';
        session()->flash('success', 'Tipo de mantenimiento creado exitosamente.');
    }
    public function create()
    {
        $this->view = 'create';
        $this->resetFields();
    }
    public function index()
    {
        $this->view = 'index';
        $this->resetFields();
    }
    public function edit($id)
    {
        $this->view = 'edit';
        $this->editId = $id;
        $maintenanceType = MaintenanceType::find($id);
        $this->name = $maintenanceType->name;
        $this->description = $maintenanceType->description;
    }
    public function update()
    {
        $this->validate([
            'name' => 'required|min:3|max:50',
            'description' => 'required|min:3|max:50',
        ]);

        $maintenanceType = MaintenanceType::find($this->editId);
        $maintenanceType->update([
            'name' => $this->name,
            'description' => $this->description,
        ]);

        $this->resetFields();
        $this->view = 'index';
        session()->flash('success', 'Tipo de mantenimiento actualizado exitosamente.');
    }
    public function delete($id)
    {
        $maintenanceType = MaintenanceType::find($id);
        if ($maintenanceType) {
            $maintenanceType->delete();
            session()->flash('success', 'Tipo de mantenimiento eliminado exitosamente.');
        } else {
            session()->flash('error', 'Tipo de mantenimiento no encontrado.');
        }
    }
    public function resetFields()
    {
        $this->name = '';
        $this->description = '';
        $this->editId = null;
        $this->search = '';
    }
    public function render()
    {
        $maintenanceTypes = MaintenanceType::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('description', 'like', '%' . $this->search . '%')
            ->paginate(12);
        return view('livewire.type-maintenance', [
            'maintenanceTypes' => $maintenanceTypes,
            'view' => $this->view,]);
    }
}

