<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RecentMaintenanceTable extends Component
{
    /** Últimos mantenimientos mostrados en la tabla */
    public $maintenances = [];

    /** Datos para el modal */
    public $showModal          = false;
    public $selectedMaintenance = null;   // objeto con datos generales
    public $details            = [];      // collection de tipos realizados

    /* ---------- Ciclo de vida ---------- */
    public function mount(): void
    {
        /* Traemos los 10 mantenimientos más recientes
           ─ una fila por mantenimiento
           ─ todos los tipos ejecutados en ese mantenimiento se concatenan con coma            */
        $this->maintenances = DB::table('maintenances')
            ->leftJoin('machines',            'maintenances.serial_id',      '=', 'machines.serial')
            ->leftJoin('users',               'maintenances.card_id',        '=', 'users.card')
            ->leftJoin('maintenance_details', 'maintenances.id',            '=', 'maintenance_details.maintenance_id')
            ->leftJoin('maintenance_types',   'maintenance_details.maintenance_type_id', '=', 'maintenance_types.id')
            ->select(
                'maintenances.id',
                'machines.serial      as machine_serial',
                DB::raw("GROUP_CONCAT(DISTINCT maintenance_types.name ORDER BY maintenance_types.name SEPARATOR ', ') as maintenance_types"),
                'maintenances.maintenance_date',
                'maintenances.next_maintenance_date',
                'maintenances.type as maintenance_type', // Agregamos el tipo de mantenimiento
                DB::raw("CONCAT(users.name,' ',users.last_name) as user_name")
            )
            ->groupBy(
                'maintenances.id',
                'machines.serial',
                'maintenances.maintenance_date',
                'maintenances.next_maintenance_date',
                'maintenances.type', // Incluir el tipo en el group by
                'users.name',
                'users.last_name'
            )
            ->orderBy('maintenances.maintenance_date', 'desc')
            ->take(10)
            ->get();
    }

    /* ---------- Acciones ---------- */
    /** Abre modal y carga detalle de tipos para un mantenimiento */
    public function showMaintenanceDetails(int $maintenanceId): void
    {
        $this->selectedMaintenance = DB::table('maintenances')
            ->leftJoin('machines', 'maintenances.serial_id', '=', 'machines.serial')
            ->leftJoin('users',    'maintenances.card_id',   '=', 'users.card')
            ->select(
                'maintenances.*',
                'machines.serial as machine_serial',
                DB::raw("CONCAT(users.name,' ',users.last_name) as user_name")
            )
            ->where('maintenances.id', $maintenanceId)
            ->first();

        $this->details = DB::table('maintenance_details')
            ->join('maintenance_types', 'maintenance_details.maintenance_type_id', '=', 'maintenance_types.id')
            ->where('maintenance_details.maintenance_id', $maintenanceId)
            ->select('maintenance_types.name as type_name')
            ->get();

        $this->showModal = true;
    }

    /** Cerrar el modal */
    public function closeModal(): void
    {
        $this->showModal = false;
        $this->selectedMaintenance = null;
        $this->details = [];
    }

    public function render()
    {
        return view('livewire.recent-maintenance-table');
    }
}
