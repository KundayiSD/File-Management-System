<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        if (\App\Models\User::where('name', 'Admin')->exists()) {
            return;
        }
        \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'Admin',
            'password' => bcrypt('111'),
            'phone' => '0788157862',
            'role' => 'admin',
            'status' => 'active'
        ]);

    }
}
