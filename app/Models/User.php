<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',
        'nama_lengkap',
        'email',
        'tingkat_bahasa',
        'role',
        'password',
        'theme_preference',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->nama_lengkap)
            ->explode(' ')
            ->map(fn (string $name) => Str::of($name)->substr(0, 1))
            ->implode('');
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isGuru(): bool
    {
        return $this->role === 'guru';
    }

    public function isMurid(): bool
    {
        return $this->role === 'murid';
    }

    // Relationships
    public function taughtClasses()
    {
        return $this->hasMany(ClassModel::class, 'id_guru');
    }

    public function enrolledClasses()
    {
        return $this->belongsToMany(ClassModel::class, 'class_students', 'id_student', 'id_class');
    }

    public function quizScores()
    {
        return $this->hasMany(QuizScore::class, 'id_student');
    }

    public function assignmentSubmissions()
    {
        return $this->hasMany(AssignmentSubmission::class, 'id_student');
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class, 'id_student');
    }

    public function verifiedRegistrations()
    {
        return $this->hasMany(Registration::class, 'verified_by');
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class, 'user_id');
    }
}
