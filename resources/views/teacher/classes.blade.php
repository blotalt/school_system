@extends('layouts.teacher')

@section('content')
<x-page-header>
    <div>
        <h1>Class Timetable - Weekly Grid</h1>
        <p>Managing Grade 12 - Section A weekly schedule</p>
    </div>
    <div style="display:flex;gap:20px;align-items:flex-end;">
        <div class="header-group">
            <label>SELECT CLASS</label>
            <select class="filter-select">
                <option>Grade 12 - A</option>
                <option>Grade 12 - B</option>
                <option>Grade 11 - A</option>
                <option>Grade 11 - B</option>
            </select>
        </div>
        <div class="header-group">
            <label>SHIFT SELECTION</label>
            <div class="shift-toggle">
                <button type="button" class="shift-btn active" data-shift="morning">Morning shift</button>
                <button type="button" class="shift-btn" data-shift="afternoon">Afternoon shift</button>
            </div>
        </div>
        <button type="button" class="icon-only-btn"><i class="fa-solid fa-gear"></i></button>
    </div>
</x-page-header>

@php
$days = ['Monday','Tuesday','Wednesday','Thursday','Friday'];

$morningPeriods = [
    ['label' => 'P1', 'time' => '7:10 - 8:00', 'slots' => ['Chemistry|SK|chemistry','Math|BK|math','Chemistry|SK|chemistry','Math|BK|math', null]],
    ['break' => '10 MIN BREAK (8:00 - 8:10 AM)'],
    ['label' => 'P2', 'time' => '8:10 - 9:00', 'slots' => ['Khmer|SR|khmer','Physics|LV|physics','Physics|LV|physics','Khmer|SR|khmer','Math|BK|math']],
    ['break' => '10 MIN BREAK (9:00 - 9:10 AM)'],
    ['label' => 'P3', 'time' => '9:10 - 10:00', 'slots' => ['Math|BK|math','Biology|TM|biology', null, 'Physics|LV|physics','Biology|TM|biology']],
    ['break' => '10 MIN BREAK (10:00 - 10:10 AM)'],
    ['label' => 'P4', 'time' => '10:10 - 11:00', 'slots' => ['Physics|LV|physics','Khmer|SR|khmer','Math|BK|math','Chemistry|SK|chemistry','History|NN|khmer']],
];

$afternoonPeriods = [
    ['label' => 'P1', 'time' => '1:10 - 2:00', 'slots' => ['Chemistry|SK|chemistry','Math|BK|math','Chemistry|SK|chemistry','Math|BK|math', null]],
    ['break' => '10 MIN BREAK (8:00 - 8:10 AM)'],
    ['label' => 'P2', 'time' => '2:10 - 3:00', 'slots' => ['Khmer|SR|khmer','Physics|LV|physics','Physics|LV|physics','Khmer|SR|khmer','Math|BK|math']],
    ['break' => '10 MIN BREAK (9:00 - 9:10 AM)'],
    ['label' => 'P3', 'time' => '3:10 - 4:00', 'slots' => ['Math|BK|math','Biology|TM|biology', null, 'Physics|LV|physics','Biology|TM|biology']],
    ['break' => '10 MIN BREAK (10:00 - 10:10 AM)'],
    ['label' => 'P4', 'time' => '4:10 - 5:00', 'slots' => ['Physics|LV|physics','Khmer|SR|khmer','Math|BK|math','Chemistry|SK|chemistry','History|NN|khmer']],
];
@endphp

<button type="button" id="editBtn" class="add-btn" style="margin:16px 0;" onclick="enterEditMode()">
    <i class="fa-solid fa-pen"></i> Edit Schedule
</button>

@foreach(['morning' => $morningPeriods, 'afternoon' => $afternoonPeriods] as $shiftKey => $periods)
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
            @foreach($periods as $row)
                @if(isset($row['break']))
                    <tr class="break-row">
                        <td colspan="6"><i class="fa-regular fa-clock"></i> {{ $row['break'] }}</td>
                    </tr>
                @else
                    <tr>
                        <td class="time-box">{{ $row['label'] }}<br><small>{{ $row['time'] }}</small></td>
                        @foreach($row['slots'] as $slot)
                            <td>
                                @if($slot)
                                    @php [$subj, $initials, $color] = explode('|', $slot); @endphp
                                    <div class="subject-card subject-{{ $color }}">
                                        <strong>{{ $subj }}</strong><br>
                                        <span>{{ $initials }}</span>
                                    </div>
                                @else
                                    <div class="empty-slot" onclick="openSlotModal(this)"><i class="fa-solid fa-plus"></i></div>
                                @endif
                            </td>
                        @endforeach
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
</div>
@endforeach

<div class="grid-actions" id="gridActions" style="display:none;">
    <button type="button" class="save-btn" onclick="applyChanges()"><i class="fa-solid fa-floppy-disk"></i> Apply Changes</button>
    <button type="button" class="cancel-btn" onclick="resetGrid()">Reset Grid</button>
</div>

<!-- Add Subject Modal -->
<div id="slotModal" class="slot-modal-overlay" style="display:none;">
    <div class="slot-modal">
        <h3>Add Subject</h3>
        <div class="form-group">
            <label>Subject</label>
            <select id="modalSubject">
                <option value="Chemistry|chemistry">Chemistry</option>
                <option value="Math|math">Math</option>
                <option value="Physics|physics">Physics</option>
                <option value="Biology|biology">Biology</option>
                <option value="Khmer|khmer">Khmer</option>
                <option value="History|khmer">History</option>
            </select>
        </div>
        <div class="form-group">
            <label>Teacher Initials</label>
            <input type="text" id="modalInitials" placeholder="e.g. SK" maxlength="3">
        </div>
        <div class="form-actions">
            <button type="button" class="cancel-btn" onclick="closeSlotModal()">Cancel</button>
            <button type="button" class="save-btn" onclick="confirmAddSubject()">Add</button>
        </div>
    </div>
</div>

<script>
let activeSlot = null;
let editMode = false;

function enterEditMode() {
    editMode = true;
    document.getElementById('editBtn').style.display = 'none';
    document.getElementById('gridActions').style.display = 'flex';
    document.body.classList.add('grid-editing');
}

function exitEditMode() {
    editMode = false;
    document.getElementById('editBtn').style.display = 'inline-flex';
    document.getElementById('gridActions').style.display = 'none';
    document.body.classList.remove('grid-editing');
}

function openSlotModal(el) {
    if (!editMode) return; // only allow adding when in edit mode
    activeSlot = el;
    document.getElementById('slotModal').style.display = 'flex';
}

function closeSlotModal() {
    document.getElementById('slotModal').style.display = 'none';
    activeSlot = null;
}

function confirmAddSubject() {
    const [subj, color] = document.getElementById('modalSubject').value.split('|');
    const initials = document.getElementById('modalInitials').value || '--';
    activeSlot.outerHTML = `<div class="subject-card subject-${color}"><strong>${subj}</strong><br><span>${initials}</span></div>`;
    closeSlotModal();
}

function applyChanges() {
    alert('Changes saved (not yet connected to backend).');
    exitEditMode();
}

function resetGrid() {
    location.reload();
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
