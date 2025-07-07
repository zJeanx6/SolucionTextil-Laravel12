<?php

namespace Database\Seeders;

use App\Models\Machine;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MachineSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Tipo 1 (Hiladora) — brand_id=1, proveedor natural 9000000001
        Machine::create([ 'serial'=>'100000001','image'=>null,'state_id'=>3,'machine_type_id'=>1,'brand_id'=>1,'supplier_nit'=>'9000000001','last_maintenance'=>null, 'company_nit' => '12345678-1' ]);
        Machine::create([ 'serial'=>'100000002','image'=>null,'state_id'=>4,'machine_type_id'=>1,'brand_id'=>1,'supplier_nit'=>'9000000001','last_maintenance'=>null, 'company_nit' => '12345678-1' ]);
        Machine::create([ 'serial'=>'100000003','image'=>null,'state_id'=>5,'machine_type_id'=>1,'brand_id'=>1,'supplier_nit'=>'9000000001','last_maintenance'=>null, 'company_nit' => '12345678-1' ]);
        Machine::create([ 'serial'=>'100000004','image'=>null,'state_id'=>3,'machine_type_id'=>1,'brand_id'=>1,'supplier_nit'=>'9000000001','last_maintenance'=>null, 'company_nit' => '12345678-1' ]);
        Machine::create([ 'serial'=>'100000005','image'=>null,'state_id'=>4,'machine_type_id'=>1,'brand_id'=>1,'supplier_nit'=>'9000000001','last_maintenance'=>null, 'company_nit' => '12345678-1' ]);

        // Tipo 2 (Carda) — brand_id=2, proveedor jurídica 8000000002
        Machine::create([ 'serial'=>'200000001','image'=>null,'state_id'=>3,'machine_type_id'=>2,'brand_id'=>2,'supplier_nit'=>'8000000002','last_maintenance'=>null, 'company_nit' => '12345678-1' ]);
        Machine::create([ 'serial'=>'200000002','image'=>null,'state_id'=>4,'machine_type_id'=>2,'brand_id'=>2,'supplier_nit'=>'8000000002','last_maintenance'=>null, 'company_nit' => '12345678-1' ]);
        Machine::create([ 'serial'=>'200000003','image'=>null,'state_id'=>5,'machine_type_id'=>2,'brand_id'=>2,'supplier_nit'=>'8000000002','last_maintenance'=>null, 'company_nit' => '12345678-1' ]);
        Machine::create([ 'serial'=>'200000004','image'=>null,'state_id'=>3,'machine_type_id'=>2,'brand_id'=>2,'supplier_nit'=>'8000000002','last_maintenance'=>null, 'company_nit' => '12345678-1' ]);
        Machine::create([ 'serial'=>'200000005','image'=>null,'state_id'=>4,'machine_type_id'=>2,'brand_id'=>2,'supplier_nit'=>'8000000002','last_maintenance'=>null, 'company_nit' => '12345678-1' ]);

        // Tipo 3 (Tejedora Plana) — brand_id=3, proveedor natural 9000000003
        Machine::create([ 'serial'=>'300000001','image'=>null,'state_id'=>3,'machine_type_id'=>3,'brand_id'=>3,'supplier_nit'=>'9000000003','last_maintenance'=>null, 'company_nit' => '12345678-1' ]);
        Machine::create([ 'serial'=>'300000002','image'=>null,'state_id'=>4,'machine_type_id'=>3,'brand_id'=>3,'supplier_nit'=>'9000000003','last_maintenance'=>null, 'company_nit' => '12345678-1' ]);
        Machine::create([ 'serial'=>'300000003','image'=>null,'state_id'=>5,'machine_type_id'=>3,'brand_id'=>3,'supplier_nit'=>'9000000003','last_maintenance'=>null, 'company_nit' => '12345678-1' ]);
        Machine::create([ 'serial'=>'300000004','image'=>null,'state_id'=>3,'machine_type_id'=>3,'brand_id'=>3,'supplier_nit'=>'9000000003','last_maintenance'=>null, 'company_nit' => '12345678-1' ]);
        Machine::create([ 'serial'=>'300000005','image'=>null,'state_id'=>4,'machine_type_id'=>3,'brand_id'=>3,'supplier_nit'=>'9000000003','last_maintenance'=>null, 'company_nit' => '12345678-1' ]);

        // Tipo 4 (Tejedora de Punto Circular) — brand_id=4, proveedor jurídica 8000000004
        Machine::create([ 'serial'=>'400000001','image'=>null,'state_id'=>3,'machine_type_id'=>4,'brand_id'=>4,'supplier_nit'=>'8000000004','last_maintenance'=>null, 'company_nit' => '12345678-1' ]);
        Machine::create([ 'serial'=>'400000002','image'=>null,'state_id'=>4,'machine_type_id'=>4,'brand_id'=>4,'supplier_nit'=>'8000000004','last_maintenance'=>null, 'company_nit' => '12345678-1' ]);
        Machine::create([ 'serial'=>'400000003','image'=>null,'state_id'=>5,'machine_type_id'=>4,'brand_id'=>4,'supplier_nit'=>'8000000004','last_maintenance'=>null, 'company_nit' => '12345678-1' ]);
        Machine::create([ 'serial'=>'400000004','image'=>null,'state_id'=>3,'machine_type_id'=>4,'brand_id'=>4,'supplier_nit'=>'8000000004','last_maintenance'=>null, 'company_nit' => '12345678-1' ]);
        Machine::create([ 'serial'=>'400000005','image'=>null,'state_id'=>4,'machine_type_id'=>4,'brand_id'=>4,'supplier_nit'=>'8000000004','last_maintenance'=>null, 'company_nit' => '12345678-1' ]);

        // Tipo 5 (Máquina de Corte) — brand_id=5, proveedor natural 9000000005
        Machine::create([ 'serial'=>'500000001','image'=>null,'state_id'=>3,'machine_type_id'=>5,'brand_id'=>5,'supplier_nit'=>'9000000005','last_maintenance'=>null, 'company_nit' => '12345678-1' ]);
        Machine::create([ 'serial'=>'500000002','image'=>null,'state_id'=>4,'machine_type_id'=>5,'brand_id'=>5,'supplier_nit'=>'9000000005','last_maintenance'=>null, 'company_nit' => '12345678-1' ]);
        Machine::create([ 'serial'=>'500000003','image'=>null,'state_id'=>5,'machine_type_id'=>5,'brand_id'=>5,'supplier_nit'=>'9000000005','last_maintenance'=>null, 'company_nit' => '12345678-1' ]);
        Machine::create([ 'serial'=>'500000004','image'=>null,'state_id'=>3,'machine_type_id'=>5,'brand_id'=>5,'supplier_nit'=>'9000000005','last_maintenance'=>null, 'company_nit' => '12345678-1' ]);
        Machine::create([ 'serial'=>'500000005','image'=>null,'state_id'=>4,'machine_type_id'=>5,'brand_id'=>5,'supplier_nit'=>'9000000005','last_maintenance'=>null, 'company_nit' => '12345678-1' ]);

        // Tipo 6 (Máquina de Costura Industrial) — brand_id=6, proveedor jurídica 8000000006
        Machine::create([ 'serial'=>'600000001','image'=>null,'state_id'=>3,'machine_type_id'=>6,'brand_id'=>6,'supplier_nit'=>'8000000006','last_maintenance'=>null, 'company_nit' => '12345678-2' ]);
        Machine::create([ 'serial'=>'600000002','image'=>null,'state_id'=>4,'machine_type_id'=>6,'brand_id'=>6,'supplier_nit'=>'8000000006','last_maintenance'=>null, 'company_nit' => '12345678-2' ]);
        Machine::create([ 'serial'=>'600000003','image'=>null,'state_id'=>5,'machine_type_id'=>6,'brand_id'=>6,'supplier_nit'=>'8000000006','last_maintenance'=>null, 'company_nit' => '12345678-2' ]);
        Machine::create([ 'serial'=>'600000004','image'=>null,'state_id'=>3,'machine_type_id'=>6,'brand_id'=>6,'supplier_nit'=>'8000000006','last_maintenance'=>null, 'company_nit' => '12345678-2' ]);
        Machine::create([ 'serial'=>'600000005','image'=>null,'state_id'=>4,'machine_type_id'=>6,'brand_id'=>6,'supplier_nit'=>'8000000006','last_maintenance'=>null, 'company_nit' => '12345678-2' ]);

        // Tipo 7 (Overlock) — brand_id=7, proveedor natural 9000000007
        Machine::create([ 'serial'=>'700000001','image'=>null,'state_id'=>3,'machine_type_id'=>7,'brand_id'=>7,'supplier_nit'=>'9000000007','last_maintenance'=>null, 'company_nit' => '12345678-2' ]);
        Machine::create([ 'serial'=>'700000002','image'=>null,'state_id'=>4,'machine_type_id'=>7,'brand_id'=>7,'supplier_nit'=>'9000000007','last_maintenance'=>null, 'company_nit' => '12345678-2' ]);
        Machine::create([ 'serial'=>'700000003','image'=>null,'state_id'=>5,'machine_type_id'=>7,'brand_id'=>7,'supplier_nit'=>'9000000007','last_maintenance'=>null, 'company_nit' => '12345678-2' ]);
        Machine::create([ 'serial'=>'700000004','image'=>null,'state_id'=>3,'machine_type_id'=>7,'brand_id'=>7,'supplier_nit'=>'9000000007','last_maintenance'=>null, 'company_nit' => '12345678-2' ]);
        Machine::create([ 'serial'=>'700000005','image'=>null,'state_id'=>4,'machine_type_id'=>7,'brand_id'=>7,'supplier_nit'=>'9000000007','last_maintenance'=>null, 'company_nit' => '12345678-2' ]);

        // Tipo 8 (Máquina de Bordado) — brand_id=8, proveedor jurídica 8000000008
        Machine::create([ 'serial'=>'800000001','image'=>null,'state_id'=>3,'machine_type_id'=>8,'brand_id'=>8,'supplier_nit'=>'8000000008','last_maintenance'=>null, 'company_nit' => '12345678-2' ]);
        Machine::create([ 'serial'=>'800000002','image'=>null,'state_id'=>4,'machine_type_id'=>8,'brand_id'=>8,'supplier_nit'=>'8000000008','last_maintenance'=>null, 'company_nit' => '12345678-2' ]);
        Machine::create([ 'serial'=>'800000003','image'=>null,'state_id'=>5,'machine_type_id'=>8,'brand_id'=>8,'supplier_nit'=>'8000000008','last_maintenance'=>null, 'company_nit' => '12345678-2' ]);
        Machine::create([ 'serial'=>'800000004','image'=>null,'state_id'=>3,'machine_type_id'=>8,'brand_id'=>8,'supplier_nit'=>'8000000008','last_maintenance'=>null, 'company_nit' => '12345678-2' ]);
        Machine::create([ 'serial'=>'800000005','image'=>null,'state_id'=>4,'machine_type_id'=>8,'brand_id'=>8,'supplier_nit'=>'8000000008','last_maintenance'=>null, 'company_nit' => '12345678-2' ]);

        // Tipo 9 (Serigrafía Textil) — brand_id=9, proveedor natural 9000000009
        Machine::create([ 'serial'=>'900000001','image'=>null,'state_id'=>3,'machine_type_id'=>9,'brand_id'=>9,'supplier_nit'=>'9000000009','last_maintenance'=>null, 'company_nit' => '12345678-2' ]);
        Machine::create([ 'serial'=>'900000002','image'=>null,'state_id'=>4,'machine_type_id'=>9,'brand_id'=>9,'supplier_nit'=>'9000000009','last_maintenance'=>null, 'company_nit' => '12345678-2' ]);
        Machine::create([ 'serial'=>'900000003','image'=>null,'state_id'=>5,'machine_type_id'=>9,'brand_id'=>9,'supplier_nit'=>'9000000009','last_maintenance'=>null, 'company_nit' => '12345678-2' ]);
        Machine::create([ 'serial'=>'900000004','image'=>null,'state_id'=>3,'machine_type_id'=>9,'brand_id'=>9,'supplier_nit'=>'9000000009','last_maintenance'=>null, 'company_nit' => '12345678-2' ]);
        Machine::create([ 'serial'=>'900000005','image'=>null,'state_id'=>4,'machine_type_id'=>9,'brand_id'=>9,'supplier_nit'=>'9000000009','last_maintenance'=>null, 'company_nit' => '12345678-2' ]);

        // Tipo 10 (Calandria/Plancha Industrial) — brand_id=10, proveedor jurídica 8000000010
        Machine::create([ 'serial'=>'1000000001','image'=>null,'state_id'=>3,'machine_type_id'=>10,'brand_id'=>10,'supplier_nit'=>'8000000010','last_maintenance'=>null, 'company_nit' => '12345678-2' ]);
        Machine::create([ 'serial'=>'1000000002','image'=>null,'state_id'=>4,'machine_type_id'=>10,'brand_id'=>10,'supplier_nit'=>'8000000010','last_maintenance'=>null, 'company_nit' => '12345678-2' ]);
        Machine::create([ 'serial'=>'1000000003','image'=>null,'state_id'=>5,'machine_type_id'=>10,'brand_id'=>10,'supplier_nit'=>'8000000010','last_maintenance'=>null, 'company_nit' => '12345678-2' ]);
        Machine::create([ 'serial'=>'1000000004','image'=>null,'state_id'=>3,'machine_type_id'=>10,'brand_id'=>10,'supplier_nit'=>'8000000010','last_maintenance'=>null, 'company_nit' => '12345678-2' ]);
        Machine::create([ 'serial'=>'1000000005','image'=>null,'state_id'=>4,'machine_type_id'=>10,'brand_id'=>10,'supplier_nit'=>'8000000010','last_maintenance'=>null, 'company_nit' => '12345678-2' ]);
    }
}
