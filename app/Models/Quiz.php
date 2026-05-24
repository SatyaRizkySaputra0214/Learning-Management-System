<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_meeting',
        'id_skill',
        'judul_kuis',
        'deskripsi',
        'start_at',
        'end_at',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
    ];

    public function isNotYetStarted(): bool
    {
        return $this->start_at && now()->lt($this->start_at);
    }

    public function isOngoing(): bool
    {
        return $this->start_at && $this->end_at && now()->between($this->start_at, $this->end_at);
    }

    public function isEnded(): bool
    {
        return $this->end_at && now()->gt($this->end_at);
    }

    public function meeting()
    {
        return $this->belongsTo(Meeting::class, 'id_meeting');
    }

    public function skill()
    {
        return $this->belongsTo(Skill::class, 'id_skill');
    }

    public function questions()
    {
        return $this->hasMany(Question::class, 'id_quiz');
    }

    public function scores()
    {
        return $this->hasMany(QuizScore::class, 'id_quiz');
    }
}
