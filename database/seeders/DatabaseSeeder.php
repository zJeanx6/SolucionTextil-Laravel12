<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Size;
use App\Models\State;
use App\Models\User;
use App\Models\Brand;
use App\Models\Color;
use App\Models\ElementType;
use App\Models\MachineType;
use App\Models\ProductType;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            ColorSeeder::class,         // 1º  ← Colores
            ElementTypeSeeder::class,   // 2º  ← Tipos Elementos
            ElementSeeder::class,       // 3º  ← Elementos
            SizesSeeder::class,         // 4º  ← Tallas
            ProductTypesSeeder::class,  // 5º  ← Tipos Productos
            ProductsSeeder::class,
        ]);

        User::factory()->create([
            'card' => '10000000',
            'name' => 'admin',
            'last_name' => 'user',
            'email' => 'admin@soluciontextil.com',
            'password' => bcrypt('12345')
        ]);

        Role::factory(15)->create();
        State::factory(15)->create();
        Brand::factory(15)->create();
        MachineType::factory(15)->create();
    }
}
