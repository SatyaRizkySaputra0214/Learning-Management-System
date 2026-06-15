<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Course;
use App\Models\Skill;
use App\Models\ClassModel;
use App\Models\Meeting;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AssignmentFileAccessTest extends TestCase
{
    use RefreshDatabase;

    private User $guru;
    private User $student1;
    private User $student2;
    private User $otherUser;
    private ClassModel $class;
    private Assignment $assignment;
    private AssignmentSubmission $submission;
    private string $fileContent = 'test file content';

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');

        $course = Course::create([
            'nama_bahasa' => 'English',
            'kode' => 'eng',
        ]);

        $skill = Skill::create([
            'nama_skill' => 'Writing',
            'kode' => 'writing',
        ]);

        $this->guru = User::create([
            'username' => 'guru1',
            'nama_lengkap' => 'Guru Satu',
            'email' => 'guru@test.com',
            'password' => bcrypt('password'),
            'role' => 'guru',
        ]);

        $this->student1 = User::create([
            'username' => 'murid1',
            'nama_lengkap' => 'Murid Satu',
            'email' => 'murid1@test.com',
            'password' => bcrypt('password'),
            'role' => 'murid',
        ]);

        $this->student2 = User::create([
            'username' => 'murid2',
            'nama_lengkap' => 'Murid Dua',
            'email' => 'murid2@test.com',
            'password' => bcrypt('password'),
            'role' => 'murid',
        ]);

        $this->otherUser = User::create([
            'username' => 'userlain',
            'nama_lengkap' => 'User Lain',
            'email' => 'lain@test.com',
            'password' => bcrypt('password'),
            'role' => 'murid',
        ]);

        $this->class = ClassModel::create([
            'id_course' => $course->id,
            'id_guru' => $this->guru->id,
            'nama_kelas' => 'Kelas Test',
            'periode' => '2026',
            'status' => 'aktif',
        ]);

        $this->class->students()->attach([$this->student1->id, $this->student2->id]);

        $meeting = Meeting::create([
            'id_class' => $this->class->id,
            'urutan_pertemuan' => 1,
            'judul_pertemuan' => 'Pertemuan 1',
        ]);

        $this->assignment = Assignment::create([
            'id_meeting' => $meeting->id,
            'id_skill' => $skill->id,
            'judul_tugas' => 'Tugas Test',
            'deskripsi' => 'Deskripsi tugas test',
            'deadline' => now()->addDays(7),
            'poin_maksimal' => 100,
        ]);

        $file = UploadedFile::fake()->create('jawaban.pdf', 10);
        $filePath = $file->store('assignment_submissions', 'public');

        $this->submission = AssignmentSubmission::create([
            'id_assignment' => $this->assignment->id,
            'id_student' => $this->student1->id,
            'file_url' => $filePath,
            'submitted_at' => now(),
        ]);
    }

    public function test_student_can_view_own_submission_file(): void
    {
        $response = $this->actingAs($this->student1)
            ->get(route('murid.assignment.file', $this->submission));

        $response->assertOk();
    }

    public function test_student_cannot_view_other_student_submission_file(): void
    {
        $response = $this->actingAs($this->student2)
            ->get(route('murid.assignment.file', $this->submission));

        $response->assertForbidden();
    }

    public function test_guru_can_view_any_submission_file(): void
    {
        $response = $this->actingAs($this->guru)
            ->get(route('guru.assignments.file', $this->submission));

        $response->assertOk();
    }

    public function test_unauthorized_user_cannot_view_submission_file(): void
    {
        $response = $this->actingAs($this->otherUser)
            ->get(route('murid.assignment.file', $this->submission));

        $response->assertForbidden();
    }

    public function test_student_can_delete_own_submission(): void
    {
        $this->assertDatabaseHas('assignment_submissions', [
            'id' => $this->submission->id,
            'id_student' => $this->student1->id,
        ]);

        $response = $this->actingAs($this->student1)
            ->delete(route('murid.assignment.delete', $this->assignment));

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('assignment_submissions', [
            'id' => $this->submission->id,
        ]);
    }

    public function test_student_cannot_delete_other_student_submission(): void
    {
        $response = $this->actingAs($this->student2)
            ->delete(route('murid.assignment.delete', $this->assignment));

        $response->assertRedirect();
        $response->assertSessionHas('error');

        $this->assertDatabaseHas('assignment_submissions', [
            'id' => $this->submission->id,
        ]);
    }

    public function test_file_review_page_uses_controller_route_not_storage_url(): void
    {
        $response = $this->actingAs($this->student1)
            ->get(route('murid.assignment.review', $this->assignment));

        $response->assertOk();
        $response->assertSee(route('murid.assignment.file', $this->submission));
        $response->assertDontSee(Storage::url($this->submission->file_url));
    }
}
