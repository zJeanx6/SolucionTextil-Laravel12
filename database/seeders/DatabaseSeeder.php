<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Size;
use App\Models\State;
use App\Models\User;
use App\Models\Brand;
use App\Models\Color;
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

        Size::factory(3)->create();
        Role::factory(3)->create();
        State::factory(3)->create();
        Brand::factory(5)->create();
        Color::factory(5)->create();
    }
}
