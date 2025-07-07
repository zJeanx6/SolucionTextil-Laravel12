<?php

namespace App\Livewire;

use App\Models\Company;
use App\Models\License;
use App\Models\LicenseType;
use App\Models\State;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Illuminate\Support\Str;
use Carbon\Carbon;

class LicenseManager extends Component
{
    use WithPagination;

    public $license, $company_nit, $purchase_date, $end_date, $state_id = 1, $license_type_id;
    public $view = 'index';
    public $editLicense = '';
    public $search = '';

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function mount()
    {
        $this->resetPage();
        $this->purchase_date = Carbon::now()->toDateString();  // Establecer la fecha de compra como la fecha actual
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    // Reglas de validación para la creación
    protected function createRules()
    {
        return [
            'license' => 'required|string|max:255|unique:licenses,license',
            'company_nit' => 'required|exists:companies,nit',
            'purchase_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:purchase_date',
            'state_id' => 'required|exists:states,id',
            'license_type_id' => 'required|exists:license_types,id',
        ];
    }

    // Reglas de validación para la edición
    protected function updateRules()
    {
        return [
            'license' => 'required|string|max:255|unique:licenses,license,' . $this->editLicense,
            'company_nit' => 'required|exists:companies,nit',
            'purchase_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:purchase_date',
            'state_id' => 'required|exists:states,id',
            'license_type_id' => 'required|exists:license_types,id',
        ];
    }

    public function save()
    {
        $this->validate($this->createRules());

        License::create([
            'license' => $this->license,
            'company_nit' => $this->company_nit,
            'purchase_date' => $this->purchase_date,
            'end_date' => $this->end_date,
            'state_id' => $this->state_id,
            'license_type_id' => $this->license_type_id,
        ]);

        $this->index();
        $this->dispatch('event-notify', 'Licencia creada.');
    }

    public function create()
    {
        $this->reset();
        $this->resetValidation();
        $this->view = 'create';
        $this->purchase_date = Carbon::now()->toDateString();  // Aseguramos que la fecha de compra siempre sea la fecha actual al crear una licencia
        $this->end_date = null; // Limpiar fecha de fin para que se recalculé cuando se seleccione el tipo de licencia
    }

    public function index()
    {
        $this->reset();
        $this->view = 'index';
    }

    public function edit($license)
    {
        $this->reset('search');
        $licenseRecord = License::where('license', $license)->firstOrFail();
        $this->editLicense = $licenseRecord->license;
        $this->license = $licenseRecord->license;
        $this->company_nit = $licenseRecord->company_nit;
        $this->purchase_date = $licenseRecord->purchase_date;
        $this->end_date = $licenseRecord->end_date;
        $this->state_id = $licenseRecord->state_id;
        $this->license_type_id = $licenseRecord->license_type_id;
        $this->view = 'edit';
    }

    public function update()
    {
        $this->validate($this->updateRules());

        $licenseRecord = License::where('license', $this->license)->firstOrFail();
        $licenseRecord->update([
            'company_nit' => $this->company_nit,
            'purchase_date' => $this->purchase_date,
            'end_date' => $this->end_date,
            'state_id' => $this->state_id,
            'license_type_id' => $this->license_type_id,
        ]);

        $this->reset(['license', 'company_nit', 'purchase_date', 'end_date', 'state_id', 'license_type_id', 'editLicense']);
        $this->dispatch('event-notify', 'Licencia actualizada.');
        $this->index();
    }

    private function hasRelatedLicenses(License $license)
    {
        return License::where('company_nit', $license->company_nit)->exists();
    }

    public function delete($license)
    {
        $this->dispatch('event-confirm', $license);
    }

    #[On('deleteConfirmed')]
    public function deleteConfirmed($license)
    {
        $licenseRecord = License::where('license', $license)->firstOrFail();

        if ($this->hasRelatedLicenses($licenseRecord)) {
            $this->dispatch('event-notify', 'No se puede eliminar la licencia porque está asociada con una empresa.');
            return;
        }

        $licenseRecord->delete();
        $this->dispatch('event-notify', 'Licencia eliminada.');
    }

    // Generador de licencia aleatoria
    public function generateLicense()
    {
        // Genera una clave aleatoria con el formato XXXX-XXXX-XXXX-XXXX-XXXX
        $license = strtoupper(Str::random(4)) . '-' . strtoupper(Str::random(4)) . '-' . strtoupper(Str::random(4)) . '-' . strtoupper(Str::random(4)) . '-' . strtoupper(Str::random(4));

        // Asegurarse de que la licencia no exista ya
        while (License::where('license', $license)->exists()) {
            $license = strtoupper(Str::random(4)) . '-' . strtoupper(Str::random(4)) . '-' . strtoupper(Str::random(4)) . '-' . strtoupper(Str::random(4)) . '-' . strtoupper(Str::random(4));
        }

        $this->license = $license;
    }

    // Función para recalcular la fecha de fin automáticamente cuando se cambia el tipo de licencia
    public function updatedLicenseTypeId($value)
    {
        $licenseType = LicenseType::find($value);
        if ($licenseType) {
            // Sumamos la duración al día actual para obtener la fecha de fin
            $this->end_date = Carbon::parse($this->purchase_date)->addDays($licenseType->duration)->toDateString();
        }
    }

    public function render()
    {
        if ($this->view !== 'index') {
            return view('livewire.license-manager', ['licenses' => collect()]);
        }

        $licenses = License::query()
            ->when($this->search, fn($q) => $q->where('license', 'like', "%{$this->search}%"))
            ->orderByDesc('license')
            ->paginate(12);

        return view('livewire.license-manager', compact('licenses'));
    }
}
