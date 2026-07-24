<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'khmer_name', 'email', 'password', 'role', 'locale', 'profile_picture'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    public function isAdmin(): bool   { return $this->role === 'admin'; }
    public function isTeacher(): bool { return $this->role === 'teacher'; }
    public function isStudent(): bool { return $this->role === 'student'; }

    public function displayName(): string
    {
        if (app()->getLocale() === 'km' && $this->khmer_name) {
            return $this->khmer_name;
        }
        return $this->name;
    }

    public function profilePicture(): string
    {
        if ($this->profile_picture) {
            return asset($this->profile_picture);
        }
        if ($this->role === 'admin') {
            return asset('images/profiles/admin.png');
        }
        if ($this->role === 'teacher') {
            $gender = $this->teacher?->gender ?? 'male';
            return asset("images/profiles/teacher_{$gender}.png");
        }
        if ($this->role === 'student') {
            $gender = $this->student?->gender ?? 'male';
            $ext = $gender === 'male' ? 'jpg' : 'png';
            return asset("images/profiles/student_{$gender}.{$ext}");
        }
        return asset('images/profiles/admin.png');
    }

    public function student(): HasOne
    {
        return $this->hasOne(Student::class);
    }

    public function teacher(): HasOne
    {
        return $this->hasOne(Teacher::class);
    }
}