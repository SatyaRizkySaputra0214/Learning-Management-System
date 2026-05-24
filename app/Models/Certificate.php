<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_student',
        'id_class',
        'nomor_sertifikat',
        'file_pdf_url',
        'tgl_terbit',
        'nilai_reading',
        'nilai_writing',
        'nilai_listening',
        'nilai_speaking',
        'nilai_grammar',
        'rata_rata_total',
    ];

    protected $casts = [
        'tgl_terbit' => 'date',
        'nilai_reading' => 'decimal:2',
        'nilai_writing' => 'decimal:2',
        'nilai_listening' => 'decimal:2',
        'nilai_speaking' => 'decimal:2',
        'nilai_grammar' => 'decimal:2',
        'rata_rata_total' => 'decimal:2',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'id_student');
    }

    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'id_class');
    }

    public function getGradeAttribute(): string
    {
        $average = $this->rata_rata_total ?? 0;
        
        return match(true) {
            $average >= 90 => 'A',
            $average >= 80 => 'B',
            $average >= 70 => 'C',
            $average >= 60 => 'D',
            default => 'E',
        };
    }
}
