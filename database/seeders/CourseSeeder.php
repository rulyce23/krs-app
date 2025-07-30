<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Course::create([
            'code' => 'IF101',
            'name' => 'Pemrograman Dasar',
            'description' => 'Mata kuliah dasar pemrograman menggunakan bahasa C++',
            'credits' => 3,
            'semester' => '1',
            'day' => 'Senin',
            'start_time' => '08:00:00',
            'end_time' => '10:30:00',
            'room' => 'Lab 1',
            'lecturer' => 'Dr. Bambang Sutrisno',
            'quota' => 30,
            'is_active' => true,
        ]);

        Course::create([
            'code' => 'IF102',
            'name' => 'Algoritma dan Struktur Data',
            'description' => 'Mata kuliah tentang algoritma dan struktur data dasar',
            'credits' => 3,
            'semester' => '2',
            'day' => 'Selasa',
            'start_time' => '08:00:00',
            'end_time' => '10:30:00',
            'room' => 'Lab 2',
            'lecturer' => 'Dr. Siti Aminah',
            'quota' => 25,
            'is_active' => true,
        ]);

        Course::create([
            'code' => 'IF201',
            'name' => 'Pemrograman Web',
            'description' => 'Mata kuliah pemrograman web menggunakan HTML, CSS, dan JavaScript',
            'credits' => 3,
            'semester' => '3',
            'day' => 'Rabu',
            'start_time' => '13:00:00',
            'end_time' => '15:30:00',
            'room' => 'Lab 3',
            'lecturer' => 'Ir. Ahmad Hidayat',
            'quota' => 30,
            'is_active' => true,
        ]);

        Course::create([
            'code' => 'IF202',
            'name' => 'Basis Data',
            'description' => 'Mata kuliah tentang konsep dan implementasi basis data',
            'credits' => 3,
            'semester' => '3',
            'day' => 'Kamis',
            'start_time' => '08:00:00',
            'end_time' => '10:30:00',
            'room' => 'Lab 4',
            'lecturer' => 'Dr. Rina Mardiana',
            'quota' => 28,
            'is_active' => true,
        ]);

        Course::create([
            'code' => 'IF301',
            'name' => 'Pemrograman Berorientasi Objek',
            'description' => 'Mata kuliah pemrograman berorientasi objek menggunakan Java',
            'credits' => 3,
            'semester' => '5',
            'day' => 'Senin',
            'start_time' => '13:00:00',
            'end_time' => '15:30:00',
            'room' => 'Lab 1',
            'lecturer' => 'Ir. Budi Santoso',
            'quota' => 25,
            'is_active' => true,
        ]);

        Course::create([
            'code' => 'IF302',
            'name' => 'Jaringan Komputer',
            'description' => 'Mata kuliah tentang konsep dan implementasi jaringan komputer',
            'credits' => 3,
            'semester' => '5',
            'day' => 'Selasa',
            'start_time' => '13:00:00',
            'end_time' => '15:30:00',
            'room' => 'Lab 2',
            'lecturer' => 'Dr. Hendra Wijaya',
            'quota' => 20,
            'is_active' => true,
        ]);

        Course::create([
            'code' => 'IF401',
            'name' => 'Pemrograman Mobile',
            'description' => 'Mata kuliah pengembangan aplikasi mobile',
            'credits' => 3,
            'semester' => '7',
            'day' => 'Rabu',
            'start_time' => '08:00:00',
            'end_time' => '10:30:00',
            'room' => 'Lab 3',
            'lecturer' => 'Ir. Dian Kusuma',
            'quota' => 22,
            'is_active' => true,
        ]);

        Course::create([
            'code' => 'IF402',
            'name' => 'Kecerdasan Buatan',
            'description' => 'Mata kuliah tentang konsep dan implementasi kecerdasan buatan',
            'credits' => 3,
            'semester' => '7',
            'day' => 'Kamis',
            'start_time' => '13:00:00',
            'end_time' => '15:30:00',
            'room' => 'Lab 4',
            'lecturer' => 'Dr. Eko Prasetyo',
            'quota' => 18,
            'is_active' => true,
        ]);

        Course::create([
            'code' => 'SI101',
            'name' => 'Pengantar Sistem Informasi',
            'description' => 'Mata kuliah pengantar sistem informasi',
            'credits' => 3,
            'semester' => '1',
            'day' => 'Jumat',
            'start_time' => '08:00:00',
            'end_time' => '10:30:00',
            'room' => 'Ruang 101',
            'lecturer' => 'Dr. Sri Wahyuni',
            'quota' => 35,
            'is_active' => true,
        ]);

        Course::create([
            'code' => 'SI201',
            'name' => 'Analisis dan Perancangan Sistem',
            'description' => 'Mata kuliah analisis dan perancangan sistem informasi',
            'credits' => 3,
            'semester' => '3',
            'day' => 'Jumat',
            'start_time' => '13:00:00',
            'end_time' => '15:30:00',
            'room' => 'Ruang 102',
            'lecturer' => 'Ir. Joko Widodo',
            'quota' => 30,
            'is_active' => true,
        ]);
    }
}
