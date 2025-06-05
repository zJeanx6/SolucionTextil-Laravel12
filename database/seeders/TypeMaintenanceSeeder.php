<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MaintenanceType;

class TypeMaintenanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MaintenanceType::create (['name'=>'Preventivo', 'description'=>'Mantenimiento preventivo programado para evitar fallos.']);
        MaintenanceType::create  (['name'=>'Correctivo', 'description'=> 'Mantenimiento correctivo para reparar fallos detectados.']);
        MaintenanceType::create (['name'=> 'Predictivo', 'description'=>'Mantenimiento predictivo basado en el estado del equipo.']);
        MaintenanceType::create (['name'=>'Condicional', 'description'=>'Mantenimiento condicional basado en condiciones específicas del equipo.']);
        MaintenanceType::create (['name'=>'Urgente', 'description'=>'Mantenimiento urgente para fallos críticos que requieren atención inmediata.']);
        MaintenanceType::create (['name'=>'Programado', 'description'=>'Mantenimiento programado para realizar tareas de mantenimiento rutinarias.']);

    }
}
