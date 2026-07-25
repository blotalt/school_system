@extends('layouts.teacher')

@section('content')

<x-page-header>
    <div>
        <h1>{{ __('teacher.homework.title') }}</h1>
        <p>{{ __('teacher.homework.subtitle') }}</p>
    </div>
    <a href="{{ route('teacher.homework.create') }}" class="add-btn">
        <i class="fa-solid fa-plus"></i> {{ __('teacher.homework.assign_homework') }}
    </a>
</x-page-header>

@if (session('status') || session('success'))
    <div class="alert alert-success" style="margin-bottom:16px;padding:12px 16px;background:#e6f9f0;border:1px solid #10b981;border-radius:10px;color:#0a7a4d;">
        {{ session('status') ?? session('success') }}
    </div>
@endif

<div class="data-card">
    <table class="data-table">
        <thead>
            <tr>
                <th>{{ __('teacher.homework.title_column') }}</th>
                <th>{{ __('teacher.homework.class_column') }}</th>
                <th>{{ __('teacher.homework.subject_column') }}</th>
                <th>{{ __('teacher.homework.due_date_column') }}</th>
                <th>{{ __('teacher.homework.attachment_column') }}</th>
                <th>{{ __('teacher.homework.actions_column') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($homeworks as $hw)
                <tr>
                    <td>{{ $hw->title }}</td>
                    <td>{{ $hw->schoolClass->name ?? '—' }}</td>
                    <td>{{ $hw->subject->name ?? '—' }}</td>
                    <td>{{ $hw->due_date->format('M j, Y') }}</td>
                    <td>
                        @if($hw->attachment_path)
                            <a href="{{ asset('storage/' . $hw->attachment_path) }}" target="_blank" title="{{ $hw->attachment_name }}"><i class="fa-solid fa-paperclip"></i></a>
                        @else
                            <span style="color:#c4c9d4;">—</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('teacher.homework.submissions', $hw) }}" title="{{ __('teacher.homework.view_submissions') }}" style="margin-right:12px;">
                            <i class="fa-solid fa-inbox"></i> {{ $hw->submissions_count }}
                        </a>
                        <a href="{{ route('teacher.homework.edit', $hw) }}" title="{{ __('common.edit') }}"><i class="fa-solid fa-pen"></i></a>
                        <form action="{{ route('teacher.homework.destroy', $hw) }}" method="POST" style="display:inline;margin-left:12px;" onsubmit="return confirm('{{ __('teacher.homework.delete_confirm') }}');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" title="{{ __('common.delete') }}" style="background:none;border:none;cursor:pointer;color:#9ca3af;">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" style="text-align:center;color:#8a94a6;">{{ __('teacher.homework.no_homework_yet') }}</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div style="margin-top:20px;">
    {{ $homeworks->links() }}
</div>

@endsection
