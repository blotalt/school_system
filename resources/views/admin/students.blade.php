@extends('layouts.admin')

@section('content')
<x-page-header>
    <div>
        <h1>Student Management</h1>
        <p>Managing 1,248 enrolled students for the current semester.</p>
    </div>
</x-page-header>

@php
$students = [
    (object)['id' => 'ST-2023-0482', 'name' => 'Serey Sokha', 'grade' => 'Grade 12', 'section' => '12-A', 'track' => 'Science', 'attendance' => 98, 'status' => 'Active'],
    (object)['id' => 'ST-2023-1109', 'name' => 'Visal Rattanak', 'grade' => 'Grade 11', 'section' => '11-C', 'track' => 'Social Science', 'attendance' => 84, 'status' => 'Active'],
    (object)['id' => 'ST-2023-0021', 'name' => 'Vannak Chantrea', 'grade' => 'Grade 12', 'section' => '12-B', 'track' => 'Science', 'attendance' => 95, 'status' => 'Active'],
    (object)['id' => 'ST-2022-0941', 'name' => 'Dara Phirun', 'grade' => 'Grade 10', 'section' => '10-F', 'track' => 'Social Science', 'attendance' => 42, 'status' => 'On Leave'],
    (object)['id' => 'ST-2023-0112', 'name' => 'Kalyan Bopha', 'grade' => 'Grade 12', 'section' => '12-A', 'track' => 'Science', 'attendance' => 92, 'status' => 'Active'],
];
@endphp

<div class="data-card-header" style="background:#fff;border-radius:16px 16px 0 0;border:1px solid #e5e9f2;border-bottom:none;padding:20px 24px;">
    <div style="display:flex;gap:20px;align-items:center;flex-wrap:wrap;justify-content:space-between;">
        <div class="search-box" style="width:320px;">
            <input type="text" placeholder="e.g. Sophea Rath">
            <i class="fa-solid fa-magnifying-glass"></i>
        </div>
        <div style="display:flex;gap:15px;align-items:center;">
            <select class="filter-select">
                <option>All Grades</option>
                <option>Grade 10</option>
                <option>Grade 11</option>
                <option>Grade 12</option>
            </select>
            <select class="filter-select">
                <option>All Tracks</option>
                <option>Science</option>
                <option>Social Science</option>
            </select>
            <a href="{{ route('admin.students.create') }}" class="add-btn">
                <i class="fa-solid fa-user-plus"></i> Add
            </a>
        </div>
    </div>
</div>

<div class="data-card" style="border-radius:0 0 16px 16px;">
    <table class="data-table">
        <thead>
            <tr>
                <th>Student</th>
                <th>Grade</th>
                <th>Section</th>
                <th>Track</th>
                <th>Attendance</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $student)
                <tr>
                    <td>
                        <strong>{{ $student->name }}</strong><br>
                        <span style="color:#9ca3af;font-size:13px;">{{ $student->id }}</span>
                    </td>
                    <td>{{ $student->grade }}</td>
                    <td>{{ $student->section }}</td>
                    <td><span class="badge badge-{{ $student->track === 'Science' ? 'science' : 'geography' }}">{{ $student->track }}</span></td>
                    <td>
                        <div style="display:flex;align-items:center;gap:8px;">
                            <div style="width:80px;height:6px;background:#eef1f6;border-radius:10px;overflow:hidden;">
                                <div style="width:{{ $student->attendance }}%;height:100%;background:{{ $student->attendance < 60 ? '#ef4444' : '#10b981' }};"></div>
                            </div>
                            <span>{{ $student->attendance }}%</span>
                        </div>
                    </td>
                    <td><span class="badge badge-{{ $student->status === 'Active' ? 'active' : 'leave' }}">{{ $student->status }}</span></td>
                    <td>
                        <a href="#" title="View"><i class="fa-regular fa-eye"></i></a>
                        <a href="#" title="Edit" style="margin-left:12px;"><i class="fa-solid fa-pen"></i></a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection