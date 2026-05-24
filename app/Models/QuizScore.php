<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizScore extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_quiz',
        'id_student',
        'started_at',
        'completed_at',
        'skor',
        'total_poin',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class, 'id_quiz');
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'id_student');
    }
}
