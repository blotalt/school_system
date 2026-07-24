@extends('layouts.teacher')

@section('content')

<x-page-header>
    <div>
        <h1>{{ __('teacher.classes.title') }}</h1>
        <p>{{ __('teacher.classes.subtitle') }}</p>
    </div>
</x-page-header>

<div class="data-card">
    <table class="data-table">
        <thead>
            <tr>
                <th>{{ __('teacher.classes.class_name') }}</th>
                <th>{{ __('teacher.classes.grade') }}</th>
                <th>{{ __('common.track') }}</th>
                <th>{{ __('teacher.classes.students') }}</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($classes as $class)
                <tr>
                    <td>{{ $class->name }}</td>
                    <td>{{ $class->grade_level ?? '—' }}</td>
                    <td>{{ $class->track ?? __('common.default_track') }}</td>
                    <td>{{ $class->students_count }}</td>
                    <td>
                        <a href="{{ route('teacher.attendance.show', $class) }}" class="add-btn">
                            <i class="fa-solid fa-user-check"></i> {{ __('teacher.classes.attendance') }}
                        </a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" style="text-align:center;color:#8a94a6;">{{ __('teacher.classes.no_homeroom_classes') }}</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
