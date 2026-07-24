@php
    $unreadCount = auth()->user()->unreadNotifications->count();
    $recentNotifications = auth()->user()->notifications()->latest()->take(10)->get();
@endphp

<div class="notif-dropdown-wrapper" onclick="toggleNotifDropdown(event)">
    <div class="icon-btn" style="position:relative;">
        <i class="fa-regular fa-bell"></i>
        @if($unreadCount > 0)
            <span class="notif-badge">{{ $unreadCount > 9 ? '9+' : $unreadCount }}</span>
        @endif
    </div>

    <div class="notif-dropdown" id="notifDropdown">
        <div class="notif-dropdown-header">
            <strong>{{ __('nav.notifications') }}</strong>
            @if($unreadCount > 0)
                <form method="POST" action="{{ route('notifications.readAll') }}">
                    @csrf
                    <button type="submit" class="notif-mark-all">{{ __('nav.mark_all_read') }}</button>
                </form>
            @endif
        </div>
        <div class="notif-list">
            @forelse($recentNotifications as $notification)
                <a href="{{ route('notifications.read', $notification) }}" class="notif-item {{ $notification->read_at ? '' : 'unread' }}">
                    <div class="notif-item-icon"><i class="fa-solid {{ $notification->data['icon'] ?? 'fa-bell' }}"></i></div>
                    <div class="notif-item-body">
                        <strong>{{ $notification->data['title'] ?? __('nav.notification_fallback') }}</strong>
                        <p>{{ $notification->data['message'] ?? '' }}</p>
                        <span>{{ $notification->created_at->diffForHumans() }}</span>
                    </div>
                </a>
            @empty
                <div class="notif-empty">{{ __('nav.no_notifications_yet') }}</div>
            @endforelse
        </div>
    </div>
</div>

<script>
function toggleNotifDropdown(e) {
    e.stopPropagation();
    document.getElementById('notifDropdown').classList.toggle('show');
}
document.addEventListener('click', function () {
    document.getElementById('notifDropdown')?.classList.remove('show');
});
</script>
