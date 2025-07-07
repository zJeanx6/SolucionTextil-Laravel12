<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\LicenseType;
use App\Models\Role;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Company::create(['nit' => '12345678-1', 'name' => 'SENA', 'email' => 'SENA@dominio.com']);
        Company::create(['nit' => '12345678-2', 'name' => 'TALLER', 'email' => 'TALLER@dominio.com']);
        LicenseType::create(['name' => 'semanal', 'duration' => 7]);
        
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
        Role::factory()->create(['id' => 9, 'name' => 'superadmin', 'description' => 'Manejo de licenciamiento']);

        User::factory()->create(['card' => '0', 'name' => 'SUPER', 'last_name' => 'ADMIN', 'email' => 'superadmin@soluciontextil.com', 'password' => bcrypt('0987654321'), 'role_id' => 9, 'state_id' => 1]);
    
        User::factory()->create(['card' => '1000000', 'name' => 'adminS', 'last_name' => 'sena', 'email' => 'adminSENA@soluciontextil.com', 'phone' => 0000000000, 'password' => bcrypt('1234567890'), 'company_nit' => '12345678-1', 'role_id' => 1, 'state_id' => 1]);
        User::factory()->create(['card' => '1000001', 'name' => 'empleadoS', 'last_name' => 'sena', 'email' => 'inventarioSENA@soluciontextil.com', 'phone' => 0000000000, 'password' => bcrypt('1234567890'), 'company_nit' => '12345678-1', 'role_id' => 2, 'state_id' => 1]);
        User::factory()->create(['card' => '1000002', 'name' => 'mantenimientoS', 'last_name' => 'sena', 'email' => 'mantenimientoSENA@soluciontextil.com', 'phone' => 0000000000, 'password' => bcrypt('1234567890'), 'company_nit' => '12345678-1', 'role_id' => 3, 'state_id' => 1]);
        User::factory()->create(['card' => '1000003', 'name' => 'instructorS', 'last_name' => 'sena', 'email' => 'instructorSENA@soluciontextil.com', 'phone' => 0000000000, 'password' => bcrypt('1234567890'), 'company_nit' => '12345678-1', 'role_id' => 4, 'state_id' => 2]);

        User::factory()->create(['card' => '1000004', 'name' => 'adminT', 'last_name' => 'taller', 'email' => 'adminTALLER@soluciontextil.com', 'phone' => 0000000000, 'password' => bcrypt('1234567890'), 'company_nit' => '12345678-2', 'role_id' => 1, 'state_id' => 1]);
        User::factory()->create(['card' => '1000005', 'name' => 'inventarioT', 'last_name' => 'taller', 'email' => 'inventarioTALLER@soluciontextil.com', 'phone' => 0000000000, 'password' => bcrypt('1234567890'), 'company_nit' => '12345678-2', 'role_id' => 2, 'state_id' => 1]);
        User::factory()->create(['card' => '1000006', 'name' => 'mantenimientoT', 'last_name' => 'taller', 'email' => 'mantenimientoTALLER@soluciontextil.com', 'phone' => 0000000000, 'password' => bcrypt('1234567890'), 'company_nit' => '12345678-2', 'role_id' => 3, 'state_id' => 1]);
        User::factory()->create(['card' => '1000007', 'name' => 'instructorT', 'last_name' => 'taller', 'email' => 'instructorTALLER@soluciontextil.com', 'phone' => 0000000000, 'password' => bcrypt('1234567890'), 'company_nit' => '12345678-2', 'role_id' => 4, 'state_id' => 2]);
    }
} 
