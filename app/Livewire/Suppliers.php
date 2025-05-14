<?php

namespace App\Livewire;

use App\Models\Supplier;
use Livewire\Component;
use Livewire\WithPagination;

class Suppliers extends Component
{
    use WithPagination;

    public $nit, $name, $person_type, $email, $phone, $representative_name, $representative_email, $representative_phone;
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
            'nit' => 'required|min:3|max:50|unique:suppliers,nit',
            'name' => 'required|min:3|max:50',
            'person_type' => 'required|min:3|max:50',
            'email' => 'required|email|max:50',
            'phone' => 'required|min:3|max:50',
            'representative_name' => 'required|min:3|max:50',
            'representative_email' => 'required|min:3|max:50',
            'representative_phone' => 'required|min:3|max:50',
        ]);

        Supplier::create([
            'nit' => $this->nit,
            'name' => $this->name,
            'person_type' => $this->person_type,
            'email' => $this->email,
            'phone' => $this->phone,
            'representative_name' => $this->representative_name,
            'representative_email' => $this->representative_email,
            'representative_phone' => $this->representative_phone,
        ]);

        $this->resetFields();
        $this->view = 'index';
        session()->flash('success', 'Proveedores creado exitosamente.');
    }

    public function create()
    {  
        $this->view = 'create';
        $this->resetFields();
    }

    public function index()
    {
        $this->view = 'index';
    }

    public function edit($nit)
    {
        $supplier = Supplier::findOrFail($nit);

        $this->editId = $supplier->nit;
        $this->nit = $supplier->nit;
        $this->name = $supplier->name;
        $this->person_type = $supplier->person_type;
        $this->email = $supplier->email;
        $this->phone = $supplier->phone;
        $this->representative_name = $supplier->representative_name;
        $this->representative_email = $supplier->representative_email;
        $this->representative_phone = $supplier->representative_phone;
        $this->view = 'edit';
    }

    public function update()
    {
        $this->validate([
            'nit' => 'required|min:3|max:50',
            'name' => 'required|min:3|max:50',
            'person_type' => 'required|min:3|max:50',
            'email' => 'required|min:3|max:50',
            'phone' => 'required|min:3|max:50',
            'representative_name' => 'required|min:3|max:50',
            'representative_email' => 'required|min:3|max:50',
            'representative_phone' => 'required|min:3|max:50',
        ]);

        $supplier = Supplier::findOrFail($this->editId);
        $supplier->update([
            'name' => $this->name,
            'person_type' => $this->person_type,
            'email' => $this->email,
            'phone' => $this->phone,
            'representative_name' => $this->representative_name,
            'representative_email' => $this->representative_email,
            'representative_phone' => $this->representative_phone,
        ]);

        $this->resetFields();
        $this->view = 'index';
        session()->flash('success', 'Proveedor actualizado exitosamente.');
    }

    public function delete($nit)
{
    Supplier::findOrFail($nit)->delete(); 
    $this->resetFields(); 
    session()->flash('success', 'Proveedor eliminado exitosamente.');
}


    public function resetFields()
    {
        $this->reset([
            'nit', 'name', 'person_type', 'email', 'phone','representative_name', 'representative_email', 'representative_phone', 'editId'
        ]);
    }

    public function render()
    {
        $suppliers = Supplier::query()
            ->where('name', 'like', '%' . $this->search . '%')
            ->orderBy('nit', 'desc')
            ->paginate(12);

        return view('livewire.supplier', [
            'suppliers' => $suppliers,
            'view' => $this->view,
        ]);
    }

}
