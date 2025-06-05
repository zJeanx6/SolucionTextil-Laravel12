<?php

namespace Database\Seeders;
use App\Models\Supplier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class supplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Supplier::create([
            'nit' => '900123456-1',
            'name' => 'Proveedor Uno',
            'person_type' => 'Natural',
            'email' => 'proveedoruno@gmail.com',
            'phone' => '3001234567',
            'representative_name' => 'Juan Perez',
            'representative_email' => 'juan@gmail.com',
            'representative_phone' => '3001234567',
        ]);
        Supplier::create([
            'nit' => '900987654-2',
            'name' => 'Proveedor Dos',
            'person_type' => 'Jurídica',
            'email' => 'proveedordos@gmail.com',
            'phone' => '3009876543',
            'representative_name' => 'Maria Lopez',
            'representative_email' => 'mario@gmail.com',
            'representative_phone' => '3009876543',
        ]);
    }
}
