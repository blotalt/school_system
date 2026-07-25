@extends('layouts.student')

@section('content')
<x-page-header>
    <div>
        <h1>{{ __('student.schedule.title') }}</h1>
        <p>{{ __('student.schedule.subtitle') }}</p>
    </div>
</x-page-header>

<div class="stat-grid">
    <div class="stat-card">
        <div class="stat-icon"><i class="fa-solid fa-school"></i></div>
        <div class="stat-value">{{ $class?->displayName() ?? '—' }}</div>
        <div class="stat-label">{{ __('common.class') }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="fa-solid fa-layer-group"></i></div>
        <div class="stat-value">{{ $class?->displayTrack() ?? '—' }}</div>
        <div class="stat-label">{{ __('common.track') }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="fa-solid fa-chalkboard-user"></i></div>
        <div class="stat-value">{{ $class?->teacher?->user?->name ?? '—' }}</div>
        <div class="stat-label">{{ __('student.schedule.homeroom_teacher') }}</div>
    </div>
</div>

@php
$subjectColors = [
    'Mathematics' => 'math', 'Physics' => 'physics', 'Biology' => 'biology',
    'Chemistry' => 'chemistry', 'English' => 'english', 'History' => 'history',
    'Geography' => 'geography', 'Computer Science' => 'computerscience',
];
@endphp

<div style="display:flex;justify-content:space-between;align-items:center;margin:24px 0 16px;">
    <h3 style="margin:0;">{{ __('student.schedule.weekly_timetable') }}</h3>
    <div class="header-group">
        <label>{{ __('admin.classes.shift_selection') }}</label>
        <div class="shift-toggle">
            <button type="button" class="shift-btn active" data-shift="morning">{{ __('admin.classes.morning_shift') }}</button>
            <button type="button" class="shift-btn" data-shift="afternoon">{{ __('admin.classes.afternoon_shift') }}</button>
        </div>
    </div>
</div>

@foreach(['morning', 'afternoon'] as $shiftKey)
<div class="timetable-container shift-grid" data-shift="{{ $shiftKey }}" style="{{ $shiftKey === 'afternoon' ? 'display:none;' : '' }}">
    <table class="schedule-table-grid">
        <thead>
            <tr>
                <th class="time-head">{{ __('admin.classes.time_column') }}</th>
                @foreach($days as $day)
                    <th>{{ strtoupper(__('common.days.' . $day)) }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @for($period = 1; $period <= 4; $period++)
                <tr>
                    <td class="time-box">P{{ $period }}<br><small>{{ $periodTimes[$shiftKey][$period] }}</small></td>
                    @foreach($days as $day)
                        @php $slot = $schedules->get("{$shiftKey}-{$day}-{$period}"); @endphp
                        <td>
                            @if($slot)
                                @php $colorClass = $subjectColors[$slot->subject->name] ?? 'default'; @endphp
                                <div class="subject-card subject-{{ $colorClass }}">
                                    <strong>{{ $slot->subject->displayName() }}</strong><br>
                                    <span>{{ collect(explode(' ', $slot->teacher->user->displayName()))->map(fn($n) => mb_substr($n, 0, 1))->take(2)->implode('') }}</span>
                                </div>
                            @else
                                <div class="empty-slot"></div>
                            @endif
                        </td>
                    @endforeach
                </tr>
                @if($period < 4)
                    @php
                        $breakStart = explode(' - ', $periodTimes[$shiftKey][$period])[1];
                        $breakEnd = explode(' - ', $periodTimes[$shiftKey][$period + 1])[0];
                    @endphp
                    <tr class="break-row">
                        <td colspan="{{ count($days) + 1 }}"><i class="fa-regular fa-clock"></i> {{ __('admin.classes.break_label', ['start' => $breakStart, 'end' => $breakEnd]) }}</td>
                    </tr>
                @endif
            @endfor
        </tbody>
    </table>
</div>
@endforeach

<div class="data-card" style="margin-top:24px;">
    <div class="data-card-header">
        <h3>{{ __('student.schedule.upcoming_exams') }}</h3>
    </div>
    <table class="data-table">
        <thead>
            <tr>
                <th>{{ __('student.schedule.exam_column') }}</th>
                <th>{{ __('common.subject') }}</th>
                <th>{{ __('student.schedule.type_column') }}</th>
                <th>{{ __('student.schedule.date_column') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($exams as $exam)
                <tr>
                    <td>{{ $exam->title }}</td>
                    <td>{{ $exam->subject?->displayName() ?? '—' }}</td>
                    <td>{{ $exam->subject?->displayName() ?? '—' }}</td>
<td><span class="badge">{{ __('teacher.exams.' . $exam->exam_type) }}</span></td>
                </tr>
            @empty
                <tr><td colspan="4" style="text-align:center;color:#8a94a6;">{{ __('student.schedule.no_exams_scheduled') }}</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<script>
document.querySelectorAll('.shift-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.shift-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');

        const shift = this.dataset.shift;
        document.querySelectorAll('.shift-grid').forEach(grid => {
            grid.style.display = (grid.dataset.shift === shift) ? 'block' : 'none';
        });
    });
});
</script>
@endsection
