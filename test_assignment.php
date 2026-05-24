<?php

// Test script untuk membuat assignment/tugas

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Meeting;
use App\Models\Skill;
use App\Models\Assignment;

echo "=== Test Buat Tugas/Assignment ===\n\n";

// Ambil meeting pertama
$meeting = Meeting::with('class')->first();

if (!$meeting) {
    echo "❌ Tidak ada pertemuan. Buat pertemuan dulu.\n";
    exit;
}

echo "✓ Meeting: {$meeting->judul_pertemuan}\n";
echo "  Kelas: {$meeting->class->nama_kelas}\n\n";

// Ambil skill pertama
$skill = Skill::first();

if (!$skill) {
    echo "❌ Tidak ada skill. Jalankan seeder dulu.\n";
    exit;
}

echo "✓ Skill: {$skill->nama_skill}\n\n";

// Buat assignment test
echo "Membuat tugas test...\n";

$assignment = Assignment::create([
    'id_meeting' => $meeting->id,
    'id_skill' => $skill->id,
    'judul_tugas' => 'Test Assignment - Write Introduction',
    'deskripsi' => 'Write your introduction in English (minimum 100 words). Include: name, origin, hobby, and dream job.',
    'deadline' => now()->addDays(7),
    'poin_maksimal' => 100,
]);

echo "✓ Tugas berhasil dibuat!\n";
echo "  ID: {$assignment->id}\n";
echo "  Judul: {$assignment->judul_tugas}\n";
echo "  Skill: {$assignment->skill->nama_skill}\n";
echo "  Deadline: {$assignment->deadline->format('d M Y')}\n\n";

echo "=== Test Selesai! ===\n";
echo "\nSekarang coba akses:\n";
echo "http://localhost:8000/guru/classes/{$meeting->class->id}\n";
echo "Tugas seharusnya sudah muncul di daftar.\n";
