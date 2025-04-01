<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Size;
use App\Models\State;
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

        Size::factory(5)->create();
        Role::factory(5)->create();
        State::factory(5)->create();
    }
}
