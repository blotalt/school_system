@extends('layouts.student')

@section('content')
<x-page-header>
    <div>
        <h1>{{ __('student.homework.title') }}</h1>
        <p>{{ __('student.homework.subtitle') }}</p>
    </div>
</x-page-header>

<div class="data-card">
    <div class="data-card-header">
        <h3>{{ __('student.homework.assigned_homework') }}</h3>
    </div>
    <table class="data-table">
        <thead>
            <tr>
                <th>{{ __('student.homework.title_column') }}</th>
                <th>{{ __('student.homework.subject_column') }}</th>
                <th>{{ __('student.homework.due_date_column') }}</th>
                <th>{{ __('student.homework.attachment_column') }}</th>
                <th>{{ __('student.homework.status_column') }}</th>
                <th>{{ __('student.homework.submission_column') }}</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($homeworks as $hw)
                @php
                    $overdue = $hw->due_date && $hw->due_date->isPast();
                    $submission = $submissions->get($hw->id);
                @endphp
                <tr>
                    <td>{{ $hw->title }}</td>
                    <td>{{ $hw->subject?->displayName() ?? '—' }}</td>
                    <td>{{ optional($hw->due_date)->format('M d, Y') ?? '—' }}</td>
                    <td>
                        @if($hw->attachment_path)
                            <a href="{{ asset('storage/' . $hw->attachment_path) }}" target="_blank">
                                <i class="fa-solid fa-paperclip"></i> {{ $hw->attachment_name }}
                            </a>
                        @else
                            <span style="color:#c4c9d4;">—</span>
                        @endif
                    </td>
                    <td>
                        <span class="badge {{ $overdue ? 'badge-geography' : 'badge-science' }}">
                            {{ $overdue ? __('student.homework.past_due') : __('student.homework.upcoming') }}
                        </span>
                    </td>
                    <td>
                        @if(!$submission)
                            <span style="color:#c4c9d4;">{{ __('student.homework.not_submitted') }}</span>
                        @elseif($submission->graded_at)
                            <span class="badge badge-science">{{ __('student.homework.graded') }} — {{ $submission->score }}/100</span>
                        @else
                            <span class="badge">{{ __('student.homework.submitted') }}</span>
                        @endif
                    </td>
                    <td><a href="{{ route('student.view-task', $hw) }}" title="View"><i class="fa-regular fa-eye"></i></a></td>
                </tr>
            @empty
                <tr><td colspan="7" style="text-align:center;color:#8a94a6;">{{ __('student.homework.no_homework_yet') }}</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
