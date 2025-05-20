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
            ['id' => 1, 'name' => 'Camisa'],
            ['id' => 2, 'name' => 'Camiseta'],
            ['id' => 3, 'name' => 'Pantalón'],
            ['id' => 4, 'name' => 'Falda'],
            ['id' => 5, 'name' => 'Vestido'],
            ['id' => 6, 'name' => 'Short'],
            ['id' => 7, 'name' => 'Chaqueta'],
            ['id' => 8, 'name' => 'Sudadera'],
            ['id' => 9, 'name' => 'Blusa'],
            ['id' => 10, 'name' => 'Saco'],
        ];

        ProductType::insert($types);
    }
}
