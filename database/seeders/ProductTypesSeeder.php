<?php

namespace Database\Seeders;

use App\Models\ProductType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductTypesSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['id' => 1, 'name' => 'Camisa', 'company_nit'=>'12345678-1'],
            ['id' => 2, 'name' => 'Camiseta', 'company_nit'=>'12345678-1'],
            ['id' => 3, 'name' => 'Pantalón', 'company_nit'=>'12345678-1'],
            ['id' => 4, 'name' => 'Falda', 'company_nit'=>'12345678-1'],
            ['id' => 5, 'name' => 'Vestido', 'company_nit'=>'12345678-1'],
            ['id' => 6, 'name' => 'Short', 'company_nit'=>'12345678-2'],
            ['id' => 7, 'name' => 'Chaqueta', 'company_nit'=>'12345678-2'],
            ['id' => 8, 'name' => 'Sudadera', 'company_nit'=>'12345678-2'],
            ['id' => 9, 'name' => 'Blusa', 'company_nit'=>'12345678-2'],
            ['id' => 10, 'name' => 'Saco', 'company_nit'=>'12345678-2'],
        ];

        ProductType::insert($types);
    }
}
