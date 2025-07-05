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
use Illuminate\support\Str; // genera nombres únicos para las imágenes
use Illuminate\Support\Facades\Log; // para registrar logs
use Illuminate\Support\Facades\Storage; // para manejar el almacenamiento de archivos

class Machines extends Component
{
    use WithPagination, WithFileUploads; // habilita paginación y subida de archivos

    // Propiedades del formulario
    public $serial, $image, $last_maintenance, $state_id, $machine_type_id, $brand_id, $supplier_nit;
    public $view = 'index'; // Vista actual del componente (index, create, show, edit)
    public $editId = null; // ID de la máquina en edición
    public $search = ''; // Término de búsqueda
    public $currentImagePath; // Ruta de la imagen actual (usada en edición o visualización)
    public $modelSelected = null; // Filtro por tipo de máquina
    public $states; // Lista de estados para select

    // Control de modales
    public $showNewTypeModal = false;
    public $showNewBrandModal = false;
    public $showNewSupplierModal = false;

    // Listas de datos
    public $machineTypes = [];
    public $brands = [];
    public $suppliers = [];

    // Campos para nuevo tipo, marca o proveedor
    public $newMachineTypeName = '';
    public $newBrandName = '';
    public $newSupplierNit, $newSupplierName, $newSupplierPersonType, $newSupplierEmail, $newSupplierPhone;
    public $newSupplierRepName, $newSupplierRepEmail, $newSupplierRepPhone;
    public $newSupplierShowJuridica = false; // muestra campos adicionales si es persona jurídica

    // Se ejecuta al modificar la barra de búsqueda
    public function updatingSearch()
    {
        $this->resetPage();
    }

    // Guarda una nueva máquina
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

        // Generar nombre y guardar imagen
        $imageName = $this->serial . '-' . time() . '.' . $this->image->getClientOriginalExtension();
        $imagePath = $this->image->storeAs('machines-images', $imageName, 'public');

        // Crear la máquina
        Machine::create([
            'serial' => $this->serial,
            'image' => $imagePath,
            'last_maintenance' => null, // inicialmente sin mantenimiento
            'state_id' => $this->state_id,
            'machine_type_id' => $this->machine_type_id,
            'brand_id' => $this->brand_id,
            'supplier_nit' => $this->supplier_nit,
        ]);

        // Limpiar campos y volver al index
        $this->resetFields();
        $this->view = 'index';
        session()->flash('success', 'Máquina creada exitosamente.');
    }

    // Cambia a la vista de creación
    public function create()
    {
        $this->resetFields();
        $this->machineTypes = MachineType::all();
        $this->brands = Brand::all();
        $this->suppliers = Supplier::all();
        $this->view = 'create';
    }

    // Regresa al index y resetea todo
    public function index()
    {
        $this->resetFields();
        $this->resetPage();
        $this->view = 'index';
    }

    // Muestra detalles de una máquina
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

        // Cambiar la vista a 'show'
        $this->view = 'show';
    }

    // Carga datos para editar una máquina
    public function edit($serial)
    {
        $this->view = 'edit';
        $this->editId = $serial;

        $machine = Machine::where('serial', $serial)->firstOrFail();

        $this->serial = $machine->serial;
        $this->currentImagePath = $machine->image;
        $this->last_maintenance = $machine->last_maintenance ?? null;
        $this->image = null;
        $this->state_id = $machine->state_id;
        $this->machine_type_id = $machine->machine_type_id;
        $this->brand_id = $machine->brand_id;
        $this->supplier_nit = $machine->supplier_nit;

        $this->machineTypes = MachineType::all();
        $this->brands = Brand::all();
        $this->suppliers = Supplier::all();
    }

    // Actualiza los datos de la máquina editada
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

        // Si hay imagen nueva, reemplazarla
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

    // Elimina una máquina
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

    // Limpia todos los campos
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

        //  evita perder la ruta de la imagen cuando entras a editar
        if ($this->view !== 'edit') {
            $this->currentImagePath = '';
        }
    }

    // Validación en vivo de cada propiedad
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

    // Se ejecuta al cargar el componente
    public function mount()
    {
        $this->states = State::whereIn('id', [3,4,5])->orderBy('name')->get();
    }

    // Renderiza la vista con los datos
    public function render()
    {
        $machines = Machine::query()
            ->when($this->modelSelected, fn($query) => $query->where('machine_type_id', $this->modelSelected))
            ->where('serial', 'like', '%' . $this->search . '%')
            ->paginate(10);

        return view('livewire.machines', [
            'machines' => $machines,
            'machine_types' => MachineType::all(),
            'brands' => Brand::all(),
            'suppliers' => Supplier::all(),
        ]);
    }

    // Control para crear tipo, marca o proveedor
    public function updatedMachineTypeId($value) {
        if ($value === 'new_machine_type') {
            $this->machine_type_id = '';
            $this->showNewTypeModal = true;
        }
    }

    public function updatedBrandId($value) {
        if ($value === 'new_brand') {
            $this->brand_id = '';
            $this->showNewBrandModal = true;
        }
    }

    public function updatedSupplierNit($value) {
        if ($value === 'new_supplier') {
            $this->supplier_nit = '';
            $this->showNewSupplierModal = true;
            return;
        }
        $this->newSupplierShowJuridica = ($value === 'Juridica');
    }

    public function updatedNewSupplierPersonType($value) {
        $this->newSupplierShowJuridica = ($value === 'Juridica');
    }

    // Guardar nuevo tipo de máquina
    public function saveNewType() {
        $this->validate([
            'newMachineTypeName' => 'required|string|min:3|max:100',
        ], [], ['newMachineTypeName' => 'nombre del tipo de máquina']);

        $type = MachineType::create(['name' => $this->newMachineTypeName]);
        $this->machineTypes = MachineType::all();
        $this->machine_type_id = $type->id;
        $this->newMachineTypeName = '';
        $this->showNewTypeModal = false;

        $this->dispatch('event-notify', 'Tipo de máquina creado correctamente.');
    }

    // Guardar nueva marca
    public function saveNewBrand() {
        $this->validate([
            'newBrandName' => 'required|string|min:3|max:100',
        ], [], ['newBrandName' => 'nombre de la marca']);

        $brand = Brand::create(['name' => $this->newBrandName]);
        $this->brands = Brand::all();
        $this->brand_id = $brand->id;
        $this->newBrandName = '';
        $this->showNewBrandModal = false;

        $this->dispatch('event-notify', 'Marca creada correctamente.');
    }

    // Guardar nuevo proveedor
    public function saveNewSupplier() {
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

        $data = [
            'nit' => $this->newSupplierNit,
            'name' => $this->newSupplierName,
            'person_type' => $this->newSupplierPersonType,
            'email' => $this->newSupplierEmail,
            'phone' => $this->newSupplierPhone,
        ];

        if ($this->newSupplierPersonType === 'Juridica') {
            $data += [
                'representative_name' => $this->newSupplierRepName,
                'representative_email' => $this->newSupplierRepEmail,
                'representative_phone' => $this->newSupplierRepPhone,
            ];
        }

        Supplier::create($data);

        $this->dispatch('event-notify', 'Proveedor creado correctamente.');

        $this->suppliers = Supplier::orderBy('name')->get();
        $this->supplier_nit = $this->newSupplierNit;

        // Reset campos y cerrar modal
        $this->reset([
            'newSupplierNit', 'newSupplierName', 'newSupplierPersonType', 'newSupplierEmail', 'newSupplierPhone',
            'newSupplierRepName', 'newSupplierRepEmail', 'newSupplierRepPhone', 'newSupplierShowJuridica'
        ]);
        $this->showNewSupplierModal = false;
    }
}
