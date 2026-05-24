<?php

// Test script untuk memeriksa semua relasi dan query

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\ClassModel;
use App\Models\Course;
use App\Models\Skill;

echo "=== Testing LMS Bahasa Relations ===\n\n";

// Test 1: Users
echo "1. Testing Users...\n";
$admin = User::where('role', 'admin')->first();
$gurus = User::where('role', 'guru')->get();
$murids = User::where('role', 'murid')->get();

echo "   Admin: " . ($admin ? $admin->nama_lengkap : "Not found") . "\n";
echo "   Guru count: " . $gurus->count() . "\n";
echo "   Murid count: " . $murids->count() . "\n";

// Test 2: Courses
echo "\n2. Testing Courses...\n";
$courses = Course::all();
foreach ($courses as $course) {
    echo "   - {$course->nama_bahasa} ({$course->kode})\n";
}

// Test 3: Skills
echo "\n3. Testing Skills...\n";
$skills = Skill::all();
foreach ($skills as $skill) {
    echo "   - {$skill->nama_skill} ({$skill->kode})\n";
}

// Test 4: Classes
echo "\n4. Testing Classes...\n";
$classes = ClassModel::with(['course', 'guru', 'students'])->get();
foreach ($classes as $class) {
    echo "   - {$class->nama_kelas}: {$class->course->nama_bahasa} | Guru: {$class->guru->nama_lengkap} | Students: {$class->students->count()}\n";
}

// Test 5: User Relations
echo "\n5. Testing User Relations...\n";
if ($gurus->count() > 0) {
    $guru = $gurus->first();
    $taughtClasses = $guru->taughtClasses;
    echo "   Guru {$guru->nama_lengkap} teaches {$taughtClasses->count()} class(es)\n";
}

if ($murids->count() > 0) {
    $murid = $murids->first();
    $enrolledClasses = $murid->enrolledClasses;
    echo "   Murid {$murid->nama_lengkap} enrolled in {$enrolledClasses->count()} class(es)\n";
}

// Test 6: Available Students Query 
echo "\n6. Testing Available Students Query...\n";
if ($classes->count() > 0) {
    $class = $classes->first();
    $availableStudents = User::where('role', 'murid')
        ->whereDoesntHave('enrolledClasses', function($q) use ($class) {
            $q->where('class_students.id_class', $class->id);
        })
        ->orderBy('nama_lengkap')
        ->get();
    
    echo "   Class: {$class->nama_kelas}\n";
    echo "   Enrolled students: {$class->students->count()}\n";
    echo "   Available students: {$availableStudents->count()}\n";
}

echo "\n=== All Tests Completed Successfully! ===\n";
