@extends('layouts.student')

@section('content')
<x-page-header>
    <div>
        <h1>{{ __('student.attendance.title') }}</h1>
        <p>{{ __('student.attendance.subtitle') }}</p>
    </div>
</x-page-header>

<div class="stat-grid">
    <div class="stat-card">
        <div class="stat-icon"><i class="fa-solid fa-circle-check"></i></div>
        <div class="stat-value">{{ $rate }}%</div>
        <div class="stat-label">{{ __('student.attendance.stat_attendance_rate') }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="fa-solid fa-user-check"></i></div>
        <div class="stat-value">{{ $present }}</div>
        <div class="stat-label">{{ __('student.attendance.stat_days_present') }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="fa-solid fa-calendar-days"></i></div>
        <div class="stat-value">{{ $total }}</div>
        <div class="stat-label">{{ __('student.attendance.stat_days_recorded') }}</div>
    </div>
</div>

<div class="data-card">
    <div class="data-card-header" style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:10px;">
        <h3>{{ __('student.attendance.history') }}</h3>
        <div style="display:flex;gap:10px;">
            <a href="{{ route('student.attendance.export') }}" class="add-btn">
                <i class="fa-solid fa-file-excel"></i> {{ __('student.attendance.export_excel') }}
            </a>
            <a href="{{ route('student.attendance.export.pdf') }}" class="add-btn" style="background:#dc2626;">
                <i class="fa-solid fa-file-pdf"></i> {{ __('student.attendance.export_pdf') }}
            </a>
        </div>
    </div>
    <table class="data-table">
        <thead>
            <tr>
                <th>{{ __('common.date') }}</th>
                <th>{{ __('common.status') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($records as $record)
                @php
                    $map = ['present' => 'badge-science', 'absent' => 'badge-geography', 'late' => 'badge'];
                    $statusLabels = ['present' => __('teacher.attendance.present'), 'absent' => __('teacher.attendance.absent'), 'late' => __('teacher.attendance.late')];
                @endphp
                <tr>
                    <td>{{ $record->date->format('M d, Y') }}</td>
                    <td><span class="badge {{ $map[$record->status] ?? 'badge' }}">{{ $statusLabels[$record->status] ?? ucfirst($record->status) }}</span></td>
                </tr>
            @empty
                <tr><td colspan="2" style="text-align:center;color:#8a94a6;">{{ __('student.attendance.no_records_yet') }}</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
