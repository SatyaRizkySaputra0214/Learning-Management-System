<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_class',
        'urutan_pertemuan',
        'judul_pertemuan',
        'deskripsi',
    ];

    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'id_class');
    }

    public function materials()
    {
        return $this->hasMany(Material::class, 'id_meeting');
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class, 'id_meeting');
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class, 'id_meeting');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'id_meeting');
    }

    public function announcements()
    {
        return $this->hasMany(Announcement::class, 'id_meeting');
    }
}
