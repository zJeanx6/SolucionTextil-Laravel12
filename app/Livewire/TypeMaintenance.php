<?php

namespace App\Livewire;

use App\Models\MaintenanceType;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class TypeMaintenance extends Component
{

    use WithPagination;
    public $name, $description, $type;
    public $maintenanceType;
    public $maintenance_type;
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
            'maintenance_type' => 'required|string|in:Preventivo,Correctivo',
        ]);

        MaintenanceType::create([
            'name' => $this->name,
            'description' => $this->description,
            'type' => $this->maintenance_type,
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
        $this->maintenanceType = MaintenanceType::find($id);
        $this->name = $this->maintenanceType->name;
        $this->description = $this->maintenanceType->description;
        $this->maintenance_type = $this->maintenanceType->type; // Asignar el tipo correctamente
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|min:3|max:50',
            'description' => 'required|min:3|max:50',
            'maintenance_type' => 'required|string|in:Preventivo,Correctivo',
        ]);

        $maintenanceType = MaintenanceType::find($this->editId);
        $maintenanceType->update([
            'name' => $this->name,
            'description' => $this->description,
            'type' => $this->maintenance_type,
        ]);

        $this->resetFields();
        $this->view = 'index';
        session()->flash('success', 'Tipo de mantenimiento actualizado exitosamente.');
    }

    private function hasRelatedData(MaintenanceType $maintenanceType)
    {
        return DB::table('maintenance_details')
            ->where('maintenance_type_id', $maintenanceType->id)
            ->exists();
    }

    public function delete($id)
    {
        $this->dispatch('event-confirm', $id);
    }

    #[On('deleteConfirmed')]
    public function deleteConfirmed($id)
    {
        $maintenanceType = MaintenanceType::find($id);

        // Verifica si el tipo de mantenimiento tiene datos relacionados en maintenance_details
        if ($maintenanceType && $this->hasRelatedData($maintenanceType)) {
            // Si tiene registros relacionados, mostramos un mensaje amigable
            $this->dispatch('event-notify', 'No se puede eliminar este tipo de mantenimiento porque está relacionado con otros mantenimientos.');
            return;
        }

        // Si no tiene datos relacionados, proceder con la eliminación
        if ($maintenanceType) {
            $maintenanceType->delete();
            $this->dispatch('event-notify', 'Tipo de mantenimiento eliminado exitosamente.');
        } else {
            $this->dispatch('event-notify', 'Tipo de mantenimiento no encontrado.');
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

