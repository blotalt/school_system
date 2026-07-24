@extends('layouts.admin')

@section('content')
<x-page-header>
    <div>
        <h1>{{ __('admin.teachers.title') }}</h1>
        <p>{{ __('admin.teachers.subtitle', ['count' => $teachers->total()]) }}</p>
    </div>
</x-page-header>

@if (session('success'))
    <div class="alert alert-success" style="margin-bottom:16px;padding:12px 16px;background:#e6f9f0;border:1px solid #10b981;border-radius:10px;color:#0a7a4d;">
        {{ session('success') }}
    </div>
@endif

<div class="data-card-header" style="background:#fff;border-radius:16px 16px 0 0;border:1px solid #e5e9f2;border-bottom:none;padding:20px 24px;">
    <form method="GET" action="{{ route('admin.teachers.index') }}" style="display:flex;gap:20px;align-items:center;flex-wrap:wrap;justify-content:space-between;width:100%;">
        <x-live-search :endpoint="route('admin.search')" name="search" :value="$search" placeholder="{{ __('admin.teachers.search_placeholder') }}" style="width:320px;" />
        <div style="display:flex;gap:15px;align-items:center;">
            <a href="{{ route('admin.teachers.create') }}" class="add-btn">
                <i class="fa-solid fa-user-plus"></i> {{ __('common.add') }}
            </a>
        </div>
    </form>
</div>

<div class="data-card" style="border-radius:0 0 16px 16px;">
    <table class="data-table">
        <thead>
            <tr>
                <th>{{ __('admin.teachers.name_column') }}</th>
                <th>{{ __('common.subject') }}</th>
                <th>{{ __('admin.teachers.assigned_classes') }}</th>
                <th>{{ __('common.email') }}</th>
                <th>{{ __('common.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($teachers as $teacher)
                <tr>
<td>
    <div style="display:flex;align-items:center;gap:10px;">
        <img src="{{ $teacher->user->profilePicture() }}" style="width:36px;height:36px;border-radius:50%;object-fit:cover;flex-shrink:0;">
        <div>
            <strong>{{ $teacher->user->displayName() }}</strong>
<br><span style="color:#9ca3af;font-size:13px;">TCH-{{ str_pad($teacher->id, 4, '0', STR_PAD_LEFT) }}</span>
        </div>
    </div>
</td>
                    <td>
                        @forelse($teacher->subjects as $subject)
                            <span class="badge badge-subject">{{ $subject->name }}</span>
                        @empty
                            <span style="color:#9ca3af;">&mdash;</span>
                        @endforelse
                    </td>
                    <td>{{ $teacher->classes->map(fn($c) => $c->displayName())->implode(', ') ?: __('admin.teachers.not_available') }}</td>
                    <td>{{ $teacher->user->email }}</td>
                    <td>
                        <a href="{{ route('admin.teachers.edit', $teacher) }}" title="{{ __('common.edit') }}"><i class="fa-solid fa-pen"></i></a>
                        <form action="{{ route('admin.teachers.destroy', $teacher) }}" method="POST" style="display:inline;margin-left:12px;" onsubmit="return confirm('{{ __('admin.teachers.delete_confirm') }}');">
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
                    <td colspan="5" style="text-align:center;color:#9ca3af;padding:24px;">{{ __('admin.teachers.no_teachers_found') }}</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div style="margin-top:20px;">
    {{ $teachers->links() }}
</div>
@endsection
