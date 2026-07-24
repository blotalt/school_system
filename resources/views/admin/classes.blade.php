@extends('layouts.admin')

@section('content')
<x-page-header>
    <div>
        <h1>{{ __('admin.classes.title') }}</h1>
        <p>{{ $class ? __('admin.classes.subtitle', ['name' => $class->displayName()]) : __('admin.classes.no_classes_yet') }}</p>
    </div>
    @if($class)
    <div style="display:flex;gap:16px;align-items:flex-end;flex-wrap:wrap;">
        <form method="GET" action="{{ route('admin.classes.index') }}">
            <div class="header-group">
                <label>{{ __('admin.classes.select_class') }}</label>
                <select name="class" class="filter-select" onchange="this.form.submit()">
                    @foreach($classes as $c)
                        <option value="{{ $c->id }}" {{ $class->id === $c->id ? 'selected' : '' }}>
    {{ $c->displayName() }}
                            @if($c->schedule_approved_at) ✓ @endif
                        </option>
                    @endforeach
                </select>
            </div>
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

@if(session('success'))
    <div style="margin-bottom:16px;padding:12px 16px;background:#e6f9f0;border:1px solid #10b981;border-radius:10px;color:#0a7a4d;">{{ session('success') }}</div>
@endif
@if($errors->any())
    <div style="margin-bottom:16px;padding:12px 16px;background:#fdecea;border:1px solid #f5b7b1;border-radius:10px;color:#c0392b;">{{ $errors->first() }}</div>
@endif

@if(!$class)
    <div class="data-card" style="padding:40px;text-align:center;color:#9ca3af;">
        No classes yet. <a href="{{ route('admin.classes.create') }}">Create one</a>.
    </div>
@else

{{-- Status Bar --}}
<div style="display:flex;align-items:center;gap:12px;margin-bottom:20px;flex-wrap:wrap;padding:14px 18px;background:#fff;border-radius:12px;border:1px solid #e5e9f2;">
    @if($class->schedule_approved_at)
        <span style="display:flex;align-items:center;gap:6px;background:#d1fae5;color:#065f46;border:1px solid #10b981;border-radius:8px;padding:6px 14px;font-size:13px;font-weight:600;">
            <i class="fa-solid fa-circle-check"></i>Approved — Published to teachers
        </span>
        <form method="POST" action="{{ route('admin.classes.schedule.unapprove', $class) }}">
            @csrf
            <button type="submit" class="cancel-btn" style="font-size:13px;">
                <i class="fa-solid fa-rotate-left"></i>Revert to Draft
            </button>
        </form>
    @else
        <span style="display:flex;align-items:center;gap:6px;background:#fef3c7;color:#92400e;border:1px solid #f59e0b;border-radius:8px;padding:6px 14px;font-size:13px;font-weight:600;">
            <i class="fa-regular fa-clock"></i> Draft — Not visible to teachers yet
        </span>
        <form method="POST" action="{{ route('admin.classes.schedule.approve', $class) }}">
            @csrf
            <button type="submit" class="save-btn" style="font-size:13px;">
                <i class="fa-solid fa-circle-check"></i> Approve & Publish
            </button>
        </form>
    @endif

    <div style="margin-left:auto;display:flex;gap:12px;">
        <button type="button" id="editBtn" class="add-btn" onclick="enterEditMode()">
            <i class="fa-solid fa-pen"></i> Edit Schedule
        </button>
        <button type="button" id="exitEditBtn" class="cancel-btn" style="display:none;" onclick="exitEditMode()">
            Done Editing
        </button>
    </div>
</div>

{{-- Legend --}}
<div style="display:flex;gap:16px;font-size:12px;color:#6b7280;margin-bottom:12px;flex-wrap:wrap;">
    <span><span style="display:inline-block;width:10px;height:10px;border-radius:3px;background:#f59e0b;margin-right:4px;"></span>Preferred</span>
    <span><span style="display:inline-block;width:10px;height:10px;border-radius:3px;background:#10b981;margin-right:4px;"></span>Available</span>
    <span><span style="display:inline-block;width:10px;height:10px;border-radius:3px;background:#e5e9f2;border:1px solid #d1d5db;margin-right:4px;"></span>No data</span>
    <span><span style="display:inline-block;width:10px;height:10px;border-radius:3px;background:#fecaca;margin-right:4px;"></span>Conflict (teaching elsewhere)</span>
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
                                    <strong>{{ $slot->subject->displayName() }}</strong><br>
                                    <span>{{ explode(' ', $slot->teacher->user->displayName())[0] }}</span>
                                    <form action="{{ route('admin.classes.schedule.destroy', [$class, $slot]) }}" method="POST"
                                          class="edit-only-delete" style="display:none;position:absolute;top:2px;right:2px;"
                                          onsubmit="return confirm('Remove this slot?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="background:none;border:none;cursor:pointer;color:inherit;opacity:.7;">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                    </form>
                                </div>
                            @else
                                <div class="avail-slot"
                                     data-period="{{ $period }}"
                                     data-day="{{ $day }}"
                                     data-shift="{{ $shiftKey }}"
                                     onclick="openSlotModal({{ $period }}, '{{ $day }}', '{{ $shiftKey }}')">
                                    <div class="avail-chips" id="chips-{{ $shiftKey }}-{{ $day }}-{{ $period }}"></div>
                                    <i class="fa-solid fa-plus avail-plus"></i>
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
                        <td colspan="{{ count($days) + 1 }}">
                            <i class="fa-regular fa-clock"></i>
                            {{ __('admin.classes.break_label', ['start' => $breakStart, 'end' => $breakEnd]) }}
                        </td>
                    </tr>
                @endif
            @endfor
        </tbody>
    </table>
</div>
@endforeach

{{-- Assign Modal --}}
<div id="slotModal" class="slot-modal-overlay" style="display:none;">
    <form class="slot-modal" method="POST" id="slotForm" action="" style="width:520px;max-height:90vh;overflow-y:auto;">
        @csrf
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
            <h3 style="margin:0;">Assign Slot</h3>
            <span id="slotLabel" style="font-size:13px;color:#6b7280;background:#f3f4f6;padding:4px 10px;border-radius:6px;"></span>
        </div>
        <input type="hidden" name="day_of_week" id="modalDay">
        <input type="hidden" name="period" id="modalPeriod">
        <input type="hidden" name="shift" id="modalShift">
        <input type="hidden" name="teacher_id" id="modalTeacherId">

        <div class="form-group">
            <label>Subject</label>
            <select name="subject_id" id="modalSubject" required onchange="renderTeacherList()">
                <option value="">Select a subject</option>
                @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}">{{ $subject->displayName() }}</option>
                @endforeach
            </select>
        </div>

        <div style="margin-bottom:8px;">
            <label style="font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:8px;">Select Teacher</label>
            <div style="display:flex;gap:12px;font-size:11px;color:#6b7280;margin-bottom:8px;flex-wrap:wrap;">
                <span><span style="display:inline-block;width:8px;height:8px;border-radius:2px;background:#f59e0b;margin-right:3px;"></span>Preferred</span>
                <span><span style="display:inline-block;width:8px;height:8px;border-radius:2px;background:#10b981;margin-right:3px;"></span>Available</span>
                <span><span style="display:inline-block;width:8px;height:8px;border-radius:2px;background:#e5e9f2;margin-right:3px;"></span>No data</span>
                <span><span style="display:inline-block;width:8px;height:8px;border-radius:2px;background:#fecaca;margin-right:3px;"></span>Conflict</span>
            </div>
            <div id="teacherList" style="display:flex;flex-direction:column;gap:6px;max-height:300px;overflow-y:auto;"></div>
        </div>

        <div class="form-actions" style="margin-top:16px;">
            <button type="button" class="cancel-btn" onclick="closeSlotModal()">Cancel</button>
            <button type="submit" class="save-btn" id="assignBtn" disabled>Assign</button>
        </div>
    </form>
</div>

<style>
.avail-slot {
    min-height: 56px; border: 1px dashed #d1d5db; border-radius: 8px;
    display: flex; flex-direction: column; align-items: center;
    justify-content: center; gap: 4px; cursor: default; padding: 6px;
    transition: background .15s;
}
.grid-editing .avail-slot { cursor: pointer; }
.grid-editing .avail-slot:hover { background: #f0f9ff; border-color: #93c5fd; }
.avail-plus { color: #d1d5db; font-size: 12px; display: none; }
.grid-editing .avail-plus { display: block; }
.avail-chips { display: flex; flex-wrap: wrap; gap: 3px; justify-content: center; }
.avail-chip {
    border-radius: 5px; padding: 2px 7px;
    font-size: 11px; font-weight: 600; white-space: nowrap;
}
.avail-chip.preferred   { background: #fef3c7; color: #92400e; border: 1px solid #f59e0b; }
.avail-chip.available   { background: #d1fae5; color: #065f46; border: 1px solid #10b981; }
.avail-chip.no_data     { background: #f3f4f6; color: #6b7280; border: 1px solid #e5e9f2; }
.avail-chip.conflict    { background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; }
.teacher-row {
    display: flex; align-items: center; gap: 10px;
    padding: 10px 12px; border-radius: 10px; border: 2px solid #e5e9f2;
    cursor: pointer; transition: all .15s;
}
.teacher-row:hover:not(.dimmed) { border-color: #93c5fd; background: #f0f9ff; }
.teacher-row.selected { border-color: #1e40af; background: #eff6ff; }
.teacher-row.dimmed { opacity: .4; cursor: not-allowed; pointer-events: none; }
.t-avatar {
    width: 34px; height: 34px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 11px; font-weight: 700; color: #fff; flex-shrink: 0;
}
.t-avatar.preferred  { background: #f59e0b; }
.t-avatar.available  { background: #10b981; }
.t-avatar.no_data    { background: #9ca3af; }
.t-avatar.conflict   { background: #ef4444; }
.avail-badge {
    margin-left: auto; font-size: 11px; font-weight: 600;
    padding: 2px 8px; border-radius: 20px; white-space: nowrap;
}
.avail-badge.preferred  { background: #fef3c7; color: #92400e; }
.avail-badge.available  { background: #d1fae5; color: #065f46; }
.avail-badge.no_data    { background: #f3f4f6; color: #9ca3af; }
.avail-badge.conflict   { background: #fef2f2; color: #b91c1c; }
</style>

<script>
    const SUBJECT_DISPLAY_MAP = @json($subjects->mapWithKeys(fn($s) => [$s->id => $s->displayName()]));
const AVAILABILITY_MAP  = @json($availabilityMap ?? []);
const ALL_ASSIGNED      = @json($allAssignedSlots ?? []);
const TEACHER_DATA      = @json($teacherData ?? []);
const PERIOD_TIMES      = @json($periodTimes);

let editMode = false;
let currentSlotKey = null;
let selectedTeacherId = null;

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

function getAvailability(teacherId, slotKey) {
    const assigned = ALL_ASSIGNED[teacherId] ?? [];
    if (assigned.includes(slotKey)) return 'conflict';
    return AVAILABILITY_MAP[teacherId]?.[slotKey] ?? 'no_data';
}

function availOrder(status) {
    return { preferred: 0, available: 1, no_data: 2, unavailable: 3, conflict: 4 }[status] ?? 2;
}

function renderChips() {
    document.querySelectorAll('.avail-slot').forEach(cell => {
        const key = `${cell.dataset.shift}-${cell.dataset.day}-${cell.dataset.period}`;
        const container = document.getElementById(`chips-${cell.dataset.shift}-${cell.dataset.day}-${cell.dataset.period}`);
        if (!container) return;

        const teachers = TEACHER_DATA
            .map(t => ({ ...t, avail: getAvailability(t.id, key) }))
            .filter(t => t.avail !== 'conflict' && t.avail !== 'unavailable')
            .sort((a, b) => availOrder(a.avail) - availOrder(b.avail))
            .slice(0, 4);

        container.innerHTML = '';
        teachers.forEach(t => {
            const chip = document.createElement('div');
            chip.className = `avail-chip ${t.avail}`;
            chip.title = `${t.name} — ${t.avail}`;
            chip.textContent = t.firstname;
            container.appendChild(chip);
        });

        const totalAvail = TEACHER_DATA.filter(t => {
            const a = getAvailability(t.id, key);
            return a !== 'conflict' && a !== 'unavailable' && a !== 'no_data';
        }).length;

        if (totalAvail > 4) {
            const more = document.createElement('div');
            more.className = 'avail-chip no_data';
            more.textContent = `+${totalAvail - 4}`;
            container.appendChild(more);
        }
    });
}

function openSlotModal(period, day, shift) {
    if (!editMode) return;
    currentSlotKey = `${shift}-${day}-${period}`;
    selectedTeacherId = null;
    document.getElementById('modalPeriod').value = period;
    document.getElementById('modalDay').value = day;
    document.getElementById('modalShift').value = shift;
    document.getElementById('modalTeacherId').value = '';
    document.getElementById('assignBtn').disabled = true;
    document.getElementById('slotForm').action = "{{ route('admin.classes.schedule.store', $class) }}";
    document.getElementById('slotLabel').textContent = `${day} · P${period} · ${PERIOD_TIMES[shift][period]}`;
    document.getElementById('modalSubject').value = '';
    renderTeacherList();
    document.getElementById('slotModal').style.display = 'flex';
}

function closeSlotModal() {
    document.getElementById('slotModal').style.display = 'none';
    currentSlotKey = null;
    selectedTeacherId = null;
}

function renderTeacherList() {
    const subjectId = parseInt(document.getElementById('modalSubject').value) || null;
    const list = document.getElementById('teacherList');
    list.innerHTML = '';

    const teachers = TEACHER_DATA
        .map(t => ({
            ...t,
            avail: getAvailability(t.id, currentSlotKey),
            matchesSubject: !subjectId || t.subjects.includes(subjectId),
        }))
        .sort((a, b) => {
            if (a.matchesSubject !== b.matchesSubject) return a.matchesSubject ? -1 : 1;
            return availOrder(a.avail) - availOrder(b.avail);
        });

    teachers.forEach(t => {
        const isConflict = t.avail === 'conflict';
        const dimmed = !t.matchesSubject || isConflict;
        const badgeLabels = {
            preferred: '★ Preferred', available: '✓ Available',
            no_data: '— No data', unavailable: '✗ Unavailable',
            conflict: '⚠ Teaching elsewhere',
        };

        const row = document.createElement('div');
        row.className = `teacher-row${dimmed ? ' dimmed' : ''}`;
        row.dataset.teacherId = t.id;
        row.innerHTML = `
            <div class="t-avatar ${t.avail}">${t.firstname.charAt(0)}</div>
            <div style="flex:1;min-width:0;">
                <div style="font-weight:600;font-size:13px;">${t.name}</div>
                <div style="font-size:12px;color:#9ca3af;">${SUBJECT_DISPLAY_MAP[t.subjects[0]] || 'No specialty'}</div>
            </div>
            <span class="avail-badge ${t.avail}">${badgeLabels[t.avail] ?? '—'}</span>
        `;

        if (!dimmed) {
            row.addEventListener('click', () => {
                document.querySelectorAll('.teacher-row').forEach(r => r.classList.remove('selected'));
                row.classList.add('selected');
                selectedTeacherId = t.id;
                document.getElementById('modalTeacherId').value = t.id;
                document.getElementById('assignBtn').disabled = !document.getElementById('modalSubject').value;
            });
        }
        list.appendChild(row);
    });
}

document.getElementById('modalSubject').addEventListener('change', function() {
    document.getElementById('assignBtn').disabled = !(this.value && selectedTeacherId);
    renderTeacherList();
});

document.querySelectorAll('.shift-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.shift-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        document.querySelectorAll('.shift-grid').forEach(g => {
            g.style.display = (g.dataset.shift === this.dataset.shift) ? 'block' : 'none';
        });
    });
});

renderChips();
</script>
@endif
@endsection