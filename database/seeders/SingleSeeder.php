<?php

namespace Database\Seeders;

use App\Models\Element;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SingleSeeder extends Seeder
{
    public function run(): void
    {
        // Desactiva las claves foráneas
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Limpia la tabla sin errores
        DB::table('elements')->truncate();

        // Vuelve a activar las claves foráneas
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Genera 50 elementos nuevos
        Element::factory()->count(50)->create();
    }
}
