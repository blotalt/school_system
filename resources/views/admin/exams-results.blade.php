@extends('layouts.admin')

@section('content')
<a href="{{ route('admin.exams.index') }}" class="back-link">
    <i class="fa-solid fa-arrow-left"></i> Back to Exams
</a>

<x-page-header>
    <div>
        <h1>Mid-Term Mathematics — Results</h1>
        <p>Grade 12 - A · Math · Max Score: 100</p>
    </div>
</x-page-header>

@php
$results = [
    (object)['name'=>'Serey Sokha','roll_no'=>'ST-2023-0482','score'=>92],
    (object)['name'=>'Visal Rattanak','roll_no'=>'ST-2023-1109','score'=>78],
    (object)['name'=>'Vannak Chantrea','roll_no'=>'ST-2023-0021','score'=>null],
    (object)['name'=>'Dara Phirun','roll_no'=>'ST-2022-0941','score'=>65],
];
@endphp

<div class="data-card">
    <table class="data-table">
        <thead>
            <tr>
                <th>Student</th>
                <th>Roll No.</th>
                <th>Score</th>
            </tr>
        </thead>
        <tbody>
            @foreach($results as $r)
                <tr>
                    <td>{{ $r->name }}</td>
                    <td>{{ $r->roll_no }}</td>
                    <td>{{ $r->score ?? '—' }} / 100</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection