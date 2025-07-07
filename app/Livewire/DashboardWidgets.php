<?php

namespace App\Livewire;

use App\Models\Company;
use App\Models\License;
use Livewire\Component;

class DashboardWidgets extends Component
{
    public $totalCompanies;
    public $totalLicenses;
    public $activeLicenses;
    public $expiredLicenses;

    public function mount()
    {
        // Consultas para obtener los datos
        $this->totalCompanies = Company::count();
        $this->totalLicenses = License::count();
        $this->activeLicenses = License::where('state_id', 1)->count(); // Licencias activas
        $this->expiredLicenses = License::where('state_id', 2)->count(); // Licencias expiradas
    }

    public function render()
    {
        return view('livewire.dashboard-widgets');
    }
}
