@extends('layouts.admin')

@section('content')
<div class="profile-page">
    <div class="profile-header">
        <h1>My Profile</h1>
        <p>Manage your account information.</p>
    </div>

    @if (session('success'))
        <div class="alert alert-success" style="margin-bottom:16px;padding:12px 16px;background:#e6f9f0;border:1px solid #10b981;border-radius:10px;color:#0a7a4d;">
            {{ session('success') }}
        </div>
    @endif

    <div class="profile-wrapper">
        <div class="profile-left">
            <div class="profile-card">
                <div class="profile-image">
                    <div class="avatar-circle" style="width:100px;height:100px;font-size:28px;">
                        {{ collect(explode(' ', $user->name))->map(fn ($n) => mb_substr($n, 0, 1))->take(2)->implode('') }}
                    </div>
                    <button type="button" class="camera-btn" title="Photo upload coming soon"><i class="fa-solid fa-camera"></i></button>
                </div>
                <h2>{{ $user->name }}</h2>
                <span class="role-badge">Administrator</span>
                <hr>
                <div class="profile-info">
                    <label>Email</label>
                    <h4>{{ $user->email }}</h4>
                </div>
                <div class="profile-info">
                    <label>Member Since</label>
                    <h4>{{ $user->created_at->format('F Y') }}</h4>
                </div>
            </div>
        </div>

        <div class="profile-right">
            <div class="profile-form-header">
                <h2>Account Information</h2>
                <button type="button" class="edit-btn" id="editProfileBtn" onclick="toggleEditProfile()">
                    <i class="fa-solid fa-pen"></i> Edit
                </button>
            </div>

            <form id="profileForm" method="POST" action="{{ route('admin.profile.update') }}">
                @csrf
                @method('PUT')

                <div class="form-row">
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" disabled>
                        @error('name') <span class="field-error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" disabled>
                        @error('email') <span class="field-error">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="profile-actions" id="profileFormActions" style="display:none;">
                    <button type="button" class="discard-profile-btn" onclick="cancelEditProfile()">Discard</button>
                    <button type="submit" class="save-profile-btn">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function toggleEditProfile() {
    document.querySelectorAll('#profileForm input').forEach(el => el.disabled = false);
    document.getElementById('profileFormActions').style.display = 'flex';
    document.getElementById('editProfileBtn').style.display = 'none';
}
function cancelEditProfile() {
    location.reload();
}
</script>
@endsection
