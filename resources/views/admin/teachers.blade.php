@extends('layouts.admin')

@section('content')
<x-page-header>
    <div>
        <h1>Teacher Management</h1>
        <p>Managing 124 teachers for the current semester.</p>
    </div>
</x-page-header>

@php
$teachers = [
    (object)['id' => 'EMP-2023-01', 'name' => 'Mr. Sophea Rath', 'subjects' => ['Physics','Maths'], 'classes' => 'Grade 11-A, Grade 12-B', 'contact' => '+855 12 345 678', 'status' => 'Active'],
    (object)['id' => 'EMP-2023-08', 'name' => 'Ms. Sreyneang Kim', 'subjects' => ['Biology'], 'classes' => 'Grade 10-C, Grade 11-B', 'contact' => '+855 99 876 543', 'status' => 'Active'],
    (object)['id' => 'EMP-2020-05', 'name' => 'Dr. Chan Dara', 'subjects' => ['History'], 'classes' => 'N/A (On Leave)', 'contact' => '+855 10 222 333', 'status' => 'Inactive'],
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
                <option>All</option>
                <option>Physics</option>
                <option>Biology</option>
                <option>History</option>
            </select>
            <select class="filter-select">
                <option>All</option>
                <option>Active</option>
                <option>Inactive</option>
            </select>
            <a href="{{ route('admin.teachers.create') }}" class="add-btn">
                <i class="fa-solid fa-user-plus"></i> Add
            </a>
        </div>
    </div>
</div>

<div class="data-card" style="border-radius:0 0 16px 16px;">
    <table class="data-table">
        <thead>
            <tr>
                <th>Teacher Name</th>
                <th>Subject(s)</th>
                <th>Assigned Classes</th>
                <th>Contact</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($teachers as $teacher)
                <tr>
                    <td>
                        <strong>{{ $teacher->name }}</strong><br>
                        <span style="color:#9ca3af;font-size:13px;">{{ $teacher->id }}</span>
                    </td>
                    <td>
                        @foreach($teacher->subjects as $subject)
                            <span class="badge badge-subject">{{ $subject }}</span>
                        @endforeach
                    </td>
                    <td>{{ $teacher->classes }}</td>
                    <td>{{ $teacher->contact }}</td>
                    <td><span class="badge badge-{{ $teacher->status === 'Active' ? 'active' : 'inactive' }}">{{ strtoupper($teacher->status) }}</span></td>
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