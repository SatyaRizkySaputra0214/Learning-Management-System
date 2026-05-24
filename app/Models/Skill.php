<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_skill',
        'kode',
    ];

    public function getNamaAttribute()
    {
        return $this->nama_skill;
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class, 'id_skill');
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class, 'id_skill');
    }
}
