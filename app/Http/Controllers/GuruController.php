<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use App\Models\Meeting;
use App\Models\Material;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\QuizScore;
use App\Models\Certificate;
use App\Models\Skill;
use App\Models\User;
use App\Models\Attendance;
use App\Models\Announcement;
use App\Models\Registration;
use App\Exports\ClassGradesExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Excel;

class GuruController extends Controller
{
    public function dashboard()
    {
        $guru = auth()->user();
        
        // Statistik utama
        $totalClasses = $guru->taughtClasses()->count();
        $totalStudents = $guru->taughtClasses()->with('students')->get()->pluck('students')->flatten()->unique('id')->count();
        
        // Tugas yang belum dinilai
        $assignmentIds = $guru->taughtClasses()
            ->with(['meetings.assignments'])
            ->get()
            ->pluck('meetings')
            ->flatten()
            ->pluck('assignments')
            ->flatten()
            ->pluck('id');
        
        $ungradedAssignments = \App\Models\AssignmentSubmission::whereIn('id_assignment', $assignmentIds)
            ->whereNull('nilai_guru')
            ->count();
        
        // Kuis yang belum dikerjakan murid
        $quizIds = $guru->taughtClasses()
            ->with(['meetings.quizzes'])
            ->get()
            ->pluck('meetings')
            ->flatten()
            ->pluck('quizzes')
            ->flatten()
            ->pluck('id');
        
        $totalQuizAttempts = \App\Models\QuizScore::whereIn('id_quiz', $quizIds)->whereNotNull('skor')->count();
        $totalQuizzes = $quizIds->count();
        $incompleteQuizzes = $totalQuizzes > 0 ? $totalQuizzes - $totalQuizAttempts : 0;
        
        // Kelas aktif
        $activeClasses = $guru->taughtClasses()->where('status', 'aktif')->with(['course', 'students'])->get();
        
        // Recent activity - tugas yang perlu dinilai
        $recentSubmissions = \App\Models\AssignmentSubmission::whereIn('id_assignment', $assignmentIds)
            ->whereNull('nilai_guru')
            ->with(['assignment.meeting.class', 'student'])
            ->orderBy('submitted_at', 'desc')
            ->limit(5)
            ->get();
        
        return view('guru.dashboard', compact(
            'totalClasses',
            'totalStudents',
            'ungradedAssignments',
            'incompleteQuizzes',
            'activeClasses',
            'recentSubmissions'
        ));
    }

    public function classes()
    {
        $classes = auth()->user()->taughtClasses()->with(['course', 'students'])->paginate(15);
        return view('guru.classes.index', compact('classes'));
    }

    public function showClass(ClassModel $class)
    {
        if ($class->id_guru !== auth()->id()) {
            abort(403);
        }

        $class->load(['meetings' => function($q) {
            $q->orderBy('urutan_pertemuan')->with(['materials', 'quizzes.skill', 'assignments.skill', 'announcements']);
        }, 'students', 'course']);

        return view('guru.classes.show', compact('class'));
    }

    public function createMeeting(ClassModel $class)
    {
        if ($class->id_guru !== auth()->id()) {
            abort(403);
        }

        return view('guru.meetings.create', compact('class'));
    }

    public function storeMeeting(Request $request, ClassModel $class)
    {
        if ($class->id_guru !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'urutan_pertemuan' => 'required|integer|min:1',
            'judul_pertemuan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $class->meetings()->create($validated);

        return redirect()->route('guru.classes.show', $class)->with('success', 'Pertemuan berhasil dibuat.');
    }

    public function editMeeting(Meeting $meeting)
    {
        if ($meeting->class->id_guru !== auth()->id()) {
            abort(403);
        }

        return view('guru.meetings.edit', compact('meeting'));
    }

    public function updateMeeting(Request $request, Meeting $meeting)
    {
        if ($meeting->class->id_guru !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'urutan_pertemuan' => 'required|integer|min:1',
            'judul_pertemuan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $meeting->update($validated);

        return redirect()->route('guru.classes.show', $meeting->class)->with('success', 'Pertemuan berhasil diupdate.');
    }

    public function deleteMeeting(Meeting $meeting)
    {
        if ($meeting->class->id_guru !== auth()->id()) {
            abort(403);
        }

        $class = $meeting->class;
        $meeting->delete();

        return redirect()->route('guru.classes.show', $class)->with('success', 'Pertemuan berhasil dihapus.');
    }

    // Materials
    public function createMaterial(Meeting $meeting)
    {
        if ($meeting->class->id_guru !== auth()->id()) {
            abort(403);
        }

        return view('guru.materials.create', compact('meeting'));
    }

    public function storeMaterial(Request $request, Meeting $meeting)
    {
        if ($meeting->class->id_guru !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'tipe' => 'required|in:video,pdf,doc',
            'file_url' => 'required_if:tipe,video|nullable|url',
            'file_upload' => 'required_if:tipe,pdf,doc|nullable|file|max:10240',
            'deskripsi' => 'nullable|string',
        ]);

        $fileUrl = $validated['file_url'];

        if ($request->hasFile('file_upload')) {
            $fileUrl = $request->file('file_upload')->store('materials', 'public');
        }

        $meeting->materials()->create([
            'judul' => $validated['judul'],
            'tipe' => $validated['tipe'],
            'file_url' => $fileUrl,
            'deskripsi' => $validated['deskripsi'],
        ]);

        return redirect()->route('guru.classes.show', $meeting->class)->with('success', 'Materi berhasil ditambahkan.');
    }

    public function deleteMaterial(Material $material)
    {
        if ($material->meeting->class->id_guru !== auth()->id()) {
            abort(403);
        }

        $class = $material->meeting->class;
        
        if (!str_starts_with($material->file_url, 'http')) {
            Storage::disk('public')->delete($material->file_url);
        }
        
        $material->delete();

        return redirect()->route('guru.classes.show', $class)->with('success', 'Materi berhasil dihapus.');
    }

    // Quizzes
    public function createQuiz(Meeting $meeting)
    {
        if ($meeting->class->id_guru !== auth()->id()) {
            abort(403);
        }

        $skills = Skill::all();
        return view('guru.quizzes.create', compact('meeting', 'skills'));
    }

    public function storeQuiz(Request $request, Meeting $meeting)
    {
        if ($meeting->class->id_guru !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'id_skill' => 'required|exists:skills,id',
            'judul_kuis' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal_mulai' => 'required|date',
            'jam_mulai' => 'required|date_format:H:i',
            'tanggal_berakhir' => 'required|date|after_or_equal:tanggal_mulai',
            'jam_berakhir' => 'required|date_format:H:i',
        ]);

        $startAt = $validated['tanggal_mulai'] . ' ' . $validated['jam_mulai'] . ':00';
        $endAt = $validated['tanggal_berakhir'] . ' ' . $validated['jam_berakhir'] . ':00';

        if ($endAt <= $startAt) {
            return back()->withErrors(['jam_berakhir' => 'Waktu selesai harus setelah waktu mulai.'])->withInput();
        }

        $validated['start_at'] = $startAt;
        $validated['end_at'] = $endAt;
        unset($validated['tanggal_mulai'], $validated['jam_mulai'], $validated['tanggal_berakhir'], $validated['jam_berakhir']);

        try {
            $quiz = $meeting->quizzes()->create($validated);
            return redirect()->route('guru.quizzes.edit', $quiz)->with('success', 'Kuis berhasil dibuat: ' . $validated['judul_kuis']);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal membuat kuis: ' . $e->getMessage()])->withInput();
        }
    }

    public function editQuiz(Quiz $quiz)
    {
        if ($quiz->meeting->class->id_guru !== auth()->id()) {
            abort(403);
        }

        $quiz->load('questions', 'skill');
        $skills = Skill::all();
        return view('guru.quizzes.edit', compact('quiz', 'skills'));
    }

    public function updateQuiz(Request $request, Quiz $quiz)
    {
        if ($quiz->meeting->class->id_guru !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'id_skill' => 'required|exists:skills,id',
            'judul_kuis' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal_mulai' => 'required|date',
            'jam_mulai' => 'required|date_format:H:i',
            'tanggal_berakhir' => 'required|date|after_or_equal:tanggal_mulai',
            'jam_berakhir' => 'required|date_format:H:i',
        ]);

        $startAt = $validated['tanggal_mulai'] . ' ' . $validated['jam_mulai'] . ':00';
        $endAt = $validated['tanggal_berakhir'] . ' ' . $validated['jam_berakhir'] . ':00';

        if ($endAt <= $startAt) {
            return back()->withErrors(['jam_berakhir' => 'Waktu selesai harus setelah waktu mulai.'])->withInput();
        }

        $validated['start_at'] = $startAt;
        $validated['end_at'] = $endAt;
        unset($validated['tanggal_mulai'], $validated['jam_mulai'], $validated['tanggal_berakhir'], $validated['jam_berakhir']);

        $quiz->update($validated);

        return redirect()->route('guru.quizzes.edit', $quiz)->with('success', 'Kuis berhasil diupdate.');
    }

    public function addQuestion(Quiz $quiz, Request $request)
    {
        if ($quiz->meeting->class->id_guru !== auth()->id()) {
            abort(403);
        }

        $request->merge([
            'soal' => str_replace(["\r\n", "\r", "\n"], '[[NEWLINE]]', $request->soal),
        ]);

        $validated = $request->validate([
            'soal' => 'required|string',
            'opsi_a' => 'required|string',
            'opsi_b' => 'required|string',
            'opsi_c' => 'required|string',
            'opsi_d' => 'required|string',
            'kunci_jawaban' => 'required|in:A,B,C,D',
            'poin' => 'nullable|integer|min:1',
        ]);

        $quiz->questions()->create($validated);

        return back()->with('success', 'Soal berhasil ditambahkan.');
    }

    public function deleteQuestion(Question $question)
    {
        if ($question->quiz->meeting->class->id_guru !== auth()->id()) {
            abort(403);
        }

        $quiz = $question->quiz;
        $question->delete();

        return redirect()->route('guru.quizzes.edit', $quiz)->with('success', 'Soal berhasil dihapus.');
    }

    public function editQuestion(Question $question)
    {
        if ($question->quiz->meeting->class->id_guru !== auth()->id()) {
            abort(403);
        }

        return view('guru.questions.edit', compact('question'));
    }

    public function updateQuestion(Request $request, Question $question)
    {
        if ($question->quiz->meeting->class->id_guru !== auth()->id()) {
            abort(403);
        }

        $request->merge([
            'soal' => str_replace(["\r\n", "\r", "\n"], '[[NEWLINE]]', $request->soal),
        ]);

        $validated = $request->validate([
            'soal' => 'required|string',
            'opsi_a' => 'required|string',
            'opsi_b' => 'required|string',
            'opsi_c' => 'required|string',
            'opsi_d' => 'required|string',
            'kunci_jawaban' => 'required|in:A,B,C,D',
            'poin' => 'nullable|integer|min:1',
        ]);

        $question->update($validated);

        return redirect()->route('guru.quizzes.edit', $question->quiz)->with('success', 'Soal berhasil diupdate.');
    }

    public function deleteQuiz(Quiz $quiz)
    {
        if ($quiz->meeting->class->id_guru !== auth()->id()) {
            abort(403);
        }

        $class = $quiz->meeting->class;
        $quiz->delete();

        return redirect()->route('guru.classes.show', $class)->with('success', 'Kuis berhasil dihapus.');
    }

    // Assignments
    public function createAssignment(Meeting $meeting)
    {
        if ($meeting->class->id_guru !== auth()->id()) {
            abort(403);
        }

        $skills = Skill::all();
        return view('guru.assignments.create', compact('meeting', 'skills'));
    }

    public function createAssignmentSimple(Meeting $meeting)
    {
        if ($meeting->class->id_guru !== auth()->id()) {
            abort(403);
        }

        $skills = Skill::all();
        $class = $meeting->class;
        return view('guru.assignments.create-simple', compact('meeting', 'skills', 'class'));
    }

    public function storeAssignment(Request $request, Meeting $meeting)
    {
        if ($meeting->class->id_guru !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'id_skill' => 'required|exists:skills,id',
            'judul_tugas' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'deadline' => 'nullable|date',
            'poin_maksimal' => 'nullable|integer|min:1|max:100',
        ]);

        try {
            $meeting->assignments()->create($validated);
            return redirect()->route('guru.classes.show', $meeting->class)->with('success', 'Tugas berhasil dibuat: ' . $validated['judul_tugas']);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal membuat tugas: ' . $e->getMessage()])->withInput();
        }
    }

    public function editAssignment(Assignment $assignment)
    {
        if ($assignment->meeting->class->id_guru !== auth()->id()) {
            abort(403);
        }

        $skills = Skill::all();
        return view('guru.assignments.edit', compact('assignment', 'skills'));
    }

    public function updateAssignment(Request $request, Assignment $assignment)
    {
        if ($assignment->meeting->class->id_guru !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'id_skill' => 'required|exists:skills,id',
            'judul_tugas' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'deadline' => 'nullable|date',
            'poin_maksimal' => 'nullable|integer|min:1|max:100',
        ]);

        $assignment->update($validated);

        return redirect()->route('guru.assignments.submissions', $assignment)->with('success', 'Tugas berhasil diupdate.');
    }

    public function deleteAssignment(Assignment $assignment)
    {
        if ($assignment->meeting->class->id_guru !== auth()->id()) {
            abort(403);
        }

        $class = $assignment->meeting->class;
        $assignment->delete();

        return redirect()->route('guru.classes.show', $class)->with('success', 'Tugas berhasil dihapus.');
    }

    public function viewSubmissions(Assignment $assignment)
    {
        if ($assignment->meeting->class->id_guru !== auth()->id()) {
            abort(403);
        }

        $class = $assignment->meeting->class;
        $class->load(['students']);
        
        // Get all submissions for this assignment
        $submissions = $assignment->submissions()->with('student')->get();
        
        // Build student list with submission status
        $studentSubmissions = [];
        foreach ($class->students as $student) {
            $submission = $submissions->firstWhere('id_student', $student->id);
            $studentSubmissions[] = [
                'student' => $student,
                'submission' => $submission,
                'has_submitted' => $submission !== null,
                'has_file' => $submission && !empty($submission->file_url),
                'is_graded' => $submission && $submission->nilai_guru !== null,
            ];
        }
        
        $assignment->load(['skill', 'meeting.class']);
        
        return view('guru.assignments.submissions', compact('assignment', 'studentSubmissions'));
    }

    public function gradeSubmission(Request $request, AssignmentSubmission $submission)
    {
        if ($submission->assignment->meeting->class->id_guru !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'nilai_guru' => 'required|numeric|min:0|max:100',
            'feedback' => 'nullable|string',
        ]);

        $submission->update($validated);

        return back()->with('success', 'Nilai berhasil disimpan.');
    }

    public function gradeStudent(Request $request, Assignment $assignment)
    {
        if ($assignment->meeting->class->id_guru !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'id_student' => 'required|exists:users,id',
            'nilai_guru' => 'required|numeric|min:0|max:100',
            'feedback' => 'nullable|string',
        ]);

        // Check student is enrolled in the class
        $class = $assignment->meeting->class;
        $student = User::findOrFail($validated['id_student']);
        if (!$class->students->contains($student)) {
            abort(403, 'Student is not enrolled in this class');
        }

        // Find existing submission or create a new one
        $submission = AssignmentSubmission::where('id_assignment', $assignment->id)
            ->where('id_student', $student->id)
            ->first();

        if ($submission) {
            // Update existing submission (student already submitted or was graded before)
            $submission->update([
                'nilai_guru' => $validated['nilai_guru'],
                'feedback' => $validated['feedback'] ?? null,
            ]);
        } else {
            // Create new submission record for teacher grading without student submission
            $assignment->submissions()->create([
                'id_student' => $student->id,
                'nilai_guru' => $validated['nilai_guru'],
                'feedback' => $validated['feedback'] ?? null,
                'file_url' => '',
                'submitted_at' => now(),
            ]);
        }

        return back()->with('success', 'Nilai berhasil disimpan.');
    }

    public function viewSubmissionFile(AssignmentSubmission $submission)
    {
        if ($submission->assignment->meeting->class->id_guru !== auth()->id()) {
            abort(403);
        }

        if (!$submission->file_url || !Storage::disk('public')->exists($submission->file_url)) {
            abort(404, 'File tidak ditemukan.');
        }

        return Storage::disk('public')->response($submission->file_url);
    }

    // Certificates
    public function certificatesIndex(Request $request, ClassModel $class)
    {
        if (!auth()->check() || !auth()->user()->isGuru()) {
            abort(403, 'Akses ditolak. Anda harus login sebagai guru.');
        }

        if ($class->id_guru !== auth()->id()) {
            abort(403, 'Akses ditolak. Anda bukan guru pengampu kelas ini.');
        }

        $query = $class->students();
        
        // Search functionality
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where('nama_lengkap', 'LIKE', "%{$searchTerm}%");
        }

        $students = $query->get();
        $class->load('meetings');
        
        return view('guru.certificates.index', compact('class', 'students'));
    }

    public function generateCertificate(ClassModel $class, User $student)
    {
        if (!auth()->check() || !auth()->user()->isGuru()) {
            abort(403, 'Akses ditolak. Anda harus login sebagai guru.');
        }

        if ($class->id_guru !== auth()->id()) {
            abort(403, 'Akses ditolak. Anda bukan guru pengampu kelas ini.');
        }

        // Cek apakah murid sudah menyelesaikan semua kuis dan tugas
        $meetingIds = $class->meetings()->pluck('id');
        
        $totalQuizzes = \App\Models\Quiz::whereIn('id_meeting', $meetingIds)->count();
        $totalAssignments = \App\Models\Assignment::whereIn('id_meeting', $meetingIds)->count();
        
        $completedQuizzes = \App\Models\QuizScore::whereIn('id_quiz', function($query) use ($meetingIds) {
            $query->select('id')->from('quizzes')->whereIn('id_meeting', $meetingIds);
        })
        ->where('id_student', $student->id)
        ->whereNotNull('skor')
        ->count();
        
        $completedAssignments = \App\Models\AssignmentSubmission::whereIn('id_assignment', function($query) use ($meetingIds) {
            $query->select('id')->from('assignments')->whereIn('id_meeting', $meetingIds);
        })
        ->where('id_student', $student->id)
        ->whereNotNull('nilai_guru')
        ->count();
        
        $isAllCompleted = ($completedQuizzes >= $totalQuizzes) && ($completedAssignments >= $totalAssignments);
        
        if (!$isAllCompleted) {
            return redirect()->route('guru.classes.show', $class)
                ->with('error', "Murid belum menyelesaikan semua tugas dan kuis. Progress: {$completedQuizzes}/{$totalQuizzes} kuis, {$completedAssignments}/{$totalAssignments} tugas.");
        }

        $skills = Skill::all();
        $skillScores = [];

        foreach ($skills as $skill) {
            $quizScores = $student->quizScores()
                ->whereHas('quiz', function($q) use ($skill) {
                    $q->where('id_skill', $skill->id);
                })
                ->get();

            $assignmentScores = $student->assignmentSubmissions()
                ->whereHas('assignment', function($q) use ($skill) {
                    $q->where('id_skill', $skill->id);
                })
                ->whereNotNull('nilai_guru')
                ->get();

            $quizzesAvg = $quizScores->avg('skor');
            $assignmentsAvg = $assignmentScores->avg('nilai_guru');

            // Hitung nilai skill: jika ada quiz dan assignment, rata-rata keduanya
            // Jika hanya ada quiz, gunakan nilai quiz
            // Jika hanya ada assignment, gunakan nilai assignment
            if ($quizScores->isNotEmpty() && $assignmentScores->isNotEmpty()) {
                $skillScores[$skill->kode] = ($quizzesAvg + $assignmentsAvg) / 2;
            } elseif ($quizScores->isNotEmpty()) {
                $skillScores[$skill->kode] = $quizzesAvg;
            } elseif ($assignmentScores->isNotEmpty()) {
                $skillScores[$skill->kode] = $assignmentsAvg;
            } else {
                $skillScores[$skill->kode] = 0;
            }
        }

        $rataRata = collect($skillScores)->avg();

        return view('guru.certificates.generate', compact('student', 'class', 'skillScores', 'rataRata', 'skills'));
    }

    public function storeCertificate(Request $request, ClassModel $class, User $student)
    {
        if ($class->id_guru !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'nilai_reading' => 'nullable|numeric|min:0|max:100',
            'nilai_writing' => 'nullable|numeric|min:0|max:100',
            'nilai_listening' => 'nullable|numeric|min:0|max:100',
            'nilai_speaking' => 'nullable|numeric|min:0|max:100',
            'nilai_grammar' => 'nullable|numeric|min:0|max:100',
        ]);

        $values = array_filter($validated, fn($v) => $v !== null);
        $rataRata = count($values) > 0 ? collect($values)->avg() : 0;

        $nomorSertifikat = 'CERT-' . strtoupper($class->course->kode) . '-' . date('Ymd') . '-' . str_pad(Certificate::count() + 1, 4, '0', STR_PAD_LEFT);

        Certificate::create([
            'id_student' => $student->id,
            'id_class' => $class->id,
            'nomor_sertifikat' => $nomorSertifikat,
            'tgl_terbit' => now(),
            'nilai_reading' => $validated['nilai_reading'] ?? null,
            'nilai_writing' => $validated['nilai_writing'] ?? null,
            'nilai_listening' => $validated['nilai_listening'] ?? null,
            'nilai_speaking' => $validated['nilai_speaking'] ?? null,
            'nilai_grammar' => $validated['nilai_grammar'] ?? null,
            'rata_rata_total' => $rataRata,
        ]);

        return redirect()->route('guru.classes.show', $class)->with('success', 'Sertifikat berhasil dibuat.');
    }

    public function viewStudentCertificate(ClassModel $class, User $student)
    {
        if ($class->id_guru !== auth()->id()) {
            abort(403);
        }

        $certificate = Certificate::where('id_student', $student->id)
            ->where('id_class', $class->id)
            ->with(['class.course', 'student'])
            ->firstOrFail();

        return view('murid.certificates.download', compact('certificate'));
    }

    // Select Class for Grades (Rekap Nilai)
    public function selectClassForGrades()
    {
        $classes = auth()->user()->taughtClasses()->with(['course', 'students', 'meetings'])->paginate(15);
        return view('guru.grades.select-class', compact('classes'));
    }

    // Grade Summary
    public function gradeSummary(ClassModel $class)
    {
        if ($class->id_guru !== auth()->id()) {
            abort(403);
        }

        $class->load(['students', 'course', 'meetings' => function($q) {
            $q->with(['quizzes', 'assignments']);
        }]);

        $studentGrades = [];
        foreach ($class->students as $student) {
            $grades = $class->getStudentGrades($student);
            $studentGrades[] = [
                'student' => $student,
                'skill_scores' => $grades['skill_scores'],
                'average' => $grades['average'],
                'quiz_count' => $grades['quiz_count'],
                'assignment_count' => $grades['assignment_count'],
            ];
        }

        $skills = Skill::all();

        return view('guru.grades.summary', compact('class', 'studentGrades', 'skills'));
    }

    public function exportGrades(ClassModel $class, Excel $excel)
    {
        if ($class->id_guru !== auth()->id()) {
            abort(403);
        }

        $class->load(['students', 'course', 'meetings' => function($q) {
            $q->with(['quizzes', 'assignments']);
        }]);

        $studentGrades = [];
        foreach ($class->students as $student) {
            $grades = $class->getStudentGrades($student);
            $studentGrades[] = [
                'student' => $student,
                'skill_scores' => $grades['skill_scores'],
                'average' => $grades['average'],
                'quiz_count' => $grades['quiz_count'],
                'assignment_count' => $grades['assignment_count'],
            ];
        }

        $filename = 'Rekap_Nilai_' . str_replace(' ', '_', $class->nama_kelas) . '_' . date('Y-m-d') . '.xlsx';

        return $excel->download(new ClassGradesExport($class, $studentGrades), $filename);
    }

    public function studentGrades(ClassModel $class, User $student)
    {
        if ($class->id_guru !== auth()->id()) {
            abort(403);
        }

        if (!$class->students->contains($student)) {
            abort(403, 'Student is not enrolled in this class');
        }

        $class->load(['meetings' => function($q) {
            $q->with(['quizzes.skill', 'assignments.skill', 'attendances']);
        }]);

        $grades = $class->getStudentGrades($student);

        // Get detailed scores
        $meetingIds = $class->meetings()->pluck('id');

        $quizScores = QuizScore::whereIn('id_quiz', function($query) use ($meetingIds) {
            $query->select('id')->from('quizzes')->whereIn('id_meeting', $meetingIds);
        })
        ->where('id_student', $student->id)
        ->whereNotNull('skor')
        ->with(['quiz.meeting', 'quiz.skill'])
        ->get();

        $assignmentSubmissions = AssignmentSubmission::whereIn('id_assignment', function($query) use ($meetingIds) {
            $query->select('id')->from('assignments')->whereIn('id_meeting', $meetingIds);
        })
        ->where('id_student', $student->id)
        ->whereNotNull('nilai_guru')
        ->with(['assignment.meeting', 'assignment.skill'])
        ->get();

        $attendance = Attendance::whereIn('id_meeting', $meetingIds)
            ->where('id_student', $student->id)
            ->get();

        $skills = Skill::all();

        // Build complete list of all quizzes and assignments with scores (0 if not done)
        $allQuizzesWithScores = [];
        $allAssignmentsWithScores = [];

        foreach ($class->meetings as $meeting) {
            foreach ($meeting->quizzes as $quiz) {
                $score = $quizScores->firstWhere('id_quiz', $quiz->id);
                $allQuizzesWithScores[] = [
                    'quiz' => $quiz,
                    'meeting' => $meeting,
                    'score' => $score ? $score->skor : 0,
                    'completed' => $score !== null,
                ];
            }

            foreach ($meeting->assignments as $assignment) {
                $submission = $assignmentSubmissions->firstWhere('id_assignment', $assignment->id);
                $allAssignmentsWithScores[] = [
                    'assignment' => $assignment,
                    'meeting' => $meeting,
                    'score' => $submission ? $submission->nilai_guru : 0,
                    'completed' => $submission !== null,
                ];
            }
        }

        return view('guru.grades.student-detail', compact('student', 'class', 'grades', 'allQuizzesWithScores', 'allAssignmentsWithScores', 'skills', 'attendance'));
    }

    // Student Detail (Registration Data)
    public function studentDetail(ClassModel $class, User $student)
    {
        if ($class->id_guru !== auth()->id()) {
            abort(403);
        }

        if (!$class->students->contains($student)) {
            abort(403, 'Student is not enrolled in this class');
        }

        // Find registration data for this student
        $registration = Registration::where('user_id', $student->id)->first();

        return view('guru.students.detail', compact('student', 'class', 'registration'));
    }

    // Attendance
    public function attendanceIndex(Meeting $meeting)
    {
        if ($meeting->class->id_guru !== auth()->id()) {
            abort(403);
        }

        $meeting->load(['class.students', 'attendances.student']);

        // Get attendance status counts
        $attendanceStats = [
            'hadir' => $meeting->attendances()->where('status', 'hadir')->count(),
            'izin' => $meeting->attendances()->where('status', 'izin')->count(),
            'sakit' => $meeting->attendances()->where('status', 'sakit')->count(),
            'alfa' => $meeting->attendances()->where('status', 'alfa')->count(),
        ];

        return view('guru.attendance.index', compact('meeting', 'attendanceStats'));
    }

    public function markAttendance(Request $request, Meeting $meeting)
    {
        if ($meeting->class->id_guru !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'attendances' => 'required|array',
            'attendances.*.id_student' => 'required|exists:users,id',
            'attendances.*.status' => 'required|in:hadir,izin,sakit,alfa',
            'attendances.*.keterangan' => 'nullable|string|max:500',
        ]);

        foreach ($validated['attendances'] as $attendanceData) {
            Attendance::updateOrCreate(
                [
                    'id_meeting' => $meeting->id,
                    'id_student' => $attendanceData['id_student'],
                ],
                [
                    'status' => $attendanceData['status'],
                    'keterangan' => $attendanceData['keterangan'] ?? null,
                    'checked_at' => now(),
                ]
            );
        }

        return redirect()->route('guru.attendance.index', $meeting)
            ->with('success', 'Kehadiran berhasil disimpan.');
    }

    // Announcements
    public function createAnnouncement(Meeting $meeting)
    {
        if ($meeting->class->id_guru !== auth()->id()) {
            abort(403);
        }

        return view('guru.announcements.create', compact('meeting'));
    }

    public function storeAnnouncement(Request $request, Meeting $meeting)
    {
        if ($meeting->class->id_guru !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'judul_pengumuman' => 'required|string|max:255',
            'isi_pengumuman' => 'required|string',
            'is_penting' => 'nullable|boolean',
        ]);

        $meeting->announcements()->create([
            'id_guru' => auth()->id(),
            'judul_pengumuman' => $validated['judul_pengumuman'],
            'isi_pengumuman' => $validated['isi_pengumuman'],
            'is_penting' => $validated['is_penting'] ?? false,
            'published_at' => now(),
        ]);

        return redirect()->route('guru.classes.show', $meeting->class)
            ->with('success', 'Pengumuman berhasil dibuat.');
    }

    public function deleteAnnouncement(Announcement $announcement)
    {
        if ($announcement->meeting->class->id_guru !== auth()->id()) {
            abort(403);
        }

        $class = $announcement->meeting->class;
        $announcement->delete();

        return redirect()->route('guru.classes.show', $class)
            ->with('success', 'Pengumuman berhasil dihapus.');
    }

    public function editAnnouncement(Announcement $announcement)
    {
        if ($announcement->meeting->class->id_guru !== auth()->id()) {
            abort(403);
        }

        return view('guru.announcements.edit', compact('announcement'));
    }

    public function updateAnnouncement(Request $request, Announcement $announcement)
    {
        if ($announcement->meeting->class->id_guru !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'judul_pengumuman' => 'required|string|max:255',
            'isi_pengumuman' => 'required|string',
            'is_penting' => 'nullable|boolean',
        ]);

        $announcement->update($validated);

        return redirect()->route('guru.classes.show', $announcement->meeting->class)
            ->with('success', 'Pengumuman berhasil diupdate.');
    }

    // Quiz Results Management
    public function quizResults(Request $request, Quiz $quiz)
    {
        // Security check
        if ($quiz->meeting->class->id_guru !== auth()->id()) {
            abort(403);
        }

        $class = $quiz->meeting->class;

        $query = QuizScore::where('id_quiz', $quiz->id)
            ->with(['quiz.meeting.class', 'student'])
            ->orderBy('created_at', 'desc');

        // Search functionality
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->whereHas('student', function($sq) use ($searchTerm) {
                    $sq->where('nama_lengkap', 'LIKE', "%{$searchTerm}%");
                });
            });
        }

        $results = $query->paginate(15);

        return view('guru.quizzes.results', compact('results', 'class', 'quiz'));
    }

    public function selectClassForQuizResults()
    {
        $classes = auth()->user()->taughtClasses()->with(['course', 'students', 'meetings'])->paginate(15);
        return view('guru.quizzes.select-class', compact('classes'));
    }

    public function classQuizResults(Request $request, ClassModel $class)
    {
        // Security check
        if ($class->id_guru !== auth()->id()) {
            abort(403);
        }

        $meetingIds = $class->meetings()->pluck('id');
        $quizIds = Quiz::whereIn('id_meeting', $meetingIds)->pluck('id');

        $query = QuizScore::whereIn('id_quiz', $quizIds)
            ->with(['quiz.meeting.class', 'student'])
            ->orderBy('created_at', 'desc');

        // Search functionality
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->whereHas('student', function($sq) use ($searchTerm) {
                    $sq->where('nama_lengkap', 'LIKE', "%{$searchTerm}%");
                })->orWhereHas('quiz', function($sq) use ($searchTerm) {
                    $sq->where('judul_kuis', 'LIKE', "%{$searchTerm}%");
                });
            });
        }

        $results = $query->paginate(15);

        return view('guru.quizzes.results', compact('results', 'class'));
    }

    public function resetQuizScore(QuizScore $score)
    {
        // Security check
        if ($score->quiz->meeting->class->id_guru !== auth()->id()) {
            abort(403);
        }

        $score->delete();

        return back()->with('success', 'Hasil kuis berhasil direset. Murid dapat mengerjakan ulang.');
    }
}
