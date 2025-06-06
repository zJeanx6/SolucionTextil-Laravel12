<?php

namespace Database\Seeders;

use App\Models\State;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StateSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // —— ESTADOS BASE (se mantienen sí o sí)
        State::factory()->create([
            'id'          => 1,
            'name'        => 'Activo',
            'description' => 'Estado activo de un registro',
        ]);

        State::factory()->create([
            'id'          => 2,
            'name'        => 'Inactivo',
            'description' => 'Estado inactivo de un registro',
        ]);

        // —— ESTADOS ADICIONALES PARA MÁQUINAS
        State::factory()->create([
            'id'          => 3,
            'name'        => 'En buen estado',
            'description' => 'Máquina en óptimas condiciones',
        ]);

        State::factory()->create([
            'id'          => 4,
            'name'        => 'Regular',
            'description' => 'Máquina funciona, pero requiere atención',
        ]);

        State::factory()->create([
            'id'          => 5,
            'name'        => 'Dañada',
            'description' => 'Máquina no está operativa por daños',
        ]);
    }
}
