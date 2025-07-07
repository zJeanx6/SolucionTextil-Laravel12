<?php

namespace App\Livewire;

use App\Models\License;
use App\Models\LicenseType;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class LicenseTypeManager extends Component
{
    use WithPagination;

    public $name, $duration;
    public $view = 'index';
    public $editId = null;
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
            'name' => 'required|string|max:100|unique:license_types,name',
            'duration' => 'required|integer|min:1',
        ];
    }

    // Reglas de validación para la edición
    protected function updateRules()
    {
        return [
            'name' => 'required|string|max:100|unique:license_types,name,' . $this->editId,
            'duration' => 'required|integer|min:1',
        ];
    }

    public function save()
    {
        $this->validate($this->createRules());

        LicenseType::create([
            'name' => $this->name,
            'duration' => $this->duration,
        ]);

        $this->reset(['name', 'duration']);
        $this->view = 'index';
        $this->dispatch('event-notify', 'Tipo de licencia creada.');
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

    public function edit($id)
    {
        $this->reset('search');
        $licenseType = LicenseType::findOrFail($id);
        $this->editId = $licenseType->id;
        $this->name = $licenseType->name;
        $this->duration = $licenseType->duration;
        $this->view = 'edit';
    }

    public function update()
    {
        $this->validate($this->updateRules());

        $licenseType = LicenseType::findOrFail($this->editId);
        $licenseType->update([
            'name' => $this->name,
            'duration' => $this->duration,
        ]);

        $this->reset(['name', 'duration', 'editId']);
        $this->dispatch('event-notify', 'Tipo de licencia actualizado.');
        $this->index();
    }

    private function hasRelatedLicenses(LicenseType $licenseType)
    {
        return License::where('license_type_id', $licenseType->id)->exists();
    }

    public function delete($id)
    {
        $this->dispatch('event-confirm', $id);
    }

    #[On('deleteConfirmed')]
    public function deleteConfirmed($id)
    {
        $licenseType = LicenseType::findOrFail($id);

        if ($this->hasRelatedLicenses($licenseType)) {
            $this->dispatch('event-notify', 'No se puede eliminar el tipo de licencia porque está asociado con licencias.');
            return;
        }

        $licenseType->delete();
        $this->dispatch('event-notify', 'Tipo de licencia eliminado.');
    }

    public function render()
    {
        if ($this->view !== 'index') {
            return view('livewire.license-type-manager', ['licenseTypes' => collect()]);
        }

        $licenseTypes = LicenseType::query()
            ->when($this->search, fn($q) => $q->where('name', 'like', "%{$this->search}%"))
            ->orderByDesc('id')
            ->paginate(12);

        return view('livewire.license-type-manager', compact('licenseTypes'));
    }
}
