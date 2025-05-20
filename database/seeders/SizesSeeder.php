<?php

namespace Database\Seeders;

use App\Models\Size;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SizesSeeder extends Seeder
{
    public function run(): void
    {
        $sizes = [
            ['id' => 1, 'name' => 'Extra pequeño',        'abbreviation' => 'XS'],
            ['id' => 2, 'name' => 'Pequeño',              'abbreviation' => 'S'],
            ['id' => 3, 'name' => 'Mediano',              'abbreviation' => 'M'],
            ['id' => 4, 'name' => 'Grande',               'abbreviation' => 'L'],
            ['id' => 5, 'name' => 'Extra grande',         'abbreviation' => 'XL'],
            ['id' => 6, 'name' => 'Doble extra grande',   'abbreviation' => 'XXL'],
        ];

        Size::insert($sizes);
    }
}
