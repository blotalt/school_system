<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Announcement extends Model
{
    protected $fillable = [
        'author_id',
        'title',
        'body',
        'audience',
        'class_id',
        'priority',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    /**
     * Announcements visible to a given student:
     * anything for everyone/students, plus anything targeted at their own class.
     */
    public function scopeVisibleToStudent($query, ?int $classId)
    {
        return $query->where(function ($q) use ($classId) {
            $q->whereIn('audience', ['everyone', 'students'])
              ->orWhere(function ($c) use ($classId) {
                  $c->where('audience', 'class')->where('class_id', $classId);
              });
        });
    }

    /**
     * Announcements visible to teachers: everyone + teacher-targeted.
     */
    public function scopeVisibleToTeacher($query)
    {
        return $query->whereIn('audience', ['everyone', 'teachers']);
    }
}
