@extends('layouts.student')

@section('content')
<x-page-header>
    <div>
        <h1>My Attendance</h1>
        <p>Your attendance history, read-only.</p>
    </div>
</x-page-header>

<div class="stat-grid">
    <div class="stat-card">
        <div class="stat-icon"><i class="fa-solid fa-circle-check"></i></div>
        <div class="stat-value">{{ $rate }}%</div>
        <div class="stat-label">Attendance Rate</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="fa-solid fa-user-check"></i></div>
        <div class="stat-value">{{ $present }}</div>
        <div class="stat-label">Days Present</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="fa-solid fa-calendar-days"></i></div>
        <div class="stat-value">{{ $total }}</div>
        <div class="stat-label">Days Recorded</div>
    </div>
</div>

<div class="data-card">
    <div class="data-card-header">
        <h3>Attendance History</h3>
    </div>
    <table class="data-table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($records as $record)
                @php
                    $map = ['present' => 'badge-science', 'absent' => 'badge-geography', 'late' => 'badge'];
                @endphp
                <tr>
                    <td>{{ $record->date->format('M d, Y') }}</td>
                    <td><span class="badge {{ $map[$record->status] ?? 'badge' }}">{{ ucfirst($record->status) }}</span></td>
                </tr>
            @empty
                <tr><td colspan="2" style="text-align:center;color:#8a94a6;">No attendance records yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
