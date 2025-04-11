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
    public function run(): void
    {
        User::factory()->create([
            'card' => '10000000',
            'name' => 'admin',
            'last_name' => 'user',
            'email' => 'admin@soluciontextil.com',
            'password' => bcrypt('12345')
        ]);

        Size::factory(15)->create();
        Role::factory(15)->create();
        State::factory(15)->create();
        Brand::factory(15)->create();
        Color::factory(15)->create();
    }
}
