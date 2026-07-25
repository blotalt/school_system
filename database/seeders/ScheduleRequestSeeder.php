<?php

namespace Database\Seeders;

use App\Models\ClassSchedule;
use App\Models\ScheduleRequest;
use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Sample schedule-request data for the admin approval queue. The Monday-
 * Friday grid is deliberately 100% full (see ClassScheduleSeeder), so
 * there are no free weekday slots left to request — every sample request
 * here targets Saturday instead (a teacher proposing an extra session).
 * A couple of "approved" ones also get a matching Saturday ClassSchedule
 * row, mirroring what Admin\ScheduleRequestController::approve() does.
 */
class ScheduleRequestSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();
        if (! $admin) {
            return;
        }

        // A representative sample of existing (class, subject, teacher)
        // combos to base Saturday requests on — keeps subject/teacher/class
        // coherent (a teacher proposing to teach their own subject again).
        $sample = ClassSchedule::where('period', 1)->where('day_of_week', 'Monday')->orderBy('class_id')->limit(9)->get();
        if ($sample->isEmpty()) {
            return;
        }

        $statuses = [
            0 => 'approved', 1 => 'approved',
            2 => 'rejected', 3 => 'rejected',
            4 => 'pending', 5 => 'pending', 6 => 'pending', 7 => 'pending', 8 => 'pending',
        ];

        foreach ($sample as $i => $row) {
            $status = $statuses[$i] ?? 'pending';

            $request = ScheduleRequest::create([
                'class_id'    => $row->class_id,
                'subject_id'  => $row->subject_id,
                'teacher_id'  => $row->teacher_id,
                'day_of_week' => 'Saturday',
                'period'      => 1,
                'shift'       => $row->shift,
                'status'      => $status,
                'reviewed_by' => $status === 'pending' ? null : $admin->id,
                'reviewed_at' => $status === 'pending' ? null : now()->subDays(3 + $i),
            ]);

            if ($status === 'approved') {
                ClassSchedule::firstOrCreate([
                    'class_id'    => $request->class_id,
                    'day_of_week' => 'Saturday',
                    'period'      => 1,
                    'shift'       => $request->shift,
                ], [
                    'subject_id' => $request->subject_id,
                    'teacher_id' => $request->teacher_id,
                ]);
            }
        }
    }
}
