<?php

namespace Database\Seeders;

use App\Models\roles;
use App\Models\sizes;
use App\Models\states;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'admin',
            'last_name' => 'user',
            'email' => 'admin@soluciontextil.com',
            'password' => bcrypt('12345')
        ]);

        Sizes::factory(3)->create();
        Roles::factory(3)->create();
        States::factory(3)->create();
    }
}
