@extends('layouts.admin')

@section('content')
<x-page-header>
    <div>
        <h1>Institutional Dashboard</h1>
        <p>Academic Session: 2025-2026 • Senior Secondary Department</p>
    </div>
</x-page-header>

@php
$stats = [
    ['icon' => 'fa-user-graduate', 'value' => '1,240', 'label' => 'Total Students'],
    ['icon' => 'fa-chalkboard-user', 'value' => '84', 'label' => 'Total Teachers'],
    ['icon' => 'fa-circle-check', 'value' => '96.5%', 'label' => 'Attendance Rate'],
    ['icon' => 'fa-school', 'value' => '42', 'label' => 'Active Classes'],
];

$classes = [
    ['name' => 'Grade 12 - A', 'track' => 'Science', 'students' => 42, 'attendance' => 98],
    ['name' => 'Grade 12 - B', 'track' => 'Geography', 'students' => 38, 'attendance' => 95],
    ['name' => 'Grade 11 - A', 'track' => 'Science', 'students' => 45, 'attendance' => 97],
    ['name' => 'Grade 11 - B', 'track' => 'Geography', 'students' => 40, 'attendance' => 94],
];
@endphp

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
        <a href="/admin/classes">View All Classes</a>
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
            @foreach($classes as $class)
                <tr>
                    <td>{{ $class['name'] }}</td>
                    <td><span class="badge badge-{{ strtolower($class['track']) }}">{{ strtoupper($class['track']) }}</span></td>
                    <td>{{ $class['students'] }}</td>
                    <td>{{ $class['attendance'] }}%</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection