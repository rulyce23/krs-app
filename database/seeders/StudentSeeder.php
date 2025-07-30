<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Student::create([
            'nim' => '2021001',
            'name' => 'Ahmad Fauzi',
            'email' => 'ahmad.fauzi@student.ac.id',
            'password' => Hash::make('student123'),
            'major' => 'Sistem Informasi',
            'semester' => '5',
        ]);

        Student::create([
            'nim' => '2021002',
            'name' => 'Siti Nurhaliza',
            'email' => 'siti.nurhaliza@student.ac.id',
            'password' => Hash::make('student123'),
            'major' => 'Sistem Informasi',
            'semester' => '5',
        ]);

        Student::create([
            'nim' => '2021003',
            'name' => 'Budi Santoso',
            'email' => 'budi.santoso@student.ac.id',
            'password' => Hash::make('student123'),
            'major' => 'Teknik Informatika',
            'semester' => '3',
        ]);

        Student::create([
            'nim' => '2021004',
            'name' => 'Dewi Sartika',
            'email' => 'dewi.sartika@student.ac.id',
            'password' => Hash::make('student123'),
            'major' => 'Teknik Informatika',
            'semester' => '3',
        ]);

        Student::create([
            'nim' => '2021005',
            'name' => 'Rizki Pratama',
            'email' => 'rizki.pratama@student.ac.id',
            'password' => Hash::make('student123'),
            'major' => 'Sistem Informasi',
            'semester' => '7',
        ]);
    }
}
