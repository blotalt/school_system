@extends('layouts.student')

@section('content')
<x-page-header>
    <div>
        <h1>My Schedule</h1>
        <p>{{ $class?->name ?? '—' }} official timetable.</p>
    </div>
</x-page-header>

<div class="stat-grid">
    <div class="stat-card">
        <div class="stat-icon"><i class="fa-solid fa-school"></i></div>
        <div class="stat-value">{{ $class->name ?? '—' }}</div>
        <div class="stat-label">Class</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="fa-solid fa-layer-group"></i></div>
        <div class="stat-value">{{ $class->track ?? '—' }}</div>
        <div class="stat-label">Track</div>
    </div>

</div>

@if($schedules->isEmpty())
    <div class="data-card" style="padding:32px;text-align:center;color:#9ca3af;">
        No approved schedule yet for your class. Check back later.
    </div>
@else
    <div style="margin-bottom:12px;">
        <div class="shift-toggle">
            <button type="button" class="shift-btn active" data-shift="morning">Morning</button>
            <button type="button" class="shift-btn" data-shift="afternoon">Afternoon</button>
        </div>
    </div>

    @php
    $subjectColors = [
        'Mathematics' => 'math', 'Physics' => 'physics', 'Biology' => 'biology',
        'Chemistry' => 'chemistry', 'English' => 'english', 'History' => 'history',
        'Geography' => 'geography', 'Computer Science' => 'computerscience',
    ];
    @endphp

    @foreach(['morning', 'afternoon'] as $shiftKey)
    <div class="timetable-container shift-grid" data-shift="{{ $shiftKey }}" style="{{ $shiftKey === 'afternoon' ? 'display:none;' : '' }}">
        <table class="schedule-table-grid">
            <thead>
                <tr>
                    <th class="time-head">Time</th>
                    @foreach($days as $day)
                        <th>{{ strtoupper($day) }}</th>
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
                                        <strong>{{ $slot->subject->name }}</strong><br>
                                        <span>{{ $slot->teacher->user->name }}</span>
                                    </div>
                                @else
                                    <div class="empty-slot" style="cursor:default;"></div>
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
                            <td colspan="6"><i class="fa-regular fa-clock"></i> 10 MIN BREAK ({{ $breakStart }} - {{ $breakEnd }})</td>
                        </tr>
                    @endif
                @endfor
            </tbody>
        </table>
    </div>
    @endforeach
@endif

<div class="data-card" style="margin-top:24px;">
    <div class="data-card-header"><h3>Upcoming Exams</h3></div>
    <table class="data-table">
        <thead>
            <tr>
                <th>Exam</th><th>Subject</th><th>Type</th><th>Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($exams as $exam)
                <tr>
                    <td>{{ $exam->title }}</td>
                    <td>{{ $exam->subject->name ?? '—' }}</td>
                    <td><span class="badge">{{ ucfirst($exam->exam_type) }}</span></td>
                    <td>{{ $exam->exam_date ? \Carbon\Carbon::parse($exam->exam_date)->format('M d, Y') : '—' }}</td>
                </tr>
            @empty
                <tr><td colspan="4" style="text-align:center;color:#8a94a6;">No exams scheduled yet.</td></tr>
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