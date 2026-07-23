@extends('layouts.admin')
@section('content')
<div style="padding:28px 32px 8px;">
   <h1 style="font-size:24px;font-weight:700;color:#1a2235;margin:0 0 4px;">Schedule Management</h1>
<p style="color:#8a94a6;font-size:14px;margin:0;">Academic Year 2025–2026 · Semester 1 · Review teacher schedule requests and view the official timetable.</p>
</div>
@if(session('success'))
<div style="margin:0 32px 16px;padding:12px 16px;background:#e6f9f0;border:1px solid #10b981;border-radius:10px;color:#0a7a4d;">{{ session('success') }}</div>
@endif
@if(session('error'))
<div style="margin:0 32px 16px;padding:12px 16px;background:#fdecea;border:1px solid #f5b7b1;border-radius:10px;color:#c0392b;">{{ session('error') }}</div>
@endif
<div style="margin:0 32px 24px;" class="data-card">
    <div class="data-card-header">
        <h3>Pending Requests <span style="background:#fef3c7;color:#92400e;padding:2px 10px;border-radius:20px;font-size:13px;">{{ $pending->count() }}</span></h3>
    </div>
    @if($pending->isEmpty())
    <div style="padding:24px;text-align:center;color:#9ca3af;">No pending requests.</div>
    @else
    <table class="data-table">
        <thead>
            <tr>
                <th>Teacher</th>
                <th>Class</th>
                <th>Subject</th>
                <th>Time Slot</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pending as $req)
            @php $timeLabel = $periodTimes[$req->shift][$req->period]; @endphp
            <tr>
                <td>{{ $req->teacher->user->name }}</td>
                <td>{{ $req->schoolClass->name }}</td>
                <td>{{ $req->subject->name }}</td>
                <td>
                    <strong>{{ $req->day_of_week }}</strong><br>
                    <span style="color:#6b7280;font-size:13px;">{{ ucfirst($req->shift) }} P{{ $req->period }} {{ $timeLabel }}</span>
                </td>
                <td style="display:flex;gap:8px;align-items:center;">
                    <form method="POST" action="{{ route('admin.schedule.approve', $req) }}">
                        @csrf
                        <button type="submit" class="save-btn" style="padding:6px 14px;font-size:13px;">Approve</button>
                    </form>
                    <button type="button" class="cancel-btn" style="padding:6px 14px;font-size:13px;" onclick="openRejectModal({{ $req->id }})">Reject</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
<div style="margin:0 32px;background:#fff;border-radius:16px 16px 0 0;border:1px solid #e5e9f2;border-bottom:none;padding:20px 24px;display:flex;align-items:flex-end;gap:24px;flex-wrap:wrap;">
    <div>
        <h3 style="margin:0 0 4px;">Official Timetable</h3>
        <p style="color:#9ca3af;font-size:13px;margin:0;">Approved schedules only.</p>
    </div>
    <form method="GET" action="{{ route('admin.schedule.index') }}">
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
@php
$subjectColors = ['Mathematics'=>'math','Physics'=>'physics','Biology'=>'biology','Chemistry'=>'chemistry','English'=>'english','History'=>'history','Geography'=>'geography','Computer Science'=>'computerscience'];
@endphp
@foreach(['morning','afternoon'] as $shiftKey)
<div class="timetable-container shift-grid" data-shift="{{ $shiftKey }}" style="margin:0 32px 24px;{{ $shiftKey==='afternoon' ? 'display:none;' : '' }}">
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
            @for($period=1;$period<=4;$period++)
            <tr>
                <td class="time-box">P{{ $period }}<br><small>{{ $periodTimes[$shiftKey][$period] }}</small></td>
                @foreach($days as $day)
                @php $slot = $schedules->get("{$shiftKey}-{$day}-{$period}"); @endphp
                <td>
                    @if($slot)
                    @php $colorClass = $subjectColors[$slot->subject->name] ?? 'default'; @endphp
<div class="subject-card subject-{{ $colorClass }}" style="position:relative;">
    <strong>{{ $slot->subject->name }}</strong><br>
    <span style="font-size:12px;">{{ $slot->teacher->user->name }}</span>
    <form method="POST" action="{{ route('admin.schedule.destroy', $slot) }}" style="position:absolute;top:2px;right:2px;" onsubmit="return confirm('Remove this slot?')">
        @csrf
        @method('DELETE')
        <button type="submit" style="background:none;border:none;cursor:pointer;color:inherit;opacity:.6;"><i class="fa-solid fa-xmark"></i></button>
    </form>
</div>
                    @else
                    <div class="empty-slot" style="cursor:default;"></div>
                    @endif
                </td>
                @endforeach
            </tr>
            @if($period<4)
            @php $breakStart=explode(' - ',$periodTimes[$shiftKey][$period])[1];$breakEnd=explode(' - ',$periodTimes[$shiftKey][$period+1])[0]; @endphp
            <tr class="break-row">
                <td colspan="6">10 MIN BREAK ({{ $breakStart }} - {{ $breakEnd }})</td>
            </tr>
            @endif
            @endfor
        </tbody>
    </table>
</div>
@endforeach
<div id="rejectModal" class="slot-modal-overlay" style="display:none;">
    <form class="slot-modal" style="width:420px;" method="POST" id="rejectForm">
        @csrf
        <h3>Reject Schedule Request</h3>
        <div class="form-group">
            <label>Reason (optional)</label>
            <textarea name="rejection_note" rows="3" style="width:100%;border:1px solid #e5e9f2;border-radius:10px;padding:12px;"></textarea>
        </div>
        <div class="form-actions">
            <button type="button" class="cancel-btn" onclick="document.getElementById('rejectModal').style.display='none'">Cancel</button>
            <button type="submit" class="save-btn" style="background:#ef4444;">Reject</button>
        </div>
    </form>
</div>
<script>
function openRejectModal(id){document.getElementById('rejectForm').action='/admin/schedule/'+id+'/reject';document.getElementById('rejectModal').style.display='flex';}
document.querySelectorAll('.shift-btn').forEach(btn=>{btn.addEventListener('click',function(){document.querySelectorAll('.shift-btn').forEach(b=>b.classList.remove('active'));this.classList.add('active');const shift=this.dataset.shift;document.querySelectorAll('.shift-grid').forEach(grid=>{grid.style.display=(grid.dataset.shift===shift)?'block':'none';});});});
</script>
@endsection