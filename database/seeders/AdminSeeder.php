<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            'username' => 'admin',
            'name' => 'Administrator',
            'email' => 'admin@simak.ac.id',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        Admin::create([
            'username' => 'koordinator',
            'name' => 'Koordinator SIM',
            'email' => 'koordinator@simak.ac.id',
            'password' => Hash::make('koordinator123'),
            'role' => 'admin',
        ]);
    }
}
