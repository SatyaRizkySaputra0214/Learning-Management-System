<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignmentSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_assignment',
        'id_student',
        'file_url',
        'catatan_siswa',
        'nilai_guru',
        'feedback',
        'submitted_at',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'nilai_guru' => 'decimal:2',
    ];

    public function assignment()
    {
        return $this->belongsTo(Assignment::class, 'id_assignment');
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'id_student');
    }
}
