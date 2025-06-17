<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
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

        Role::factory()->create(['id' => 1, 'name' => 'administrador', 'description' => 'administrar todos los modulos del software']);
        Role::factory()->create(['id' => 2, 'name' => 'inventario', 'description' => 'administrar todos los inventarios']);
        Role::factory()->create(['id' => 3, 'name' => 'mantenimiento', 'description' => 'administrar el mantenimiento de maquinaria']);
        Role::factory()->create(['id' => 4, 'name' => 'instructor', 'description' => 'Quienes reciben los elementos de trabajo']);
    
        User::factory()->create(['card' => '10000000', 'name' => 'administrador', 'last_name' => 'usuario', 'email' => 'admin@soluciontextil.com', 'phone' => 0000000000, 'password' => bcrypt('12345'), 'role_id' => 1, 'state_id' => 1]);
        User::factory()->create(['card' => '10000001', 'name' => 'inventario', 'last_name' => 'usuario', 'email' => 'inventario@soluciontextil.com', 'phone' => 0000000000, 'password' => bcrypt('12345'), 'role_id' => 2, 'state_id' => 1]);
        User::factory()->create(['card' => '10000002', 'name' => 'mantenimiento', 'last_name' => 'usuario', 'email' => 'mantenimiento@soluciontextil.com', 'phone' => 0000000000, 'password' => bcrypt('12345'), 'role_id' => 3, 'state_id' => 1]);
        User::factory()->create(['card' => '10000003', 'name' => 'instructor', 'last_name' => 'usuario', 'email' => 'instructor@soluciontextil.com', 'phone' => 0000000000, 'password' => bcrypt('12345'), 'role_id' => 4, 'state_id' => 2]);
    }
} 
