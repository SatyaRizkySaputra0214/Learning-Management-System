<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Course::create([
            'nama_bahasa' => 'English',
            'kode' => 'eng',
            'deskripsi' => 'Kursus Bahasa Inggris',
        ]);

        Course::create([
            'nama_bahasa' => 'Korean',
            'kode' => 'kor',
            'deskripsi' => 'Kursus Bahasa Korea',
        ]);

        Course::create([
            'nama_bahasa' => 'Thai',
            'kode' => 'th',
            'deskripsi' => 'Kursus Bahasa Thailand',
        ]);
    }
}
