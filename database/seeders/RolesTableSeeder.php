<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role; // Import the Role model

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        // Create roles
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'manager']);
        Role::create(['name' => 'salesperson']);
    }
}

