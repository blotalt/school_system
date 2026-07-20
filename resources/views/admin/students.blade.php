@extends('layouts.admin')

@section('content')
<div class="page-title">
    <h1>Student Management</h1>
    <p>All enrolled students for the current semester.</p>
</div>

@if(session('success'))
    <div class="filter-card" style="color:#1a7f37;margin-bottom:8px;">{{ session('success') }}</div>
@endif

<div class="data-card-header" style="background:#fff;border-radius:16px 16px 0 0;border:1px solid #e5e9f2;border-bottom:none;padding:20px 24px;">
    <div style="display:flex;gap:20px;align-items:center;flex-wrap:wrap;justify-content:space-between;">
        <div class="search-box" style="width:320px;">
            <input type="text" id="studentSearch" placeholder="e.g. Sophea Rath" onkeyup="liveSearch('studentSearch','studentTable')">
            <i class="fa-solid fa-magnifying-glass"></i>
        </div>
        <div style="display:flex;gap:15px;align-items:center;">
            <a href="{{ route('admin.students.create') }}" class="add-btn">
                <i class="fa-solid fa-user-plus"></i> Add Student
            </a>
        </div>
    </div>
</div>

<div class="data-card" style="border-radius:0 0 16px 16px;">
    <table class="data-table">
        <thead>
            <tr>
                <th>Student</th>
                <th>Roll No.</th>
                <th>Class</th>
                <th>Track</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="studentTable">
            @forelse($students as $student)
                <tr>
                    <td>
                        <strong>{{ $student->user->name }}</strong><br>
                        <span style="color:#9ca3af;font-size:13px;">{{ $student->user->email }}</span>
                    </td>
                    <td>{{ $student->roll_no }}</td>
                    <td>{{ $student->schoolClass->name ?? '—' }}</td>
                    <td>
                        @if($student->schoolClass?->track)
                            <span class="badge badge-science">{{ $student->schoolClass->track }}</span>
                        @else
                            <span style="color:#9ca3af;">—</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.students.edit', $student) }}" title="Edit"><i class="fa-solid fa-pen"></i></a>
                        <form method="POST" action="{{ route('admin.students.destroy', $student) }}" style="display:inline;margin-left:12px;" onsubmit="return confirm('Delete this student?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background:none;border:none;cursor:pointer;color:#ef4444;" title="Delete"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" style="text-align:center;color:#8a94a6;">No students yet.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div style="padding:16px;">{{ $students->links() }}</div>
</div>

<script>
function liveSearch(inputId, tableId) {
    var filter = document.getElementById(inputId).value.toLowerCase();
    var rows = document.getElementById(tableId).getElementsByTagName('tr');
    for (var i = 0; i < rows.length; i++) {
        var text = rows[i].textContent.toLowerCase();
        rows[i].style.display = text.includes(filter) ? '' : 'none';
    }
}
</script>
@endsection