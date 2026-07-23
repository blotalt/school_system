<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Teacher extends Model
{
    protected $fillable = [
        'user_id',
        'subject_specialty',
        'date_of_birth',
        'gender',
        'phone',
    ];

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function classes(): HasMany
    {
        return $this->hasMany(SchoolClass::class, 'teacher_id');
    }

    public function assignedClasses(): BelongsToMany
    {
        return $this->belongsToMany(SchoolClass::class, 'class_teacher', 'teacher_id', 'class_id');
    }

    public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class);
    }
}