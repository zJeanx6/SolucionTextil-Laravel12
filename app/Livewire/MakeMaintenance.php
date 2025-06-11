<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Machine;
use App\Models\MaintenanceDetail;
use App\Models\MaintenanceType;
use App\Models\Maintenance;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
//libreria de laravel que permite trabajar con fechas de manera sencilla

class MakeMaintenance extends Component
{
    use WithPagination;

    public $view = 'index'; //Variable que maneja la vista 
    public $search = '';//Almacena la busqueda
    public $showAll = 'false';//Mantiene esta variable en falso para que solo se muestre su informacion cuando el boton lo requiera
    public $selectedMachine; //Almacena la maquina a la cual se le va a hacer el mantenimiento

    // Campos para el formulario que se utilizan como variables publicas
    public $maintenance_date;
    public $next_maintenance_date;
    public $description;
    public $maintenance_type_id;

    //Metodo que se ejecuta al iniciar el componente
    public function mount()
    {
        //Se inicializa la fecha actual y la proxima fecha de mantenimiento por defecto un mes despues
        $this->maintenance_date = now()->format('Y-m-d');
        $this->next_maintenance_date = now()->addMonth()->format('Y-m-d');
        $this->showAll = false;//Por defecto no de muestran todas mas maquinas
    }

    //Vuelve a la viats del indexxc
    public function index()
    {
       $this->view = 'index';
        $this->reset();
    }

    //Alterna entre mostrar todas las máquinas o solo las que necesitan mantenimiento
    public function toggleShowAll()
    {
        $this->showAll = !$this->showAll;//Cambia el estado de la variable showAll
        $this->resetPage(); // Reiniciar la paginación al cambiar el filtro
    }

    //Muestra la vista de mantenimiento para una máquina específica
    public function showCreateForm($serial)
    {
        $this->reset(['maintenance_type_id', 'maintenance_date', 'next_maintenance_date', 'description']);//Resetea las variables del formulario
        $this->view = 'create';//Cambia la vista a 'create'
        $this->selectedMachine = Machine::find($serial);//Busca la maquina por su serial
        $this->maintenance_date = now()->format('Y-m-d'); // Establece la fecha de mantenimiento a la fecha actual
    }

    //Guarda el mantenimiento de la máquina seleccionada
    public function saveMaintenance()
    {
        // Validar los campos del formulario
        $this->validate([
            'maintenance_type_id' => 'required|exists:maintenance_types,id',
            'maintenance_date' => 'required|date',
            'next_maintenance_date' => 'required|date|after:maintenance_date',
            'description' => 'required|string|max:500'
        ]);

        // Verificar si el usuario está autenticado
        $user = Auth::user();
        if (!$user) {
            session()->flash('error', 'No se pudo registrar el mantenimiento: usuario no autenticado.');
            return;
        }

        // Registrar en la tabla maintenances
        $maintenance = Maintenance::create([
            'maintenance_type_id' => $this->maintenance_type_id,
            'serial_id' => $this->selectedMachine->serial,
            'card_id' => $user->card, // ahora seguro
            'state_id' => 1 // Estado "Completado"
        ]);

        // Registrar detalles técnicos en la tabla maintenance_details
        MaintenanceDetail::create([
            'maintenance_id' => $maintenance->id,
            'maintenance_type_id' => $this->maintenance_type_id,
            'description' => $this->description,
            'maintenance_date' => $this->maintenance_date,
            'next_maintenance_date' => $this->next_maintenance_date
        ]);

        // Actualizar máquina
        $this->selectedMachine->update([
            'last_maintenance' => $this->maintenance_date
        ]);

        session()->flash('success', 'Mantenimiento registrado exitosamente.');
        $this->view = 'index'; // Volver a la vista de índice después de guardar
    }

    public function updatedMaintenanceDate($value)
    {
        $maintenanceDate = Carbon::parse($value);
        $minNextDate = $maintenanceDate->addDay()->format('Y-m-d');
        
        // Actualiza la próxima fecha si es menor que la fecha mínima permitida
        if ($this->next_maintenance_date < $minNextDate) {
            $this->next_maintenance_date = $minNextDate;
        }
    }

    // Define las reglas de validación para el formulario
    protected function rules()
    {
        $minDate = $this->maintenance_date 
            ? Carbon::parse($this->maintenance_date)->addDay()->format('Y-m-d')
            : Carbon::tomorrow()->format('Y-m-d');

        return [
            'maintenance_date' => 'required|date',
            'next_maintenance_date' => ['required','date','after_or_equal:'.$minDate],
        ];
    }

    public function render()
    {
        $query = Machine::query()
            ->with(['maintenances' => fn($q) => $q->latest()])
            ->when($this->search, fn($q) => $q->where('serial', 'like', '%'.$this->search.'%'));

        if (!$this->showAll) {
            $query->where(function($q) {
                $q->whereNull('last_maintenance')
                ->orWhere('last_maintenance', '<', now()->subDays(30));
            });
        }

        return view('livewire.make-maintenance', [
            'machines' => $query->paginate(10),
            'maintenanceTypes' => MaintenanceType::all()
        ]);
    }

}