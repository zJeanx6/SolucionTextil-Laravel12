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
            ['id' => 1, 'name' => 'Hiladora'],
            ['id' => 2, 'name' => 'Carda'],
            ['id' => 3, 'name' => 'Tejedora Plana'],
            ['id' => 4, 'name' => 'Tejedora de Punto Circular'],
            ['id' => 5, 'name' => 'Máquina de Corte'],
            ['id' => 6, 'name' => 'Máquina de Costura Industrial'],
            ['id' => 7, 'name' => 'Overlock'],
            ['id' => 8, 'name' => 'Máquina de Bordado'],
            ['id' => 9, 'name' => 'Serigrafía Textil'],
            ['id' => 10,'name' => 'Calandria / Plancha Industrial'],
        ];

        MachineType::insert($types);
    }
}
