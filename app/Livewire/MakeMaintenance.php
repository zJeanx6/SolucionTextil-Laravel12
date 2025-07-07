<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Machine;
use App\Models\MaintenanceDetail;
use App\Models\MaintenanceType;
use App\Models\Maintenance;
use App\Models\User;
use App\Models\State;  // Importar la clase State
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MakeMaintenance extends Component
{
    use WithPagination;

    public $view = 'index'; 
    public $search = ''; 
    public $showAll = false; 
    public $selectedMachine; 

    // Campos para el formulario que se utilizan como variables públicas
    public $maintenance_date;
    public $next_maintenance_date;
    public $description;
    public $maintenance_type = 'Correctivo'; // Por defecto, el mantenimiento es de tipo 'Correctivo'
    public $maintenance_types = []; 
    public $maintenance_type_id = []; 
    public $state_id; // Para el estado de la máquina seleccionado

    // Método que se ejecuta al iniciar el componente
    public function mount()
    {
        $this->maintenance_date = now()->format('Y-m-d');
        $this->next_maintenance_date = now()->addMonth()->format('Y-m-d');
        $this->showAll = false; 
        $this->updateMaintenanceTypes(); 
    }

    // Método para actualizar los tipos de mantenimiento basados en el tipo seleccionado
    public function updateMaintenanceTypes()
    {
        $this->maintenance_types = MaintenanceType::where('type', $this->maintenance_type)->get();
    }

    // Método para actualizar el estado de la máquina seleccionado
    public function updateMachineState()
    {
        $machine = Machine::find($this->selectedMachine->serial);
        $machine->update([
            'state_id' => $this->state_id // Actualiza el estado de la máquina
        ]);
    }

    // Vuelve a la vista del índice
    public function index()
    {
        $this->view = 'index';
        $this->reset();
    }

    // Alterna entre mostrar todas las máquinas o solo las que necesitan mantenimiento
    public function toggleShowAll()
    {
        $this->showAll = !$this->showAll; 
        $this->resetPage();
    }

    // Muestra la vista de mantenimiento para una máquina específica
    public function showCreateForm($serial)
    {
        $this->reset(['maintenance_type', 'maintenance_date', 'next_maintenance_date', 'description', 'state_id']); 
        $this->view = 'create';
        $this->selectedMachine = Machine::find($serial); 
        $this->maintenance_date = now()->format('Y-m-d');
        $this->updateMaintenanceTypes(); 
    }

    // Guarda el mantenimiento de la máquina seleccionada
    public function saveMaintenance()
    {
        $this->validate([
            'maintenance_type_id' => 'required|array',
            'maintenance_type_id.*' => 'exists:maintenance_types,id',
            'maintenance_date' => 'required|date',
            'next_maintenance_date' => 'required|date|after:maintenance_date',
            'description' => 'required|string|max:500',
            'state_id' => 'required|exists:states,id' // Validar el estado
        ]);

        // Verificar si el usuario está autenticado
        $user = Auth::user();
        if (!$user) {
            $this->dispatch('event-notify', 'No se pudo registrar el mantenimiento: usuario no autenticado.');
            return;
        }

        // Registrar el mantenimiento en la tabla maintenances
        $maintenance = Maintenance::create([
            'serial_id' => $this->selectedMachine->serial,
            'card_id' => $user->card,
            'state_id' => $this->state_id, // Guardamos el estado seleccionado
            'description' => $this->description,
            'maintenance_date' => $this->maintenance_date,
            'next_maintenance_date' => $this->next_maintenance_date,
            'type' => $this->maintenance_type // Guardamos el tipo seleccionado
        ]);

        // Registrar los detalles del mantenimiento (tipos de mantenimiento)
        foreach ($this->maintenance_type_id as $typeId) {
            MaintenanceDetail::create([
                'maintenance_id' => $maintenance->id,
                'maintenance_type_id' => $typeId,
            ]);
        }

        // Actualizar el estado de la máquina
        $this->updateMachineState();

        // Actualizar la máquina con la última fecha de mantenimiento
        $this->selectedMachine->update([
            'last_maintenance' => $this->maintenance_date
        ]);

        // Notificación con dispatch
        $this->dispatch('event-notify', 'Mantenimiento registrado exitosamente.');
        $this->view = 'index';
    }
    
    public function render()
    {
        $query = Machine::query()
            ->with(['maintenances' => fn($q) => $q->latest()])
            ->when($this->search, fn($q) => $q->where('serial', 'like', '%' . $this->search . '%'))
            ->where('company_nit', Auth::user()->company_nit);
        if (!$this->showAll) {
            $query->where(function ($q) {
                $q->whereNull('last_maintenance')
                    ->orWhere('last_maintenance', '<', now()->subDays(30));
            });
        }

        return view('livewire.make-maintenance', [
            'machines' => $query->paginate(12),
            'maintenanceTypes' => MaintenanceType::all(),
            'states' => State::whereIn('id', [3, 4, 5])->get() // Filtrar los estados 3, 4 y 5
        ]);
    }
}
