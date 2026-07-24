@extends('layouts.admin')

@section('content')
<x-page-header>
    <div>
        <h1>{{ __('admin.dashboard.title') }}</h1>
        <p>{{ __('admin.dashboard.subtitle') }}</p>
    </div>
</x-page-header>

<div class="stat-grid">
    @foreach($stats as $stat)
        <div class="stat-card">
            <div class="stat-icon"><i class="fa-solid {{ $stat['icon'] }}"></i></div>
            <div class="stat-value">{{ $stat['value'] }}</div>
            <div class="stat-label">{{ $stat['label'] }}</div>
        </div>
    @endforeach
</div>

<div class="data-card">
    <div class="data-card-header">
        <h3>{{ __('admin.dashboard.classes_overview') }}</h3>
        <a href="/admin/classes">{{ __('admin.dashboard.view_all_classes') }}</a>
    </div>
    <table class="data-table">
        <thead>
            <tr>
                <th>{{ __('admin.dashboard.class_name') }}</th>
                <th>{{ __('common.track') }}</th>
                <th>{{ __('admin.dashboard.students') }}</th>
                <th>{{ __('admin.dashboard.attendance') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($classes as $class)
                <tr>
                    <td>{{ $class->name }}</td>
                    <td><span class="badge badge-{{ strtolower($class->track) }}">{{ strtoupper($class->track) }}</span></td>
                    <td>{{ $class->students }}</td>
                    <td>{{ $class->attendance }}%</td>
                </tr>
            @empty
                <tr><td colspan="4" style="text-align:center;color:#8a94a6;">{{ __('admin.dashboard.no_classes_yet') }}</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection