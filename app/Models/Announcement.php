<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_meeting',
        'id_guru',
        'judul_pengumuman',
        'isi_pengumuman',
        'is_penting',
        'published_at',
    ];

    protected $casts = [
        'is_penting' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function meeting()
    {
        return $this->belongsTo(Meeting::class, 'id_meeting');
    }

    public function guru()
    {
        return $this->belongsTo(User::class, 'id_guru');
    }

    public function readByUsers()
    {
        return $this->belongsToMany(User::class, 'announcement_reads', 'id_announcement', 'id_user')
            ->withPivot('read_at')
            ->withTimestamps();
    }
}
