<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;//Proporciona acceso a la base de datos
use Livewire\Attributes\Lazy;//Permite que el componente se cargue de forma diferida, mejorando el rendimiento al evitar la carga inmediata de datos innecesarios

#[Lazy]
class RecentMaintenanceTable extends Component
{
    public $maintenances;//Propiedad pública para almacenar las mantenimientos recientes

    // Esta función se ejecuta al montar el componente
    public function mount()
    {
        $this->maintenances = DB::table('maintenances')
        ->join('maintenance_details', 'maintenances.id', '=', 'maintenance_details.maintenance_id')// Une la tabla de mantenimientos con los detalles de mantenimiento por medio del ID de mantenimiento
        ->join('machines', 'maintenances.serial_id', '=', 'machines.serial')// Une la tabla de mantenimientos con las máquinas por medio del ID de serie
        ->join('users', 'maintenances.card_id', '=', 'users.card')// Une la tabla de mantenimientos con los usuarios por medio del documento del usuario
        ->join('maintenance_types', 'maintenance_details.maintenance_type_id', '=', 'maintenance_types.id')// Une la tabla de detalles de mantenimiento con los tipos de mantenimiento por medio del ID del tipo de mantenimiento
        ->leftJoin('states', 'maintenances.state_id', '=', 'states.id')// Une la tabla de mantenimientos con los estados por medio del ID del estado
        ->selectRaw("

            maintenances.created_at AS date,
            'Mantenimiento' AS type,
            machines.serial AS machine_serial,
            CONCAT(users.name, ' ', users.last_name) AS user_name,
            maintenances.maintenance_type AS maintenance_category,
            maintenance_types.name AS specific_maintenance_type,
            maintenance_details.maintenance_date,
            maintenance_details.next_maintenance_date,
            states.name AS current_state,
            CASE
                WHEN maintenances.maintenance_type = 'Preventivo' THEN 'Mantenimiento preventivo'
                WHEN maintenances.maintenance_type = 'Correctivo' THEN 'Mantenimiento correctivo'
                ELSE 'Otro tipo de mantenimiento'
            END AS maintenance_nature,
            CASE
                WHEN maintenance_details.next_maintenance_date IS NULL THEN 'Sin fecha de próximo mantenimiento'
                WHEN maintenance_details.next_maintenance_date < NOW() THEN 'Próximo mantenimiento vencido'
                ELSE 'Próximo mantenimiento pendiente'
            END AS next_maintenance_status
        ")
        ->orderBy('date', 'desc')// Ordena los mantenimientos por fecha de creación en orden descendente
        ->take(10)// Limita la consulta a los 10 mantenimientos más recientes
        ->get();// Obtiene los datos de la base de datos y los almacena en la propiedad $maintenances
    }
    public function render()
    {
        return view('livewire.recent-maintenance-table');
    }
}
