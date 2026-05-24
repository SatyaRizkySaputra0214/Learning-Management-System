<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_bahasa',
        'kode',
        'deskripsi',
    ];

    public function classes()
    {
        return $this->hasMany(ClassModel::class, 'id_course');
    }
}
