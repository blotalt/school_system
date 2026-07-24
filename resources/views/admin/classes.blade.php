@extends('layouts.admin')

@section('content')
<x-page-header>
    <div>
        <h1>{{ __('admin.classes.title') }}</h1>
        <p>{{ $class ? __('admin.classes.subtitle', ['name' => $class->name]) : __('admin.classes.no_classes_yet') }}</p>
    </div>
    @if($class)
    <div style="display:flex;gap:20px;align-items:flex-end;">
        <form method="GET" action="{{ route('admin.classes.index') }}" id="classSwitchForm">
            <div class="header-group">
                <label>{{ __('admin.classes.select_class') }}</label>
                <select name="class" class="filter-select" onchange="this.form.submit()">
                    @foreach($classes as $c)
                        <option value="{{ $c->id }}" {{ $class->id === $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>
            <input type="hidden" name="shift" id="shiftInput" value="morning">
        </form>
        <div class="header-group">
            <label>{{ __('admin.classes.shift_selection') }}</label>
            <div class="shift-toggle">
                <button type="button" class="shift-btn active" data-shift="morning">{{ __('admin.classes.morning_shift') }}</button>
                <button type="button" class="shift-btn" data-shift="afternoon">{{ __('admin.classes.afternoon_shift') }}</button>
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
        {{ __('admin.classes.no_classes_message') }} <a href="{{ route('admin.classes.create') }}">{{ __('admin.classes.create_one') }}</a> {{ __('admin.classes.to_build_schedule') }}
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
    <i class="fa-solid fa-pen"></i> {{ __('admin.classes.edit_schedule') }}
</button>
<button type="button" id="exitEditBtn" class="cancel-btn" style="margin:16px 0 16px 10px;display:none;" onclick="exitEditMode()">
    {{ __('admin.classes.done_editing') }}
</button>

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
                        <td colspan="{{ count($days) + 1 }}"><i class="fa-regular fa-clock"></i> {{ __('admin.classes.break_label', ['start' => $breakStart, 'end' => $breakEnd]) }}</td>
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
        <h3>{{ __('admin.classes.add_subject_modal') }}</h3>
        <input type="hidden" name="day_of_week" id="modalDay">
        <input type="hidden" name="period" id="modalPeriod">
        <input type="hidden" name="shift" id="modalShift">
        <div class="form-group">
            <label>{{ __('common.subject') }}</label>
            <select name="subject_id" id="modalSubject" required onchange="filterTeachersBySubject()">
                <option value="">{{ __('admin.classes.select_a_subject') }}</option>
                @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>{{ __('common.teacher') }}</label>
            <select name="teacher_id" id="modalTeacher" required>
                @foreach($teachers as $teacher)
                    <option value="{{ $teacher->id }}" data-subjects="{{ $teacher->subjects->pluck('id')->implode(',') }}">{{ $teacher->user->name }}</option>
                @endforeach
            </select>
            <span id="teacherHint" style="display:none;color:#9ca3af;font-size:13px;margin-top:4px;">{{ __('admin.classes.no_teacher_hint') }}</span>
        </div>
        <div class="form-actions">
            <button type="button" class="cancel-btn" onclick="closeSlotModal()">{{ __('common.cancel') }}</button>
            <button type="submit" class="save-btn">{{ __('common.add') }}</button>
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
    document.getElementById('modalSubject').value = '';
    filterTeachersBySubject();
    document.getElementById('slotModal').style.display = 'flex';
}

function closeSlotModal() {
    document.getElementById('slotModal').style.display = 'none';
}

function filterTeachersBySubject() {
    const subjectId = document.getElementById('modalSubject').value;
    const teacherSelect = document.getElementById('modalTeacher');
    const options = Array.from(teacherSelect.options);
    const hint = document.getElementById('teacherHint');

    if (!subjectId) {
        options.forEach(opt => opt.hidden = false);
        hint.style.display = 'none';
        return;
    }

    const matching = options.filter(opt => (opt.dataset.subjects || '').split(',').includes(subjectId));

    if (matching.length === 0) {
        // No teacher assigned to this subject yet — fall back to showing everyone.
        options.forEach(opt => opt.hidden = false);
        hint.style.display = 'block';
        return;
    }

    hint.style.display = 'none';
    options.forEach(opt => opt.hidden = !matching.includes(opt));

    if (matching.length >= 1 && !matching.some(opt => opt.selected)) {
        teacherSelect.value = matching[0].value;
    }
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
