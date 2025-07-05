<?php

namespace App\Livewire;

use App\Models\MaintenanceType;
use Livewire\Component;
use Livewire\WithPagination;

class TypeMaintenance extends Component
{
    use WithPagination; // Habilita la paginación para los resultados

    // Propiedades del formulario y del componente
    public $name, $description; // Campos para el nombre y descripción del tipo de mantenimiento
    public $modelSelected = 'maintenance_types'; // Modelo seleccionado (no utilizado en este componente directamente)
    public $view = 'index'; // Vista actual (index, create, edit)
    public $editId = null; // ID del registro que se está editando
    public $search = ''; // Término de búsqueda

    // Se ejecuta al actualizar el término de búsqueda
    public function updatingSearch()
    {
        $this->resetPage(); // Reinicia la paginación al buscar
    }

    // Crea un nuevo tipo de mantenimiento
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

        $this->resetFields(); // Limpia los campos del formulario
        $this->view = 'index'; // Vuelve a la vista de listado
        session()->flash('success', 'Tipo de mantenimiento creado exitosamente.');
    }

    // Cambia a la vista de creación
    public function create()
    {
        $this->view = 'create';
        $this->resetFields();
    }

    // Cambia a la vista de listado (index)
    public function index()
    {
        $this->view = 'index';
        $this->resetFields();
    }

    // Carga un tipo de mantenimiento para editar
    public function edit($id)
    {
        $this->view = 'edit';
        $this->editId = $id;
        $maintenanceType = MaintenanceType::find($id);
        $this->name = $maintenanceType->name;
        $this->description = $maintenanceType->description;
    }

    // Actualiza un tipo de mantenimiento existente
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

    // Elimina un tipo de mantenimiento
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

    // Limpia los campos del formulario
    public function resetFields()
    {
        $this->name = '';
        $this->description = '';
        $this->editId = null;
        $this->search = '';
    }

    // Renderiza la vista con la lista de tipos de mantenimiento filtrados por búsqueda
    public function render()
    {
        $maintenanceTypes = MaintenanceType::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('description', 'like', '%' . $this->search . '%')
            ->paginate(12);

        return view('livewire.type-maintenance', [
            'maintenanceTypes' => $maintenanceTypes,
            'view' => $this->view,
        ]);
    }
}
