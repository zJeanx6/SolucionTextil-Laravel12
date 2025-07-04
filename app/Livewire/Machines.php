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
    use WithPagination,WithFileUploads;//habilita paginacion y la subida de archivos

    public $serial, $image, $last_maintenance, $state_id, $machine_type_id, $brand_id, $supplier_nit;//campos del formulario
    public $view = 'index'; //Controla la vista actual
    public $editId = null; //Id la maquina que se esta editando
    public $search = ''; //Variable que almacena la busqueda
    public $currentImagePath; //Ruta de la imagen esa variable es usada en edicion y visualizacion
    public $modelSelected = null; //Filtro por tipo de maquina
    public $states; //Lista de estados para el select

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

    //Metodo que reinicia la paqina conforme a la barra de busqueda
    public function updatingSearch()
    {
        $this->resetPage();
    }

    //Metodo que guarda una nueva maquina
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


        // Generar un nombre único para la imagen tomando el serial y la fecha actual
        $imageName = $this->serial . '-' . time() . '.'. $this->image->getClientOriginalExtension();
        // Guardar la imagen en la carpeta 'machines-images' dentro de 'public'
        $imagePath = $this->image->storeAs('machines-images', $imageName, 'public');

        Machine::create([
            'serial' => $this->serial,
            'image' => $imagePath,
            'last_maintenance' => $this->last_maintenance, // Guardar la fecha de último mantenimiento
            'state_id' => $this->state_id,
            'machine_type_id' => $this->machine_type_id,
            'brand_id' => $this->brand_id,
            'supplier_nit' => $this->supplier_nit, 
            'last_maintenance' => null, // Inicialmente no hay mantenimiento
        ]);

        //limpia los campos y vuelve a la vista principal
        $this->resetFields();
        $this->view = 'index';
        session()->flash('success', 'Máquina creada exitosamente.');
    }

    //cambia a la vista de creavion
    public function create()
    {     
        $this->resetFields();
        $this->machineTypes = MachineType::all();
        $this->brands = Brand::all();
        $this->suppliers = Supplier::all();
        $this->view = 'create'; // Cambia la vista a 'create'        
    }

    //Vuelve al index y limpia los campos
    public function index()
    {
        $this->resetFields(); // Sirve para limpiar los campos del formulario
        $this->resetPage(); // Resetea la paginación
        $this->view = 'index';
    }

    //Metodo que muestra los detalles de de la maquina
    public function show($serial)
    {
        $machine = Machine::where('serial', $serial)->firstOrFail();
        //Carga datos en las propiedades
        $this->serial = $machine->serial;
        $this->currentImagePath = $machine->image; // Para mostrar la imagen actual
        $this->last_maintenance = $machine->last_maintenance ?? 'No Registrado';
        $this->state_id = $machine->state_id;
        $this->machine_type_id = $machine->machine_type_id;
        $this->brand_id = $machine->brand_id;
        $this->supplier_nit = $machine->supplier_nit;

        // Cambiar la vista a 'show'
        $this->view = 'show';
    }

    //Metodo que edita la informacion de la maquina menos el serial
    public function edit($serial)
    {
        $this->view = 'edit';
        $this->editId = $serial;

        $machine = Machine::find($serial);

        if ($machine) {
            $this->serial = $machine->serial;
            $this->currentImagePath = $machine->image; // Para mostrar la imagen actual
            $this->last_maintenance = $machine->last_maintenance ?? null; // Puede ser null si no hay mantenimiento registrado
            $this->image = null; 
            $this->last_maintenance = $machine->last_maintenance;
            $this->state_id = $machine->state_id;
            $this->machine_type_id = $machine->machine_type_id;
            $this->brand_id = $machine->brand_id;
            $this->supplier_nit = $machine->supplier_nit;
        }
    }


//Actualiza una maquina existente
public function update()    
{
    //Valida campos menos el serial
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

    // Actualizar campos básicos
    $machine->update([
        'serial' => $this->serial,
        'last_maintenance' => $this->last_maintenance, // Actualizar la fecha de último mantenimiento
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

    $this->dispatch('event-notify', 'Máquina actualizada exitosamente.');
    $this->resetFields();
    $this->view = 'index';
}


    //elimina la maquina
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

    //Restablece los campos del formulario
    public function resetFields()
    {
        $this->serial = '';
        $this->image = '';
        $this->last_maintenance = null; // Inicialmente no hay mantenimiento
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

    //Validacion en tipo real de campos individuales
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

    //Se ejecuta cuando se monta el componente
    public function mount()
    {
        $this->states = State::all();//Carga los estados una vez para el select
    }

    //Renderiza la vista con los datos
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
            'brands' => Brand::all(),
            'suppliers' => Supplier::all(),
        ]);
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

        $type = \App\Models\MachineType::create([
            'name' => $this->newMachineTypeName,
        ]);

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


}

