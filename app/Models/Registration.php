<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'email',
        'no_telp',
        'kursus_pilihan',
        'tingkat_bahasa',
        'bukti_bayar_url',
        'bukti_kemampuan_dasar',
        'status',
        'admin_notes',
        'verified_by',
        'user_id',
    ];

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isBuktiKemampuanRequired(): bool
    {
        $kursus = $this->kursus_pilihan;
        $tingkat = $this->tingkat_bahasa;

        if ($kursus === 'eng' && in_array($tingkat, ['A2', 'B1'])) return true;
        if ($kursus === 'kor' && $tingkat === 'Intermediate') return true;
        if ($kursus === 'th' && $tingkat === 'Intermediate') return true;

        return false;
    }

    public function getKursusLabelAttribute(): string
    {
        return match($this->kursus_pilihan) {
            'eng' => 'English',
            'kor' => 'Korean',
            'th' => 'Thai',
            default => $this->kursus_pilihan,
        };
    }
}
