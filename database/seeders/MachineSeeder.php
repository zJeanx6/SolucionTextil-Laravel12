<?php

namespace Database\Seeders;

use App\Models\Machine;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MachineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Machine::create([
            'serial' => '123456789',
            'image' => null,
            'state_id' => 1,
            'machine_type_id' => 1,
            'brand_id' => 1,
            'supplier_nit' => '900123456-1',
            'last_maintenance' => null,
        ]);
        Machine::create([
            'serial' => '987654321',
            'image' => null,
            'state_id' => 2,
            'machine_type_id' => 2,
            'brand_id' => 2,
            'supplier_nit' => '900987654-2',
            'last_maintenance' => null,
       ]);
       Machine::create([
            'serial' => '913578642',
            'image' => null,
            'state_id' => 1,
            'machine_type_id' => 1,
            'brand_id' => 1,
            'supplier_nit' => '900123456-1',
            'last_maintenance' => null,
        ]);
        Machine::create([
            'serial' => '864223156',
            'image' => null,
            'state_id' => 2,
            'machine_type_id' => 2,
            'brand_id' => 2,
            'supplier_nit' => '900987654-2',
            'last_maintenance' => null,
       ]);
        Machine::create([
            'serial' => '741258963',
            'image' => null,
            'state_id' => 1,
            'machine_type_id' => 1,
            'brand_id' => 1,
            'supplier_nit' => '900123456-1',
            'last_maintenance' => null,
        ]);
        Machine::create([
            'serial' => '369852147',
            'image' => null,
            'state_id' => 2,
            'machine_type_id' => 2,
            'brand_id' => 2,
            'supplier_nit' => '900987654-2',
            'last_maintenance' => null,
       ]);
    }
}
