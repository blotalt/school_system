<?php

namespace App\Http\Controllers\Teacher\Concerns;

use App\Models\SchoolClass;
use Illuminate\Support\Facades\Auth;

/**
 * Layer 2 of the permission model.
 *
 * The 'role:teacher' middleware only confirms "you are A teacher" - it can't
 * tell Teacher A from Teacher B. Without this check, Teacher A could create
 * an exam/homework/attendance record for Teacher B's class just by
 * submitting B's class_id. Every write method in every Teacher controller
 * must call this before creating/updating/deleting anything.
 */
trait EnsuresClassOwnership
{
    protected function ensureTeacherOwnsClass(int $classId): SchoolClass
    {
        $class = SchoolClass::findOrFail($classId);

        abort_unless(
            $class->teacher_id === Auth::user()->teacher->id,
            403,
            'You do not have permission to manage this class.'
        );

        return $class;
    }
}
