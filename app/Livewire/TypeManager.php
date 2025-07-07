<?php

namespace App\Livewire;

use App\Models\ElementType;
use App\Models\MachineType;
use App\Models\ProductType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class TypeManager extends Component
{
    use WithPagination;

    // Arranca sin filtro   seleccionado
    public $modelSelected = '';
    public $name;
    public $elementGroup = '';
    public $view = 'index';
    public $editId = null;
    public $search = '';

    protected $models = [
        'element_types' => ElementType::class,
        'product_types' => ProductType::class,
        'machine_types' => MachineType::class,
    ];

    // Persistir filtros
    protected $queryString = [
        'search'        => ['except' => ''],
        'modelSelected' => ['except' => ''],
    ];

    public function mount(){
        $this->resetPage();
    }

    public function updatingSearch(){
        $this->resetPage(); // Resetea la paginación al buscar.
    }

    public function updatingModelSelected(){
        $this->resetPage(); // Resetea la paginación al cambiar el modelo seleccionado.
    }

    public function getCurrentModel(){
        return $this->models[$this->modelSelected];
    }

    protected function rules(){
        return ['name' => 'required|min:3|max:50'];
    }

    public function save()
    {
        $this->validate();
        $company_nit = Auth::user()->company_nit;

        if ($this->modelSelected === 'element_types') {
            $ranges = [
                'G-01' => [1100, 1999],
                'G-02' => [2100, 2999],
                'G-03' => [3100, 3999],
                'G-04' => [4100, 4999],
            ];
            [$min, $max] = $ranges[$this->elementGroup];
            $last = ElementType::whereBetween('id', [$min, $max])->max('id');
            $newId = $last ? min($last + 1, $max) : $min;
            ElementType::create([
                'id' => $newId,
                'name' => $this->name,
                'company_nit' => $company_nit
            ]);
            $this->reset(['name', 'elementGroup']);
        } else {
            $model = $this->getCurrentModel();
            $model::create([
                'name' => $this->name,
                'company_nit' => $company_nit
            ]);
            $this->reset('name');
        }
        $this->view = 'index';
        $this->dispatch('event-notify', 'Tipo creado.');
    }

    public function create(){
        $this->reset('search');
        $this->view = 'create';
    }

    public function index(){
        $this->reset('search');
        $this->view = 'index';
    }

    public function edit($id)
    {
        $this->reset('search');
        $model = $this->getCurrentModel();
        $type = $model::findOrFail($id);
        $this->editId = $type->id;
        $this->name = $type->name;
        $this->view = 'edit';
    }

    public function update()
    {
        $this->validate();
        $model = $this->getCurrentModel();
        $type = $model::findOrFail($this->editId);
        $type->update(['name' => $this->name]);
        $this->reset(['name', 'editId']);
        $this->view = 'index';
        $this->dispatch('event-notify', 'Tipo Actualizado.');
    }

    private function hasRelatedData($type)
    {
        // Verifica si el tipo está relacionado con productos, elementos o máquinas
        switch ($this->modelSelected) {
            case 'element_types':
                return DB::table('elements')->where('element_type_id', $type->id)->exists();
            case 'product_types':
                return DB::table('products')->where('product_type_id', $type->id)->exists();
            case 'machine_types':
                return DB::table('machines')->where('machine_type_id', $type->id)->exists();
            default:
                return false;
        }
    }

    public function delete($id){
        $this->dispatch('event-confirm', $id);
    }

    #[On('deleteConfirmed')]
    public function deleteConfirmed($id)
    {
        $model = $this->getCurrentModel();
        $type = $model::findOrFail($id);

        // Verifica si el tipo tiene datos relacionados
        if ($this->hasRelatedData($type)) {
            // Si tiene registros relacionados, muestra un mensaje amigable
            $this->dispatch('event-notify', 'No se puede eliminar este tipo porque está relacionado con otros registros.');
            return;
        }

        // Si no tiene datos relacionados, proceder con la eliminación
        $type->delete();
        $this->dispatch('event-notify', 'Tipo Eliminado.');
    }

    public function render()
    {
        if ($this->view !== 'index' || ! $this->modelSelected) {
            return view('livewire.type-manager', ['types' => collect()]);
        }

        $model = $this->models[$this->modelSelected];
        $types = $model::query()
            ->where('company_nit', Auth::user()->company_nit)
            ->when($this->search, fn($q) => $q->where('name', 'like', "%{$this->search}%"))
            ->orderByDesc('id')
            ->paginate(12);

        return view('livewire.type-manager', compact('types'));
    }

}
