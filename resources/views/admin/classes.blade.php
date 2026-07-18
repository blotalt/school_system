@extends('layouts.admin')

@section('content')
<x-page-header>
    <div>
        <h1>Class Timetable - Weekly Grid</h1>
        <p>{{ $class ? "Managing {$class->name} weekly schedule" : 'No classes yet.' }}</p>
    </div>
    @if($class)
    <div style="display:flex;gap:20px;align-items:flex-end;">
        <form method="GET" action="{{ route('admin.classes.index') }}" id="classSwitchForm">
            <div class="header-group">
                <label>SELECT CLASS</label>
                <select name="class" class="filter-select" onchange="this.form.submit()">
                    @foreach($classes as $c)
                        <option value="{{ $c->id }}" {{ $class->id === $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>
            <input type="hidden" name="shift" id="shiftInput" value="morning">
        </form>
        <div class="header-group">
            <label>SHIFT SELECTION</label>
            <div class="shift-toggle">
                <button type="button" class="shift-btn active" data-shift="morning">Morning shift</button>
                <button type="button" class="shift-btn" data-shift="afternoon">Afternoon shift</button>
            </div>
        </div>
    </div>
    @endif
</x-page-header>

@if (session('success'))
    <div class="alert alert-success" style="margin-bottom:16px;padding:12px 16px;background:#e6f9f0;border:1px solid #10b981;border-radius:10px;color:#0a7a4d;">
        {{ session('success') }}
    </div>
@endif
@if ($errors->any())
    <div class="alert alert-error" style="margin-bottom:16px;padding:12px 16px;background:#fdecea;border:1px solid #f5b7b1;border-radius:10px;color:#c0392b;">
        {{ $errors->first() }}
    </div>
@endif

@if(!$class)
    <div class="data-card" style="padding:40px;text-align:center;color:#9ca3af;">
        No classes exist yet. <a href="{{ route('admin.classes.create') }}">Create one</a> to build its schedule.
    </div>
@else

@php
$subjectColors = [
    'Mathematics' => 'math', 'Physics' => 'physics', 'Biology' => 'biology',
    'Chemistry' => 'chemistry', 'English' => 'english', 'History' => 'history',
    'Geography' => 'geography', 'Computer Science' => 'computerscience',
];
@endphp

<button type="button" id="editBtn" class="add-btn" style="margin:16px 0;" onclick="enterEditMode()">
    <i class="fa-solid fa-pen"></i> Edit Schedule
</button>
<button type="button" id="exitEditBtn" class="cancel-btn" style="margin:16px 0 16px 10px;display:none;" onclick="exitEditMode()">
    Done Editing
</button>

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
                                <div class="subject-card subject-{{ $colorClass }}" style="position:relative;">
                                    <strong>{{ $slot->subject->name }}</strong><br>
                                    <span>{{ collect(explode(' ', $slot->teacher->user->name))->map(fn($n) => mb_substr($n, 0, 1))->take(2)->implode('') }}</span>
                                    <form action="{{ route('admin.classes.schedule.destroy', [$class, $slot]) }}" method="POST" class="edit-only-delete" style="display:none;position:absolute;top:2px;right:2px;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Clear slot" style="background:none;border:none;cursor:pointer;color:inherit;opacity:.6;">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                    </form>
                                </div>
                            @else
                                <div class="empty-slot" onclick="openSlotModal({{ $period }}, '{{ $day }}', '{{ $shiftKey }}')"><i class="fa-solid fa-plus"></i></div>
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

<!-- Add Subject Modal -->
<div id="slotModal" class="slot-modal-overlay" style="display:none;">
    <form class="slot-modal" method="POST" id="slotForm" action="">
        @csrf
        <h3>Add Subject</h3>
        <input type="hidden" name="day_of_week" id="modalDay">
        <input type="hidden" name="period" id="modalPeriod">
        <input type="hidden" name="shift" id="modalShift">
        <div class="form-group">
            <label>Subject</label>
            <select name="subject_id" required>
                @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Teacher</label>
            <select name="teacher_id" required>
                @foreach($teachers as $teacher)
                    <option value="{{ $teacher->id }}">{{ $teacher->user->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-actions">
            <button type="button" class="cancel-btn" onclick="closeSlotModal()">Cancel</button>
            <button type="submit" class="save-btn">Add</button>
        </div>
    </form>
</div>

<script>
let editMode = false;

function enterEditMode() {
    editMode = true;
    document.getElementById('editBtn').style.display = 'none';
    document.getElementById('exitEditBtn').style.display = 'inline-flex';
    document.body.classList.add('grid-editing');
    document.querySelectorAll('.edit-only-delete').forEach(el => el.style.display = 'block');
}

function exitEditMode() {
    editMode = false;
    document.getElementById('editBtn').style.display = 'inline-flex';
    document.getElementById('exitEditBtn').style.display = 'none';
    document.body.classList.remove('grid-editing');
    document.querySelectorAll('.edit-only-delete').forEach(el => el.style.display = 'none');
}

function openSlotModal(period, day, shift) {
    if (!editMode) return;
    document.getElementById('modalPeriod').value = period;
    document.getElementById('modalDay').value = day;
    document.getElementById('modalShift').value = shift;
    document.getElementById('slotForm').action = "{{ route('admin.classes.schedule.store', $class) }}";
    document.getElementById('slotModal').style.display = 'flex';
}

function closeSlotModal() {
    document.getElementById('slotModal').style.display = 'none';
}

document.querySelectorAll('.shift-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.shift-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');

        const shift = this.dataset.shift;
        document.getElementById('shiftInput').value = shift;
        document.querySelectorAll('.shift-grid').forEach(grid => {
            grid.style.display = (grid.dataset.shift === shift) ? 'block' : 'none';
        });
    });
});
</script>
@endif
@endsection
