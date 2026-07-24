@extends('layouts.admin')

@section('content')
<div class="breadcrumb">
    <a href="{{ route('admin.dashboard') }}">{{ __('common.dashboard') }}</a> &gt;
    <a href="{{ route('admin.students.index') }}">{{ __('admin.students.title') }}</a> &gt;
    <span>{{ __('admin.students.edit_title') }}</span>
</div>

<x-page-header>
    <div>
        <h1>{{ __('admin.students.edit_title') }}</h1>
        <p>{{ __('admin.students.edit_subtitle', ['name' => $student->user->displayName()]) }}</p>
    </div>
</x-page-header>

<form method="POST" action="{{ route('admin.students.update', $student) }}" class="form-card" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="form-row">
        <div class="form-group">
            <label>{{ __('common.full_name') }}</label>
            <input type="text" name="name" value="{{ old('name', $student->user->name) }}">
            @error('name') <span class="field-error">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label>{{ __('common.email_address') }}</label>
            <input type="email" name="email" value="{{ old('email', $student->user->email) }}">
            @error('email') <span class="field-error">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="form-row">
    <div class="form-group">
        <label>ឈ្មោះជាអក្សរខ្មែរ (Khmer Name)</label>
        <input type="text" name="khmer_name" value="{{ old('khmer_name', $student->user->khmer_name) }}" placeholder="ឧ. សុខ ដារ៉ា">
        @error('khmer_name') <span class="field-error">{{ $message }}</span> @enderror
    </div>
    <div class="form-group">
        <label>{{ __('common.gender') }}</label>
        <select name="gender">
            <option value="">-- Select --</option>
            <option value="male" @selected(old('gender', $student->gender) === 'male')>{{ __('common.male') }}</option>
            <option value="female" @selected(old('gender', $student->gender) === 'female')>{{ __('common.female') }}</option>
        </select>
        @error('gender') <span class="field-error">{{ $message }}</span> @enderror
    </div>
</div>

<div class="form-group">
    <label>Profile Picture</label>
    @if($student->user->profile_picture)
        <div style="margin-bottom:8px;">
            <img src="{{ asset($student->user->profile_picture) }}" style="width:60px;height:60px;border-radius:50%;object-fit:cover;">
        </div>
    @endif
    <input type="file" name="profile_picture" accept="image/*">
    <small style="color:#9ca3af;">Leave empty to keep current photo. Default photo based on gender if none uploaded.</small>
    @error('profile_picture') <span class="field-error">{{ $message }}</span> @enderror
</div>

    <div class="form-row">
        <div class="form-group">
            <label>{{ __('common.roll_number') }}</label>
            <input type="text" name="roll_no" value="{{ old('roll_no', $student->roll_no) }}">
            @error('roll_no') <span class="field-error">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label>{{ __('common.date_of_birth') }}</label>
            <input type="date" name="date_of_birth" value="{{ old('date_of_birth', optional($student->date_of_birth)->format('Y-m-d')) }}">
            @error('date_of_birth') <span class="field-error">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="form-group" style="max-width:400px;">
        <label>{{ __('common.system_password') }}</label>
        <div class="password-input-wrapper">
            <input type="password" name="password" placeholder="{{ __('admin.students.password_hint') }}">
            <button type="button" class="password-toggle-btn" onclick="togglePasswordVisibility(this)" aria-label="{{ __('common.show_password') }}"><i class="fa-solid fa-eye"></i></button>
        </div>
        @error('password') <span class="field-error">{{ $message }}</span> @enderror
    </div>

    <div class="form-group">
        <label>{{ __('common.guardian_contact') }}</label>
        <input type="text" name="guardian_contact" value="{{ old('guardian_contact', $student->guardian_contact) }}">
        @error('guardian_contact') <span class="field-error">{{ $message }}</span> @enderror
    </div>

    <div class="form-group">
        <label>{{ __('admin.students.assigned_class') }}</label>
        <div class="section-toggle-group">
            @foreach($classes as $class)
                <label class="section-toggle">
                    <input type="radio" name="class_id" value="{{ $class->id }}" {{ (string) old('class_id', $student->class_id) === (string) $class->id ? 'checked' : '' }}>
                    <span>{{ $class->name }}</span>
                </label>
            @endforeach
        </div>
        @error('class_id') <span class="field-error">{{ $message }}</span> @enderror
    </div>

    <div class="form-actions">
        <a href="{{ route('admin.students.index') }}" class="cancel-btn">{{ __('common.cancel') }}</a>
        <button type="submit" class="save-btn"><i class="fa-solid fa-floppy-disk"></i> {{ __('common.save_changes') }}</button>
    </div>
</form>
@endsection
