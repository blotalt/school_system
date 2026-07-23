@extends('layouts.teacher')

@section('content')
<x-page-header>
    <div>
        <h1>Schedule</h1>
        <p>Academic Year 2025–2026 · Semester 1 · Submit your preferred teaching slots for admin approval.</p>
    </div>
    <div style="display:flex;gap:10px;">
        @if($myPending > 0)
            <span style="background:#fef3c7;color:#92400e;padding:6px 14px;border-radius:20px;font-size:13px;font-weight:600;">
                {{ $myPending }} Pending
            </span>
        @endif
        @if($myRejected > 0)
            <span style="background:#fef2f2;color:#ef4444;padding:6px 14px;border-radius:20px;font-size:13px;font-weight:600;">
                {{ $myRejected }} Rejected
            </span>
        @endif
    </div>
</x-page-header>

@if(session('success'))
    <div style="margin-bottom:16px;padding:12px 16px;background:#e6f9f0;border:1px solid #10b981;border-radius:10px;color:#0a7a4d;">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div style="margin-bottom:16px;padding:12px 16px;background:#fdecea;border:1px solid #f5b7b1;border-radius:10px;color:#c0392b;">{{ session('error') }}</div>
@endif

@if($classes->isEmpty())
    <div class="data-card" style="padding:40px;text-align:center;color:#9ca3af;">
        You have no classes assigned yet. Contact admin to get assigned to classes.
    </div>
@else

<div style="display:flex;gap:20px;align-items:flex-end;margin-bottom:16px;flex-wrap:wrap;">
    <form method="GET" action="{{ route('teacher.schedule.index') }}">
        <div class="header-group">
            <label>SELECT CLASS</label>
            <select name="class" class="filter-select" onchange="this.form.submit()">
                @foreach($classes as $c)
                    <option value="{{ $c->id }}" {{ $class?->id === $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                @endforeach
            </select>
        </div>
    </form>
    <div class="header-group">
        <label>SHIFT</label>
        <div class="shift-toggle">
            <button type="button" class="shift-btn active" data-shift="morning">Morning</button>
            <button type="button" class="shift-btn" data-shift="afternoon">Afternoon</button>
        </div>
    </div>
</div>

<div style="display:flex;gap:16px;margin-bottom:16px;font-size:13px;flex-wrap:wrap;">
    <span style="display:flex;align-items:center;gap:6px;"><span style="width:14px;height:14px;border-radius:3px;background:#d1fae5;display:inline-block;"></span> Approved (others)</span>
    <span style="display:flex;align-items:center;gap:6px;"><span style="width:14px;height:14px;border-radius:3px;background:#bfdbfe;display:inline-block;"></span> Your pending</span>
    <span style="display:flex;align-items:center;gap:6px;"><span style="width:14px;height:14px;border-radius:3px;background:#fecaca;display:inline-block;"></span> Your rejected</span>
    <span style="display:flex;align-items:center;gap:6px;"><span style="width:14px;height:14px;border-radius:3px;background:#f3f4f6;border:1px dashed #d1d5db;display:inline-block;"></span> Available</span>
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
                                @if($slot->status === 'approved')
                                    @if($slot->teacher_id === $teacher->id)
                                        @php $colorClass = $subjectColors[$slot->subject->name] ?? 'default'; @endphp
                                        <div class="subject-card subject-{{ $colorClass }}">
                                            <strong>{{ $slot->subject->name }}</strong><br>
                                            <small>✓ Approved</small>
                                        </div>
                                    @else
                                        <div class="subject-card subject-default" style="opacity:.65;">
                                            <strong>{{ $slot->subject->name }}</strong><br>
                                            <small>{{ $slot->teacher->user->name }}</small>
                                        </div>
                                    @endif
                                @elseif($slot->status === 'pending' && $slot->teacher_id === $teacher->id)
                                    <div style="background:#dbeafe;border-radius:8px;padding:8px;font-size:13px;text-align:center;">
                                        <strong>{{ $slot->subject->name }}</strong><br>
                                        <span style="color:#1d4ed8;font-size:12px;">⏳ Pending</span>
                                        <form method="POST" action="{{ route('teacher.schedule.destroy', $slot) }}" style="margin-top:4px;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="background:none;border:none;color:#ef4444;cursor:pointer;font-size:11px;">Cancel</button>
                                        </form>
                                    </div>
                                @elseif($slot->status === 'rejected' && $slot->teacher_id === $teacher->id)
                                    <div style="background:#fecaca;border-radius:8px;padding:8px;font-size:12px;text-align:center;">
                                        <strong>{{ $slot->subject->name }}</strong><br>
                                        <span style="color:#b91c1c;font-size:12px;">✗ Rejected</span>
                                        @if($slot->rejection_note)
                                            <br><em style="font-size:11px;">{{ $slot->rejection_note }}</em>
                                        @endif
                                        <form method="POST" action="{{ route('teacher.schedule.destroy', $slot) }}" style="margin-top:4px;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="background:none;border:none;color:#7f1d1d;cursor:pointer;font-size:11px;text-decoration:underline;">Remove & Resubmit</button>
                                        </form>
                                    </div>
                                @else
                                    <div class="empty-slot" style="cursor:default;opacity:.3;"></div>
                                @endif
                            @else
                                <div class="empty-slot" onclick="openSlotModal({{ $period }}, '{{ $day }}', '{{ $shiftKey }}')">
                                    <i class="fa-solid fa-plus"></i>
                                </div>
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

<div id="slotModal" class="slot-modal-overlay" style="display:none;">
    <form class="slot-modal" method="POST" action="{{ route('teacher.schedule.store') }}">
        @csrf
        <h3>Request Schedule Slot</h3>
        <input type="hidden" name="class_id" value="{{ $class?->id }}">
        <input type="hidden" name="day_of_week" id="modalDay">
        <input type="hidden" name="period" id="modalPeriod">
        <input type="hidden" name="shift" id="modalShift">

        <div class="form-group">
            <label>Class</label>
            <input type="text" value="{{ $class?->name }}" disabled style="background:#f3f4f6;">
        </div>

        <div class="form-group">
            <label>Subject</label>
            <select name="subject_id" required>
                <option value="">Select your subject</option>
                @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Time Slot</label>
            <input type="text" id="slotLabel" disabled style="background:#f3f4f6;">
        </div>

        <p style="font-size:13px;color:#6b7280;">This will be submitted for admin approval.</p>

        <div class="form-actions">
            <button type="button" class="cancel-btn" onclick="document.getElementById('slotModal').style.display='none'">Cancel</button>
            <button type="submit" class="save-btn">Submit Request</button>
        </div>
    </form>
</div>

@endif

<script>
const periodTimes = @json($periodTimes);

function openSlotModal(period, day, shift) {
    document.getElementById('modalDay').value = day;
    document.getElementById('modalPeriod').value = period;
    document.getElementById('modalShift').value = shift;
    document.getElementById('slotLabel').value = day + ' — P' + period + ' (' + periodTimes[shift][period] + ')';
    document.getElementById('slotModal').style.display = 'flex';
}

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