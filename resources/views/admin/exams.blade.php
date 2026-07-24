@extends('layouts.admin')

@section('content')
<x-page-header>
    <div>
        <h1>{{ __('admin.exams.title') }}</h1>
        <p>{{ __('admin.exams.subtitle', ['count' => $exams->total()]) }}</p>
    </div>
</x-page-header>

@if (session('success'))
    <div class="alert alert-success" style="margin-bottom:16px;padding:12px 16px;background:#e6f9f0;border:1px solid #10b981;border-radius:10px;color:#0a7a4d;">
        {{ session('success') }}
    </div>
@endif

<div class="data-card-header" style="background:#fff;border-radius:16px 16px 0 0;border:1px solid #e5e9f2;border-bottom:none;padding:20px 24px;">
    <form method="GET" action="{{ route('admin.exams.index') }}" style="display:flex;gap:20px;align-items:center;flex-wrap:wrap;justify-content:space-between;width:100%;">
        <select name="class" class="filter-select" onchange="this.form.submit()">
            <option value="">{{ __('admin.exams.all_classes') }}</option>
            @foreach($classes as $c)
                <option value="{{ $c->id }}" {{ (string) $classId === (string) $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
            @endforeach
        </select>
        <a href="{{ route('admin.exams.create') }}" class="add-btn">
            <i class="fa-solid fa-plus"></i> {{ __('admin.exams.add_exam') }}
        </a>
    </form>
</div>

<div class="data-card" style="border-radius:0 0 16px 16px;">
    <table class="data-table">
        <thead>
            <tr>
                <th>{{ __('admin.exams.title_column') }}</th>
                <th>{{ __('admin.exams.class_column') }}</th>
                <th>{{ __('admin.exams.subject_column') }}</th>
                <th>{{ __('admin.exams.teacher_column') }}</th>
                <th>{{ __('admin.exams.type_column') }}</th>
                <th>{{ __('admin.exams.date_column') }}</th>
                <th>{{ __('admin.exams.results_column') }}</th>
                <th>{{ __('common.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($exams as $exam)
                <tr>
                    <td><strong>{{ $exam->title }}</strong></td>
                    <td>{{ $exam->schoolClass->name ?? __('admin.exams.unassigned') }}</td>
                    <td>{{ $exam->subject->name ?? '—' }}</td>
                    <td>{{ $exam->teacher->user->name ?? '—' }}</td>
                    <td><span class="badge badge-subject">{{ ucfirst($exam->exam_type) }}</span></td>
                    <td>{{ \Illuminate\Support\Carbon::parse($exam->exam_date)->format('M j, Y') }}</td>
                    <td>{{ $exam->results_count }} / {{ $exam->schoolClass->students()->count() ?? 0 }}</td>
                    <td>
                        <a href="{{ route('admin.exams.results.index', $exam) }}" title="Enter Scores"><i class="fa-solid fa-pen-to-square"></i></a>
                        <a href="{{ route('admin.exams.edit', $exam) }}" title="{{ __('common.edit') }}" style="margin-left:12px;"><i class="fa-solid fa-pen"></i></a>
                        <form action="{{ route('admin.exams.destroy', $exam) }}" method="POST" style="display:inline;margin-left:12px;" onsubmit="return confirm('{{ __('admin.exams.delete_confirm') }}');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" title="{{ __('common.delete') }}" style="background:none;border:none;cursor:pointer;color:#9ca3af;">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align:center;color:#9ca3af;padding:24px;">{{ __('admin.exams.no_exams_found') }}</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div style="margin-top:20px;">
    {{ $exams->links() }}
</div>
@endsection
