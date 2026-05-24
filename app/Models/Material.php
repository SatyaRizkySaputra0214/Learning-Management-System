<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_meeting',
        'judul',
        'tipe',
        'file_url',
        'deskripsi',
    ];

    public function meeting()
    {
        return $this->belongsTo(Meeting::class, 'id_meeting');
    }
}
