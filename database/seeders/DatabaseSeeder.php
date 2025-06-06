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
use App\Models\Maintenance;
use App\Models\ProductType;
use App\Models\Supplier;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            SizesSeeder::class,           // 1º  ← Tallas
            BrandSeeder::class,           // 2º  ← Marcas
            StateSeeder::class,           // 3º  ← Estados
            ColorSeeder::class,           // 4º  ← Colores
            SupplierSeeder::class,        // 5º  ← Proveedores
            ElementTypeSeeder::class,     // 6º  ← Tipos Elementos
            ElementSeeder::class,         // 7º  ← Elementos
            RollSeeder::class,            // 8º  ← Rollos
            ProductTypesSeeder::class,    // 9º  ← Tipos Productos
            ProductsSeeder::class,        // 10º  ← Productos
            MaintenanceTypeSeeder::class, // 11º  ← Tipos de Mantenimientos
            MachineTypeSeeder::class,     // 12º  ← Tipos Maquinarias
            MachineSeeder::class,         // 13º  ← Maquinarias
        ]);

        Role::factory()->create(['id' => 1, 'name' => 'admin', 'description' => 'administrar todos los modulos del software']);
        Role::factory()->create(['id' => 2, 'name' => 'inventory', 'description' => 'administrar todos los inventarios']);
        Role::factory()->create(['id' => 3, 'name' => 'maintenance', 'description' => 'administrar el mantenimiento de maquinaria']);
        Role::factory()->create(['id' => 4, 'name' => 'instructor', 'description' => 'Quienes reciben los elementos de trabajo']);
    
        User::factory()->create(['card' => '10000000', 'name' => 'admin', 'last_name' => 'user1', 'email' => 'admin@soluciontextil.com', 'password' => bcrypt('12345'), 'role_id' => 1]);
        User::factory()->create(['card' => '10000001', 'name' => 'inventory', 'last_name' => 'user2', 'email' => 'inventory@soluciontextil.com', 'password' => bcrypt('12345'), 'role_id' => 2]);
        User::factory()->create(['card' => '10000002', 'name' => 'maintenance', 'last_name' => 'user3', 'email' => 'maintenance@soluciontextil.com', 'password' => bcrypt('12345'), 'role_id' => 3]);
        User::factory()->create(['card' => '10000003', 'name' => 'instructor', 'last_name' => 'user4', 'email' => 'instructor@soluciontextil.com', 'password' => bcrypt('12345'), 'role_id' => 4]);
    }
}
