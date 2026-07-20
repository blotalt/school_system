@extends('layouts.student')

@section('content')
<div class="page-title">
<h1>My Homework</h1>
        <p>Assignments for your class, read-only.</p>
</div>

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
                        <span class="badge {{ $overdue ? 'badge-geography' : 'badge-science' }}">
                            {{ $overdue ? 'Past Due' : 'Upcoming' }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" style="text-align:center;color:#8a94a6;">No homework assigned yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
