<?php

namespace App\Livewire;

use App\Models\Supplier;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Suppliers extends Component
{
    use WithPagination;//habilita la paginacion en el componente

    //propiedades publicas que se usan en el formulario y las vistas
    public $nit, $name, $person_type, $email, $phone, $representative_name, $representative_email, $representative_phone;
    public $view = 'index'; //controla la vista actual del componente
    public $editId = null; //almacena el NIT del proveedor que se está editando
    public $search = ''; //para buscar proveedores por NIT, nombre o representante
    public $showJuridica = false; //controla la visibilidad del campo de representante para personas jurídicas

    //metodo que reinicia la paginación al actualizar la búsqueda
    public function updatingSearch()
    {
        $this->resetPage();
    }

    //Valida y guarda un nuevo proveedor en la base de datos
    public function save()
    {
        $rules = [
            'nit' => 'required|min:3|max:50|unique:suppliers,nit',
            'name' => 'required|min:3|max:50',
            'person_type' => 'required|in:Natural,Juridica', //Asegura que el tipo de persona sea Natural o Juridica
            'email' => 'required|email|max:50',
            'phone' => 'required|min:3|max:50',
        ];

        //Si la persona es jurídica, se añaden las reglas para los campos del representante
        if ($this->person_type === 'Juridica'){
            $rules += [
                'representative_name' => 'required|min:3|max:50',
                'representative_email' => 'required|email|max:50',
                'representative_phone' => 'required|min:3|max:50',
            ];
        }

        $this->validate($rules);

        $data = [
            'nit' => $this->nit,
            'name' => $this->name,
            'person_type' => $this->person_type,
            'email' => $this->email,
            'phone' => $this->phone,
            'company_nit' => Auth::user()->company_nit,
        ];

        if ($this->person_type === 'Juridica') {
            $data += [
                'representative_name' => $this->representative_name,
                'representative_email' => $this->representative_email,
                'representative_phone' => $this->representative_phone,
            ];
        }

        Supplier::create($data);

        $this->resetFields();//Resetea los campos del formulario
        $this->view = 'index';// Cambia la vista a 'index' después de guardar
        session()->flash('success', 'Proveedores creado exitosamente.');
    }

    //método que cambia la vista a 'create' y resetea los campos del formulario
    public function create()
    {  
        $this->view = 'create';
        $this->resetFields();
    }

    //método que cambia la vista a 'index' y resetea los campos del formulario
    public function index()
    {
        $this->resetFields(); //Sirve para limpiar los campos del formulario
        $this->resetPage(); //Resetea la paginación
        $this->view = 'index';
    }

    //método que muestra los detalles de un proveedor específico solo para lectura
    public function show($nit)
    {
        $supplier = Supplier::where('nit', $nit)->firstOrFail();
        //Carga los datos del proveedor en las propiedades publicas
        $this->nit = $supplier->nit;
        $this->name = $supplier->name;
        $this->person_type = $supplier->person_type;
        $this->email = $supplier->email;
        $this->phone = $supplier->phone;
        $this->representative_name = $supplier->representative_name;
        $this->representative_email = $supplier->representative_email;
        $this->representative_phone = $supplier->representative_phone;

        $this->view = 'show';// Cambia la vista a 'show' para mostrar los detalles del proveedor
    }

    //Método que carga los datos de un proveedor específico en el formulario para editar
    public function edit($nit)
    {
        $supplier = Supplier::where('nit', $nit)->firstOrFail();

        //Se guarda el Nit como identificador para la edición
        $this->editId = $supplier->nit;

        //Se cargan los datos actuales en el formulario
        $this->nit = $supplier->nit;
        $this->name = $supplier->name;
        $this->person_type = $supplier->person_type;
        $this->email = $supplier->email;
        $this->phone = $supplier->phone;

        $this->showJuridica = ($supplier->person_type === 'Juridica'); //Controla la visibilidad del campo representante

        //Solo cargamos estos campos si es persona juridica
        if ($this->showJuridica){
            $this->representative_name = $supplier->representative_name;
            $this->representative_email = $supplier->representative_email;
            $this->representative_phone = $supplier->representative_phone;
        } 

        $this->view = 'edit';
    }

    //Método que valida y actualiza los datos de un proveedor existente
    public function update()
    {
        $rules=[
            'name' => 'required|min:3|max:50',
            'person_type' => 'required|min:3|max:50',
            'email' => 'required|min:3|max:50',
            'phone' => 'required|min:3|max:50',
        ];

        if($this->person_type === 'Juridica'){
            $rules += [
                'representative_name' => 'required|min:3|max:50',
                'representative_email' => 'required|email|max:50',
                'representative_phone' => 'required|min:3|max:50',
            ];
        }

        $this->validate($rules);

        $supplier = Supplier::where('nit',$this->editId)->firstOrFail();

        $data = [
            'nit' => $this->nit,
            'name' => $this->name,
            'person_type' => $this->person_type,
            'email' => $this->email,
            'phone' => $this->phone,
        ];
        if ($this->person_type === 'Juridica') {
            $data += [
                'representative_name' => $this->representative_name,
                'representative_email' => $this->representative_email,
                'representative_phone' => $this->representative_phone,
            ];
        }
        else {
            // Si es persona natural, se eliminan los campos del representante
            $data += [
                'representative_name' => null,
                'representative_email' => null,
                'representative_phone' => null,
            ];
        }
        //Se actualizan los campos editables no se modifica el nit
        $supplier->update($data);

        $this->resetFields();
        $this->view = 'index';
        session()->flash('success', 'Proveedor actualizado exitosamente.');
    }

    private function hasRelatedData(Supplier $supplier)
    {
        return DB::table('machines')
            ->where('supplier_nit', $supplier->nit)
            ->exists();
    }

    public function delete($nit)
    {
        $this->dispatch('event-confirm', $nit);
    }

    #[On('deleteConfirmed')]
    public function deleteConfirmed($nit)
    {
        $supplier = Supplier::findOrFail($nit);

        if ($this->hasRelatedData($supplier)) {
            $this->dispatch('event-notify', 'No se puede eliminar el proveedor porque está relacionado con máquinas.');
            return;
        }

        $supplier->delete();

        $this->resetFields(); 
        $this->dispatch('event-notify', 'Proveedor eliminado exitosamente.');
    }

    //Método que resetea los campos del formulario
    public function resetFields()
    {
        $this->reset([
            'nit', 'name', 'person_type', 'email', 'phone','representative_name', 'representative_email', 'representative_phone', 'editId','showJuridica'
        ]);
    }

    //Metodo para actualizar la visibilidad de los campos
    public function updatedPersonType($value)
    {

        $this->showJuridica = ($value === 'Juridica');

        $this->dispatch('person-type-updated', showJuridica: $this->showJuridica);

        //Si cambiamos de juridica a natural se limpian los campos
        if (!$this->showJuridica) {
            $this->representative_name = null;
            $this->representative_email = null;
            $this->representative_phone = null;
        }
    }

    //Método que renderiza la vista del componente
    public function render()
    {
        $suppliers = Supplier::query()
            ->where('company_nit', Auth::user()->company_nit) // Filtrar por company_nit del usuario autenticado
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('nit', 'like', '%' . $this->search . '%')
                    ->orWhere('name', 'like', '%' . $this->search . '%')
                    ->orWhere('representative_name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->paginate(10);

        return view('livewire.supplier', [
            'suppliers' => $suppliers,
        ]);
    }

}
