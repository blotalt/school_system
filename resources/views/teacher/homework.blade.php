@extends('layouts.teacher')

@section('content')
<div class="page-title-bar">
    <div>
        <h1>Homework</h1>
        <p>Assignments you've posted for your classes.</p>
    </div>
    <a href="{{ route('teacher.homework.create') }}" class="add-btn">
        <i class="fa-solid fa-plus"></i> Add Homework
    </a>
</div>

@if(session('status'))
    <div class="filter-card" style="color:#1a7f37;margin-bottom:8px;">{{ session('status') }}</div>
@endif

<div class="data-card">
    <table class="data-table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Class</th>
                <th>Subject</th>
                <th>Due Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($homeworks as $hw)
                @php $overdue = $hw->due_date && $hw->due_date->isPast(); @endphp
                <tr>
                    <td><strong>{{ $hw->title }}</strong></td>
                    <td>{{ $hw->schoolClass->name ?? '—' }}</td>
                    <td>{{ $hw->subject->name ?? '—' }}</td>
                    <td>{{ optional($hw->due_date)->format('M d, Y') ?? '—' }}</td>
                    <td>
                        <span class="badge {{ $overdue ? 'badge-geography' : 'badge-science' }}">
                            {{ $overdue ? 'Past Due' : 'Upcoming' }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('teacher.homework.edit', $hw) }}" title="Edit"><i class="fa-solid fa-pen"></i></a>
                        <form method="POST" action="{{ route('teacher.homework.destroy', $hw) }}" style="display:inline;margin-left:12px;" onsubmit="return confirm('Delete this homework?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background:none;border:none;cursor:pointer;color:#ef4444;" title="Delete"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" style="text-align:center;color:#8a94a6;">No homework posted yet.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div style="padding:16px;">{{ $homeworks->links() }}</div>
</div>
@endsection
