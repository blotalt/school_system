<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SchoolClass extends Model
{
    protected $table = 'classes';

    protected $fillable = [
        'name',
        'track',
        'grade_level',
        'teacher_id',
    ];

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    public function teachers(): BelongsToMany
    {
        return $this->belongsToMany(Teacher::class, 'class_teacher', 'class_id', 'teacher_id');
    }

    public function students(): HasMany
    {
        return $this->hasMany(Student::class, 'class_id');
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(ClassSchedule::class, 'class_id');
    }
}