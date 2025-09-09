<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Course::create([
            'name' => 'Pemrograman Web',
            'code' => 'PWB001',
            'credits' => 3,
            'tuition_fee' => 2500000,
            'description' => 'Mata kuliah yang mempelajari dasar-dasar pengembangan web menggunakan HTML, CSS, JavaScript, dan framework modern.',
            'is_active' => true,
        ]);

        Course::create([
            'name' => 'Database Management System',
            'code' => 'DMS001',
            'credits' => 3,
            'tuition_fee' => 2750000,
            'description' => 'Mata kuliah yang mempelajari konsep database, SQL, dan manajemen basis data.',
            'is_active' => true,
        ]);

        Course::create([
            'name' => 'Mobile Application Development',
            'code' => 'MAD001',
            'credits' => 4,
            'tuition_fee' => 3000000,
            'description' => 'Mata kuliah pengembangan aplikasi mobile untuk Android dan iOS.',
            'is_active' => true,
        ]);

        Course::create([
            'name' => 'Sistem Informasi Manajemen',
            'code' => 'SIM001',
            'credits' => 3,
            'tuition_fee' => 2250000,
            'description' => 'Mata kuliah yang mempelajari konsep dan implementasi sistem informasi dalam organisasi.',
            'is_active' => true,
        ]);

        Course::create([
            'name' => 'Artificial Intelligence',
            'code' => 'AI001',
            'credits' => 4,
            'tuition_fee' => 3500000,
            'description' => 'Mata kuliah yang mempelajari konsep dasar AI, machine learning, dan implementasinya.',
            'is_active' => false, // Tidak aktif untuk testing
        ]);
    }
}
