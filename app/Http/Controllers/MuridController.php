<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use App\Models\Meeting;
use App\Models\Material;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\QuizScore;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\Certificate;
use App\Models\Announcement;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class MuridController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();
        
        // Get enrolled classes with relationships
        $classes = $user->enrolledClasses()
            ->with(['course', 'guru', 'meetings', 'meetings.quizzes', 'meetings.assignments'])
            ->get();

        // 1. Tugas (All assignments - overdue and upcoming, limited to 4, excluding submitted ones)
        $classIds = $classes->pluck('id');
        $meetingIds = Meeting::whereIn('id_class', $classIds)->pluck('id');

        // Get assignment IDs that the student has already submitted
        $submittedAssignmentIds = AssignmentSubmission::where('id_student', $user->id)
            ->pluck('id_assignment');

        $assignments = Assignment::whereIn('id_meeting', $meetingIds)
            ->whereNotIn('id', $submittedAssignmentIds)
            ->with(['meeting.class', 'skill'])
            ->orderBy('deadline', 'asc')
            ->limit(4)
            ->get();

        // 2. Calculate class progress for each active class
        $classProgress = [];
        foreach ($classes as $class) {
            $totalMeetings = $class->meetings->count();
            $completedMeetings = 0;
            
            foreach ($class->meetings as $meeting) {
                // Check if student has completed quizzes and assignments for this meeting
                $quizzesCompleted = $meeting->quizzes->contains(function($quiz) use ($user) {
                    return QuizScore::where('id_quiz', $quiz->id)
                        ->where('id_student', $user->id)
                        ->whereNotNull('skor')
                        ->exists();
                });
                
                $assignmentsCompleted = $meeting->assignments->contains(function($assignment) use ($user) {
                    return AssignmentSubmission::where('id_assignment', $assignment->id)
                        ->where('id_student', $user->id)
                        ->whereNotNull('nilai_guru')
                        ->exists();
                });
                
                if ($quizzesCompleted || $assignmentsCompleted || $totalMeetings === 0) {
                    $completedMeetings++;
                }
            }
            
            $progressPercentage = $totalMeetings > 0 ? round(($completedMeetings / $totalMeetings) * 100) : 0;
            $classProgress[$class->id] = $progressPercentage;
        }

        // 3. Notifikasi Penting - Important announcements from all classes (exclude read/dismissed)
        $importantAnnouncements = Announcement::whereIn('id_meeting', $meetingIds)
            ->whereDoesntHave('readByUsers', function($q) use ($user) {
                $q->where('users.id', $user->id);
            })
            ->with(['guru', 'meeting.class'])
            ->orderBy('is_penting', 'desc')
            ->orderBy('published_at', 'desc')
            ->limit(10)
            ->get();

        // 4. Rata-rata nilai (Average grades)
        $quizScores = QuizScore::whereIn('id_quiz', function($query) use ($meetingIds) {
            $query->select('id')->from('quizzes')->whereIn('id_meeting', $meetingIds);
        })
        ->where('id_student', $user->id)
        ->with('quiz')
        ->get();

        $assignmentSubmissions = AssignmentSubmission::whereIn('id_assignment', function($query) use ($meetingIds) {
            $query->select('id')->from('assignments')->whereIn('id_meeting', $meetingIds);
        })
        ->where('id_student', $user->id)
        ->whereNotNull('nilai_guru')
        ->with('assignment')
        ->get();

        $quizAverage = $quizScores->avg('skor');
        $assignmentAverage = $assignmentSubmissions->avg('nilai_guru');
        
        $overallAverage = null;
        if ($quizAverage !== null && $assignmentAverage !== null) {
            $overallAverage = round(($quizAverage + $assignmentAverage) / 2, 2);
        } elseif ($quizAverage !== null) {
            $overallAverage = round($quizAverage, 2);
        } elseif ($assignmentAverage !== null) {
            $overallAverage = round($assignmentAverage, 2);
        }

        // 5. Persentase kehadiran (Attendance percentage)
        $attendanceRecords = Attendance::whereIn('id_meeting', $meetingIds)
            ->where('id_student', $user->id)
            ->get();
        
        $totalAttendanceRequired = $attendanceRecords->count();
        $presentCount = $attendanceRecords->whereIn('status', ['present', 'hadir'])->count();
        $attendancePercentage = $totalAttendanceRequired > 0 
            ? round(($presentCount / $totalAttendanceRequired) * 100, 2) 
            : 0;

        // Add detailed grades and attendance for each class, grouped by meeting
        foreach ($classes as $class) {
            foreach ($class->meetings as $meeting) {
                $meeting->quiz_scores = $quizScores->filter(function($score) use ($meeting) {
                    return $score->quiz->id_meeting == $meeting->id;
                });

                $meeting->assignment_scores = $assignmentSubmissions->filter(function($submission) use ($meeting) {
                    return $submission->assignment->id_meeting == $meeting->id;
                });

                $meeting->attendance = $attendanceRecords->where('id_meeting', $meeting->id)->first();
            }
        }

        return view('murid.dashboard', compact(
            'classes',
            'assignments',
            'classProgress',
            'importantAnnouncements',
            'overallAverage',
            'quizAverage',
            'assignmentAverage',
            'attendancePercentage',
            'totalAttendanceRequired',
            'presentCount'
        ));
    }

    public function markAnnouncementRead(Announcement $announcement)
    {
        DB::table('announcement_reads')->updateOrInsert(
            [
                'id_announcement' => $announcement->id,
                'id_user' => auth()->id(),
            ],
            [
                'read_at' => now(),
            ]
        );

        return response()->json(['success' => true]);
    }

    public function progressDetail(Request $request)
    {
        $user = auth()->user();
        $classes = $user->enrolledClasses()
            ->with(['course', 'guru', 'meetings'])
            ->get();

        $meetingIds = Meeting::whereIn('id_class', $classes->pluck('id'))->pluck('id');

        $quizScores = QuizScore::whereIn('id_quiz', function($query) use ($meetingIds) {
            $query->select('id')->from('quizzes')->whereIn('id_meeting', $meetingIds);
        })
        ->where('id_student', $user->id)
        ->with('quiz')
        ->get();

        $assignmentSubmissions = AssignmentSubmission::whereIn('id_assignment', function($query) use ($meetingIds) {
            $query->select('id')->from('assignments')->whereIn('id_meeting', $meetingIds);
        })
        ->where('id_student', $user->id)
        ->whereNotNull('nilai_guru')
        ->with('assignment')
        ->get();

        $attendanceRecords = Attendance::whereIn('id_meeting', $meetingIds)
            ->where('id_student', $user->id)
            ->get();

        foreach ($classes as $class) {
            foreach ($class->meetings as $meeting) {
                $meeting->quiz_scores = $quizScores->filter(function($score) use ($meeting) {
                    return $score->quiz->id_meeting == $meeting->id;
                });

                $meeting->assignment_scores = $assignmentSubmissions->filter(function($submission) use ($meeting) {
                    return $submission->assignment->id_meeting == $meeting->id;
                });

                $meeting->attendance = $attendanceRecords->where('id_meeting', $meeting->id)->first();
            }
        }

        $classAverages = [];
        foreach ($classes as $class) {
            $grades = $class->getStudentGrades($user);
            $hadirCount = 0;
            $totalAttendance = 0;

            foreach ($class->meetings as $meeting) {
                if ($meeting->attendance) {
                    $totalAttendance++;
                    if (in_array(strtolower($meeting->attendance->status), ['present', 'hadir'])) {
                        $hadirCount++;
                    }
                }
            }

            $classAverages[$class->id] = [
                'nilai' => $grades['average'] !== null ? round($grades['average'], 1) : 0,
                'kehadiran' => $totalAttendance > 0 ? round(($hadirCount / $totalAttendance) * 100, 1) : 0,
            ];
        }

        $selectedClassId = $request->get('class_id');

        return view('murid.progress-detail', compact('classes', 'selectedClassId', 'classAverages'));
    }

    public function viewMeeting(Meeting $meeting)
    {
        if (!$meeting->class->students->contains(auth()->user())) {
            abort(403);
        }

        $meeting->load(['materials', 'quizzes', 'assignments', 'announcements']);

        return view('murid.meeting', compact('meeting'));
    }

    public function downloadMaterial(Material $material)
    {
        if (!$material->meeting->class->students->contains(auth()->user())) {
            abort(403);
        }

        if (str_starts_with($material->file_url, 'http')) {
            return redirect($material->file_url);
        }

        return Storage::disk('public')->download($material->file_url);
    }

    public function takeQuiz(Quiz $quiz)
    {
        if (!$quiz->meeting->class->students->contains(auth()->user())) {
            abort(403);
        }

        if ($quiz->isEnded()) {
            return redirect()->route('murid.enrolled-classes.show', $quiz->meeting->class)
                ->with('error', 'Kuis telah berakhir.');
        }

        if ($quiz->isNotYetStarted()) {
            return redirect()->route('murid.enrolled-classes.show', $quiz->meeting->class)
                ->with('error', 'Kuis belum dimulai.');
        }

        $existingScore = QuizScore::where('id_quiz', $quiz->id)
            ->where('id_student', auth()->id())
            ->first();

        if ($existingScore && $existingScore->skor !== null) {
            return redirect()->route('murid.quiz.result', $existingScore);
        }

        $quiz->load('questions', 'skill');

        if (!$existingScore) {
            $existingScore = QuizScore::create([
                'id_quiz' => $quiz->id,
                'id_student' => auth()->id(),
                'started_at' => now(),
            ]);
        }

        return view('murid.quizzes.take', compact('quiz'));
    }

    public function submitQuiz(Request $request, Quiz $quiz)
    {
        if (!$quiz->meeting->class->students->contains(auth()->user())) {
            abort(403);
        }

        if ($quiz->isEnded()) {
            return redirect()->route('murid.enrolled-classes.show', $quiz->meeting->class)
                ->with('error', 'Waktu pengerjaan kuis telah habis!');
        }

        $quiz->load('questions');

        $scoreRecord = QuizScore::where('id_quiz', $quiz->id)
            ->where('id_student', auth()->id())
            ->first();

        if (!$scoreRecord) {
            return redirect()->route('murid.enrolled-classes.show', $quiz->meeting->class)
                ->with('error', 'Data pengerjaan kuis tidak ditemukan.');
        }

        // Validasi jawaban - allow partial submission for timed quizzes
        $validated = $request->validate([
            'answers' => 'nullable|array',
            'answers.*' => 'nullable|in:A,B,C,D'
        ]);

        $answers = $validated['answers'] ?? [];
        
        $correctCount = 0;
        $totalPoin = 0;

        foreach ($quiz->questions as $question) {
            $userAnswer = $answers[$question->id] ?? null;
            if ($userAnswer === $question->kunci_jawaban) {
                $correctCount++;
                $totalPoin += $question->poin ?? 1;
            }
        }

        $skor = round(($correctCount / $quiz->questions->count()) * 100);

        $scoreRecord->update([
            'skor' => $skor,
            'total_poin' => $totalPoin,
            'completed_at' => now(),
        ]);

        return redirect()->route('murid.quiz.result', $scoreRecord)->with('success', 'Kuis berhasil dikerjakan!');
    }

    public function checkDeadline(Quiz $quiz)
    {
        if (!$quiz->meeting->class->students->contains(auth()->user())) {
            abort(403);
        }

        return response()->json([
            'end_at' => $quiz->end_at ? $quiz->end_at->timestamp : null,
            'is_ended' => $quiz->isEnded(),
        ]);
    }

    public function quizResult(QuizScore $score)
    {
        if ($score->id_student !== auth()->id()) {
            abort(403);
        }

        $score->load('quiz');

        return view('murid.quizzes.result', compact('score'));
    }

    public function submitAssignment(Assignment $assignment)
    {
        if (!$assignment->meeting->class->students->contains(auth()->user())) {
            abort(403);
        }

        $existingSubmission = AssignmentSubmission::where('id_assignment', $assignment->id)
            ->where('id_student', auth()->id())
            ->first();

        $assignment->load('skill');

        return view('murid.assignments.submit', compact('assignment', 'existingSubmission'));
    }

    public function storeAssignmentSubmission(Request $request, Assignment $assignment)
    {
        if (!$assignment->meeting->class->students->contains(auth()->user())) {
            abort(403);
        }

        $validated = $request->validate([
            'file_upload' => 'required|file|max:10240',
            'catatan_siswa' => 'nullable|string|max:500',
        ]);

        $filePath = $request->file('file_upload')->store('assignment_submissions', 'public');

        AssignmentSubmission::updateOrCreate(
            [
                'id_assignment' => $assignment->id,
                'id_student' => auth()->id(),
            ],
            [
                'file_url' => $filePath,
                'catatan_siswa' => $validated['catatan_siswa'],
                'submitted_at' => now(),
            ]
        );

        return redirect()->route('murid.enrolled-classes.show', $assignment->meeting->class)->with('success', 'Tugas berhasil dikumpulkan.');
    }

    public function reviewAssignment(Assignment $assignment)
    {
        if (!$assignment->meeting->class->students->contains(auth()->user())) {
            abort(403);
        }

        $submission = AssignmentSubmission::where('id_assignment', $assignment->id)
            ->where('id_student', auth()->id())
            ->first();

        if (!$submission) {
            return redirect()->route('murid.assignment.submit', $assignment)
                ->with('error', 'Anda belum mengumpulkan tugas ini.');
        }

        $assignment->load('skill', 'meeting.class');

        return view('murid.assignments.review', compact('assignment', 'submission'));
    }

    public function viewSubmissionFile(AssignmentSubmission $submission)
    {
        if ($submission->id_student !== auth()->id()) {
            abort(403);
        }

        if (!$submission->file_url || !Storage::disk('public')->exists($submission->file_url)) {
            abort(404, 'File tidak ditemukan.');
        }

        return Storage::disk('public')->response($submission->file_url);
    }

    public function destroySubmission(Assignment $assignment)
    {
        if (!$assignment->meeting->class->students->contains(auth()->user())) {
            abort(403);
        }

        $submission = AssignmentSubmission::where('id_assignment', $assignment->id)
            ->where('id_student', auth()->id())
            ->first();

        if (!$submission) {
            return back()->with('error', 'Tidak ada jawaban untuk dihapus.');
        }

        if ($submission->file_url && Storage::disk('public')->exists($submission->file_url)) {
            Storage::disk('public')->delete($submission->file_url);
        }

        $submission->delete();

        return redirect()->route('murid.enrolled-classes.show', $assignment->meeting->class)
            ->with('success', 'Jawaban tugas berhasil dihapus.');
    }

    public function enrolledClasses()
    {
        $user = auth()->user();

        // Get enrolled classes with relationships
        $classes = $user->enrolledClasses()
            ->with(['course', 'guru'])
            ->get();

        // Calculate stats for each class
        $classStats = [];
        foreach ($classes as $class) {
            $meetings = $class->meetings;
            $totalMeetings = $meetings->count();
            $totalMaterials = $meetings->sum(fn($m) => $m->materials->count());
            $totalQuizzes = $meetings->sum(fn($m) => $m->quizzes->count());
            $totalAssignments = $meetings->sum(fn($m) => $m->assignments->count());

            // Count completed items
            $completedQuizzes = 0;
            $completedAssignments = 0;

            foreach ($meetings as $meeting) {
                foreach ($meeting->quizzes as $quiz) {
                    if (QuizScore::where('id_quiz', $quiz->id)
                        ->where('id_student', $user->id)
                        ->whereNotNull('skor')
                        ->exists()) {
                        $completedQuizzes++;
                    }
                }

                foreach ($meeting->assignments as $assignment) {
                    if (AssignmentSubmission::where('id_assignment', $assignment->id)
                        ->where('id_student', $user->id)
                        ->whereNotNull('nilai_guru')
                        ->exists()) {
                        $completedAssignments++;
                    }
                }
            }

            // Calculate progress
            $totalItems = $totalQuizzes + $totalAssignments;
            $completedItems = $completedQuizzes + $completedAssignments;
            $progress = $totalItems > 0 ? round(($completedItems / $totalItems) * 100) : 0;

            $classStats[$class->id] = [
                'totalMeetings' => $totalMeetings,
                'totalMaterials' => $totalMaterials,
                'totalQuizzes' => $totalQuizzes,
                'totalAssignments' => $totalAssignments,
                'completedQuizzes' => $completedQuizzes,
                'completedAssignments' => $completedAssignments,
                'progress' => $progress,
            ];
        }

        return view('murid.enrolled-classes', compact('classes', 'classStats'));
    }

    public function showEnrolledClass(ClassModel $class)
    {
        $user = auth()->user();

        // Check if user is enrolled in this class
        if (!$class->students->contains($user)) {
            abort(403);
        }

        $class->load(['course', 'guru', 'meetings' => function($q) {
            $q->orderBy('urutan_pertemuan')->with('announcements');
        }]);

        return view('murid.class', compact('class'));
    }

    public function certificates()
    {
        $certificates = auth()->user()->certificates()->with('class.course')->orderBy('created_at', 'desc')->get();
        return view('murid.certificates', compact('certificates'));
    }

    public function downloadCertificate(Certificate $certificate)
    {
        if ($certificate->id_student !== auth()->id()) {
            abort(403);
        }

        // Jika ada file PDF yang sudah di-generate, download itu
        if ($certificate->file_pdf_url) {
            return Storage::disk('public')->download($certificate->file_pdf_url);
        }

        // Jika tidak, tampilkan view untuk print/save PDF
        return view('murid.certificates.download', compact('certificate'));
    }
}
