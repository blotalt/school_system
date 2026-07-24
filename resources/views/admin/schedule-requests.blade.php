@extends('layouts.admin')

@section('content')
<x-page-header>
    <div>
        <h1>{{ __('admin.schedule_requests.title') }}</h1>
        <p>{{ __('admin.schedule_requests.subtitle') }}</p>
    </div>
</x-page-header>

@if (session('success'))
    <div class="alert alert-success" style="margin-bottom:16px;padding:12px 16px;background:#e6f9f0;border:1px solid #10b981;border-radius:10px;color:#0a7a4d;">
        {{ session('success') }}
    </div>
@endif
@if ($errors->any())
    <div class="alert alert-error" style="margin-bottom:16px;padding:12px 16px;background:#fdecea;border:1px solid #f5b7b1;border-radius:10px;color:#c0392b;">
        {{ $errors->first() }}
    </div>
@endif

@php
    $statuses = [
        'pending'  => __('admin.schedule_requests.status_pending'),
        'approved' => __('admin.schedule_requests.status_approved'),
        'rejected' => __('admin.schedule_requests.status_rejected'),
        'all'      => __('admin.schedule_requests.status_all'),
    ];
@endphp

<div class="filter-card">
    <span>{{ __('common.status') }}:</span>
    @foreach($statuses as $value => $label)
        <a href="{{ route('admin.schedule-requests.index', ['status' => $value]) }}">
            <button type="button" class="{{ $status === $value ? 'active' : '' }}">{{ $label }}</button>
        </a>
    @endforeach
</div>

<div class="data-card" style="margin-top:16px;">
    <table class="data-table">
        <thead>
            <tr>
                <th>{{ __('common.teacher') }}</th>
                <th>{{ __('common.class') }}</th>
                <th>{{ __('common.subject') }}</th>
                <th>{{ __('admin.schedule_requests.slot_column') }}</th>
                <th>{{ __('admin.schedule_requests.submitted_column') }}</th>
                @if($status === 'pending' || $status === 'all')
                    <th>{{ __('common.actions') }}</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @forelse($requests as $req)
                <tr>
                    <td>{{ $req->teacher->user->name }}</td>
                    <td>{{ $req->schoolClass->name }}</td>
                    <td>{{ $req->subject->name }}</td>
                    <td>{{ strtoupper(__('common.days.' . $req->day_of_week)) }} &middot; P{{ $req->period }} ({{ $periodTimes[$req->shift][$req->period] }})</td>
                    <td>{{ $req->created_at->format('M d, Y') }}</td>
                    @if($status === 'pending' || $status === 'all')
                        <td>
                            @if($req->status === 'pending')
                                <form action="{{ route('admin.schedule-requests.approve', $req) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="approve-btn">{{ __('admin.schedule_requests.approve') }}</button>
                                </form>
                                <form action="{{ route('admin.schedule-requests.reject', $req) }}" method="POST" style="display:inline;margin-left:8px;" onsubmit="return confirm('{{ __('admin.schedule_requests.reject_confirm') }}');">
                                    @csrf
                                    <button type="submit" class="reject-btn">{{ __('admin.schedule_requests.reject') }}</button>
                                </form>
                            @else
                                <span style="color:#9ca3af;font-size:13px;">—</span>
                            @endif
                        </td>
                    @endif
                </tr>
            @empty
                <tr>
                    <td colspan="{{ ($status === 'pending' || $status === 'all') ? 6 : 5 }}" style="text-align:center;color:#9ca3af;padding:24px;">{{ __('admin.schedule_requests.none_found') }}</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
