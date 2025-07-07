<?php

namespace Database\Seeders;

use App\Models\MachineType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MachineTypeSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $types = [
            ['id' => 1, 'name' => 'Hiladora', 'company_nit'=>'12345678-1'],
            ['id' => 2, 'name' => 'Carda', 'company_nit'=>'12345678-1'],
            ['id' => 3, 'name' => 'Tejedora Plana', 'company_nit'=>'12345678-1'],
            ['id' => 4, 'name' => 'Tejedora de Punto Circular', 'company_nit'=>'12345678-1'],
            ['id' => 5, 'name' => 'Máquina de Corte', 'company_nit'=>'12345678-1'],
            ['id' => 6, 'name' => 'Máquina de Costura Industrial', 'company_nit'=>'12345678-2'],
            ['id' => 7, 'name' => 'Overlock', 'company_nit'=>'12345678-2'],
            ['id' => 8, 'name' => 'Máquina de Bordado', 'company_nit'=>'12345678-2'],
            ['id' => 9, 'name' => 'Serigrafía Textil', 'company_nit'=>'12345678-2'],
            ['id' => 10,'name' => 'Calandria / Plancha Industrial', 'company_nit'=>'12345678-2'],
        ];

        MachineType::insert($types);
    }
}
