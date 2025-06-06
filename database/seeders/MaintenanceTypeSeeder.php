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
                'description' => 'Eliminación de polvo y fibras acumuladas en superficies y componentes.',
            ],
            [
                'id'          => 2,
                'name'        => 'Lubricación',
                'description' => 'Aplicación de lubricantes en puntos de fricción para reducir desgaste.',
            ],
            [
                'id'          => 3,
                'name'        => 'Ajuste de tensiones',
                'description' => 'Verificación y regulación de tensiones de hilos, correas y bandas.',
            ],
            [
                'id'          => 4,
                'name'        => 'Calibración',
                'description' => 'Ajuste de sensores y controles electrónicos para garantizar precisión.',
            ],
            [
                'id'          => 5,
                'name'        => 'Inspección mecánica',
                'description' => 'Revisión de engranajes, rodamientos y piezas móviles en busca de desgaste.',
            ],
            [
                'id'          => 6,
                'name'        => 'Inspección eléctrica',
                'description' => 'Chequeo de cableado, conexiones y componentes eléctricos.',
            ],
            [
                'id'          => 7,
                'name'        => 'Sustitución de piezas',
                'description' => 'Reemplazo de rodillos, correas, rodamientos u otras piezas desgastadas.',
            ],
            [
                'id'          => 8,
                'name'        => 'Mantenimiento preventivo',
                'description' => 'Conjunto de tareas programadas para evitar fallos inesperados.',
            ],
            [
                'id'          => 9,
                'name'        => 'Mantenimiento correctivo',
                'description' => 'Reparación de averías y restauración de la máquina tras una falla.',
            ],
            [
                'id'          => 10,
                'name'        => 'Actualización de software',
                'description' => 'Instalación de nuevas versiones de firmware o software de control.',
            ],
        ];

        MaintenanceType::insert($types);
    }
}
