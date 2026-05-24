<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassModel extends Model
{
    use HasFactory;

    protected $table = 'classes';

    protected $fillable = [
        'id_course',
        'id_guru',
        'nama_kelas',
        'periode',
        'status',
        'jumlah_hari',
        'is_archived',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class, 'id_course');
    }

    public function guru()
    {
        return $this->belongsTo(User::class, 'id_guru');
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'class_students', 'id_class', 'id_student');
    }

    public function meetings()
    {
        return $this->hasMany(Meeting::class, 'id_class');
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class, 'id_class');
    }

    public function getStudentGrades(User $student)
    {
        $meetingIds = $this->meetings()->pluck('id');

        // Quiz scores
        $quizScores = QuizScore::whereIn('id_quiz', function($query) use ($meetingIds) {
            $query->select('id')->from('quizzes')->whereIn('id_meeting', $meetingIds);
        })
        ->where('id_student', $student->id)
        ->whereNotNull('skor')
        ->get();

        // Assignment scores
        $assignmentSubmissions = AssignmentSubmission::whereIn('id_assignment', function($query) use ($meetingIds) {
            $query->select('id')->from('assignments')->whereIn('id_meeting', $meetingIds);
        })
        ->where('id_student', $student->id)
        ->whereNotNull('nilai_guru')
        ->get();

        // Calculate by skill
        $skills = Skill::all();
        $skillScores = [];

        foreach ($skills as $skill) {
            $quizScoresBySkill = $quizScores->filter(function($score) use ($skill) {
                return $score->quiz->id_skill == $skill->id;
            });

            $assignmentScoresBySkill = $assignmentSubmissions->filter(function($submission) use ($skill) {
                return $submission->assignment->id_skill == $skill->id;
            });

            $quizzesAvg = $quizScoresBySkill->avg('skor');
            $assignmentsAvg = $assignmentScoresBySkill->avg('nilai_guru');

            if ($quizScoresBySkill->isNotEmpty() && $assignmentScoresBySkill->isNotEmpty()) {
                $skillScores[$skill->kode] = ($quizzesAvg + $assignmentsAvg) / 2;
            } elseif ($quizScoresBySkill->isNotEmpty()) {
                $skillScores[$skill->kode] = $quizzesAvg;
            } elseif ($assignmentScoresBySkill->isNotEmpty()) {
                $skillScores[$skill->kode] = $assignmentsAvg;
            } else {
                $skillScores[$skill->kode] = null;
            }
        }

        $validScores = array_filter($skillScores, fn($v) => $v !== null);
        $average = count($validScores) > 0 ? array_sum($validScores) / count($validScores) : null;

        return [
            'skill_scores' => $skillScores,
            'average' => $average,
            'quiz_count' => $quizScores->count(),
            'assignment_count' => $assignmentSubmissions->count(),
        ];
    }
}
