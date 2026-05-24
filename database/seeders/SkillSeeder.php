<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Skill::create([
            'nama_skill' => 'Reading',
            'kode' => 'reading',
        ]);

        Skill::create([
            'nama_skill' => 'Writing',
            'kode' => 'writing',
        ]);

        Skill::create([
            'nama_skill' => 'Listening',
            'kode' => 'listening',
        ]);

        Skill::create([
            'nama_skill' => 'Speaking',
            'kode' => 'speaking',
        ]);

        Skill::create([
            'nama_skill' => 'Grammar',
            'kode' => 'grammar',
        ]);
    }
}
