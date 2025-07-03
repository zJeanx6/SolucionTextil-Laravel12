<?php

namespace Database\Seeders;

use App\Models\MaintenanceType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MaintenanceTypeSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $types = [
            [
                'id'          => 1,
                'name'        => 'Limpieza general',
                'type'        => 'Preventivo',
                'description' => 'Eliminación de polvo y fibras acumuladas en superficies y componentes.',
            ],
            [
                'id'          => 2,
                'name'        => 'Lubricación',
                'type'        => 'Preventivo',
                'description' => 'Aplicación de lubricantes en puntos de fricción para reducir desgaste.',
            ],
            [
                'id'          => 3,
                'name'        => 'Ajuste de tensiones',
                'type'        => 'Preventivo',
                'description' => 'Verificación y regulación de tensiones de hilos, correas y bandas.',
            ],
            [
                'id'          => 4,
                'name'        => 'Calibración',
                'type'        => 'Preventivo',
                'description' => 'Ajuste de sensores y controles electrónicos para garantizar precisión.',
            ],
            [
                'id'          => 5,
                'name'        => 'Inspección mecánica',
                'type'        => 'Preventivo',
                'description' => 'Revisión de engranajes, rodamientos y piezas móviles en busca de desgaste.',
            ],
            [
                'id'          => 6,
                'name'        => 'Inspección eléctrica',
                'type'        => 'Correctivo',
                'description' => 'Chequeo de cableado, conexiones y componentes eléctricos.',
            ],
            [
                'id'          => 7,
                'name'        => 'Sustitución de piezas',
                'type'        => 'Correctivo',
                'description' => 'Reemplazo de rodillos, correas, rodamientos u otras piezas desgastadas.',
            ],
            [
                'id'          => 8,
                'name'        => 'Mantenimiento preventivo',
                'type'        => 'Correctivo',
                'description' => 'Conjunto de tareas programadas para evitar fallos inesperados.',
            ],
            [
                'id'          => 9,
                'name'        => 'Mantenimiento correctivo',
                'type'        => 'Correctivo',
                'description' => 'Reparación de averías y restauración de la máquina tras una falla.',
            ],
            [
                'id'          => 10,
                'name'        => 'Actualización de software',
                'type'        => 'Correctivo',
                'description' => 'Instalación de nuevas versiones de firmware o software de control.',
            ],
        ];

        MaintenanceType::insert($types);
    }
}
