@extends('layouts.teacher')

@section('content')
<x-page-header>
    <div>
        <h1>{{ __('teacher.schedule.title') }}</h1>
        <p>{{ $class ? __('teacher.schedule.subtitle', ['name' => $class->name]) : __('teacher.schedule.no_classes_yet') }}</p>
    </div>
    @if($class)
    <div style="display:flex;gap:20px;align-items:flex-end;">
        <form method="GET" action="{{ route('teacher.schedule.index') }}" id="classSwitchForm">
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
        {{ __('teacher.schedule.no_classes_yet') }}
    </div>
@else

@php
$subjectColors = [
    'Mathematics' => 'math', 'Physics' => 'physics', 'Biology' => 'biology',
    'Chemistry' => 'chemistry', 'English' => 'english', 'History' => 'history',
    'Geography' => 'geography', 'Computer Science' => 'computerscience',
];
@endphp

<div class="legend" style="display:flex;gap:20px;align-items:center;margin:16px 0;font-size:13px;color:#6b7280;">
    <span style="display:flex;align-items:center;gap:6px;"><span style="width:12px;height:12px;border-radius:4px;background:#eaf6ff;border:1px solid #90caf9;display:inline-block;"></span> {{ __('teacher.schedule.legend_filled') }}</span>
    <span style="display:flex;align-items:center;gap:6px;"><span style="width:12px;height:12px;border-radius:4px;background:#fffbeb;border:1px dashed #fcd34d;display:inline-block;"></span> {{ __('teacher.schedule.legend_pending') }}</span>
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
                        @php
                            $key = "{$shiftKey}-{$day}-{$period}";
                            $slot = $schedules->get($key);
                            $pending = $pendingRequests->get($key);
                        @endphp
                        <td>
                            @if($slot)
                                @php $colorClass = $subjectColors[$slot->subject->name] ?? 'default'; @endphp
                                <div class="subject-card subject-{{ $colorClass }}">
                                    <strong>{{ $slot->subject->name }}</strong><br>
                                    <span>{{ collect(explode(' ', $slot->teacher->user->name))->map(fn($n) => mb_substr($n, 0, 1))->take(2)->implode('') }}</span>
                                </div>
                            @elseif($pending && $pending->teacher_id === $teacher?->id)
                                <div class="subject-card pending-mine">
                                    <strong>{{ $pending->subject->name }}</strong>
                                    <span class="pending-badge">{{ __('teacher.schedule.pending_badge') }}</span>
                                    <form action="{{ route('teacher.schedule.destroy', $pending) }}" method="POST" onsubmit="return confirm('{{ __('teacher.schedule.cancel_confirm') }}');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="pending-cancel">{{ __('teacher.schedule.cancel') }}</button>
                                    </form>
                                </div>
                            @elseif($pending)
                                <div class="subject-card pending-locked">
                                    <span class="pending-badge">{{ __('teacher.schedule.pending_badge') }}</span>
                                </div>
                            @else
                                <div class="request-slot" onclick="openRequestModal({{ $period }}, '{{ $day }}', '{{ $shiftKey }}')"><i class="fa-solid fa-plus"></i></div>
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

<!-- Request Schedule Slot Modal -->
<div id="slotModal" class="slot-modal-overlay" style="display:none;">
    <form class="slot-modal" style="width:380px;" method="POST" id="slotForm" action="{{ route('teacher.schedule.store') }}">
        @csrf
        <h3>{{ __('teacher.schedule.request_modal_title') }}</h3>
        <input type="hidden" name="class_id" value="{{ $class->id }}">
        <input type="hidden" name="day_of_week" id="modalDay">
        <input type="hidden" name="period" id="modalPeriod">
        <input type="hidden" name="shift" id="modalShift">

        <div class="form-group">
            <label>{{ __('common.class') }}</label>
            <input type="text" value="{{ $class->name }}" disabled>
        </div>
        <div class="form-group">
            <label>{{ __('common.subject') }}</label>
            <select name="subject_id" id="modalSubject" required>
                <option value="">{{ __('teacher.schedule.select_your_subject') }}</option>
                @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>{{ __('teacher.schedule.time_slot') }}</label>
            <input type="text" id="modalTimeDisplay" disabled>
        </div>
        <p style="font-size:13px;color:#9ca3af;">{{ __('teacher.schedule.approval_notice') }}</p>
        <div class="form-actions">
            <button type="button" class="cancel-btn" onclick="closeSlotModal()">{{ __('common.cancel') }}</button>
            <button type="submit" class="save-btn">{{ __('teacher.schedule.submit_request') }}</button>
        </div>
    </form>
</div>

<script>
const DAY_LABELS = @json(collect($days)->mapWithKeys(fn($d) => [$d => __('common.days.' . $d)]));

function openRequestModal(period, day, shift) {
    document.getElementById('modalPeriod').value = period;
    document.getElementById('modalDay').value = day;
    document.getElementById('modalShift').value = shift;
    document.getElementById('modalSubject').value = '';

    const times = @json($periodTimes);
    const range = times[shift][period];
    document.getElementById('modalTimeDisplay').value = DAY_LABELS[day] + ' — P' + period + ' (' + range + ')';

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
