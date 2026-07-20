@extends('layouts.teacher')

@section('content')
<div class="page-title-bar">
    <div>
        <h1>Exams</h1>
        <p>Monthly and semester exams for your classes.</p>
    </div>
    <button type="button" class="add-btn" onclick="document.getElementById('newExamModal').style.display='flex'">
        <i class="fa-solid fa-plus"></i> New Exam
    </button>
</div>

@if(session('success'))
    <div class="filter-card" style="color:#1a7f37;margin-bottom:8px;">{{ session('success') }}</div>
@endif

<div class="data-card">
    <table class="data-table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Class</th>
                <th>Subject</th>
                <th>Type</th>
                <th>Date</th>
                <th>Max Score</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($exams as $exam)
                <tr>
                    <td><strong>{{ $exam->title }}</strong></td>
                    <td>{{ $exam->schoolClass->name ?? '—' }}</td>
                    <td>{{ $exam->subject->name ?? '—' }}</td>
                    <td><span class="badge {{ $exam->exam_type === 'monthly' ? 'badge-science' : 'badge-geography' }}">{{ ucfirst($exam->exam_type) }}</span></td>
                    <td>{{ \Carbon\Carbon::parse($exam->exam_date)->format('M d, Y') }}</td>
                    <td>{{ $exam->max_score }}</td>
                    <td>
                        <a href="{{ route('teacher.gradebook.show', $exam) }}" title="Gradebook" style="margin-right:12px;">
                            <i class="fa-solid fa-list-check"></i> Grades
                        </a>
                        <form method="POST" action="{{ route('teacher.exams.destroy', $exam) }}" style="display:inline;" onsubmit="return confirm('Delete this exam?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background:none;border:none;cursor:pointer;color:#ef4444;" title="Delete"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" style="text-align:center;color:#8a94a6;">No exams yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div id="newExamModal" class="slot-modal-overlay" style="display:{{ $errors->any() ? 'flex' : 'none' }};">
    <form class="slot-modal" style="width:480px;" method="POST" action="{{ route('teacher.exams.store') }}">
        @csrf
        <h3>New Exam</h3>

        @if($errors->any())
            <div class="form-group" style="color:#c0392b;">Please fix the errors below.</div>
        @endif

        <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" value="{{ old('title') }}" placeholder="e.g. Mid-Term Math">
            @error('title') <span style="color:#c0392b;font-size:13px;">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label>Class</label>
            <select name="class_id">
                <option value="">Select a class</option>
                @foreach($classes as $class)
                    <option value="{{ $class->id }}" @selected(old('class_id') == $class->id)>{{ $class->name }}</option>
                @endforeach
            </select>
            @error('class_id') <span style="color:#c0392b;font-size:13px;">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label>Subject</label>
            <select name="subject_id">
                <option value="">Select a subject</option>
                @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}" @selected(old('subject_id') == $subject->id)>{{ $subject->name }}</option>
                @endforeach
            </select>
            @error('subject_id') <span style="color:#c0392b;font-size:13px;">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label>Type</label>
            <select name="exam_type">
                <option value="monthly" @selected(old('exam_type') === 'monthly')>Monthly</option>
                <option value="semester" @selected(old('exam_type') === 'semester')>Semester</option>
            </select>
            @error('exam_type') <span style="color:#c0392b;font-size:13px;">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label>Exam Date</label>
            <input type="date" name="exam_date" value="{{ old('exam_date') }}">
            @error('exam_date') <span style="color:#c0392b;font-size:13px;">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label>Max Score</label>
            <input type="number" name="max_score" value="{{ old('max_score', 100) }}" min="1">
            @error('max_score') <span style="color:#c0392b;font-size:13px;">{{ $message }}</span> @enderror
        </div>

        <div class="form-actions">
            <button type="button" class="cancel-btn" onclick="document.getElementById('newExamModal').style.display='none'">Cancel</button>
            <button type="submit" class="save-btn">Create Exam</button>
        </div>
    </form>
</div>
@endsection
