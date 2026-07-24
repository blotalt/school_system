<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Homework extends Model
{
    protected $table = 'homeworks';

    protected $fillable = [
        'class_id',
        'teacher_id',
        'subject_id',
        'title',
        'description',
        'due_date',
        'attachment_path',
        'attachment_name',
    ];

    protected $casts = [
        'due_date' => 'date',
    ];

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function submissions()
    {
        return $this->hasMany(HomeworkSubmission::class);
    }
}