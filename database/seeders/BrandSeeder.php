<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $brands = [
            ['id' => 1,  'name' => 'Picanol'],
            ['id' => 2,  'name' => 'Tsudakoma'],
            ['id' => 3,  'name' => 'Toyota Industries'],
            ['id' => 4,  'name' => 'Rieter'],
            ['id' => 5,  'name' => 'Saurer'],
            ['id' => 6,  'name' => 'Itema'],
            ['id' => 7,  'name' => 'Stäubli'],
            ['id' => 8,  'name' => 'Karl Mayer'],
            ['id' => 9,  'name' => 'Murata'],
            ['id' => 10, 'name' => 'Trützschler'],
        ];

        Brand::insert($brands);
    }
}
