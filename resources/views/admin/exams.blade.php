@extends('layouts.admin')

@section('content')
<x-page-header>
    <div>
        <h1>Exam Management</h1>
        <p>Manage monthly and semester exams across all classes.</p>
    </div>
</x-page-header>

@php
$exams = [
    (object)['id'=>1,'title'=>'Mid-Term Mathematics','class'=>'Grade 12 - A','subject'=>'Math','teacher'=>'Mr. Sophea Rath','type'=>'monthly','date'=>'2026-07-25','max_score'=>100],
    (object)['id'=>2,'title'=>'Semester Biology Final','class'=>'Grade 11 - B','subject'=>'Biology','teacher'=>'Ms. Sreyneang Kim','type'=>'semester','date'=>'2026-08-10','max_score'=>100],
    (object)['id'=>3,'title'=>'Monthly History Quiz','class'=>'Grade 10 - C','subject'=>'History','teacher'=>'Dr. Chan Dara','type'=>'monthly','date'=>'2026-07-20','max_score'=>50],
];
@endphp

<div class="data-card">
    <table class="data-table">
        <thead>
            <tr>
                <th>Exam Title</th>
                <th>Class</th>
                <th>Subject</th>
                <th>Teacher</th>
                <th>Type</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($exams as $exam)
                <tr>
                    <td><strong>{{ $exam->title }}</strong></td>
                    <td>{{ $exam->class }}</td>
                    <td>{{ $exam->subject }}</td>
                    <td>{{ $exam->teacher }}</td>
                    <td><span class="badge {{ $exam->type === 'monthly' ? 'badge-science' : 'badge-geography' }}">{{ ucfirst($exam->type) }}</span></td>
                    <td>{{ $exam->date }}</td>
                    <td>
                        <a href="{{ route('admin.exams.results', $exam->id) }}">View Results</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection