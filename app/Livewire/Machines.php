<?php

namespace App\Livewire;

use App\Models\Machine;
use App\Models\State;
use App\Models\MachineType;
use App\Models\Brand;
use App\Models\Supplier;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\support\Str; //genera nombres unicos para las imagenes 
use Illuminate\Support\Facades\Log; // Añadir esta línea para importar Log
use Illuminate\Support\Facades\Storage; // También es bueno importar Storage explícitamente


class Machines extends Component
{
    use WithPagination,WithFileUploads;
    public $serial, $image, $state_id, $machine_type_id, $brand_id, $supplier_nit;
    public $view = 'index';
    public $editId = null;
    public $search = '';
    public $currentImagePath;
    public $modelSelected = null; 

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function save()
    {
        $this->validate([
            'serial' => 'required|min:3|max:50|unique:machines,serial',
            'image' => 'nullable|image|max:2048',
            'state_id' => 'required|exists:states,id',
            'machine_type_id' => 'required|exists:machine_types,id',
            'brand_id' => 'required|exists:brands,id',
            'supplier_nit' => 'required|exists:suppliers,nit', 
        ]);


        // Generar un nombre único para la imagen tomando el serial y la fecha actual
        $imageName = $this->serial . '-' . time() . '.'. $this->image->getClientOriginalExtension();
        // Guardar la imagen en la carpeta 'machines-images' dentro de 'public'
        $imagePath = $this->image->storeAs('machines-images', $imageName, 'public');

        Machine::create([
            'serial' => $this->serial,
            'image' => $imagePath,
            'state_id' => $this->state_id,
            'machine_type_id' => $this->machine_type_id,
            'brand_id' => $this->brand_id,
            'supplier_nit' => $this->supplier_nit, 
        ]);

        $this->resetFields();
        $this->view = 'index';
        session()->flash('success', 'Máquina creada exitosamente.');
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

    public function edit($serial)
    {
        $this->view = 'edit';
        $this->editId = $serial;

        $machine = Machine::find($serial);

        if ($machine) {
            $this->serial = $machine->serial;
            $this->currentImagePath = $machine->image; // Para mostrar la imagen actual
            $this->image = null; 
            $this->state_id = $machine->state_id;
            $this->machine_type_id = $machine->machine_type_id;
            $this->brand_id = $machine->brand_id;
            $this->supplier_nit = $machine->supplier_nit;
        }
    }


public function update()    
{
    $this->validate([
        'serial' => 'required|min:3|max:50|unique:machines,serial,' . $this->editId . ',serial',
        'image' => 'nullable|image|max:2048',
        'state_id' => 'required|exists:states,id',
        'machine_type_id' => 'required|exists:machine_types,id',
        'brand_id' => 'required|exists:brands,id',
        'supplier_nit' => 'required|exists:suppliers,nit',
    ]);

    $machine = Machine::findOrFail($this->editId);

    // Actualizar campos básicos
    $machine->update([
        'serial' => $this->serial,
        'state_id' => $this->state_id,
        'machine_type_id' => $this->machine_type_id,
        'brand_id' => $this->brand_id,
        'supplier_nit' => $this->supplier_nit,
    ]);

    // Manejar la imagen
    if ($this->image) {
        // Eliminar imagen anterior si existe
        if ($machine->image && Storage::disk('public')->exists($machine->image)) {
            Storage::disk('public')->delete($machine->image);
        }

        // Guardar nueva imagen
        $imageName = $this->serial . '_' . time() . '.' . $this->image->getClientOriginalExtension();
        $imagePath = $this->image->storeAs('machines-images', $imageName, 'public');
        
        // Actualizar en la base de datos
        $machine->update(['image' => $imagePath]);
        
        // Actualizar la variable para la vista
        $this->currentImagePath = $imagePath;
    }

    session()->flash('success', 'Máquina actualizada exitosamente.');
    $this->resetFields();
    $this->view = 'index';
}


    public function delete($serial)
    {
        $this->editId = $serial;
        $machine = Machine::find($this->editId);
        if ($machine) {
            $machine->delete();
            session()->flash('success', 'Máquina eliminada exitosamente.');
        } else {
            session()->flash('error', 'Máquina no encontrada.');
        }
        $this->resetFields();   
    }

    public function resetFields()
    {
        $this->serial = '';
        $this->image = '';
        $this->state_id = '';
        $this->machine_type_id = '';
        $this->brand_id = '';
        $this->supplier_nit = '';
        $this->editId = null;

        //  evita perder la ruta de la imagen cuando entras a editar
        if ($this->view !== 'edit') {
            $this->currentImagePath = '';
        }
}
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, [
            'serial' => 'required|min:3|max:50|unique:machines,serial,' . $this->editId . ',serial',
            'image' => 'nullable|image|max:2048',
            'state_id' => 'required|exists:states,id',
            'machine_type_id' => 'required|exists:machine_types,id',
            'brand_id' => 'required|exists:brands,id',
            'supplier_nit' => 'required|exists:suppliers,nit',
        ]);
    }

    public function render()
    {
        $machines = Machine::query()
            ->when($this->modelSelected, function ($query) {
                $query->where('machine_type_id', $this->modelSelected);
            })
            ->where('serial', 'like', '%' . $this->search . '%')
            ->paginate(10);

        return view('livewire.machines', [
            'machines' => $machines,
            'machine_types' => MachineType::all(),
        ]);
    }

}

