@extends('layouts.admin')

@section('content')
<div class="page-title">
    <h1>Institutional Dashboard</h1>
    <p>Academic Session: 2025-2026 · Senior Secondary Department</p>
</div>

<div class="stat-grid">
    @foreach($stats as $stat)
        <div class="stat-card">
            <div class="stat-icon"><i class="fa-solid {{ $stat['icon'] }}"></i></div>
            <div class="stat-value">{{ $stat['value'] }}</div>
            <div class="stat-label">{{ $stat['label'] }}</div>
        </div>
    @endforeach
</div>

<div class="data-card">
    <div class="data-card-header">
        <h3>Classes Overview</h3>
        <a href="{{ route('admin.classes.index') }}">View All Classes</a>
    </div>
    <table class="data-table">
        <thead>
            <tr>
                <th>Class Name</th>
                <th>Track</th>
                <th>Students</th>
                <th>Attendance</th>
            </tr>
        </thead>
        <tbody>
            @forelse($classes as $class)
                <tr>
                    <td>{{ $class->name }}</td>
                    <td><span class="badge badge-{{ strtolower($class->track ?? 'general') }}">{{ strtoupper($class->track ?? 'General') }}</span></td>
                    <td>{{ $class->students }}</td>
                    <td>{{ $class->attendance }}%</td>
                </tr>
            @empty
                <tr><td colspan="4" style="text-align:center;color:#8a94a6;">No classes yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
