{{-- @extends('layouts.admin')

@section('content')
<x-page-header>
    <div>
        <h1>Teacher Availability</h1>
        <p>See which teachers are available for each time slot. Go to Classes to assign.</p>
    </div>
</x-page-header>

@if(session('success'))
    <div class="alert alert-success" style="margin-bottom:16px;padding:12px 16px;background:#e6f9f0;border:1px solid #10b981;border-radius:10px;color:#0a7a4d;">{{ session('success') }}</div>
@endif

<div style="display:flex;gap:20px;align-items:flex-end;margin-bottom:20px;flex-wrap:wrap;">
    <div class="header-group">
        <label>SHIFT</label>
        <div class="shift-toggle">
            <button type="button" class="shift-btn active" data-shift="morning">Morning</button>
            <button type="button" class="shift-btn" data-shift="afternoon">Afternoon</button>
        </div>
    </div>
    <div class="header-group">
        <label>DAY</label>
        <div class="shift-toggle" id="dayTabs">
            @foreach($days as $i => $day)
                <button type="button" class="shift-btn {{ $i === 0 ? 'active' : '' }}" data-day="{{ $day }}">{{ substr($day, 0, 3) }}</button>
            @endforeach
        </div>
    </div>
</div>

<div style="display:flex;gap:16px;font-size:12px;color:#6b7280;margin-bottom:12px;flex-wrap:wrap;">
    <span><span style="display:inline-block;width:10px;height:10px;border-radius:3px;background:#f59e0b;margin-right:4px;"></span>Preferred</span>
    <span><span style="display:inline-block;width:10px;height:10px;border-radius:3px;background:#10b981;margin-right:4px;"></span>Available</span>
    <span><span style="display:inline-block;width:10px;height:10px;border-radius:3px;background:#f3f4f6;border:1px solid #e5e9f2;margin-right:4px;"></span>No data</span>
    <span><span style="display:inline-block;width:10px;height:10px;border-radius:3px;background:#fef2f2;border:1px solid #fecaca;margin-right:4px;"></span>Unavailable</span>
    <span><span style="display:inline-block;width:10px;height:10px;border-radius:3px;background:#1e40af;margin-right:4px;"></span>Assigned</span>
</div>

@php
$allSchedules = \App\Models\ClassSchedule::all()
    ->keyBy(fn($s) => "{$s->teacher_id}-{$s->shift}-{$s->day_of_week}-{$s->period}");
@endphp

@foreach(['morning', 'afternoon'] as $shiftKey)
<div class="shift-grid" data-shift="{{ $shiftKey }}" style="{{ $shiftKey === 'afternoon' ? 'display:none;' : '' }}">
    @foreach($days as $day)
    <div class="day-grid" data-day="{{ $day }}" style="{{ !$loop->first ? 'display:none;' : '' }}">
        <div class="data-card" style="overflow-x:auto;">
            <table class="data-table" style="min-width:600px;">
                <thead>
                    <tr>
                        <th style="min-width:160px;">Teacher</th>
                        @for($p = 1; $p <= 4; $p++)
                            <th>P{{ $p }}<br><small style="font-weight:400;color:#9ca3af;">{{ $periodTimes[$shiftKey][$p] }}</small></th>
                        @endfor
                    </tr>
                </thead>
                <tbody>
                    @foreach($teachers as $teacher)
                        <tr>
                            <td>
                                <div style="display:flex;align-items:center;gap:8px;">
                                    <div style="width:30px;height:30px;border-radius:50%;background:#1e40af;color:#fff;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;flex-shrink:0;">
                                        {{ collect(explode(' ', $teacher->user->displayName()))->map(fn($n) => mb_substr($n, 0, 1))->take(2)->implode('') }}
                                    </div>
                                    <div>
                                        <div style="font-weight:600;font-size:13px;">{{ $teacher->user->displayName() }}</div>
                                        <div style="font-size:11px;color:#9ca3af;">{{ $teacher->subject_specialty ?? '—' }}</div>
                                    </div>
                                </div>
                            </td>
                            @for($period = 1; $period <= 4; $period++)
                                @php
                                    $availKey    = "{$shiftKey}-{$day}-{$period}";
                                    $assignedKey = "{$teacher->id}-{$shiftKey}-{$day}-{$period}";
                                    $isAssigned  = isset($allSchedules[$assignedKey]);
                                    $avail       = $availabilityMap[$teacher->id][$availKey] ?? 'no_data';
                                    $assignedSlot = $allSchedules[$assignedKey] ?? null;
                                @endphp
                                <td style="text-align:center;">
                                    @if($isAssigned)
                                        <div style="background:#1e40af;color:#fff;border-radius:6px;padding:4px 6px;font-size:11px;font-weight:600;">
                                            {{ $assignedSlot?->subject?->name ?? 'Assigned' }}<br>
                                            <span style="font-size:10px;opacity:.8;">{{ $assignedSlot?->schoolClass?->name ?? '' }}</span>
                                        </div>
                                    @elseif($avail === 'preferred')
                                        <span style="display:inline-block;background:#fef3c7;color:#92400e;border:1px solid #f59e0b;border-radius:6px;padding:4px 8px;font-size:11px;font-weight:600;">★ Preferred</span>
                                    @elseif($avail === 'available')
                                        <span style="display:inline-block;background:#d1fae5;color:#065f46;border:1px solid #10b981;border-radius:6px;padding:4px 8px;font-size:11px;font-weight:600;">✓ Available</span>
                                    @elseif($avail === 'unavailable')
                                        <span style="display:inline-block;background:#fef2f2;color:#b91c1c;border:1px solid #fecaca;border-radius:6px;padding:4px 8px;font-size:11px;">✗ Unavailable</span>
                                    @else
                                        <span style="color:#d1d5db;font-size:18px;">—</span>
                                    @endif
                                </td>
                            @endfor
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endforeach
</div>
@endforeach

<div style="margin-top:16px;padding:14px 16px;background:#eef2ff;border-radius:10px;color:#3730a3;font-size:13px;">
    <i class="fa-solid fa-circle-info"></i>
    To assign a teacher to a class, go to <a href="{{ route('admin.classes.index') }}" style="color:#3730a3;font-weight:600;">Classes</a>, click <strong>Edit Schedule</strong>, then click an empty slot.
</div>

<script>
document.querySelectorAll('.shift-btn[data-shift]').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.shift-btn[data-shift]').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        const shift = this.dataset.shift;
        document.querySelectorAll('.shift-grid').forEach(g => {
            g.style.display = (g.dataset.shift === shift) ? 'block' : 'none';
        });
    });
});

document.querySelectorAll('.shift-btn[data-day]').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.shift-btn[data-day]').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        const day = this.dataset.day;
        document.querySelectorAll('.day-grid').forEach(g => {
            g.style.display = (g.dataset.day === day) ? 'block' : 'none';
        });
    });
});
</script>
@endsection --}}