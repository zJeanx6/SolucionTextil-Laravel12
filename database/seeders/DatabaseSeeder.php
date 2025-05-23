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

        Role::factory()->create([
            'id' => 1,
            'name' => 'admin',
            'description' => 'administrar todos los modulos del software'
        ]);
        
        Role::factory()->create([
            'id' => 2,
            'name' => 'inventory',
            'description' => 'administrar todos los inventarios'
        ]);

        Role::factory()->create([
            'id' => 3,
            'name' => 'maintenance',
            'description' => 'administrar el mantenimiento de maquinaria'
        ]);
        
        User::factory()->create([
            'card' => '10000000',
            'name' => 'admin',
            'last_name' => 'user1',
            'email' => 'admin@soluciontextil.com',
            'password' => bcrypt('12345'),
            'role_id' => 1,
        ]);

        User::factory()->create([
            'card' => '10000001',
            'name' => 'inventory',
            'last_name' => 'user2',
            'email' => 'inventory@soluciontextil.com',
            'password' => bcrypt('12345'),
            'role_id' => 2,
        ]);

        User::factory()->create([
            'card' => '10000002',
            'name' => 'maintenance',
            'last_name' => 'user3',
            'email' => 'maintenance@soluciontextil.com',
            'password' => bcrypt('12345'),
            'role_id' => 3,
        ]);

        State::factory(15)->create();
        Brand::factory(15)->create();
        MachineType::factory(15)->create();
    }
}
