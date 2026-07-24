@extends('layouts.admin')

@section('content')
<x-page-header>
    <div>
        <h1>{{ __('admin.students.title') }}</h1>
        <p>{{ __('admin.students.subtitle', ['count' => $students->total()]) }}</p>
    </div>
</x-page-header>

@if (session('success'))
    <div class="alert alert-success" style="margin-bottom:16px;padding:12px 16px;background:#e6f9f0;border:1px solid #10b981;border-radius:10px;color:#0a7a4d;">
        {{ session('success') }}
    </div>
@endif

<div class="data-card-header" style="background:#fff;border-radius:16px 16px 0 0;border:1px solid #e5e9f2;border-bottom:none;padding:20px 24px;">
    <form method="GET" action="{{ route('admin.students.index') }}" style="display:flex;gap:20px;align-items:center;flex-wrap:wrap;justify-content:space-between;width:100%;">
        <x-live-search :endpoint="route('admin.search')" name="search" :value="$search" placeholder="{{ __('admin.students.search_placeholder') }}" style="width:320px;" />
        <div style="display:flex;gap:15px;align-items:center;">
            <select name="grade" class="filter-select" onchange="this.form.submit()">
                <option value="">{{ __('admin.students.all_grades') }}</option>
                @foreach($grades as $g)
                    <option value="{{ $g }}" {{ $grade === $g ? 'selected' : '' }}>{{ __('admin.students.grade_label', ['grade' => $g]) }}</option>
                @endforeach
            </select>
            <select name="track" class="filter-select" onchange="this.form.submit()">
                <option value="">{{ __('admin.students.all_tracks') }}</option>
                @foreach($tracks as $t)
                    <option value="{{ $t }}" {{ $track === $t ? 'selected' : '' }}>{{ $t }}</option>
                @endforeach
            </select>
            <a href="{{ route('admin.students.create') }}" class="add-btn">
                <i class="fa-solid fa-user-plus"></i> {{ __('common.add') }}
            </a>
        </div>
    </form>
</div>

<div class="data-card" style="border-radius:0 0 16px 16px;">
    <table class="data-table">
        <thead>
            <tr>
                <th>{{ __('common.student') }}</th>
                <th>{{ __('admin.students.class_column') }}</th>
                <th>{{ __('admin.students.track_column') }}</th>
                <th>{{ __('admin.students.attendance_column') }}</th>
                <th>{{ __('common.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($students as $student)
                <tr>
<td>
    <div style="display:flex;align-items:center;gap:10px;">
        <img src="{{ $student->user->profilePicture() }}" style="width:36px;height:36px;border-radius:50%;object-fit:cover;flex-shrink:0;">
        <div>
            <strong>{{ $student->user->displayName() }}</strong>
            <br><span style="color:#9ca3af;font-size:13px;">{{ $student->roll_no }}</span>
        </div>
    </div>
</td>
                    <td>{{ $student->schoolClass->displayName() ?? __('admin.students.unassigned') }}</td>
                    <td>
                        @if($student->schoolClass?->track)
                            <span class="badge badge-{{ $student->schoolClass->track === 'Science' ? 'science' : 'geography' }}">{{ $student->schoolClass->track }}</span>
                        @else
                            <span style="color:#9ca3af;">&mdash;</span>
                        @endif
                    </td>
                    <td>
                        @if($student->attendance_percent === null)
                            <span style="color:#9ca3af;">{{ __('admin.students.no_records') }}</span>
                        @else
                            <div style="display:flex;align-items:center;gap:8px;">
                                <div style="width:80px;height:6px;background:#eef1f6;border-radius:10px;overflow:hidden;">
                                    <div style="width:{{ $student->attendance_percent }}%;height:100%;background:{{ $student->attendance_percent < 60 ? '#ef4444' : '#10b981' }};"></div>
                                </div>
                                <span>{{ $student->attendance_percent }}%</span>
                            </div>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.students.edit', $student) }}" title="{{ __('common.edit') }}"><i class="fa-solid fa-pen"></i></a>
                        <form action="{{ route('admin.students.destroy', $student) }}" method="POST" style="display:inline;margin-left:12px;" onsubmit="return confirm('{{ __('admin.students.delete_confirm') }}');">
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
                    <td colspan="5" style="text-align:center;color:#9ca3af;padding:24px;">{{ __('admin.students.no_students_found') }}</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div style="margin-top:20px;">
    {{ $students->links() }}
</div>
@endsection
