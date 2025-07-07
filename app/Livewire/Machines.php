<?php

namespace App\Livewire;

use App\Models\Machine;
use App\Models\State;
use App\Models\MachineType;
use App\Models\Brand;
use App\Models\Supplier;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;

class Machines extends Component
{
    use WithPagination, WithFileUploads;

    public $serial, $image, $last_maintenance, $state_id, $machine_type_id, $brand_id, $supplier_nit, $company_nit;
    public $view = 'index';
    public $editId = null;
    public $search = '';
    public $currentImagePath;
    public $modelSelected = null;
    public $states;
    
    //Modales 
    public $showNewTypeModal = false; //Controla la visibilidad del modal para crear un nuevo tipo de máquina
    public $showNewBrandModal = false; //Controla la visibilidad del modal para crear una nueva marca
    public $showNewSupplierModal = false; //Controla la visibilidad del modal para crear un nuevo proveedor

    public $machineTypes = []; //Lista de tipos de máquinas
    public $brands = []; //Lista de marcas
    public $suppliers = []; //Lista de proveedores
    //Campos para crear un nuevo proveedor respetando el tipo de persona
    public $newMachineTypeName = '';
    public $newBrandName = '';
    public $newSupplierNit, $newSupplierName, $newSupplierPersonType, $newSupplierEmail, $newSupplierPhone;
    public $newSupplierRepName, $newSupplierRepEmail, $newSupplierRepPhone;
    public $newSupplierShowJuridica = false;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function save()
    {
        $this->validate([
            'serial' => 'required|min:3|max:50|unique:machines,serial',
            'image' => 'nullable|image|max:2048',
            'last_maintenance' => 'nullable|date',
            'state_id' => 'required|exists:states,id',
            'machine_type_id' => 'required|exists:machine_types,id',
            'brand_id' => 'required|exists:brands,id',
            'supplier_nit' => 'required|exists:suppliers,nit',
        ]);

        $this->company_nit = Auth::user()->company_nit;

        $imageName = $this->serial . '-' . time() . '.' . $this->image->getClientOriginalExtension();
        $imagePath = $this->image->storeAs('machines-images', $imageName, 'public');

        Machine::create([
            'serial' => $this->serial,
            'image' => $imagePath,
            'last_maintenance' => $this->last_maintenance,
            'state_id' => $this->state_id,
            'machine_type_id' => $this->machine_type_id,
            'brand_id' => $this->brand_id,
            'supplier_nit' => $this->supplier_nit,
            'company_nit' => $this->company_nit,
        ]);

        $this->resetFields();
        $this->view = 'index';
        $this->dispatch('event-notify', 'Máquina creada exitosamente.');
    }

    public function create()
    {
        $this->resetFields();
        $this->machineTypes = MachineType::where('company_nit', Auth::user()->company_nit)->get();
        $this->brands = Brand::all();
        $this->suppliers = Supplier::all();
        $this->view = 'create';
    }

    public function index()
    {
        $this->resetFields();
        $this->resetPage();
        $this->view = 'index';
    }

    public function show($serial)
    {
        $machine = Machine::where('serial', $serial)->firstOrFail();
        $this->serial = $machine->serial;
        $this->currentImagePath = $machine->image;
        $this->last_maintenance = $machine->last_maintenance ?? 'No Registrado';
        $this->state_id = $machine->state_id;
        $this->machine_type_id = $machine->machine_type_id;
        $this->brand_id = $machine->brand_id;
        $this->supplier_nit = $machine->supplier_nit;

        $this->view = 'show';
    }

    public function edit($serial)
    {
        $this->view = 'edit';
        $this->editId = $serial;

        $machine = Machine::find($serial);

        if ($machine) {
            $this->serial = $machine->serial;
            $this->currentImagePath = $machine->image;
            $this->last_maintenance = $machine->last_maintenance ?? null;
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
            'last_maintenance' => 'nullable|date',
            'state_id' => 'required|exists:states,id',
            'machine_type_id' => 'required|exists:machine_types,id',
            'brand_id' => 'required|exists:brands,id',
            'supplier_nit' => 'required|exists:suppliers,nit',
        ]);

        $machine = Machine::findOrFail($this->editId);

        $machine->update([
            'serial' => $this->serial,
            'last_maintenance' => $this->last_maintenance,
            'state_id' => $this->state_id,
            'machine_type_id' => $this->machine_type_id,
            'brand_id' => $this->brand_id,
            'supplier_nit' => $this->supplier_nit,
        ]);

        if ($this->image) {
            if ($machine->image && Storage::disk('public')->exists($machine->image)) {
                Storage::disk('public')->delete($machine->image);
            }

            $imageName = $this->serial . '_' . time() . '.' . $this->image->getClientOriginalExtension();
            $imagePath = $this->image->storeAs('machines-images', $imageName, 'public');

            $machine->update(['image' => $imagePath]);
            $this->currentImagePath = $imagePath;
        }

        $this->dispatch('event-notify', 'Máquina actualizada exitosamente.');
        $this->resetFields();
        $this->view = 'index';
    }

    private function hasRelatedData(Machine $machine)
    {
        return DB::table('maintenances')
            ->where('serial_id', $machine->serial)
            ->exists();
    }

    public function delete($serial)
    {
        $this->dispatch('event-confirm', $serial);
    }

    #[On('deleteConfirmed')]
    public function deleteConfirmed($serial)
    {
        $machine = Machine::where('serial', $serial)->firstOrFail();

        if ($this->hasRelatedData($machine)) {
            $this->dispatch('event-notify', 'No se puede eliminar la máquina porque está relacionada con mantenimientos.');
            return;
        }

        if ($machine->image && Storage::disk('public')->exists($machine->image)) {
            Storage::disk('public')->delete($machine->image);
        }

        $machine->delete();
        $this->dispatch('event-notify', 'Máquina eliminada exitosamente.');
    }

    public function resetFields()
    {
        $this->serial = '';
        $this->image = '';
        $this->last_maintenance = null;
        $this->state_id = '';
        $this->machine_type_id = '';
        $this->brand_id = '';
        $this->supplier_nit = '';
        $this->editId = null;

        if ($this->view !== 'edit') {
            $this->currentImagePath = '';
        }
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, [
            'serial' => 'required|min:3|max:50|unique:machines,serial,' . $this->editId . ',serial',
            'last_maintenance' => 'nullable|date',
            'image' => 'nullable|image|max:2048',
            'state_id' => 'required|exists:states,id',
            'machine_type_id' => 'required|exists:machine_types,id',
            'brand_id' => 'required|exists:brands,id',
            'supplier_nit' => 'required|exists:suppliers,nit',
        ]);
    }

    public function mount()
    {
        $this->states = State::whereIn('id', [3, 4, 5])->get();
    }

        // Al seleccionar "+ Crear nuevo tipo"
    public function updatedMachineTypeId($value)
    {
        if ($value === 'new_machine_type') {
            $this->machine_type_id = '';
            $this->showNewTypeModal = true;
        }
    }

    // Al seleccionar "+ Crear nueva marca"
    public function updatedBrandId($value)
    {
        if ($value === 'new_brand') {
            $this->brand_id = '';
            $this->showNewBrandModal = true;
        }
    }

    // Al seleccionar "+ Crear nuevo proveedor"
    public function updatedSupplierNit($value)
    {
        if ($value === 'new_supplier') {
            $this->supplier_nit = '';
            $this->showNewSupplierModal = true;
            return;
        }

        $this->newSupplierShowJuridica = ($value === 'Juridica');
    }

    public function updatedNewSupplierPersonType($value)
    {
        $this->newSupplierShowJuridica = ($value === 'Juridica');
    }

    //Muestra el modal para crear un nuevo tipo de maquina
    public function saveNewType()
    {
        $this->validate([
            'newMachineTypeName' => 'required|string|max:100',
        ]);
        
        $this->company_nit = Auth::user()->company_nit;

        $type = \App\Models\MachineType::create([
            'name' => $this->newMachineTypeName,
            'company_nit' => $this->company_nit,
        ]);

        $this->company_nit = '';
        $this->machineTypes = \App\Models\MachineType::all();
        $this->machine_type_id = $type->id;
        $this->newMachineTypeName = '';
        $this->showNewTypeModal = false;

        $this->dispatch('event-notify', 'Tipo de máquina creado correctamente.');
    }

    public function saveNewBrand()
    {
        $this->validate([
            'newBrandName' => 'required|string|max:100',
        ]);

        $brand = \App\Models\Brand::create([
            'name' => $this->newBrandName,
        ]);

        $this->brands = \App\Models\Brand::all();
        $this->brand_id = $brand->id;
        $this->newBrandName = '';
        $this->showNewBrandModal = false;

        $this->dispatch('event-notify', 'Marca creada correctamente.');
    }

    public function saveNewSupplier()
    {
        $rules = [
            'newSupplierNit' => 'required|min:3|max:50|unique:suppliers,nit',
            'newSupplierName' => 'required|min:3|max:50',
            'newSupplierPersonType' => 'required|in:Natural,Juridica',
            'newSupplierEmail' => 'required|email|max:50',
            'newSupplierPhone' => 'required|min:3|max:50',
        ];

        if ($this->newSupplierPersonType === 'Juridica') {
            $rules += [
                'newSupplierRepName' => 'required|min:3|max:50',
                'newSupplierRepEmail' => 'required|email|max:50',
                'newSupplierRepPhone' => 'required|min:3|max:50',
            ];
        }

        $this->validate($rules);
        $this->company_nit = Auth::user()->company_nit;

        $data = [
            'nit' => $this->newSupplierNit,
            'name' => $this->newSupplierName,
            'person_type' => $this->newSupplierPersonType,
            'email' => $this->newSupplierEmail,
            'phone' => $this->newSupplierPhone,
            'company_nit' => $this->company_nit,
        ];

        if ($this->newSupplierPersonType === 'Juridica') {
            $data += [
                'representative_name' => $this->newSupplierRepName,
                'representative_email' => $this->newSupplierRepEmail,
                'representative_phone' => $this->newSupplierRepPhone,
            ];
        }

        \App\Models\Supplier::create($data);

        $this->dispatch('event-notify', 'Proveedor creado correctamente.');

        $this->suppliers = \App\Models\Supplier::orderBy('name')->get();
        $this->supplier_nit = $this->newSupplierNit;

        // Resetea y cierra modal
        $this->reset([
            'newSupplierNit', 'newSupplierName', 'newSupplierPersonType', 'newSupplierEmail', 'newSupplierPhone',
            'newSupplierRepName', 'newSupplierRepEmail', 'newSupplierRepPhone', 'newSupplierShowJuridica'
        ]);
        $this->showNewSupplierModal = false;
    }

    public function render()
    {
        $machines = Machine::query()
            ->when($this->modelSelected, function ($query) {
                $query->where('machine_type_id', $this->modelSelected);
            })
            ->where('company_nit', Auth::user()->company_nit)
            ->where('serial', 'like', '%' . $this->search . '%')
            ->paginate(10);

        return view('livewire.machines', [
            'machines' => $machines,
            'machine_types' => MachineType::where('company_nit', Auth::user()->company_nit)->get(),
            'brands' => Brand::all(),
            'suppliers' => Supplier::where('company_nit', Auth::user()->company_nit)->get(),
        ]);
    }
}
