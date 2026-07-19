@extends('layouts.student')

@section('content')
<x-page-header>
    <div>
        <h1>My Homework</h1>
        <p>Assignments for your class, read-only.</p>
    </div>
</x-page-header>

<div class="data-card">
    <div class="data-card-header">
        <h3>Assigned Homework</h3>
    </div>
    <table class="data-table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Subject</th>
                <th>Due Date</th>
                <th>Attachment</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($homeworks as $hw)
                @php $overdue = $hw->due_date && $hw->due_date->isPast(); @endphp
                <tr>
                    <td>{{ $hw->title }}</td>
                    <td>{{ $hw->subject->name ?? '—' }}</td>
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
                            {{ $overdue ? 'Past Due' : 'Upcoming' }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" style="text-align:center;color:#8a94a6;">No homework assigned yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
