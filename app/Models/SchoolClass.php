<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SchoolClass extends Model
{
    protected $table = 'classes';

    protected $fillable = [
        'name',
        'track',
        'grade_level',
        'teacher_id',
        'schedule_approved_at',
    ];

    protected function casts(): array
    {
        return [
            'schedule_approved_at' => 'datetime',
        ];
    }

    public function displayName(): string
    {
        if (app()->getLocale() === 'km') {
            return str_replace('Grade ', 'ថ្នាក់ទី ', $this->name);
        }
        return $this->name;
    }

    public function displayTrack(): string
    {
        if (!$this->track) return '';
        if (app()->getLocale() === 'km') {
            return __('common.tracks.' . $this->track);
        }
        return $this->track;
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
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