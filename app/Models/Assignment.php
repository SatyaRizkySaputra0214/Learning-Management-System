<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_meeting',
        'id_skill',
        'judul_tugas',
        'deskripsi',
        'deadline',
        'poin_maksimal',
    ];

    protected $casts = [
        'deadline' => 'datetime',
    ];

    public function meeting()
    {
        return $this->belongsTo(Meeting::class, 'id_meeting');
    }

    public function skill()
    {
        return $this->belongsTo(Skill::class, 'id_skill');
    }

    public function submissions()
    {
        return $this->hasMany(AssignmentSubmission::class, 'id_assignment');
    }
}
