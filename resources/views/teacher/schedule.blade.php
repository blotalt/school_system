@extends('layouts.teacher')

@section('content')
<div class="profile-page">
    <div class="profile-header">
        <h1>{{ __('teacher.schedule.title') }}</h1>
        <p>{{ __('teacher.schedule.official_subtitle') }}</p>
    </div>

@if(session('success'))
    <div class="alert alert-success" style="margin-bottom:16px;padding:12px 16px;background:#e6f9f0;border:1px solid #10b981;border-radius:10px;color:#0a7a4d;">{{ session('success') }}</div>
@endif

@php
    $assignedSlots  = $mySchedules->values();
    $uniqueClasses  = $assignedSlots->map(fn($s) => $s->schoolClass)->filter()->unique('id')->values();
    $uniqueSubjects = $assignedSlots->map(fn($s) => $s->subject)->filter()->unique('id')->values();
    $totalHours     = $assignedSlots->count();
@endphp

{{-- Stats --}}
<div class="data-card" style="margin-bottom:24px;padding:20px 24px;">
    <div style="display:flex;gap:32px;flex-wrap:wrap;">
        <div>
            <div style="font-size:12px;font-weight:700;color:#9ca3af;letter-spacing:.05em;margin-bottom:8px;">{{ strtoupper(__('teacher.schedule.stat_classes_teaching')) }}</div>
            @if($uniqueClasses->isEmpty())
                <span style="color:#9ca3af;font-size:13px;">{{ __('teacher.schedule.no_classes_yet') }}</span>
            @else
                <div style="display:flex;flex-wrap:wrap;gap:6px;">
                    @foreach($uniqueClasses as $class)
                        <span style="background:#eff6ff;color:#1e40af;border:1px solid #bfdbfe;border-radius:6px;padding:4px 10px;font-size:13px;font-weight:600;">
                            {{ $class->displayName() }}{{ $class->displayTrack() }}
                            @if($class->schedule_approved_at)
                                <span style="color:#10b981;margin-left:4px;" title="Approved"><i class="fa-solid fa-circle-check"></i></span>
                            @else
                                <span style="color:#f59e0b;margin-left:4px;" title="{{ __('teacher.schedule.legend_pending') }}"><i class="fa-regular fa-clock"></i></span>
                            @endif
                        </span>
                    @endforeach
                </div>
            @endif
        </div>
        <div>
            <div style="font-size:12px;font-weight:700;color:#9ca3af;letter-spacing:.05em;margin-bottom:8px;">{{ strtoupper(__('common.subjects')) }}</div>
            @if($uniqueSubjects->isEmpty())
                <span style="color:#9ca3af;font-size:13px;">{{ __('teacher.schedule.no_classes_yet') }}</span>
            @else
                <div style="display:flex;flex-wrap:wrap;gap:6px;">
                    @foreach($uniqueSubjects as $subject)
                        <span style="background:#f0fdf4;color:#15803d;border:1px solid #86efac;border-radius:6px;padding:4px 10px;font-size:13px;font-weight:600;">
                            {{ $subject->displayName() }}
                        </span>
                    @endforeach
                </div>
            @endif
        </div>
        <div>
            <div style="font-size:12px;font-weight:700;color:#9ca3af;letter-spacing:.05em;margin-bottom:8px;">{{ strtoupper(__('teacher.schedule.stat_hours_week')) }}</div>
            <span style="font-size:22px;font-weight:700;color:#1a2235;">{{ $totalHours }}<span style="font-size:14px;color:#9ca3af;font-weight:400;margin-left:4px;">{{ __('teacher.schedule.hrs_unit') }}</span></span>
        </div>
    </div>
</div>

{{-- Official Schedule --}}
@if($assignedSlots->isEmpty())
    <div style="padding:16px;background:#fef3c7;border:1px solid #f59e0b;border-radius:10px;color:#92400e;margin-bottom:24px;font-size:13px;">
        <i class="fa-solid fa-triangle-exclamation"></i>
        {{ __('teacher.schedule.no_schedule_assigned') }}
    </div>
@else
    <div style="display:flex;gap:16px;align-items:center;margin-bottom:16px;flex-wrap:wrap;">
        <h3 style="margin:0;">{{ __('teacher.schedule.official_timetable') }}</h3>
        <div class="shift-toggle">
            <button type="button" class="shift-btn active" data-shift="morning">{{ __('teacher.schedule.morning') }}</button>
            <button type="button" class="shift-btn" data-shift="afternoon">{{ __('teacher.schedule.afternoon') }}</button>
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
    <div class="timetable-container shift-grid" data-shift="{{ $shiftKey }}" style="{{ $shiftKey === 'afternoon' ? 'display:none;' : '' }}margin-bottom:24px;">
        <table class="schedule-table-grid">
            <thead>
                <tr>
                    <th class="time-head">{{ __('teacher.schedule.time_col') }}</th>
                    @foreach($days as $day)
                        @php $dayTrans = __('common.days.' . $day); @endphp
                        <th>{{ is_string($dayTrans) ? mb_strtoupper($dayTrans) : strtoupper($day) }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @for($period = 1; $period <= 4; $period++)
                    <tr>
                        <td class="time-box">P{{ $period }}<br><small>{{ $periodTimes[$shiftKey][$period] }}</small></td>
                        @foreach($days as $day)
                            @php $slot = $mySchedules->get("{$shiftKey}-{$day}-{$period}"); @endphp
                            <td>
                                @if($slot)
                                    @php $colorClass = $subjectColors[$slot->subject->name] ?? 'default'; @endphp
                                    <div class="subject-card subject-{{ $colorClass }}">
                                        <strong>{{ $slot->subject->displayName() }}</strong><br>
                                        <span style="font-size:12px;">{{ $slot->schoolClass->name }}</span>
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
                            $breakEnd   = explode(' - ', $periodTimes[$shiftKey][$period + 1])[0];
                        @endphp
                        <tr class="break-row">
                            <td colspan="{{ count($days) + 1 }}"><i class="fa-regular fa-clock"></i> {{ __('teacher.schedule.break_label') }} ({{ $breakStart }} - {{ $breakEnd }})</td>
                        </tr>
                    @endif
                @endfor
            </tbody>
        </table>
    </div>
    @endforeach
@endif

{{-- Availability Section --}}
@if($scheduleApproved)
    <div style="margin-top:24px;padding:14px 18px;background:#d1fae5;border:1px solid #10b981;border-radius:10px;color:#065f46;font-size:13px;">
        <i class="fa-solid fa-circle-check"></i> {{ __('teacher.schedule.schedule_finalized') }}
    </div>
@else
    <div style="margin-top:32px;border-top:1px solid #e5e9f2;padding-top:24px;">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;flex-wrap:wrap;gap:12px;">
            <div>
                <h3 style="margin:0 0 4px;">{{ __('teacher.schedule.avail_title') }}</h3>
                <p style="margin:0;font-size:13px;color:#9ca3af;">{{ __('teacher.schedule.avail_subtitle') }}</p>
            </div>
            <div class="shift-toggle">
                <button type="button" class="shift-btn active" data-avail-shift="morning">{{ __('teacher.schedule.morning') }}</button>
                <button type="button" class="shift-btn" data-avail-shift="afternoon">{{ __('teacher.schedule.afternoon') }}</button>
            </div>
        </div>

        <div style="display:flex;gap:14px;font-size:12px;margin-bottom:12px;flex-wrap:wrap;">
            <span><span style="display:inline-block;width:10px;height:10px;border-radius:3px;background:#f59e0b;margin-right:4px;"></span>{{ __('teacher.schedule.preferred') }}</span>
            <span><span style="display:inline-block;width:10px;height:10px;border-radius:3px;background:#10b981;margin-right:4px;"></span>{{ __('teacher.schedule.available') }}</span>
            <span><span style="display:inline-block;width:10px;height:10px;border-radius:3px;background:#e5e9f2;margin-right:4px;"></span>{{ __('teacher.schedule.unavailable') }}</span>
            <span><span style="display:inline-block;width:10px;height:10px;border-radius:3px;background:#1e40af;margin-right:4px;"></span>{{ __('teacher.schedule.already_assigned') }}</span>
        </div>

        <form method="POST" action="{{ route('teacher.schedule.store') }}">
            @csrf

            @foreach(['morning', 'afternoon'] as $shiftKey)
            <div class="avail-shift-grid" data-avail-shift="{{ $shiftKey }}" style="{{ $shiftKey === 'afternoon' ? 'display:none;' : '' }}">
                <table class="schedule-table-grid">
                    <thead>
                        <tr>
                            <th class="time-head">{{ __('teacher.schedule.time_col') }}</th>
                            @foreach($days as $day)
                                @php $dayTrans = __('common.days.' . $day); @endphp
<th>{{ is_string($dayTrans) ? mb_strtoupper($dayTrans) : strtoupper($day) }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @for($period = 1; $period <= 4; $period++)
                            <tr>
                                <td class="time-box">P{{ $period }}<br><small>{{ $periodTimes[$shiftKey][$period] }}</small></td>
                                @foreach($days as $day)
                                    @php
                                        $key      = "{$shiftKey}-{$day}-{$period}";
                                        $assigned = $mySchedules->get($key);
                                        $avail    = $availability->get($key)?->status ?? 'unavailable';
                                    @endphp
                                    <td>
                                        @if($assigned)
                                            <div class="empty-slot" style="cursor:default;background:#f0f4ff;border:1px solid #e0e7ff;">
                                                <i class="fa-solid fa-check" style="color:#bfdbfe;font-size:11px;"></i>
                                            </div>
                                            <input type="hidden" name="availability[{{ $shiftKey }}][{{ $day }}][{{ $period }}]" value="{{ $avail }}">
                                        @else
                                            <div class="avail-cell {{ $avail }}" onclick="cycleAvailability(this)" data-status="{{ $avail }}">
                                                <span class="avail-label">{{ __('teacher.schedule.' . $avail) }}</span>
                                                <input type="hidden" name="availability[{{ $shiftKey }}][{{ $day }}][{{ $period }}]" value="{{ $avail }}">
                                            </div>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                            @if($period < 4)
                                @php
                                    $breakStart = explode(' - ', $periodTimes[$shiftKey][$period])[1];
                                    $breakEnd   = explode(' - ', $periodTimes[$shiftKey][$period + 1])[0];
                                @endphp
                                <tr class="break-row">
                                    <td colspan="{{ count($days) + 1 }}"><i class="fa-regular fa-clock"></i> {{ __('teacher.schedule.break_label') }} ({{ $breakStart }} - {{ $breakEnd }})</td>
                                </tr>
                            @endif
                        @endfor
                    </tbody>
                </table>
            </div>
            @endforeach

            <div style="margin-top:16px;display:flex;justify-content:flex-end;">
                <button type="submit" class="save-btn">
                    <i class="fa-solid fa-floppy-disk"></i> {{ __('teacher.schedule.save_availability') }}
                </button>
            </div>
        </form>
    </div>
@endif

</div>

<style>
.avail-cell {
    border-radius: 8px; padding: 10px 6px; text-align: center;
    cursor: pointer; font-size: 12px; font-weight: 600;
    transition: background .15s; min-height: 52px;
    display: flex; align-items: center; justify-content: center; user-select: none;
}
.avail-cell.unavailable { background: #f3f4f6; color: #9ca3af; border: 1px dashed #d1d5db; }
.avail-cell.available   { background: #d1fae5; color: #065f46; border: 1px solid #10b981; }
.avail-cell.preferred   { background: #fef3c7; color: #92400e; border: 1px solid #f59e0b; }
.avail-cell.preferred::before { content: '★ '; }
</style>

<script>
const AVAIL_LABELS = {
    unavailable: @json(__('teacher.schedule.unavailable')),
    available:   @json(__('teacher.schedule.available')),
    preferred:   @json(__('teacher.schedule.preferred')),
};
const CYCLE = ['unavailable', 'available', 'preferred'];

function cycleAvailability(cell) {
    const next = CYCLE[(CYCLE.indexOf(cell.dataset.status) + 1) % CYCLE.length];
    cell.dataset.status = next;
    cell.className = 'avail-cell ' + next;
    cell.querySelector('input[type=hidden]').value = next;
    cell.querySelector('.avail-label').textContent = AVAIL_LABELS[next];
}

document.querySelectorAll('.shift-btn[data-shift]').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.shift-btn[data-shift]').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        document.querySelectorAll('.shift-grid').forEach(g => {
            g.style.display = (g.dataset.shift === this.dataset.shift) ? 'block' : 'none';
        });
    });
});

document.querySelectorAll('.shift-btn[data-avail-shift]').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.shift-btn[data-avail-shift]').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        document.querySelectorAll('.avail-shift-grid').forEach(g => {
            g.style.display = (g.dataset.availShift === this.dataset.availShift) ? 'block' : 'none';
        });
    });
});
</script>
@endsection