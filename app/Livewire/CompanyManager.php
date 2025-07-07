<?php

namespace App\Livewire;

use App\Models\Company;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class CompanyManager extends Component
{
    use WithPagination;

    public $nit, $name, $email;
    public $view = 'index';
    public $editNit = '';
    public $search = '';

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function mount()
    {
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage(); // Resetea la paginación al buscar.
    }

    // Reglas de validación para la creación
    protected function createRules()
    {
        return [
            'nit' => 'required|string|max:20|unique:companies,nit',
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100',
        ];
    }

    // Reglas de validación para la edición
    protected function updateRules()
    {
        return [
            'nit' => 'required|string|max:20|exists:companies,nit',
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100',
        ];
    }

    public function save()
    {
        $this->validate($this->createRules());  // Usamos las reglas de validación para la creación

        Company::create([
            'nit' => $this->nit,
            'name' => $this->name,
            'email' => $this->email,
        ]);

        $this->reset(['nit', 'name', 'email']);
        $this->view = 'index';
        $this->dispatch('event-notify', 'Empresa creada.');
    }

    public function create()
    {
        $this->reset('search');
        $this->view = 'create';
    }

    public function index()
    {
        $this->reset('search');
        $this->view = 'index';
    }

    public function edit($nit)
    {
        $this->reset('search');
        $company = Company::where('nit', $nit)->firstOrFail();
        $this->editNit = $company->nit;
        $this->nit = $company->nit;
        $this->name = $company->name;
        $this->email = $company->email;
        $this->view = 'edit';
    }

    public function update()
    {
        $this->validate($this->updateRules());

        $company = Company::where('nit', $this->nit)->firstOrFail();
        $company->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        $this->reset(['nit', 'name', 'email', 'editNit']);
        $this->dispatch('event-notify', 'Empresa actualizada.');
        $this->index();
    }

    private function hasRelatedUsers(Company $company)
    {
        return DB::table('users')
            ->where('company_nit', $company->nit)
            ->exists();
    }

    public function delete($nit)
    {
        $this->dispatch('event-confirm', $nit);
    }

    #[On('deleteConfirmed')]
    public function deleteConfirmed($nit)
    {
        $company = Company::findOrFail($nit);

        if ($this->hasRelatedUsers($company)) {
            $this->dispatch('event-notify', 'No se puede eliminar la empresa porque está asociada con usuarios.');
            return;
        }

        $company->delete();
        $this->dispatch('event-notify', 'Empresa eliminada.');
    }


    public function render()
    {
        if ($this->view !== 'index') {
            return view('livewire.company-manager', ['companies' => collect()]);
        }

        $companies = Company::query()
            ->when($this->search, fn($q) => $q->where('name', 'like', "%{$this->search}%"))
            ->orderByDesc('nit')
            ->paginate(12);

        return view('livewire.company-manager', compact('companies'));
    }
}
